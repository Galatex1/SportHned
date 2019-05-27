<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->post('/create', function(Request $request, Response $response) use ($DB){
    if(!haveEmptyParameters(array('email', 'password', 'firstname', 'lastname'), $request, $response)){
        $request_data = $request->getParsedBody(); 
        $email = $request_data['email'];
        $password = $request_data['password'];
        $firstname = $request_data['firstname'];
        $lastname = $request_data['lastname']; 
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $db = $DB->users;
        
        $result = $db->createUser($email, $hash_password, $firstname, $lastname);
        
        if($result == USER_CREATED){
            $message = array(); 
            $message['error'] = false; 
            $message['message'] = 'User created successfully';
            $response->write(json_encode($message));
            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201);
        }else if($result == USER_FAILURE){
            $message = array(); 
            $message['error'] = true; 
            $message['message'] = 'Some error occurred';
            $response->write(json_encode($message));
            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);    
        }else if($result == USER_EXISTS){
            $message = array(); 
            $message['error'] = true; 
            $message['message'] = 'User Already Exists';
            $response->write(json_encode($message));
            return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);    
        }
    }
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});
$app->post('/login', function(Request $request, Response $response) use ($DB){
    if(!haveEmptyParameters(array('email', 'password'), $request, $response)){
        $request_data = $request->getParsedBody(); 
        $email = $request_data['email'];
        $password = $request_data['password'];      
        $db = $DB->users;
        $result = $db->userLogin($email, $password);
        if($result == USER_AUTHENTICATED){
            
            $user = $db->getUserByEmail($email);
            $response_data = array();
            $response_data['error']=false; 
            $response_data['message'] = 'Login Successful';
            $response_data['user']=$user; 
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);    
        }else if($result == USER_NOT_FOUND){
            $response_data = array();
            $response_data['error']=true; 
            $response_data['message'] = 'User does not exist';
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);    
        }else if($result == USER_PASSWORD_DO_NOT_MATCH){
            $response_data = array();
            $response_data['error']=true; 
            $response_data['message'] = 'Invalid credentials';
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);  
        }
    }
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);    
});

$app->get('/', function(Request $request, Response $response) use ($DB){

    $response->write(json_encode("SportHned RESTful API"));
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);  
});

$app->get('/all', function(Request $request, Response $response) use ($DB){
    $db = $DB->users;
    $users = $db->getAllUsers();
    $response_data = array();
    $response_data['error'] = false; 
    $response_data['users'] = $users; 
    $response->write(json_encode($response_data));
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);  
});

$app->put('/update/{id}', function(Request $request, Response $response, array $args) use ($DB){
    $id = $args['id'];
    if(!haveEmptyParameters(array('email','firstname','lastname'), $request, $response)){
        $request_data = $request->getParsedBody(); 
        $email = $request_data['email'];
        $firstname = $request_data['firstname'];
        $lastname = $request_data['lastname']; 
     
        $db = $DB->users;
        if($db->updateUser($email, $firstname, $lastname, $id)){
            $response_data = array(); 
            
            if($db->userExists($id))
            { 
                $response_data['error'] = false;
                $response_data['message'] = 'User Updated Successfully';
                $user = $db->getUserByEmail($email);
                $response_data['user'] = $user; 
                $response->write(json_encode($response_data));
            }
            else
            {
                $response_data['error'] = true;
                $response_data['message'] = 'User with this ID does not exist'; 
                $response->write(json_encode($response_data));
            }
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);  
        
        }else{
            $response_data = array(); 
            $response_data['error'] = true; 
            $response_data['message'] = 'Please try again later';
            $user = $db->getUserByEmail($email);
            $response_data['user'] = $user; 
            $response->write(json_encode($response_data));
            return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);  
              
        }
    }
    
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);  
});
$app->put('/password', function(Request $request, Response $response) use ($DB){
    if(!haveEmptyParameters(array('currentpassword', 'newpassword', 'email'), $request, $response)){
        
        $request_data = $request->getParsedBody(); 
        $currentpassword = $request_data['currentpassword'];
        $newpassword = $request_data['newpassword'];
        $email = $request_data['email']; 
        $db = $DB->users;
        $result = $db->updatePassword($currentpassword, $newpassword, $email);
        if($result == PASSWORD_CHANGED){
            $response_data = array(); 
            $response_data['error'] = false;
            $response_data['message'] = 'Password Changed';
            $response->write(json_encode($response_data));
            return $response->withHeader('Content-type', 'application/json')
                            ->withStatus(200);
        }else if($result == PASSWORD_DO_NOT_MATCH){
            $response_data = array(); 
            $response_data['error'] = true;
            $response_data['message'] = 'You have given wrong password';
            $response->write(json_encode($response_data));
            return $response->withHeader('Content-type', 'application/json')
                            ->withStatus(200);
        }else if($result == PASSWORD_NOT_CHANGED){
            $response_data = array(); 
            $response_data['error'] = true;
            $response_data['message'] = 'Some error occurred';
            $response->write(json_encode($response_data));
            return $response->withHeader('Content-type', 'application/json')
                            ->withStatus(200);
        }
    }
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);  
});

$app->put('/verified/{id}', function(Request $request, Response $response, array $args) use ($DB){
    $id = $args['id'];
    if(!haveEmptyParameters(array('verified'), $request, $response)){
        
        $request_data = $request->getParsedBody(); 
        $verified = $request_data['verified']; 
        $db = $DB->users;
        $result = $db->setVerified($id, $verified);
        if($result){
            $response_data = array(); 
            $response_data['error'] = false;
            $response_data['message'] = 'Verified State was Set to '.$verified;
            $response->write(json_encode($response_data));
            return $response->withHeader('Content-type', 'application/json')
                            ->withStatus(200);
        }
        else
        {
            $response_data = array(); 
            $response_data['error'] = true;
            $response_data['message'] = 'Some error occurred';
            $response->write(json_encode($response_data));
            return $response->withHeader('Content-type', 'application/json')
                            ->withStatus(200);
        }
    }
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(422);  
});

$app->delete('/delete/{id}', function(Request $request, Response $response, array $args) use ($DB){
    $id = $args['id'];
     $db = $DB->users;
    $response_data = array();
    if($db->deleteUser($id)){
        $response_data['error'] = false; 
        $response_data['message'] = 'User has been deleted';    
    }else{
        $response_data['error'] = true; 
        $response_data['message'] = 'Plase try again later';
    }
    $response->write(json_encode($response_data));
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
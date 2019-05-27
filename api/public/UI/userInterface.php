<link rel="stylesheet" href="public/UI/style.css" type="text/css" media="screen" />
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="public/UI/actions.js"></script>
<div id='login_form'>             
  <form id='loginForm' method="POST" enctype="multipart/form-data" >               
    <div class="loginWrap">                        
            <input class='log_field' type="email" id="Email" name="email" placeholder="email@example.com" />
            <input class='log_field' type="password" id="Pass" name="password" placeholder="Password" />                      
            <input id='login_button' type="submit" name="submit" value="Log In" >
            <div class="response"></div>
    </div>         
  </form>           
</div>
<div id='reg_form'>
<h2>Registration</h2>          
     
          <form id='form' method="POST" enctype="multipart/form-data" >               
            <div class="wrap">
              
                    <input class='log_field' type="text" id="Firstame" name="firstname" placeholder="First name" />
                    <span class="validation"></span>
 
           
                    <input class='log_field' type="text" id="Lastname" name="lastname" placeholder="Last name" />
                    <span class="validation"></span>             
              
                    <input class='log_field' type="password" id="Pass1" name="password" placeholder="Password" />
                    <span class="validation"></span>
            
  
             
                    <input class='log_field' type="password" id="Pass2" name="password2" placeholder="Password again" />
                    <span class="validation"></span>
            

             
                    <input class='log_field' type="email" id="Email" name="email" placeholder="email@example.com" />
                    <span class="validation"></span>
              
                               
                    <input id='reg_button' type="submit" name="submit" value="Submit" >
                    <span class="validation"></span>

            </div>         
          </form>           
</div>
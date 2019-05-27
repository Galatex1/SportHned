$(document).ready(function(){


    $("#reg_button").click((e)=>{
        e.preventDefault();
        if(validate())
        {
            var myData=$("#form").serialize();
            console.log(myData);
            jQuery.ajax({
                   type: "POST", // HTTP method POST or GET
                   url: "/api/user/create", //Where to make Ajax calls
                   dataType:"json", // Data type, HTML, json etc.
                   data: myData, //Form variables
                   success:function(response){
                    $(".validation").eq(0).text(response.message);
       
                   },
                   error:function (xhr, ajaxOptions, thrownError){
                       console.log(xhr.responseText)
                       let error = JSON.parse(xhr.responseText);
                       $(".validation").eq(4).text(error.message);
                   } 
         });
        }
    });


    $("#login_button").click((e)=>{
        e.preventDefault();

        var myData=$("#loginForm").serialize();
        $(".response").text("Please Wait...");
        console.log(myData);
        jQuery.ajax({
                type: "POST", // HTTP method POST or GET
                url: "/api/user/login", //Where to make Ajax calls
                dataType:"json", // Data type, HTML, json etc.
                data: myData, //Form variables
                success:function(response){
                $(".response").text(response.message);
    
                },
                error:function (xhr, ajaxOptions, thrownError){
                    console.log(xhr.responseText)
                    let error = JSON.parse(xhr.responseText);
                    $(".response").text(error.message);
                } 
        });
        
    });

});


function validate()
{

    $(".validation").text("");

    if( $("#Firstname").val() == "" || $("#Lastname").val() == "" || $("#Email").val() == "" || $("#Pass1").val() == ""   )
    {
        $(".validation").eq(0).text("Please fill all fields.");
        return false;
    }
    else if ($("#Pass1").val().length < 6)
    {
        $(".validation").eq(2).text("Password must be at least 6 characters long.");
        return false;
    }
    else if( $("#Pass1").val() !== $("#Pass2").val() )
    {
        $(".validation").eq(2).text("Passwords don't match.");
        return false;
    }



    return true;
}
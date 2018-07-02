function register()
{
	if(($('#registerUsername').val().length < 1)  || ($('#registerPassword').val().length < 1) || ($('#rePassword').val().length < 1))
    {
           $("#registerMsgbox").fadeTo(200, 0.1, function()
			{ 
			  $(this).html(getmessage(6)).addClass('alert alert-danger').fadeTo(900,1);
			});	
        return;
    }
	
	if($('#registerUsername').val().length < 3)
    {
           $("#registerMsgbox").fadeTo(200, 0.1, function()
			{ 
			  $(this).html(getmessage(3)).addClass('alert alert-danger').fadeTo(900,1);
			});	
        return;
    }
    if($('#registerUsername').val().length > 16)
    {
           $("#registerMsgbox").fadeTo(200,0.1,function()
			{ 
			  $(this).html(getmessage(4)).addClass('alert alert-danger').fadeTo(900,1);
			});	
        return;
    }
	
	if($('#registerPassword').val().length < 4)
    {
           $("#registerMsgbox").fadeTo(200, 0.1, function()
			{ 
			  $(this).html(getmessage(5)).addClass('alert alert-danger').fadeTo(900,1);
			});	
        return;
    }
	
    if($('#registerPassword').val() != $('#rePassword').val())
    {
           $("#registerMsgbox").fadeTo(200, 0.1, function()
			{ 
			  $(this).html(getmessage(2)).addClass('alert alert-danger').fadeTo(900,1);
			});	
        return;
    }
   
     $.ajax({
        url : 'http://solution-ticket-system/api/nutzer',
        type : 'POST',
        data : { registerUsername:$('#registerUsername').val(),registerPassword:$('#registerPassword').val() },
        dataType:'json',
        error: function(error, errorThrown) {
            console.log(error);
            console.log(errorThrown);
        },
        success : function(data) { 
            if(data == "1")
            {
                $("#registerMsgbox").fadeTo(200, 0.1, function()
                    { 
                      $(this).html(getmessage(data)).addClass('success').fadeTo(900,1);
                });		
                //$('#loginModal').modal('toggle');
                //loginPage();
            }
            else
            {
                $("#registerMsgbox").fadeTo(200, 0.1, function()
                { 
                  $(this).html(getmessage(data)).addClass('alert alert-danger').fadeTo(900,1);
                });	
            }
        }
    });
}
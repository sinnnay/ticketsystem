
function login()
{
		$("#msgbox").removeClass().addClass('messagebox').text('Anmeldedaten werden überprüft...').fadeIn(1000);  
		$.ajax({
        url : 'http://solution-ticket-system/api/validierung',
        type : 'POST',
        data : { username:$('#username').val(),password:$('#password').val()},
        dataType:'json',
        error: function(error, errorThrown) {
          console.log(error);
          console.log(errorThrown);
        },
        success : function(data) { 
            if(data != 0)
            {
              $("#msgbox").fadeTo(200, 0.1, function()
              { 
                $(this).html('Melde an...').addClass('alert alert-success').fadeTo(900, 1);                          
              });
              console.log(data);
              localStorage.setItem('token', data);
              $('#loginModal').modal('toggle');
            }
            else
            {
               $("#msgbox").fadeTo(200, 0.1, function()
               { 
                      $(this).html('Anmeldedaten sind inkorrekt').addClass('alert alert-danger').fadeTo(900 , 1);
               });		 
            }
        }
    });
}

function logout()
{

  localStorage.removeItem('token');

  location.reload();
  
}

function registration()
{
	
      document.getElementById("registerBox").innerHTML = "<form class='form-horizontal' method='post' action='' id='register_form'>" +
					  "<div class='row'><div class='col-md-6 column'><div class='control-group'>" + 
						"<label class='control-label' for='username'>Nutzername</label><div class=''controls'>" + 
						  "<input type='text' id='registerUsername' placeholder='Nutzername'>" +
						"</div></div>" +
					  "<div class='control-group'>" +
						"<label class='control-label' for='password'>Passwort</label>" +
						"<div class='controls'>" +
						  "<input type='password' id='registerPassword' placeholder='Passwort'>" +
						"</div><br></div>" +
                        "<div class='control-group'>" +
						"<label class='control-label' for='rePassword'>Passwort wiederholen</label>" +
						"<div class='controls'>" +
						  "<input type='password' id='rePassword' placeholder='Passwort wiederholen'>" +
						"</div><br></div><div id='registerMsgbox'></div></div>" +
                        "</div>" +
					  "<div class='control-group'>" +
						"<div class='controls'>" +
						  "<input name='Submit' type='button' onclick='javascript:register()' value='Registrieren' class='btn btn-success'/>" +
						  "    <input name='Submit' type='button' onclick='javascript:loginPage()' value='Zurück zur Anmeldung' class='btn btn-success'/>" +
						"</div></div></form>";
    
}

function loginPage()
{
	
     $('#loginModal').modal('show');
      document.getElementById("registerBox").innerHTML = "<form class='form-horizontal' method='post' action='' id='login_form'>" +
					  "<div class='control-group'>" +
						"<label class='control-label' for='username'>Benutzername</label>" +
						"<div class='controls'>" +
						  "<input type='text' id='username' placeholder='Benutzername'></div></div>" +
					  "<div class='control-group'> " +
						"<label class='control-label' for='password'>Passwort</label>" +
						"<div class='controls'>" +
						  "<input type='password' id='password' placeholder='Passwort'>" +
						"</div><br>" +
                           "<div id='msgbox'></div></div>" +
					  "<div class='control-group'>" +
						"<div class='controls'>" +
						  "<input name='Submit' type='button' onclick='javascript:login()' value='Anmelden' class='btn btn-success'/>&nbsp;&nbsp;" +
						  "<input name='Submit' type='button' onclick='javascript:registration()' value='Registrieren' class='btn btn-success'/>" +
						"</div>" +
					  "</div>" +
					"</form></div><div class='modal-footer'></div>";
}



    
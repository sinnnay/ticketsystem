function getmessage(messageId)
{
    var message = "";
    messageId = parseInt(messageId);
    
    switch(messageId)
    {
          case 0:
                 message = "Nutzername ist schon belegt";
                 break;
          case 1:
                 message = "Registrierung komplett! Bitte anmelden."
                 break;
          case 2:
                 message = "Passwörter stimmen nicht überein!"
                 break;
          case 3:
                 message = "Nutzername ist zu kurz"
                 break;
          case 4:
                 message = "Nutzername ist zu lang"
                 break;
          case 5:
                 message = "Passwort ist zu kurz"
                 break;
		  case 6:
                 message = "Sie müssen in alle Felder etwas eintragen"
                 break;

    }
    
    return message;
}
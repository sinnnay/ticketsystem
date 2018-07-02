
function NewTicket()
{
      document.getElementById("display").innerHTML = "" + 
       "<br><br><input type='button' class='btn btn-secondary btn-lg' value='Zurück zur Startseite' onclick='location.reload()'><br><br>" +
          "<label>Kategorie  </label>" +
       "    <select id='category' name='category' length='51'>" +
         "<br><br>";
	  
      document.getElementById("display").innerHTML +=  "</select> " +
	   "<br><br><label>Dringlichkeit des Tickets  </label>" +
	  "    <select id='priority' name='priority' length='31'>";
    
     document.getElementById("display").innerHTML +=  "</select><br> " +
	   "<br><label>Abteilung  </label>" +
	  "    <select id='department' name='department' length='31'>";
	 
       document.getElementById("display").innerHTML += "</select> " +
	  
        "<br><br><label>Betreff  </label>    <input type='text' id='subject' size='60'><br />" +
        "<br><label>Beschreibung des Problems  </label><br /> <textarea cols='50' id='description' rows='6'> </textarea>" +
        "<br><br />" +
        "<input type='submit' class='btn btn-secondary btn-lg' value='Ticket abschicken' onclick='SubmitTicket()'>";   
    
   
         $.ajax({
        url : 'http://solution-ticket-system/api/kategorien',
        type : 'GET',
        data : {},
        dataType:'json',
        success : function(data) { 
            for(var i = 0; i < data.length; i++)
            {
                document.getElementById('category').options.add(new Option(data[i].Name, data[i].ID));
            }
        }
    });
         $.ajax({
        url : 'http://solution-ticket-system/api/prioritaeten',
        type : 'GET',
        data : {},
        dataType:'json',
        success : function(data) { 
             for(var i = 0; i < data.length; i++)
            {
               document.getElementById('priority').options.add(new Option(data[i].Level, data[i].ID));
            }
        }
    });
    
    $.ajax({
        url : 'http://solution-ticket-system/api/abteilungen',
        type : 'GET',
        data : {},
        dataType:'json',
        success : function(data) {
            for(var i = 0; i < data.length; i++)
            {
                document.getElementById('department').options.add(new Option(data[i].Name, data[i].ID));
            }
        }
    });
 
}

function SubmitTicket()
{
   
    $.ajax({
        url : 'http://solution-ticket-system/api/ticket',
        type : 'POST',
        data : { 
        subject:document.getElementById("subject").value,description:document.getElementById("description").value,
        category:document.getElementById("category").options[document.getElementById("category").selectedIndex].value,priority:document.getElementById("priority").options[document.getElementById("priority").selectedIndex].value,department:document.getElementById("department").options[document.getElementById("department").selectedIndex].value 
        },
        dataType:'json',
        beforeSend : function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + localStorage.token);
            console.log("beforeSend localStorage.getItem('token'): " + localStorage.getItem('token'));
            console.log("beforeSend xhr: " + xhr.beforeSend);
        },
        error: function(error, errorThrown) {
            console.log(error);
            console.log(errorThrown);
        },
        success : function(data) { 
     
            if(data == "1")
            {
            
                document.getElementById("display").innerHTML += "<br><br><font color='green'>Ticket erfolgreich abgeschickt!</font>";
            }
            else
            {
            
                document.getElementById("display").innerHTML += "<br><br><font color='red'>Fehler bei der Erstellung des Tickets</font>";
            }
        }
    });
}

function ShowTickets()
{
        document.getElementById("display").innerHTML = "<br><br><input type='button' class='btn btn-secondary btn-lg' value='Zurück zur Startseite' onclick='location.reload()'><br><br>";
        $.ajax({
        url : 'http://solution-ticket-system/api/tickets',
        type : 'GET',
        data : {},  // <-- Hier könnte man filtern
        dataType:'json',
        success : function(data) { 
           var ticketTable = "<table class='table-striped'><tr><th>Ticket-Ersteller</th><th>Kategorie</th><th>Dringlichkeit</th><th>Betreff</th><th>Abteilung</th></tr>";
            for(var i = 0; i < data.length; i++)
            {
               ticketTable += "<tr><td>" + data[i].Name + "</td><td>" + data[i].Kategorie + "</td><td>" + data[i].Prioritaet + "</td><td>" + data[i].Betreff + "</td><td>" + data[i].Abteilung + "</td><td><input type='button' class='btn btn-secondary'value='Inhalt anzeigen' onclick='ViewTicket(" + data[i].ID + ")'</td></tr>";
            }
            ticketTable += "</table>";
             document.getElementById("display").innerHTML += ticketTable;
        }
    });
    
}

function ViewTicket(id)
{
        $.ajax({
        url : 'http://solution-ticket-system/api/ticket',
        type : 'GET',
        data : {id:id}, 
        dataType:'json',
        success : function(data) { 
            var beschreibung = data[0].Beschreibung;
            alert(beschreibung);  
        }
    });
 
}


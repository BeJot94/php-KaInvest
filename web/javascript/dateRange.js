var app = express();
var fs = require('fs');

function getDataFromDB(){
	var bDate = document.getElementById("Bdate").value;
	var eDate = document.getElementById("Edate").value;
	
	if(bDate == '' || eDate == '')
		document.getElementById("test").innerHTML = "You have to fill both fields.";
	else
	{	
		var bDateClass = new Date(bDate);
		var eDateClass = new Date(eDate);
	
		if(bDateClass > eDateClass)
		{
			document.getElementById("test").innerHTML = "American studies discovered, that in 99,(9)% of cases <b>END DATE is LATER than BEGINNING DATE</b>. Make it correct!";
		}
		else
		{
			var query2 = "SELECT * FROM fundusz_inwestycyjny WHERE data >= '" + bDate + "' AND data <= '" + eDate + "'";
			document.getElementById("test").innerHTML = "4";
			
			fs.writeFile('public/query.txt', query2, { flag: 'w' }, function (err) {
			  if (err){				  
				  document.getElementById("test").innerHTML = "5";
				  return console.log(err);
			  }
			  else document.getElementById("test").innerHTML = 'UDALO SIE!';
			});
			document.getElementById("test").innerHTML = "6";
			
			app.get('/', function(request, response) {
				response.render('pages/index');
			});
		}	
	}
};
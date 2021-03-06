<?php

	session_start();
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>KaInvest - internship task</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link href="stylesheets/bootstrap.css" rel="stylesheet">
		<link href="stylesheets/main.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="../assets/js/html5shiv.js"></script>
		<![endif]-->
	  
		<link rel="stylesheet" href="stylesheets/morris.css">
		<script src="javascript/jquery.min.js"></script>
		<script src="javascript/raphael-min.js"></script>
		<script src="javascript/morris.min.js"></script>

		<link rel="stylesheet" href="stylesheets/chartist.min.css">
		<link href="stylesheets/bootstrap-responsive.css" rel="stylesheet">
		<link href="stylesheets/bootstrap.min.css" rel="stylesheet">
		<link href="stylesheets/dataTables.bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<script type="text/javascript" language="javascript" src="javascript/jquery-1.12.0.min.js"></script> 
		<script type="text/javascript" language="javascript" src="javascript/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="javascript/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" language="javascript" src="javascript/dateRange.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<!-- Script for drawing chart, get div with id #showResult -->
		<script type="text/javascript" class="init">		
			$(document).ready(function() {
				$('#showResult').DataTable();
			} );
		</script>
		
		<!-- Script for datepickers, get divs with id #datepicker & #datepicker2 -->
		<script>
			$(function() {
				$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
				$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
			});
		</script>	  
	</head>

	<body>
	  <div class="container-narrow">

		  <div class="masthead">
			<ul class="nav nav-pills pull-right">
			  <li class="active"><a href="/">Main</a></li>
			  <li><a href="/compare">Compare</a></li>
			</ul>
			<h3 class="muted">KaInvest</h3>
		  </div>

		  <hr>

		  <div class="jumbotron">
			<h1>Hello Kainos,<br />hello world!</h1>
			<p class="lead">This is my 3rd version of this task. I was on the wedding, I had cold, so that I had 3 days to complete this chalange. After 2 days of war with RoR and NodeJS (I can talk about
			it later), I've decided to complete this in PHP. Hope it's good enough for you to call me. :)</p>
			<a class="btn btn-large btn-success" href="#">Start work today</a>
		  </div>

		  <hr>

		  <div class="row-fluid marketing">
			<div class="span12">
			
			  <h4>Choose range of date for which you want to see data</h4>
			  <form action="php/changeRange.php" method="post">
				  <div class="form-group">
					<label for="inputdefault">Beginning date</label>
					<input class="form-control" name="Bdate" type="text" placeholder="YYYY-MM-DD" id="datepicker" <?php if(isset($_SESSION["bDate"])) echo 'value="' . $_SESSION["bDate"] . '"'; ?> required/>
					<label for="inputdefault">End date</label>
					<input class="form-control" name="Edate" type="text" placeholder="YYYY-MM-DD" id="datepicker2" <?php if(isset($_SESSION["eDate"])) echo 'value="' . $_SESSION["eDate"] . '"'; ?> required/>
					
					<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				  </div>
			  </form>
			  
			  <h5></h5>
			  
			  <h4>Stock prices of investment fund - chart data</h4>
			  <div id="KaInvestChart" style="height: 250px;"></div>
			  
			  <h5></h5>
			  
			  <h4>Stock prices of investment fund - tabular data</h4>
			  <table id="showResult" class="table table-striped table-bordered" width="100%" cellspacing="0">
				 <thead>
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
<?php
require_once "config/connect.php";

$polaczenie = pg_connect("host=" . $host . " dbname=" . $db_name . " user=" . $db_user . " password=" . $db_password)
					 or die('Connection error: ' . pg_last_error());
					 
if($polaczenie)
{
	// Check, if sb set date range for data, and:
	// * if true, get range of ID from DB, which we want to display,
	if(isset($_SESSION['bDate']) && isset($_SESSION['eDate']))
	{
		$query = "SELECT * FROM fundusz_inwestycyjny WHERE data >= '" . $_SESSION['bDate'] . "' ORDER BY data LIMIT 1";
		//echo $query . "<br />";
		$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
		$line = pg_fetch_array($result, null, PGSQL_ASSOC);
		$IDmax = $line["id"];
		
		$query = "SELECT * FROM fundusz_inwestycyjny WHERE data <= '" . $_SESSION['eDate'] . "' LIMIT 1";
		//echo $query . "<br />";
		$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
		$line = pg_fetch_array($result, null, PGSQL_ASSOC);
		$IDmin = $line["id"];
		
		//echo "max=" . $IDmax . " min=" . $IDmin;
	}
	// * if false, display 10 newest rows from DB.
	else
	{
		$IDmin = 1;
		$IDmax = 10;
	}
	
	// For every row selected above, display one row in table.
	for($i = $IDmin; $i <= $IDmax; $i++){
		
		$query = "SELECT * FROM fundusz_inwestycyjny WHERE id='$i'";								
		$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
										
		if($result)
		{
			$line = pg_fetch_array($result, null, PGSQL_ASSOC);
		
			echo "\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t<td>" . $line["id"] . "</td>\n";
			echo "\t\t\t\t\t\t<td>" . $line["data"] . "</td>\n";
			echo "\t\t\t\t\t\t<td>" . $line["wartosc"] . "</td>\n";
			echo "\t\t\t\t\t</tr>\n";
		}
	}
	
	pg_free_result($result);
	pg_close($polaczenie);
}
?>
				</tbody>
				</table>

		  <hr>

		  <div class="footer">
			<p>&copy; Bartosz Jasiński 2016</p>
		  </div>

		</div> <!-- /container -->
		
		<script>
			new Morris.Line({
			  // ID of the element in which we want to draw the chart.
			  element: 'KaInvestChart',
			  // Chart data records -- each entry in this array == point on the chart.
			  data: [
<?php
			require_once "config/connect.php";
		
			$polaczenie = pg_connect("host=" . $host . " dbname=" . $db_name . " user=" . $db_user . " password=" . $db_password)
								 or die('Connection error: ' . pg_last_error());
								 
			if(!$polaczenie)
			{
				echo "Error...";
			}
			else
			{
				// Check, if sb set date range for data, and:
				// * if true, get range of ID from DB, which we want to display,
				if(isset($_SESSION['bDate']) && isset($_SESSION['eDate']))
				{
					$query = "SELECT * FROM fundusz_inwestycyjny WHERE data >= '" . $_SESSION['bDate'] . "' ORDER BY data LIMIT 1";
					$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
					$line = pg_fetch_array($result, null, PGSQL_ASSOC);
					$IDmax = $line["id"];
					
					$query = "SELECT * FROM fundusz_inwestycyjny WHERE data <= '" . $_SESSION['eDate'] . "' LIMIT 1";
					$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
					$line = pg_fetch_array($result, null, PGSQL_ASSOC);
					$IDmin = $line["id"];
				}
				// * if false, display 10 newest rows from DB.
				else
				{
					$IDmin = 1;
					$IDmax = 10;
				}
				
				// For every row selected above, display one row of data to use in chart.
				for($i = $IDmin; $i <= $IDmax; $i++){
					
					$query = "SELECT * FROM fundusz_inwestycyjny WHERE id='$i'";								
					$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
													
					if($result)
					{
						$line = pg_fetch_array($result, null, PGSQL_ASSOC);
						
						if($i != $IDmax)
							echo "\t\t\t{" . ' day: "' . $line["data"] . '", value: ' . $line["wartosc"] . "},\n";
						else
							echo "\t\t\t{" . ' day: "' . $line["data"] . '", value: ' . $line["wartosc"] . "}\n";
					}
				}
				
				pg_free_result($result);
				pg_close($polaczenie);
			}
			
			unset($_SESSION["bDate"]);
			unset($_SESSION["eDate"]);
			?>
			  ],
			  // The name of the data record attribute that contains x-values.
			  xkey: 'day',
			  // A list of names of data record attributes that contain y-values.
			  ykeys: ['value'],
			  // Labels for the ykeys -- will be displayed when you hover over the chart.
			  labels: ['Value']
			});
		</script>
		
	</body>
</html>
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

		<link href="../stylesheets/bootstrap.css" rel="stylesheet">
		<link href="../stylesheets/main.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="../assets/js/html5shiv.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="../stylesheets/morris.css">
		<script src="../javascript/jquery.min.js"></script>
		<script src="../javascript/raphael-min.js"></script>
		<script src="../javascript/morris.min.js"></script>

		<link rel="stylesheet" href="../stylesheets/chartist.min.css">
		<link href="../stylesheets/bootstrap-responsive.css" rel="stylesheet">
		<link href="../stylesheets/bootstrap.min.css" rel="stylesheet">
		<link href="../stylesheets/dataTables.bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<script type="text/javascript" language="javascript" src="../javascript/jquery-1.12.0.min.js"></script> 
		<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="../javascript/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" language="javascript" src="../javascript/dateRange.js"></script>
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
          <li><a href="/">Main</a></li>
          <li class="active"><a href="/compare">Compare</a></li>
        </ul>
        <h3 class="muted">KaInvest</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1>Hello Kainos,<br />hello world!</h1>
        <p class="lead">This is the place, where you can compare your profits between investment funt and other investment.</p>
        <a class="btn btn-large btn-success" href="#">Start work today</a>
      </div>

      <hr>

      <div class="row-fluid marketing">
        <div class="span12">
		
		<h4>Choose range of date for which you want to invest + amout of money</h4>
		  <form action="../php/setCompareData.php" method="post">
			  <div class="form-group">
				<label for="inputdefault">Beginning date</label>
				<input class="form-control" name="Bdate" type="text" placeholder="YYYY-MM-DD" id="datepicker" <?php if(isset($_SESSION["bDate"])) echo 'value="' . $_SESSION["bDate"] . '"'; ?> required/>
				<label for="inputdefault">End date</label>
				<input class="form-control" name="Edate" type="text" placeholder="YYYY-MM-DD" id="datepicker2" <?php if(isset($_SESSION["eDate"])) echo 'value="' . $_SESSION["eDate"] . '"'; ?> required/>
				<label for="inputdefault">Interest</label>
				<input class="form-control" name="Interest" type="text" placeholder="Interest of investment (in %)..." <?php if(isset($_SESSION["interest"])) echo 'value="' . $_SESSION["interest"] . '"'; ?> required/>
				<label for="inputdefault">Amout of money</label>
				<input class="form-control" name="Money" type="text" placeholder="How much money do you want to invest..." <?php if(isset($_SESSION["invest"])) echo 'value="' . $_SESSION["invest"] . '"'; ?> required/>
				
				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
			  </div>
		  </form>
		  
		  <h5></h5>
		  
		  <h4>Compare your profits!</h4>
		  <p><?php if(isset($_SESSION["invest"])) echo "Amount of money for calculations: " . $_SESSION["invest"] . ". Daily capitalization is chosen for bank investment."; ?></p>
		  <div id="ProfitsChart" style="height: 250px;"></div>
		  
      <hr>

      <div class="footer">
        <p>&copy; Bartosz Jasiński 2016</p>
      </div>

    </div> <!-- /container -->
	
	<script>
			new Morris.Line({
			  // ID of the element in which to draw the chart.
			  element: 'ProfitsChart',
			  // Chart data records -- each entry in this array == point on the chart.
			  data: [
<?php
			require_once "../config/connect.php";
		
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
					$IDmin = $line["id"] + 1;
					
					$incomeFund = 0;
					$incomeBank = 0;
					
					// For every row selected above, display one row of data to use in chart.
					for($i = $IDmax; $i >= $IDmin; $i--){
						
						$query = "SELECT * FROM fundusz_inwestycyjny WHERE id='$i'";								
						$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
														
						if($result)
						{
							$line = pg_fetch_array($result, null, PGSQL_ASSOC);
							
							// Create new object of class DateTime - it allows to compare how many days were since last entry in DB.
							$newDay = new DateTime($line["data"]);
							
							if($i != $IDmax)
							{
								// Calculate possible income after selling all stocks in every day.
								// income from fund = (value of stock * amount of bought stocks) - invested money.
								$incomeFund = (($line["wartosc"] * $_SESSION["stocks"]) - $_SESSION["invest"]);
								
								// Get amount of days since last entry in DB.
								$dDif = $lastDay->diff($newDay);
								
								// We're using daily capitalization, so if there's more than one day between entries, we have to calculate income from X days.
								for($j = 0; $j < $dDif->days; $j++)
								{
									// Calculate daily income from bank and overall income.
									// daily income from bank = (invested money * interest (in %)) / days per year
									$dailyIncomeBank = ($_SESSION["invest"] * ($_SESSION["interest"] / 100)) / 365;
									$incomeBank += $dailyIncomeBank;
									// We have to increase amout of money which is ,,working" on bank investment every day.
									$_SESSION["invest"] += $dailyIncomeBank;
								}
							}
							
							// After counting daily income, set last used day as day using now.
							$lastDay = $newDay;
							
							if($i != $IDmin)
								echo "\t\t\t{" . ' day: "' . $line["data"] . '", incomeFund: ' . round($incomeFund, 4) . ', incomeBank: ' . round($incomeBank, 4) . "},\n";
							else
								echo "\t\t\t{" . ' day: "' . $line["data"] . '", incomeFund: ' . round($incomeFund, 4) . ', incomeBank: ' . round($incomeBank, 4) . "}\n";
						}
					}
				}
				// * if false, show one point in chart equals 0.
				else
				{
					$incomeFund = 0;
					$incomeBank = 0;
					
					echo "\t\t\t{" . ' day: "' . $line["data"] . '", incomeFund: ' . $incomeFund . ', incomeBank: ' . $incomeBank . "}\n";
				}
				
				pg_free_result($result);
				pg_close($polaczenie);
			}
			
			unset($_SESSION["bDate"]);
			unset($_SESSION["eDate"]);
			unset($_SESSION["stocks"]);
			unset($_SESSION["invest"]);
			?>
			  ],
			  // The name of the data record attribute that contains x-values.
			  xkey: 'day',
			  // A list of names of data record attributes that contain y-values.
			  ykeys: ['incomeFund', 'incomeBank'],
			  // Labels for the ykeys -- will be displayed when you hover over the chart.
			  labels: ['Income from fund', 'Income from bank']
			});
		</script>
</body>
</html>
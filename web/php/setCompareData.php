<?php

	session_start();
	
	// Getting data from form
	$_SESSION['bDate'] = $_POST['Bdate'];
	$_SESSION['eDate'] = $_POST['Edate'];
	$_SESSION['interest'] = $_POST['Interest'];
	
	require_once "../config/connect.php";
						
	$polaczenie = pg_connect("host=" . $host . " dbname=" . $db_name . " user=" . $db_user . " password=" . $db_password)
						 or die('Connection error: ' . pg_last_error());
						 
	if($polaczenie)
	{
		// Get price of one stock at beginning date
		$query = "SELECT * FROM fundusz_inwestycyjny WHERE data >= '" . $_SESSION['bDate'] . "' ORDER BY data LIMIT 1";
		//echo $query . "<br />";
		$result = pg_query($query) or die('Incorrect query: ' . pg_last_error());
		$line = pg_fetch_array($result, null, PGSQL_ASSOC);
		$stockPrice = $line["wartosc"];			

		// Set amout of stocks depending on invested money and stock price
		$_SESSION['stocks'] = (int)((int)$_POST['Money'] / $stockPrice);
		
		// Set real amout of invested money
		$_SESSION['invest'] = $_SESSION['stocks'] * $stockPrice;
		
		pg_free_result($result);
		pg_close($polaczenie);
	}
	
	header('Location: ../compare/');
	
?>
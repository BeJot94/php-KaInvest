<?php

	session_start();
	
	// Getting data from form
	$_SESSION['bDate'] = $_POST['Bdate'];
	$_SESSION['eDate'] = $_POST['Edate'];
	
	header('Location: ..');
	
?>
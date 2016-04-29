<?php

	session_start();
	
	$_SESSION['bDate'] = $_POST['Bdate'];
	$_SESSION['eDate'] = $_POST['Edate'];
	
	header('Location: ..');
	
?>
<?php
	ini_set('session.cookie_domain', 'realsil.net');    
	session_set_cookie_params(7776000, '/', 'realsil.net', false, true);
    session_start();
	
	

	/*if (date("G") == 1 && date("i") < 10) 
	{
		include('template/maintenance.php');
		//wtf is this?
		die();
	}*/
	
	$con = mysql_connect("localhost","zinefer_rsil","7c7=K)ug=Usv");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("zinefer_rsil", $con);
	//here
	$selectUser = "SELECT * FROM `workers` where `Key` = " . mysql_real_escape_string($_SESSION['userkey']) . " Limit 1";
	if($result = mysql_query($selectUser))
	{
		$userRow = mysql_fetch_assoc($result);
	}
	
	if (!$userRow or $userRow['Password'] != $_SESSION['pass'])
	{	session_destroy();
		header("Location: login.php"); 
		die(); 
	} 
	
	if ($_GET['client'] == 'clear')
	{
		unset($_SESSION['client']);
		unset($_SESSION['clientName']);
	}elseif ($_GET['client'] == 'new'){
		//Do nothing
	}elseif (($_SESSION['client'] != $_GET['client']) && $_GET['client']) {  
		$client = mysql_query("SELECT `First Name`, `Last Name`, `File Location` FROM `clients` where `key` = ".mysql_real_escape_string($_GET['client']));
		$clientrow = mysql_fetch_row($client);
		if ($clientrow)
		{
			$_SESSION['client'] = $_GET['client'];
			$_SESSION['clientName'] = $clientrow[0]." ".$clientrow[1];
			$_SESSION['clientFileLocation'] = $clientrow[2];
		}else{
			echo 'Invalid Client ID';
		}
	}
?>
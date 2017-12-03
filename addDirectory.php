<?php		
  include 'funkcje.php';
	checkLogin(false, true);
	
	session_start();
	
	if ($_GET['dirName'] != '' && !file_exists($_GET['dirName'])
		&& (preg_match('/^ftp\\/+' . $_SESSION['login'] . '\\/+.*/', $_GET['dirName']))) {
		mkdir($_GET['dirName'], 0777, true);
	}
	
	header("Location: index.php");
?>

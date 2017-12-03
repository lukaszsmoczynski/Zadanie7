<?php		
  include 'funkcje.php';
	checkLogin(false, true);
	
	session_start();
	
	foreach($_FILES as $klucz => $wartosc){
		if (is_uploaded_file($_FILES[$klucz]['tmp_name'])) {
			move_uploaded_file($_FILES['file']['tmp_name'], 'ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $_FILES['file']['name']);
		}
	}
	
	header("Location: index.php");
?>

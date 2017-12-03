<?php		
  include 'funkcje.php';
	checkLogin(false, true);
	
	session_start();
	
	if ($_POST['fileName'] != '' && file_exists($_POST['fileName'])
		&& (preg_match('/^ftp\\/+' . $_SESSION['login'] . '\\/+.*/', $_POST['fileName']))) {
		if (is_dir($_POST['fileName']))
			exec('rm -rf ' . $_POST['fileName']);
		else
			unlink($_POST['fileName']);
	}
	
	header("Location: index.php");
?>

<?php		
  include 'funkcje.php';
	checkLogin(false, true);
	
	session_start();
	
	if ($_GET['ftpDir'] != '') {
		if ($_GET['ftpDir'] == '.')
			continue;
		
		if ($_GET['ftpDir'] == '../') {
			$tablica = explode('/', $_SESSION['ftpDir']);
			
			array_pop($tablica);
			array_pop($tablica);
			
			$_SESSION['ftpDir'] = implode('/', $tablica);
			
			header("Location: index.php");
		} elseif (file_exists('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $_GET['ftpDir'])
			&& is_dir('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $_GET['ftpDir'])) {
			$_SESSION['ftpDir'] .= '/' . $_GET['ftpDir'];
			header("Location: index.php");
		} else {
			header("Location: index.php?fileNotExists=1");
		}
	}
	
	header("Location: index.php");
?>

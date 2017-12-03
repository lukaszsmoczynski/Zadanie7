<?php		
	$cookie = array();
	$cookie['name'] = 'user_PAS';
	$cookie['expire'] = time() + 86400 * 7;
	$cookie['path'] = '/';
	$cookie['value'] = $_POST['login'];
	
  include 'funkcje.php';
	
	function addUser($conn, $login, $password){
		global $sql;
		
		$result = $conn->query('SELECT * FROM users WHERE LOGIN = ' . quotedStr($login));
		
		if ($result->num_rows > 0)
			return false;
		
		$result = $conn->query('INSERT INTO users(LOGIN, PASSWORD) VALUES(' . quotedStr($login) . ', ' . quotedStr($password) . ');');
		
		mkdir($_SERVER['DOCUMENT_ROOT'] . '/Zadanie7/ftp/' . $login, 0777, true);
		return true;
	}
	
	if ($conn = connectToDB()) {
		if (addUser($conn, $_POST['login'], $_POST['md5password'])) {
			header('Location: login.php?userRegistered=1');
			setcookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path']);
		} else {
			header('Location: register.php?userExists=1');
		}
		
		$conn->close();
	}
?>

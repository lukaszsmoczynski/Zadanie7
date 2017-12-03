<?php		
  include 'funkcje.php';
	checkLogin(false, true);
	
	$cookie = array();
	$cookie['name'] = 'user_PAS';
	$cookie['expire'] = time() + 86400 * 7;
	$cookie['path'] = '/';
	$cookie['value'] = $_POST['login'];
	
	$userID = 0;
	
	function tryLogin($conn, $login, $password){
		global $userID;
		
		$result = $conn->query('SELECT * FROM users WHERE LOGIN = ' . quotedStr($login));
		
		if ($result->num_rows <= 0)
			return false;
		
		while($row = $result->fetch_assoc())
			if ($row['FAILED_LOGINS'] >= 3) {
				return -1;
			} elseif ($row['PASSWORD'] == $password) {
				$userID = $row['ID'];
				$conn->query(' UPDATE users SET FAILED_LOGINS = 0 WHERE ID = ' . $row['ID']);
				$conn->query(' INSERT INTO logi(USER_ID, RESULT, SEEN, IP) VALUES (' . quotedStr($userID) . ', 1, 1, ' . quotedStr($_SERVER["REMOTE_ADDR"]) . '); ');
				return 1;
			} else {
				$conn->query('UPDATE users SET FAILED_LOGINS = FAILED_LOGINS + 1 WHERE ID = ' . $row['ID']);
				$conn->query(' INSERT INTO logi(USER_ID, RESULT, IP) VALUES (' . $row['ID'] . ', 0, ' . quotedStr($_SERVER["REMOTE_ADDR"]) . '); ');
				if ($row['FAILED_LOGINS'] >= 2)
					return -1;
				else
					return 0;
			}
	}
	
	if ($conn = connectToDB()) {
		$wynik = tryLogin($conn, $_POST['login'], $_POST['md5password']);
		if ($wynik == 1) {
			session_start();
			$_SESSION['userID'] = $userID;
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['loggedIn'] = true;
			
			setcookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path']);
			header('Location: index.php?login=1');
		} elseif ($wynik == 0) {
			header('Location: login.php?loginFailed=1');
		} elseif ($wynik == -1) {
			header('Location: login.php?accountBlocked=1');
		}
		$conn->close();
	}
?>

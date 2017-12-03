<?php
	function connectToDB(){		
		$servername = 'localhost';
		$username = 'smoczynskiuk_Zadanie7';
		$password = 'haslo_HASLO';
		$dbName = 'smoczynskiuk_Zadanie7';
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbName);

		// Check connection
		if ($conn->connect_error) {
			return null;
		}
		
		return $conn;
	}
	
	function quotedStr($string) {
		$string = str_replace('\'', '\'\'', $string);
		return '\'' . $string . '\'';
	}
	
	function checkLogin($login, $logout){
		session_start();
		if ($login && IsSet($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
			header('Location: /Zadanie7/index.php');
		
		if ($logout && (!IsSet($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false))
			header('Location: /Zadanie7/logout.php');
	}
	
	function getFailedLogins($userID) {
		$conn = connectToDB();
		
		$result = $conn->query(' SELECT * FROM logi l WHERE l.USER_ID = ' . $userID . ' AND l.RESULT = 0 AND l.SEEN = 0 ');
		
		if ($result->num_rows <= 0)
			return;
		
		$wynik = 'Ostatnie nieudane logowania:\r\n';
		while($row = $result->fetch_assoc()){
			$wynik .= $row['LOGIN_DATE'] . ', IP: ' . $row['IP'] . '\r\n';
		}
			
		$conn->query(' UPDATE logi SET SEEN = 1 WHERE USER_ID = ' . $userID . ' AND SEEN = 0 ');
		
		return $wynik;
	}
?>
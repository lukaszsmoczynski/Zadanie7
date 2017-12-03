<?php
	include 'funkcje.php';
	checkLogin(true, false);

	$cookie = array();
	$cookie['name'] = 'user_PAS';
	
  echo '<!doctype html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Łukasz Smoczyński</title>
</head>
<body>
<a href="..">W górę</a><br>';
	
	echo '
	<script type="text/javascript"
    src="md5.js"></script>
		
	<script type="text/javascript">
function szyfrujHaslo(form){
	if (form.password.value != "") {
		form.md5password.value = md5(form.password.value);
		form.password.value = "";
	}
}
</script>';
	
	echo '<center>
	<form method="POST" action="checkLogin.php" onsubmit="szyfrujHaslo(this);"><br>
Login: <input type="text" name="login" maxlength="100" value="' . $_COOKIE[$cookie['name']] . '"><br>
Hasło: <input type="password" name="password"><br>
<input type="hidden" name="md5password" value="" />
<input type = "submit" value="Zaloguj"/>
</form><br>';

	if (IsSet($_GET['loginFailed']) && $_GET['loginFailed'] == 1)
		echo '<font color="red">Niepoprawny login lub hasło</font>';

	if (IsSet($_GET['userRegistered']) && $_GET['userRegistered'] == 1)
		echo '<font color="#669933">Dodano użytkownika. Możesz się zalogować</font>';
	
	if (IsSet($_GET['accountBlocked']) && $_GET['accountBlocked'] == 1)
		echo '<font color="red">Konto zostało zablokowane z powodu serii nieudanych prób logowania, skontaktuj się z administratorem</font>';

	echo '<br><br>
	Nie masz konta? <a href = "register.php">Zarejestruj się</a>
	';
	
	echo '</body>
</html>';
?>

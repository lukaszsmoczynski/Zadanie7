<?php	
  echo '<!doctype html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Łukasz Smoczyński</title>
</head>
<body>
<a href="..">W górę</a><br><a href = "login.php">Cofnij</a><br>';
	
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
	
	echo '<center><form method="POST" action="doRegister.php" onsubmit="szyfrujHaslo(this);">
<br>
Login: <input type="text" name="login" maxlength="100" value="' . $_COOKIE[$cookie['name']] . '"><br>
Hasło: <input type="password" name="password"><br>
<input type="hidden" name="md5password" value="" />
<input type = "submit" value="Zarejestruj"/>
</form><br>';

	if (IsSet($_GET['userExists']) && $_GET['userExists'] == 1)
		echo '<font color="red">Taki użytkownik już istnieje w systemie</font>';
	
	echo '</body>
</html>';
?>

<?php
  include 'funkcje.php';
	checkLogin(false, true);
	
	session_start();
	
	global $failedLoginsDescription;
	if ($_GET['login'] == 1)
		$failedLoginsDescription = getFailedLogins($_SESSION['userID']);
?>
	
<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Łukasz Smoczyński</title>
		<script type="text/javascript">
			function showFailedLogins(){
				var failedLoginsDescription = <?php echo quotedStr($failedLoginsDescription); ?>;
				if (failedLoginsDescription.trim() != "")
					alert(failedLoginsDescription.trim());
			}
			
			function deleteFile(div){
				var link = document.getElementById(div.id.substr(4));
				link.attributes.onclick.value = "return false;";
				
				var wynik = confirm("Czy na pewno chcesz usunąć " + (link.attributes.class == 'directory'?'folder':'plik') + " " + link.attributes.id.value + "?")
				
				if (wynik){
					var form = document.createElement("form");
					form.setAttribute("method", "post");
					form.setAttribute("action", "delete.php");
					
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", "fileName");
					hiddenField.setAttribute("value", <?php echo quotedStr('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/')?> + link.attributes.id.value);
					form.appendChild(hiddenField);
						
					document.body.appendChild(form);
					form.submit();
				}
				else
					window.location.href = 'index.php';
			}
			
			function addFiles(){
				var form = document.createElement("form");
				form.setAttribute("method", "post");
				form.setAttribute("action", "addFile.php");
				form.setAttribute("ENCTYPE", "multipart/form-data");
				form.setAttribute("id", "addFiles");
				document.body.appendChild(form);

				var input = document.createElement('input');
				form.appendChild(input);

				input.type = 'file';
				input.name = 'file';
				input.click();
				input.setAttribute("onchange", "document.getElementById('addFiles').submit();");
			}
			
			function addDirectory(){
				var wynik = prompt("Podaj nazwę folderu:")
				if (wynik != null){
					window.location.href = 'addDirectory.php?dirName=' + <?php echo quotedStr('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/')?> + wynik;
				}
			}
		</script>
	</head>
	<body onload="showFailedLogins();">
		<div style="width:100%;text-align:left;position:fixed;background-color:#364bd2;height:20px;z-index:9999;"><a href="..">W górę</a></div>
		<div class="content">
			<div class="top">
				Witaj, <?php echo $_SESSION['login'] ?> || <a href="/Zadanie7/logout.php">Wyloguj</a>
			</div><br>
			<div class="functions">
				<button class="btn" onclick="addFiles()">
				  Dodaj plik
				</button>
				<button class="btn" onClick="addDirectory()">
				  Dodaj katalog
				</button>
			</div>
			<div class="files">
<?php	
	foreach (scandir('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir']) as $wartosc) {
		$maxTekstLength = 20;
		$tekst;
		$klasa;
		
		if ($wartosc == '.')
			continue;
			
		if ($wartosc == '..') {
			if ($_SESSION['ftpDir'] == '')
				continue;
			
			$klasa = 'up';
			$tekst = 'W górę';
		} elseif (is_dir('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $wartosc)){
			$klasa = 'directory';
			
			if (strlen($wartosc) > $maxTekstLength)
				$tekst = substr($wartosc, 0, $maxTekstLength) . '...';
			else
				$tekst = $wartosc;
		}
		elseif (is_file('ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $wartosc)){
			$klasa = 'file';
			
			if (strlen($wartosc) > $maxTekstLength)
				$tekst = substr($wartosc, 0, $maxTekstLength) . '...';
			else
				$tekst = $wartosc;
		}
		
		
		echo '<a onclick class="' . $klasa . '" id="' . $wartosc . '" href="' . ($klasa == 'file'?'ftp/' . $_SESSION['login'] . '/' . $_SESSION['ftpDir'] . '/' . $wartosc:'przejdz.php?ftpDir=' . $wartosc . '/') . '">';
		if ($klasa != 'up')
			echo '<div class="deleteFile" onclick="deleteFile(this);" id = "div_' . $wartosc . '">
						</div>';
		
		echo '<div class="image">
						</div>
						<div class="description">'
							. $tekst .
						'</div>
					</a>';
	}
?>
			</div>
		</div>
	</body>
</html>

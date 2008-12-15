<html>
<head>
<title>login</title>
</head>
<body>
	<form method="post" action="index.php">
		<label for="login">login:</label><input type="text" name="login" id="login" />
		<label for="heslo">heslo:</label><input type="text" name="heslo" id="login" />
		<input type="submit" />
	</form>
	{if $chyba}
		Špatné heslo nebo jméno
	{/if}
</body>
</html>
{include file='hlavicka.tpl'}

<div id="prihlaseni">
<div id="prihlaseni-obsah">
	<form method="post" action="index.php">
		<label for="login">login:</label><input type="text" name="login" id="login" />
		<label for="heslo">heslo:</label><input type="password" name="heslo" id="login" />
		<input type="submit" />
	</form>
	{if $chyba}
		<span>Špatné heslo nebo jméno</span>
	{/if}
</div>
</div>

{include file='paticka.tpl'}

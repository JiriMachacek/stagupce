
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<form action="./?modul=uzivatele&amp;metoda=vloz" method="post">
   
   <label for="login">Login</label>
   <input type="text" name="login" id="login" size="40" value="{$login}" />
   {if $loginchyba}<span>Chyba! nebyl vyplněn login</span>{/if}{if $loginchybaexistuje}Chyba! Tento login už existuje...{/if}
   
   <label for="heslo">Heslo</label>
   <input type="text" name="heslo" id="heslo" size="40" value="{$heslo}" />
   {if $heslochyba}<span>Chyba! nebylo vyplněno heslo</span>{/if}
   
	<label for="typ">Typ</label>
	{html_options name=typ options=$prava selected=$vybrano}
	{if $typchyba}<span>Chyba! nebyl vyplněn typ uživatele</span>{/if}

	<label for="jmeno">Jméno</label>
	<input type="text" name="jmeno" id="jmeno" size="40" value="{$jmeno}" />
	{if $jmenochyba}<span>Chyba! nebylo vyplněno jméno uživatele</span>{/if}

	<label for="prijmeni">Přímení</label>
	<input type="text" name="prijmeni" id="prijmeni" size="40" value="{$prijmeni}" />
	{if $prijmenichyba}<span>Chyba! nebylo vyplněno příjmení uživatele</span>{/if}

   
   <input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}

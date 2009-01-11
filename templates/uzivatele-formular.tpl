
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<form action="./?modul=uzivatele&amp;metoda=vloz" method="post">
   
   <label for="login">login</label>
   <input type="text" name="login" id="login" size="40" value="{$login}" />
   {if $loginchyba}Chyba! nebyl vyplněn login{/if}{if $nazevchybaexistuje}Chyba! Tento login už existuje...{/if}
   
   <label for="typ">Typ</label>
   {html_options name=typ options=$prava selected=$typ}

   <label for="jmeno">Jméno</label>
   <input type="text" name="jmeno" id="jmeno" size="40" value="{$jmeno}" />
  
      <label for="primeni">Přímení</label>
   <input type="text" name="jmeno" id="jmeno" size="40" value="{$jmeno}" />

   
   <input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}
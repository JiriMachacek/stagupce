{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<form action="./?modul=ucebnytypy&amp;metoda=vloz" method="post">
   
   <label for="typ">Typ učebny</label>
   <input type="text" name="typ" id="typ" size="40" value="{$typ}" />
   {if $typchyba}Chyba! nebyl vyplněn název souboru{/if}{if $typchybaexistuje}Chyba! Tento typ už existuje...{/if}
   
   <input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}
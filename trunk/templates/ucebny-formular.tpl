{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Nová učebna</h2>
<form action="./?modul=ucebny&amp;metoda=vloz" method="post">
   
   <label for="nazev">Název</label>
   <input type="text" name="nazev" id="nazev" size="40" value="{$nazev}" />
   
   {if $nazevchyba}<span>Chyba! nebyl vyplněn název učebny</span>{/if}{if $nazevchybaexistuje}<span>Chyba! Tento název už existuje...</span>{/if}
   
	<label for="typ">Typ</label>
	{html_options name=typ options=$typy selected=$typ}
	
	{if $typchyba}<span>Chyba! nebyl vybrán typ učebny</span>{/if}
   
   <label for="kapacita">Kapacita</label>
   <input type="text" name="kapacita" id="kapacita" size="40" value="{$kapacita}" />
   
   {if $kapacitachyba}<span>Chyba! nebyla vyplněna kapacita učebny nebo byla vyplněna špatně...</span>{/if}
   
   
   <input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}

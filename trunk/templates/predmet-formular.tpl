
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Nový předmět</h2>
<form action="./?modul=predmet&amp;metoda=vloz" method="post">

   <label for="nazev">Název</label>
   <input type="text" name="nazev" id="nazev" size="40" value="{$nazev}" />
   {if $nazevchyba}Chyba! nebyl vyplněn název předmětu{/if}{if $nazevchybaexistuje}Chyba! Tento předmět už existuje...{/if}
   
   <label for="garant">Garant</label>
   {html_options name=garant options=$ucitele selected=$garant}
   {if $chybagarant}Chyba! Vyberte garanta předmětu{/if}
   
	<label for="zkouska">Zkouška</label>
	{html_options name=zkouska options=$anoNe selected=$zkouska}

	<label for="pocet_kreditu">Počet kreditů</label>
	<input type="text" name="pocet_kreditu" id="pocet_kreditu" size="40" value="{$pocet_kreditu}" />
   {if $pocet_kredituchyba}Chyba! neplatný počet kreditů {/if}
	<input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Zápis přidmětů</h2>
<form action="./?modul=rozvrhprihlaseni&metoda=zobraz" method="post">
<table>
	<tr>
		<th>Název</th>
		<th>Zkoušející</th>
		<th>Učebna</th>
		<th>Čas</th>
		<th>Volných míst</th>
		<th>Zapsat</th>
	</tr>

	{foreach from=$rozvrh item=predmet}
	<tr>
		<td>{$predmet.predmet_nazev}</td>
		<td>{$predmet.zkousejici}</td>
		<td>{$predmet.ucebna_nazev}</td>
		<td>{$predmet.cas}</td>
		<td>{$predmet.kapacita}</td>
		<td><input type="checkbox" name="predmet[]" value="{$predmet.ID_hodina}" /></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="9">Nejsou žádné zkoušky</td>
	</tr>
	{/foreach}

</table>
{if $rozvrh}
<input type="submit" name="ok" value="Vlož" />
{/if}
</form>
</div>
</div>
{include file="paticka.tpl"}
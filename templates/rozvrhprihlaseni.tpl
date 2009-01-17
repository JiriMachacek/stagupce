{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Zápis přidmětů</h2>
<form action="./?modul=rozvrhprihlaseni&metoda=zobraz" method="post">
<table>
	<tr>
		<th>Název</th>
		<th>Přednáška</th>
		<th>Kredity</th>
		<th>Zkouška</th>
		<th>Čas</th>
		<th>Den</th>
		<th>Týden</th>
		<th>Volných míst</th>
		<th>Zapsat</th>
	</tr>

	{foreach from=$rozvrh item=predmet}
	<tr>
		<td>{$predmet.nazev}</td>
		<td>{$predmet.prednaska}</td>
		<td>{$predmet.pocet_kreditu}</td>
		<td>{$predmet.zkouska}</td>
		<td>{$predmet.cas}</td>
		<td>{$predmet.den}</td>
		<td>{$predmet.tyden}</td>
		<td>{$predmet.kapacita}</td>
		<td><input type="checkbox" name="predmet[]" value="{$predmet.ID_hodina}" /></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="9">Nejsou žádné předměty k zápisu</td>
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
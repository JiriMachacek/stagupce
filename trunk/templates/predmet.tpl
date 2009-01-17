{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Seznam předmětů</h2>
<a href="./?modul=predmet&amp;metoda=vloz">Nový předmět</a><br />
<table>
	<tr>
		<th>Název</th>
		<th>Počet<br />kreditů</th>
		<th>Zkouška</th>
		<th>Garant</th>
		<th>Akce</th>
	</tr>

	{foreach from=$predmety item=predmet}
	<tr>
		<td>{$predmet.nazev}</td>
		<td>{$predmet.pocet_kreditu}</td>
		<td>{$predmet.zkouska}</td>
		<td>{$predmet.jmeno}</td>
		<td><a href="./?modul=predmet&amp;metoda=vymaz&amp;predmet={$predmet.ID_predmet}">vymazat</a></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="5">žádné předměty</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}
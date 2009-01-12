{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<table>
	<tr>
		<th>Název</th>
		<th>Přednáška</th>
		<th>Kredity</th>
		<th>Zkouška</th>
		<th>Čas</th>
		<th>Den</th>
		<th>Týden</th>
		<th>Kapacita</th>
		<th>Akce</th>
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
		<td><a href="?modul=rozvrhzalozeni&amp;metoda=vloz&amp;predmet={$predmet.ID_predmet}">přidat</a> smazat</td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="4">žádné učebny</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}
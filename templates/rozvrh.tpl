{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<table>
	<tr>
		<th>Týden</th>
		<th>Den</th>
		<th>Začátek</th>
		<th>Konec</th>
		<th>Předmět</th>
		<th>Učebna</th>
	</tr>

	{foreach from=$rozvrh item=predmet}
	<tr>
		<td>{$predmet.tyden}</td>
		<td>{$predmet.den}</td>
		<td>{$predmet.zacatek|date_format:"%H:%M"}</td>
		<td>{$predmet.konec|date_format:"%H:%M"}</td>
		<td>{$predmet.predmet}</td>
		<td>{$predmet.ucebna}</td>
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
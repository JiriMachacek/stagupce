{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<table border="1">
	<tr>
		<th>Autor</th>
		<th>Datum</th>
		<th>Název</th>
	</tr>
	<tr>
		<th colspan="3">Popis</th>
	</tr>
	{foreach from=$novinky item=novinka}
	<tr>
		<td>{$novinka.jmeno}</td>
		<td>{$novinka.datum}</td>
		<td>{$novinka.nazev}</td>
	</tr> 
	<tr>
		<th colspan="3">{$novinka.popis}</th>
	</tr>		
	{foreachelse}
	<tr>
		<td colspan="3">žádné novinky</td>
	</tr>
	{/foreach}

</table>

</div>
</div>
{include file="paticka.tpl}

{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<table border="1">
	<tr>
		<th>Vložil</th>
		<th>Předmět</th>
		<th>Název</th>
		<th>Popis</th>
		<th>Vloženo</th>
		<th>Velikost</th>
		<th>Přístupnost</th>
	</tr>
	{foreach from=$materialy item=material}
	<tr>
		<td>{$material.jmeno}</td>
		<td>Jeste neni</td>
		<td>{$material.nazev}</td>
		<td>{$material.popis}</td>
		<td>{$material.upload}</td>
		<td>{$material.velikost}</td>
		<td>{$material.pristupne}</td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="7">žádné novinky</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}

{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Typy učeben</h2>
<a href="./?modul=ucebnytypy&amp;metoda=vloz">Nový typ</a><br />

<table>
	<tr>
		<th>Typ</th>
		<th>Akce</th>
	</tr>

	{foreach from=$ucebny item=ucebna}
	<tr>
		<td>{$ucebna.typ}</td>
		<td><a href="./?modul=ucebnytypy&amp;metoda=vymaz&amp;ucebnatyp={$ucebna.ID_typ}">vymazat</a></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="4">žádné typy učeben</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<a href="./?modul=ucebnytypy&amp;metoda=vloz">Nový typ</a><br />
<table>
	<tr>
		<th>Typ</th>
		<th>Akce</th>
	</tr>

	{foreach from=$ucebny item=ucebna}
	<tr>
		<td>{$ucebna.typ}</td>
		<td>edit smazat</td>
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
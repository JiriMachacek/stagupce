{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<a href="./?modul=ucebny&metoda=vloz">Nová učebna</a><br />
<a href="./?modul=ucebnytypy&metoda=zobraz">Spravovat typy</a><br />
<table>
	<tr>
		<th>Název</th>
		<th>Typ</th>
		<th>Kapacita</th>
		<th>Akce</th>
	</tr>

	{foreach from=$ucebny item=ucebna}
	<tr>
		<td>{$ucebna.nazev}</td>
		<td>{$ucebna.typ}</td>
		<td>{$ucebna.kapacita}</td>
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
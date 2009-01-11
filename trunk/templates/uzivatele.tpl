{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<a href="./?modul=uzivatele&amp;metoda=vloz">Nový uživatel</a><br />
<table>
	<tr>
		<th>Typ</th>
		<th>Akce</th>
	</tr>

	{foreach from=$uzivatele item=uzivatel}
	<tr>
		<td>{$uzivatel.typ} || {$uzivatel.jmeno} {$uzivatel.prijmeni} </td>
		<td>edit smazat</td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="4">žádní uživatelé</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}
{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<a href="./?modul=uzivatele&amp;metoda=vloz">Nový uživatel</a><br />
<table>
	<tr>
		<th>Typ</th>
		<th>Jméno</th>
		<th>Login</th>
		<th>Akce</th>
	</tr>

	{foreach from=$uzivatele item=uzivatel}
	<tr>
		<td>{$uzivatel.typ}</td>
		<td>{$uzivatel.jmeno} {$uzivatel.prijmeni} </td>
		<td>{$uzivatel.login}</td>
		<td><a href="./?modul=uzivatele&amp;metoda=vymaz&amp;uzivatel={$uzivatel.ID_uzivatel}">vymazat</a></td>
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

{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<a href="./?modul=predmet&amp;metoda=vloz">Nový předmět</a><br />
<table>
	<tr>
		<th>Název</th>
		<th>Akce</th>
	</tr>

	{foreach from=$predmet item=ptedmet}
	<tr>
		<td>{$predmet.nazev} || {$predmet.ID_uzivatel_garant} </td>
		<td>edit smazat</td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="4">žádné předměty</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}
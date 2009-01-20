{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
	<a href="./?modul=rozvrhzalozeni&amp;metoda=vloz">nový předmět na rozvrh</a>

<table>
	<tr>
		<th>Název</th>
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
		<td>{$predmet.pocet_kreditu}</td>
		<td>{$predmet.zkouska}</td>
		<td>{$predmet.cas}</td>
		<td>{$predmet.den}</td>
		<td>{$predmet.tyden}</td>
		<td>{$predmet.kapacita}</td>
		<td><a href="./?modul=rozvrhzalozeni&amp;metoda=vymaz&amp;hodina={$predmet.ID_hodina}">vymazat</a></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="8">Nejsou žádné předměty k rozvrhu</td>
	</tr>
	{/foreach}

</table>
</div>
</div>
{include file="paticka.tpl"}

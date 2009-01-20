{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">
<h2>Zápis přidmětů</h2>
<form action="./?modul=rozvrhprihlaseni&metoda=zobraz" method="post">

	{if $uzivatele}
		<label for="uzivatel">Uživatel</label>
		<select name="uzivatel" id="uzivatel" onchange="submit()" >
		{html_options options=$uzivatele selected=$uzivatel}
		</select>
	{/if}

<table>
	<tr>
		<th>Název</th>
		<th>Zkouška</th>
		<th>Týden</th>
		<th>Den</th>
		<th>Čas</th>
		<th>Volných míst</th>
		<th>Zapsat</th>
	</tr>

	{foreach from=$rozvrh item=predmet}
	<tr>
		<td>{$predmet.nazev}</td>
		<td>{$predmet.zkouska}</td>
		<td>{$predmet.tyden}</td>
		<td>{$predmet.den}</td>
		<td>{$predmet.cas}</td>
		<td>{$predmet.kapacita}</td>
		<td><input type="checkbox" name="predmet[]" value="{$predmet.ID_hodina}"{if $predmet.zapsano}checked{/if} /></td>
	</tr> 
	{foreachelse}
	<tr>
		<td colspan="7">Nejsou žádné zkoušky</td>
	</tr>
	{/foreach}

</table>
{if $rozvrh}
<input type="submit" name="ok" value="Vlož" />
{/if}
</form>
</div>
</div>
{include file="paticka.tpl"}

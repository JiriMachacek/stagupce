{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<form  method="post" enctype="multipart/form-data">
   
   <label for="predmet">Předmět</label>
   <select>
   	<option value="0" />žádný
   </select>
   <label for="soubor">Soubor</label><input type="file" name="soubor" id="soubor" size="40" />
   {if $souborchyba}Chyba! soubor se nepovedlo nahrát{/if}
   <label for="nazev">Název</label><input type="text" name="nazev" id="nazev" size="40" value="{if $nazev}{$nazev}{/if}" />
   {if $nazevchyba}Chyba! nebyl vyplněn název souboru{/if}
   
   <label for="pristupnost">Přístupnost</label><input type="text" name="pristupnost" id="pristupnost" value="{if $pristupnost}{$pristupnost}{/if}" />
   
   <label for="popis">Popis</label>
   <textarea rows="4" cols="20" id="popis" name="popis">{if $popis}{$popis}{/if}</textarea>
   
   <input type="submit" name="ok" VALUE="Upload">
   
</form>
</div>
</div>
{include file="paticka.tpl"}

{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<form action="./?modul=predmet&amp;metoda=vloz" method="post">
   
   <label for="nazev">Název</label>
   <input type="text" name="nazev" id="nazev" size="40" value="{$login}" />
   {if $nazevchyba}Chyba! nebyl vyplněn login{/if}{if $nazevchybaexistuje}Chyba! Tento login už existuje...{/if}
   
   <label for="prednaska">Přednáška</label>
   {html_options name=prednaska options=$anoNe selected=$vybrano}
   
    <label for="zkouska">Zkouška</label>
   {html_options name=zkouska options=$anoNe selected=$vybrano}

   <label for="jmeno">Jméno</label>
   <input type="text" name="jmeno" id="jmeno" size="40" value="{$jmeno}" />
  
      <label for="prijmeni">Příjmení</label>
   <input type="text" name="prijmeni" id="prijmeni" size="40" value="{$prijmeni}" />

   
   <input type="submit" name="ok" value="Vlož">
   
</form>
</div>
</div>
{include file="paticka.tpl"}
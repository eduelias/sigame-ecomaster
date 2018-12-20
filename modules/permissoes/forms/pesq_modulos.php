<?
	//header('Content-Type: text/html; charset=UTF-8');
?>
	<br><BR>
  	<form method="GET" class="for1" name="form2" >
    <fieldset>
    	<legend> Pesquisar M&oacute;dulos: </legend>
   
        <label for="idmodulos">
        	ID:
            <input type="text" id="idmodulos" size="4"/>
		</label>
        <label for="label">
        	Label:
            <input type="text" id="label" />
		</label>
        <input type="hidden" />
        <input type="button" onClick="Javascript:WBS.pagina.pesquisa('idmodulos,modulo,label','cfg_modulo',this.parentNode,myDataTablegrupos);" value="Pesquisar" class="pesq"/>
    </fieldset>
</form>
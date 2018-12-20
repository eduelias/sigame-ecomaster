<?
	//header('Content-Type: text/html; charset=UTF-8');
?>
  	<form method="GET" class="for1" name="form1" >
    <fieldset>
    	<legend> Pesquisar Grupos: </legend>
   
        <label for="idgrupos">
        	ID:
            <input type="text" id="pq_idgrupos" size="4"/>
		</label>
        <label for="label">
        	Label:
            <input type="text" id="pq_label" />
		</label>
        <input type="hidden" />
        <input type="button" onClick="Javascript:WBS.pagina.pesquisa('idgrupos,grupo,label','cfg_grupos',this.parentNode,myDataTablegrupos);" value="Pesquisar" class="pesq"/>
    </fieldset>
</form>
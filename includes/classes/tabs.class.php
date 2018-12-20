<?php

	class tabs {
		
		public $includes; // carrega as dependencias js da classe;
		
		public $data; //public $echodata; // Variável que carrega o codigo html das tabs;
		
		public $mod;
		
		public function tabs($mod, $ori = 'top'){
			
			$str = '<link rel="stylesheet" type="text/css" href="includes/yui/'.YUI_VER.'/build/tabview/assets/skins/sam/tabview.css"><link href="templates/css/overlap.css" rel="stylesheet" type="text/css"><script type="text/javascript" src="includes/yui/'.YUI_VER.'/build/tabview/tabview'.((JSMIN)?'-min':'').'.js"></script>';
			$this->includes[] =  $str;
			$this->mod = $mod;
			$this->data[] = "<script type=\"text/javascript\">\r\nvar myTab".$mod." = new YAHOO.widget.TabView(\"demo".$mod."\", {orientation:\"".$ori."\"});\r\n myTab.subscribe('beforeContentChange',WBS.wait.show); \r\n </script><div id=\"demo".$mod."\" class=\"yui-navset\"></div>";
		}
		
		public function addOnTab($conteudo, $label){
			$this->data[] = "<script> myTab".$this->mod.".addTab( new YAHOO.widget.Tab({label: '".$label."', dataSrc: 'geraconteudo.php?file=".$conteudo."', cacheData:false, height:700})); </script>";
		}
		
		public function addOffTab($conteudo, $label){
			$this->data[] = "<script> myTab".$this->mod.".addTab( new YAHOO.widget.Tab({label:'".$label."', dataSrc:'geraconteudo.php?file=".$conteudo."', cacheData:true, height:700})); </script>";
		}
		
		public function addTab($conteudo, $label, $way = "false"){
			$i = count($this->data);
			$this->data[] = "<script> myTab".$this->mod.".addTab( new YAHOO.widget.Tab({label:'".$label."', dataSrc:'geraconteudo.php?file=".$conteudo."', cacheData:'".$way."', height:700})); </script>";
		}
		
		public function setActive($ind){
			$this->data[] = "<script> myTab".$this->mod.".set('activeIndex',".$ind."); </script>";
		}
		
		public function get_dependencias(){
			$aux = '';
			if (is_array($this->includes)){
				foreach ($this->includes as $k => $v){
					$aux .= $v;
				}
			} else {
				$aux = $this->includes;
			}
			return $aux;
		}
		
		public function get_tabhtml(){
			$aux = '';
			if (is_array($this->data)){
				foreach ($this->data as $k => $v){
					$aux .= $v;
				}
			}
			return $aux;
		}
		
		public function show_tabs(){
		
			echo $this->get_dependencias();
			
			echo $this->get_tabhtml();
		}
		
		public function gera_tab(){
			return $this->data;
		}
	}

?>
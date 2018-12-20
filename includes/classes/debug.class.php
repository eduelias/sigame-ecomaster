<?

	class debug {
	
		public function debug($var,$local = 'NaN'){
			$this->deb[$local] = $var;
		}
		
		public function ec_bug(){
			return $this->deb;
		}
		
		public function bug($var, $local = 'NaN'){
			$this->deb[$local] = $var;
		}
	}

?>
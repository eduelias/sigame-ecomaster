<?
	class gerajsondata {

		public $data;
		public $arrayobj;
		public $arrayfields;

		public function gerajsondata($arrayobj, $arrayfields) {
			$i = 0;
			foreach($arrayobj as $linha) {
				foreach($arrayfields as $field) {

					//explode pra saber se o atributo é um outro objeto
					$countObj = explode("->", $field[funcao]);

					$valorfinal = $linha;

					$j = 0;
					foreach ($countObj as $vals) {
						$j++;
						if ($j == sizeof($countObj)) {
							$valorfinal = $valorfinal->{$vals}();
						}
						else {
							$valorfinal = $valorfinal->{$vals};
						}
					}
					
					$this->data[$i][$field[campo]] = $valorfinal;
				}
				$i++;
			}
		}
	}
?>
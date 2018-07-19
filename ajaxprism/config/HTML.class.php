<?php
	class HTML{
		//if mode is false, all functions return the result; else it is directly printed out
		private $mode=false;
		private $output="";
		public function isEcho($mod) {
			$this->mode=$mod;	
		}
		public function table($data,$zero1StCol=true,$colName=array()) {
			if(!is_array($data)) {
				return false;			
			}
			if(!is_array($data[0])) {
				return $this->dataArray($data);			
			}
			$output="";
			
			
		}	
	};
	
?>
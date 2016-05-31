<?php
	function check($checkArray){

		if($_SERVER["REQUEST_METHOD"]==="GET"){
			foreach($checkArray as $check){
				if(isset($_GET[$check])){
					if($_GET[$check]==""){
						$returnArray[$check]="";
					}else{
						$returnArray[$check]=$_GET[$check];
					}
				}else{
					$returnArray[$check]="";
				}
			}
		}elseif($_SERVER["REQUEST_METHOD"]==="POST"){
			foreach($checkArray as $check){
				if(isset($_POST[$check])){
					$returnArray[$check]=$_POST[$check];
				}else{
					$returnArray[$check]="";
				}
			}
		}

		return $returnArray;
	}
?>
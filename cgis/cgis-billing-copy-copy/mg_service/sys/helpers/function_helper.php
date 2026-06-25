<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('emptystr')){
	function emptystr($str){
		if(($str=="") || ($str=='null') || ($str=='-')  || ($str=='00000000'))
			$return = "-";
		else
			$return = WhiteSpaceXML($str);
			
		return $return;
	}
}

if(!function_exists('WhiteSpaceXML')){	
	function WhiteSpaceXML($text){
		$hasil = str_replace("&","&amp;",$text);
		$hasil = str_replace("'","&apos;",$hasil);
		$hasil = str_replace("\"","&quot;",$hasil);
		$hasil = str_replace("<","&lt;",$hasil);
		$hasil = str_replace(">","&gt;",$hasil);	
		return $hasil;
	}
}

if(!function_exists('check_file')){	
	function check_file($filename){
		if(file_exists($filename)){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('create_file')){	
	function create_file($filename){
		$filename = fopen($filename, "w");
		fputs($filename, $txt);
		fclose($filename);
	}
}

if(!function_exists('remove_file')){
	function remove_file($filename) {
		if(file_exists($filename)){
			unlink($filename);
		}
	}
}

if(!function_exists('validate')){
	function validate($data, $type="TEXT"){
		if(strtoupper(trim($data))==""){
        	$return = NULL;
		} else {
			switch ($type) {
				case "TEXT":
					if (trim($data) != "") $return = trim(strtoupper($data));
					break;
				case "DATE":
					if (trim($data) != ""){
						$time = strtotime($data);
						$return = date('Y-m-d',$time);
					}
				break;
				case "DATE1":
					if (trim($data) != ""){
						$arrdate = explode("-",$data);
						$return = $arrdate[2]."-".$arrdate[1]."-".$arrdate[0];
					}
				break;
				case "DATE-S":
					if (trim($data) != ""){
						$return = substr($data,0,4)."-".substr($data,4,2)."-".substr($data,6,2);
						if(substr($data,8,6)!=""){
							$return .= " ".substr($data,8,2).":".substr($data,10,2).":".substr($data,12,2);
						}
					}
				break;
				case "DATETIME":
					if (trim($data) != ""){
						$time = strtotime($data);
						$return = date('Y-m-d H:i:s',$time);
					}
				break;
				case "DATETIME1":
					if (trim($data) != ""){
						$arrdatetime = explode(" ",$data);
						if($arrdatetime[1]!="") $time = " ".$arrdatetime[1];
						$arrdate = explode("-",$arrdatetime[0]);
						$return = $arrdate[2]."-".$arrdate[1]."-".$arrdate[0].$time;
					}
				break;
			}
		}
		return $return;
	}
}

?>
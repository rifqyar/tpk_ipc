<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_main extends CI_Model{
	var $conn = "";
	function get_uraian($conn2,$query, $select){
	
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($data->num_rows() > 0){
			$row = $data->row();
			return $row->$select;
		}else{
			return "";
		}
		return 1;
	}
	
	function get_combobox($conn2= FALSE,$query, $key, $value, $empty = FALSE, &$disable = ""){
		$combobox = array();
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($empty) $combobox[""] = "&nbsp;";
		if($data->num_rows() > 0){
			$kodedis = "";
			$arrdis = array();
			foreach($data->result_array() as $row){
				if(is_array($disable)){
					if($kodedis==$row[$disable[0]]){
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}else{
						if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}
					$kodedis = $row[$disable[0]];
					if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
				}else{
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except=""){
		$data = array();
		foreach($array as $a => $b){
			if(is_array($except)){
				if(!in_array($a, $except)) $data[$a] = $b;
			}else{
				$data[$a] = $b;
			}
		}
		return $data;
	}
	
	function send_mail($to, $subject, $body){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.edi-indonesia.co.id',
			'smtp_port' => 25,
			'smtp_user' => 'butir_v@edi-indonesia.co.id',
			'smtp_pass' => 'folderguard',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'crlf' => "\r\n",
			'start_tls' => true
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('butir_v@edi-indonesia.co.id', 'Butir');
		$email = str_replace(';', ',', $to);
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($body);
		return $this->email->send();
	}
	
	function cek_empty_array($arr){
		$empty=1;
		foreach($arr as $key => $val){
			if($val!="") $empty = 0;
		}
		return $empty;
	}
	
	
	function get_result(&$query){
	$wms_db = $this->load->database('wms',TRUE);
		$data = $wms_db->query($query);
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}
	
	function get_exist($conn2,$tabel,$where,$key){
		$query = "SELECT * from ".$tabel." WHERE ".$where." = '".$key."'";
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data   = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($data->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}
	function get_insert_select($tabel_name,$array_field,$array_key, $array_field_bypass=array())
	{
		if((is_array($array_field)) && (is_array($array_key)) && (is_array($array_key)))
		{
			#get field
			$banyak_field = count($array_field);
			$str_field="";
			for($a=0;$a<$banyak_field;$a++)
			{
				$str_field .= $array_field[$a].',';
			}
			if(strlen($str_field)>0) $str_field = substr($str_field,0,-1);
			
			#get field by pass
			$banyak_field_bypass = count($array_field_bypass);
			$str_field_bypass="";
			$str_value_bypass="";
			foreach($array_field_bypass as $keypass => $valuepass)
			{
				$str_field_bypass .= ",".$keypass.",";
				if(is_numeric($valuepass)) $str_value_bypass .= ",".$valuepass.",";
				else $str_value_bypass .= ",'".$valuepass."',";
			}
			if((strlen($str_field_bypass)>0) && (strlen($str_value_bypass)>0)) 
			{
				if($banyak_field_bypass>0){
					$str_field_bypass = substr($str_field_bypass,0,-1);
					$str_value_bypass = substr($str_value_bypass,0,-1);
					
					#replace
					$str_field_bypass = str_replace(array(",,"),array(","),$str_field_bypass);
					$str_value_bypass = str_replace(array(",,"),array(","),$str_value_bypass);
				}
			}
			#get where
			$str_where="";
			foreach($array_key as $key => $value)
			{
				if(is_numeric($value)) $str_where .= $key."=".$value." and ";
				else $str_where .= $key."='".$value."' and ";
			}
			if(strlen($str_where)>0) $str_where = substr($str_where,0,-5);
			$sql = "INSERT INTO ".$tabel_name." (".$str_field.$str_field_bypass.")
					SELECT ".$str_field.$str_value_bypass."
					FROM ".$tabel_name."
					WHERE ".$str_where;
			
			return $sql;
		}
		else
		{
			return false;
		}
		
	}
	
	function create_file($namafile,$content,$dir){
		if(!is_dir($dir))
			mkdir(str_replace('//','/',$dir), 0777, true);
		
		$pathfile = str_replace(array('//'),array('/'),$dir).$namafile;
		if(file_exists($pathfile)){
			$file = fopen($pathfile,"a");
			fwrite($file,$content."\r\n");
			fclose($file);
			return true;
		}else{
			$file = fopen ($pathfile, "w");
			if (!$file) {
			 fclose($file);
			 return false;
			}else{
				if(chmod($pathfile,0777)){
					fwrite($file,$content."\r\n");
					fclose($file);
					return true;
				}else{
					return false;
				}
			}
		}
	}
}
?>
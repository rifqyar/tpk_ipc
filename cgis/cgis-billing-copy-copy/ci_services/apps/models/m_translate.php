<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_translate extends CI_Controller{
	//$_SERVER['DOCUMENT_ROOT']."/ci_services/files/exe/;
	const dirSUC = '/home/dev/files/history/success/EDI/';
	const dirERR = '/home/dev/files/history/error/EDI/';
    const dirMAP = '/home/dev/files/mapper/';
    const dirEDI = '/home/dev/files/mailbox/EDI/'; 
    const dirFLT = '/home/dev/files/mailbox/FLT/';
	
	function get_coarri_edi_to_flt(){
		$this->getFLTFILE('COARR95B','COARR95B','COARRI');
	}
	
	function get_codeco_edi_to_flt(){
		$this->getFLTFILE('CODEC95B','CODEC95B','CODECO');
	}
	
    private function roleEDIFILE2($APRF){
		#Read EDF
        $dirEDF = self::dirMAP . $APRF . '.EDF';
        $arrEDF = file($dirEDF);
        $rtn = array();
        $grp = false;
        foreach ($arrEDF as $a) {//looping isi file EDF
            $a = trim($a);
            if (($a !== '') && !$this->startsWith($a, '*') && !$this->startsWith($a, 'PRM')) {
                $arrSem = explode(',', $a);
                $arrNum = explode(' ', $arrSem[count($arrSem) - 1]);
                $arrSem[count($arrSem) - 1] = $arrNum[0];
                switch ($arrSem[0]) {
                    case'SEG':
                        $key = $arrSem[5];
                        $i[$key] ++;
                        $rtn[$key][$i[$key]]['SEGMEN'] = $arrSem[1];
                        break;
                    case'DEL':
                        $rtn[$key][$i[$key]]['VALUE'][] = 'PLUS';
                        if ($arrSem[3] != '') {
                            $rtn[$key][$i[$key]]['VALUE'][] = $arrSem[3];
                        }
                        break;
                    case'':
                        $rtn[$key][$i[$key]]['VALUE'][] = 'TITIKDUA';
                        $rtn[$key][$i[$key]]['VALUE'][] = $arrSem[3];
                        break;
                }
            }
        }
        return $rtn;
    }
    private function roleFLTFILE2($APRF) {
        $dirHDF = self::dirMAP . $APRF . '.HDF';
        $arrHDF = file($dirHDF);
        $rtn = array();
        foreach ($arrHDF as $a) {
            $a = trim($a);
            if (($a !== '') && (!$this->startsWith($a, '*'))) {
                $num = explode(' ', $a);
                $arrSem = explode(',', $num[0]);
                if ($arrSem[0] === 'REC') {
                    $key = $arrSem[1];
                    $i = 0;
                    $start = 0;
                    $rtn[$key] = array();
                }
                elseif ($arrSem[0] === 'FLD') {
                    if ($arrSem[1] !== 'TYPE') {
                        $rtn[$key][$i]['VARIABLE'] = $arrSem[1];
                        $rtn[$key][$i]['START'] = $start;
                        $rtn[$key][$i]['LENGTH'] = $arrSem[2] + $arrSem[4];
                        $rtn[$key][$i]['TYPE'] = $arrSem[3];
                        $rtn[$key][$i]['DESC'] = $arrSem[4];
                        $rtn[$key][$i]['MODEL'] = $arrSem[5];
                        $i++;
                    }
                    $start += $arrSem[2] + $arrSem[4];
                    ;
                }
                elseif ($arrSem[0] === 'PRM') {
                    $rtn['PRM'][$arrSem[1]][$arrSem[2]] = $arrSem[3];
                }
            }
        }
        return $rtn;
    }
    private function roleEDIFILE($APRF) { //Read EDF
        $dirEDF = self::dirMAP . $APRF . '.EDF';
        $arrEDF = file($dirEDF);
        $group = '';
        $level = 0;
        $key = -1;
        foreach ($arrEDF as $a) {//looping isi file EDF
            $a = trim($a);
            if (($a !== '') && !$this->startsWith($a, '*') && !$this->startsWith($a, 'PRM')) {
                $arrSem = explode(',', $a);
                $arrNum = explode(' ', $arrSem[count($arrSem) - 1]);
                $arrSem[count($arrSem) - 1] = $arrNum[0];
                switch ($arrSem[0]) {
                    case'SEG':
                        $key++;
                        $sub = -1;
                        $rtn[$key]['SEGMEN'] = $arrSem[1];
                        $rtn[$key]['WAJIB'] = $arrSem[2];
                        $rtn[$key]['LEVEL'] = $arrSem[3];
                        $rtn[$key]['LOOP'] = $arrSem[4];
                        $rtn[$key]['KDHDF'] = $arrSem[5];
                        break;
                    case'DEL':
                        $sub++;
                        if ($arrSem[3] != '') {
                            $rtn[$key]['VALUE'][$sub]['VARIABLE'][] = $arrSem[3];
                            $rtn[$key]['VALUE'][$sub]['WAJIB'][] = $arrSem[2];
                        }
                        break;
                    case'':
                        $rtn[$key]['VALUE'][$sub]['VARIABLE'][] = $arrSem[3];
                        $rtn[$key]['VALUE'][$sub]['WAJIB'][] = $arrSem[2];
                        break;
                    case'GRP':
                        $key++;
                        $rtn[$key]['SEGMEN'] = 'GRP';
                        $rtn[$key]['GROUP'] = $arrSem[1];
                        $rtn[$key]['WAJIB'] = $arrSem[2];
                        $rtn[$key]['LOOP'] = $arrSem[3];
                        $rtn[$key]['LEVEL'] = $arrSem[4];
                        break;
                }
            }
        }
        foreach ($rtn as $a) {
            if ($a['KDHDF'] != '' || $a['SEGMEN'] == 'GRP') {
                $x[] = $a;
            }
        }
        return $x;
    }
    private function roleFLTFILE($APRF) {
        $dirHDF = self::dirMAP . $APRF . '.HDF';
        $arrHDF = file($dirHDF);
        $rtn = array();
        foreach ($arrHDF as $a) {
            $a = trim($a);
            if (($a !== '') && (!$this->startsWith($a, '*'))) {
                $num = explode(' ', $a);
                $arrSem = explode(',', $num[0]);
                if ($arrSem[0] === 'REC') {
                    $key = $arrSem[1];
                    $i = 0;
                    $start = 0;
                    $rtn[$key] = array();
                }
                elseif ($arrSem[0] === 'FLD') {
                    if ($arrSem[1] !== 'TYPE') {
                        $rtn[$key][$i]['VARIABLE'] = $arrSem[1];
                        $rtn[$key][$i]['START'] = $start;
                        $rtn[$key][$i]['LENGTH'] = $arrSem[2] + $arrSem[4];
                        $rtn[$key][$i]['TYPE'] = $arrSem[3];
                        $rtn[$key][$i]['DESC'] = $arrSem[4];
                        $rtn[$key][$i]['MODEL'] = $arrSem[5];
                        $i++;
                    }
                    $start += $arrSem[2] + $arrSem[4];
                    ;
                }
                elseif ($arrSem[0] === 'PRM') {
                    $rtn['PRM'][$arrSem[1]][$arrSem[2]] = $arrSem[3];
                }
            }
        }
        return $rtn;
    }
    private function strReplacePRM($EDIFACT, $SNRF, $NOSG) {
        $EDIFACT = str_replace(chr(252) . 'SNRF' . chr(252), $SNRF, $EDIFACT);
        $EDIFACT = str_replace(chr(252) . 'DATE' . chr(252), date('ymd'), $EDIFACT);
        $EDIFACT = str_replace(chr(252) . 'TIME' . chr(252), date('Hi'), $EDIFACT);
        $EDIFACT = str_replace(chr(252) . 'NOSG' . chr(252), $NOSG, $EDIFACT);
        return $EDIFACT;
    }
	
    function getEDIFILE($EDINUMBER, $APRF, $SNRF, $FILENAME) {
        $dirEDI = self::dirEDI . $EDINUMBER . '/';
        $dirFLT = self::dirFLT . $EDINUMBER . '/';
        $roleFLT = $this->roleFLTFILE2($APRF);
        $roleEDI = $this->roleEDIFILE2($APRF);
        $arr = $roleFLT['PRM'];
        $PETIKSATU = chr(255);
        $PLUS = chr(254);
        $TITIKDUA = chr(253);
        foreach ($arr as $k => $a) {
            $prm[$k] = str_replace('XXXXX', chr(252), $a);
        }
        $filedir = $dirFLT . $FILENAME;
        if (file_exists($filedir)) {
            $arrFile = file($filedir);
            #flt 2 array
            foreach ($arrFile as $k => $a) {//loop isi flatfile
                $key = substr($a, 0, 8);
                $keyFLT = $roleFLT[$key];
                $dataFLT = $prm[$key];
                $dataFLT['PETIKSATU'] = $PETIKSATU;
                $dataFLT['PLUS'] = $PLUS;
                $dataFLT['TITIKDUA'] = $TITIKDUA;
                foreach ($keyFLT as $vFLT) {//loop key yang telah terpilih substr($a,0,8)
                    $data = rtrim(substr($a, $vFLT['START'], $vFLT['LENGTH']));
                    $data = str_replace("'", "?'", str_replace('+', '?+', str_replace(':', '?:', str_replace('?', '??', $data))));
                    if ($data !== '') {
                        if ($vFLT['LENGTH'] !== '' && $vFLT['TYPE'] !== 'X') {
                            switch ($vFLT['TYPE']) {
                                case'N':
                                    if ($vFLT['DESC'] > 0) {
                                        $desc = '0.' . substr($data, $vFLT['DESC'] * -1) + 0;
                                        $data = substr($data, 0, $vFLT['LENGTH'] - $vFLT['DESC']) + $desc;
                                        if ($vFLT['MODEL'] == 'I') {
                                            $data = str_replace('.', '', $data);
                                        }
                                    }
                                    else {
                                        $data = (int) $data;
                                    }
                                    break;
                                case'ZN':
                                    if ($vFLT['DESC'] > 0) {
                                        switch ($vFLT['MODEL']) {
                                            case'I':$desc = substr($data, $vFLT['DESC'] * -1);
                                                break;
                                            case'E':$desc = '.' . substr($data, $vFLT['DESC'] * -1);
                                                break;
                                        }
                                    }
                                    else {
                                        $desc = '';
                                    }
                                    $data = substr($data, 0, $vFLT['LENGTH'] - $vFLT['DESC']) . $desc;
                                    break;
                            }
                        }
                        $dataFLT[$vFLT['VARIABLE']] = $data;
                    }
                }
                $keyEDI = $roleEDI[$key];
                foreach ($keyEDI as $tagEDI) {
                    $perBaris = $tagEDI['SEGMEN'];
                    foreach ($tagEDI['VALUE'] as $val) {
                        $perBaris .= $dataFLT[$val];
                    }
                    $chk = $perBaris;
                    $chk = str_replace(chr(253), '', str_replace($PLUS, '', str_replace($tagEDI['SEGMEN'], '', $chk)));
                    if ($chk !== '') {
                        $EDIFACT .= $perBaris . $dataFLT['PETIKSATU'];
                        ++$ii;
                    }
                }
            }
            #menghilangkan tag yang kosong

            while (strpos($EDIFACT, $TITIKDUA . $PLUS) || strpos($EDIFACT, $PLUS . $PETIKSATU) || strpos($EDIFACT, $TITIKDUA . $PETIKSATU)) {
                $EDIFACT = str_replace($TITIKDUA . $PLUS, $PLUS, $EDIFACT);
                $EDIFACT = str_replace($PLUS . $PETIKSATU, $PETIKSATU, $EDIFACT);
                $EDIFACT = str_replace($TITIKDUA . $PETIKSATU, $PETIKSATU, $EDIFACT);
            }
            $EDIFACT = str_replace($PLUS . $TITIKDUA, $PLUS, $EDIFACT);
            $EDIFACT = str_replace($PETIKSATU, "'\n", $EDIFACT);
            $EDIFACT = str_replace($PLUS, '+', $EDIFACT);
            $EDIFACT = str_replace($TITIKDUA, ':', $EDIFACT);
            $EDIFACT = $this->strReplacePRM($EDIFACT, $SNRF, ($ii - 2));

            $handle = fopen($dirEDI . substr($FILENAME, 0, -4) . '.EDI', 'w');
            fwrite($handle, $EDIFACT);
            fclose($handle);
            $rtn = true;
        }
        else {
            $rtn = false;
        }
        return $rtn;
    }
    function fixLen($str, $len, $chr = ' ', $alg = STR_PAD_RIGHT) {
        $hasil = str_pad(substr(trim($str), 0, $len), $len, $chr, $alg);
        return $hasil;
    }
    function cetakFF($key, $arrKey, $dataEDF) {
        $rtn = $key;
        foreach ($arrKey as $arr) {
            $str = $dataEDF[$arr['VARIABLE']];
            switch ($arr['TYPE']) {
                case'X':
                    $rtn .= $this->fixLen($str, $arr['LENGTH']);
                    break;
                case'N':
                    if ($str != '') {
                        if ($arr['DESC'] > 0) {

                            $angka = explode('.', $str);
                            $rtn .= $this->fixLen($angka[0], $arr['LENGTH'] - $arr['DESC'], '0', STR_PAD_LEFT) . $this->fixLen($angka[1], $arr['DESC'], '0');
                        }
                        else {
                            $rtn .= $this->fixLen($str, $arr['LENGTH'], '0', STR_PAD_LEFT);
                        }
                    }
                    else {
                        $rtn .= $this->fixLen('', $arr['LENGTH']);
                    }
                    break;
                case'ZN':
                    if ($arr['DESC'] > 0) {
                        $angka = explode('.', $str);
                        $rtn .= $this->fixLen($angka[0], $arr['LENGTH'] - $arr['DESC'], '0', STR_PAD_LEFT) . $this->fixLen($str, $arr['DESC'], '0');
                    }
                    else {
                        $rtn .= $this->fixLen($str, $arr['LENGTH'], '0', STR_PAD_LEFT);
                    }
                    break;
            }
        }
        return trim($rtn) . "\n";
    }
	
    function getFLTFILE($EDINUMBER, $APRF, $FILENAME, $xxx2){
        #$dirEDI = self::dirEDI . $EDINUMBER . '/';
        #$dirFLT = self::dirFLT . $EDINUMBER . '/';
		$dirEDI = self::dirEDI.$FILENAME.'/';
        $dirFLT = self::dirFLT.$FILENAME.'/';
		$dirSUC = self::dirSUC.$FILENAME.'/';
		$dirERR = self::dirERR.$FILENAME.'/';
        $roleEDI = $this->roleEDIFILE($APRF);
        foreach ($roleEDI as $k => $v) {
            $keyRoleEDI[$v['KDHDF']] .= '|' . $v['SEGMEN'];
            if ($v['SEGMEN'] == 'GRP' && $v['LEVEL'] == 1){
                $GROUP = $v['GROUP'];
                $x[$v['GROUP']] = '';
            }
            if ($v['LEVEL'] == 0) {
                $x[$GROUP] = $k;
            }
        }
		#print_r();die();
        foreach ($x as $k => $v) {
            if ($v != '' && $k != '') {
                $keyAfterGrp[$k] = $v - 1;
            }
        }
		#print_r($keyAfterGrp);die();
        unset($keyRoleEDI['']);
        $roleFLT = $this->roleFLTFILE($APRF);
        unset($roleFLT['PRM']);
        #$xxx2 = 146;
        $filedir = $dirEDI;
		$message = "";
		if(is_dir($filedir)){
			if($dh = opendir($filedir)){
				while (($file = readdir($dh)) !== false){
				  if($file!="." && $file!="..") $file_name = $file;
				}
				if(empty($file_name)) {
					echo "No records data"; exit();
				}else{
					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					if(trim($ext)!="EDI"){
						$rtn = false;
						echo "Error file";
					}else{
						$arrFile = file($filedir.$file_name);
						$arrFile = str_replace("?'", chr(255), str_replace('?+', chr(254), str_replace('?:', chr(253), str_replace('??', chr(252), $arrFile))));
						#$arrFile = $this->replace_edi($arrFile);
						#print_r($arrFile); die();
						$keyEDF = 0;
						foreach ($arrFile as $ln => $lnfile) {#loop every line of edi file
							$arr = explode("'", $lnfile);
							$lnfile = $arr[0];
							$nextKey = true;
							while ($nextKey) { #perulangan untuk mencari segmen edi yang cocok
								$role = $roleEDI[$keyEDF];
								$xxx++;
			//                    $zz = $jmlGrp;
			//                    if ($xxx >= 500) {
			//                        die('error');
			//                    }
								if ($role['LEVEL'] == 0 && $grp[$jmlGrp]==false) {
									unset($grp);
								}
								$keyTerjauh = ($keyTerjauh <= $keyEDF) ? $keyEDF : $keyTerjauh;
								if ($role == '') { #jika rule EDF Habis
									$roleHabis = true;
									break;
								}#break poin
			
			//                    $a2 = '';
								if ($this->startsWith($lnfile, $role['SEGMEN'])) { #jika segmen dan edf ketemu yang sama
									$a2 = 'cocok';
									if ($role['LEVEL'] > 0) {
										$grp[$role['LEVEL']]['KETEMU'] = true;
									}
									else if ($role['LEVEL'] == 0) {
										unset($grp);
									}
									$KDHDF = $role['KDHDF'];
									$nextKey = false;
									$str = substr($lnfile, 4);
									$arrSub = explode('+', $str);
									foreach ($arrSub as $i => $a) {
										$arrSubSub = explode(':', $a);
										foreach ($arrSubSub as $ii => $aa) {
											$data[$role['VALUE'][$i]['VARIABLE'][$ii]] = $aa;
										}
									}
									$segGroup .= '|' . $role['SEGMEN'];
									$nextSegStr = substr($arrFile[$ln + 1], 0, 3);
									if (strpos($keyRoleEDI[$KDHDF], $nextSegStr) === false || $segGroup == $keyRoleEDI[$KDHDF] || $nextSegStr == $role['SEGMEN']) {
										$FF .= $this->cetakFF($KDHDF, $roleFLT[$KDHDF], $data);
										unset($data);
										unset($segGroup);
									}
								}
								elseif ($role['SEGMEN'] === 'GRP') { #
									$jmlGrp = count($grp);
									if ($grp[$role['LEVEL']]['KETEMU'] == true) {
			//                            $a2 = 'a' . $jmlGrp;
										if (is_array($data)) {
											$FF .= $this->cetakFF($KDHDF, $roleFLT[$KDHDF], $data);
											unset($data);
											unset($segGroup);
										}
										if ($grp[$jmlGrp]['KETEMU'] == true) {
			//                                $a2 .= 'z';
											$grp[$jmlGrp]['KETEMU'] = false;
											$keyEDF = $grp[$jmlGrp]['KEYEDF'];
										}
										else {
			//                                $a2 .= 'x';
											if ($role['LEVEL'] < $jmlGrp) {
												for ($i = $jmlGrp; $i > $role['LEVEL']; $i--) {
													unset($grp[$i]);
												}
												$keyGrupTerjauh[$role['LEVEL']] = $keyEDF;
											}
											$grp[$role['LEVEL']]['KETEMU'] = false;
											$keyEDF = $grp[$role['LEVEL']]['KEYEDF'];
										}
									}
									else {
			//                            $a2 = 'b';
										if ($role['LEVEL'] > $jmlGrp) {
			//                                $a2 .= 'z';
											if ($jmlGrp > 1) {
												if ($grp[$role['LEVEL'] - 1]['KETEMU'] == true) {
													$a2 .= '!';
													$grp[$role['LEVEL']]['KEYEDF'] = $keyEDF + 1;
													$grp[$role['LEVEL']]['NAMA'] = $role['GROUP'];
													$grp[$role['LEVEL']]['KETEMU'] = false;
													$keyEDF++;
												}
												else {
			//                                        $a2 .= '@';
													unset($grp[$role['LEVEL'] - 1]);
													if ($grp[$jmlGrp - 1]['KETEMU'] == false || isset($keyGrupTerjauh[$jmlGrp])) {
			//                                            $a2 .= '#';
														if ($grp[$jmlGrp - 1]['KETEMU'] == false) {
			//                                                $a2 .= '!';
															if ($keyGrupTerjauh[$jmlGrp - 1] == '') {
																$keyEDF = $keyAfterGrp[$grp[1]['NAMA']];
			//                                                    if($xxx == 25581) echo $grp[1]['NAMA'];
															}
															else {
																$keyEDF = $keyGrupTerjauh[$jmlGrp - 1];
																unset($keyGrupTerjauh);
															}
														}
														else {
			//                                                $a2 .= '$';
															$keyEDF = $keyGrupTerjauh[$jmlGrp];
															unset($keyGrupTerjauh);
														}
													}
													else {
			//                                            $a2 .= '&';
														if (is_array($data)) {
															$FF .= $this->cetakFF($KDHDF, $roleFLT[$KDHDF], $data);
															unset($data);
															unset($segGroup);
														}
														$grp[$role['LEVEL'] - 2]['KETEMU'] = false;
														$keyEDF = $grp[$role['LEVEL'] - 2]['KEYEDF'];
													}
												}
											}
											else {
			//                                    $a2 .= '%';
												$grp[$role['LEVEL']]['KEYEDF'] = $keyEDF + 1;
												$grp[$role['LEVEL']]['NAMA'] = $role['GROUP'];
												$grp[$role['LEVEL']]['KETEMU'] = false;
												$keyEDF++;
											}
										}
										elseif ($role['LEVEL'] < $jmlGrp) {
			//                                $a2 .= 'y';
											for ($i = $jmlGrp; $i > $role['LEVEL']; $i--) {
												unset($grp[$i]);
											}
											$grp[$role['LEVEL']]['KEYEDF'] = $keyEDF + 1;
											$grp[$role['LEVEL']]['NAMA'] = $role['GROUP'];
											$grp[$role['LEVEL']]['KETEMU'] = false;
											$keyEDF++;
										}
										elseif ($role['LEVEL'] == $jmlGrp) {
			//                                $a2 .= 'x';
											$grp[$role['LEVEL']]['KEYEDF'] = $keyEDF + 1;
											$grp[$role['LEVEL']]['NAMA'] = $role['GROUP'];
											$grp[$role['LEVEL']]['KETEMU'] = false;
											$keyEDF++;
										}
									}
								}
								else {
									$jmlGrpx = count($grp);
			//                        $a2 = 'c' . $jmlGrpx . ' |' . $zz;
									if ($grp[$jmlGrpx]['KETEMU'] == true && $role['LEVEL'] < $jmlGrpx && $role['LEVEL'] == 0) {
										if($grp[$jmlGrpx - 1]['KEYEDF'] == ''){
											$keyEDF = $grp[$jmlGrpx]['KEYEDF'];
											$grp[$jmlGrpx]['KETEMU'] = false;
										} else {
											$keyEDF = $grp[$jmlGrpx - 1]['KEYEDF'];
											unset($grp[$jmlGrpx]);
										}
									}
									else {
										
			//                            $a2 .= '#';
										$keyEDF++;
									}
								}
			                   /* if($xxx == $xxx2) {
			                        echo '<a href="http://localhost/t2g/index.php/outLogin/testfunction/' . ($xxx2 - 1) . '">' . ($xxx2 - 1) . '</a> - ' . '<a href="http://localhost/t2g/index.php/outLogin/testfunction/' . ($xxx2 + 1) . '">' . ($xxx2 + 1) . '</a>';
			                        echo '<pre>' . $keyEDF . ' - ' . $b . ' ';
			                        print_r($lnfile . ' - ' . $role['LEVEL'] . '-' . $a2 . "\n");
			                        print_r($grp);
			                        print_r($keyGrupTerjauh);
			                        print_r($role);
			                        echo '</pre>';
			                        die();
			                    }*/
							}
							if ($roleHabis) {#berakhir jika role habis meskipun file masih ada.
								break;
							}
						}
						$fileAct = preg_replace('/\\.[^.\\s]{3,4}$/', '', $dirFLT.$file_name);
						$FF = str_replace(chr(255), "'", str_replace(chr(254), '+', str_replace(chr(253), ':', str_replace(chr(252), '?', $FF))));
						$handle = fopen($fileAct.'.FLT','w');
						$FF = $this->replace_content($FF);
						fwrite($handle, $FF);
						fclose($handle);
						chmod($fileAct.'.FLT',0777);
						$rtn = true;
						$message = "Success";
					}
					echo $rtn." - ";
					if($rtn){
						$folder_path = date("Ymd");
						$mvdir = $dirSUC.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);	
						}
						$mvdir .= "/";
						$handleSuc = fopen($mvdir.$file_name, 'w');
						fclose($handleSuc);
						chmod($mvdir.$file_name,0777);
						if(copy($filedir.$file_name,$mvdir.$file_name)){
							unlink($filedir.$file_name);
							echo $message;
						}
					}else{
						$folder_path = date("Ymd");
						$mvdir = $dirERR.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);
						}
						$mvdir .= "/";
						$handleErr = fopen($mvdir.$file_name, 'w');
						fclose($handleErr);
						chmod($mvdir.$file_name,0777);
						if(copy($filedir.$file_name,$mvdir.$file_name)){
							unlink($filedir.$file_name);
							echo $message;
						}
					}
				}
			}
		}
    }
	
    private function startsWith($haystack, $needle) {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
	
    private function endsWith($haystack, $needle) {
        return $needle === '' || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
    }
	
	function replace_content($content){
		$content = str_replace("\nDCOR0301DCD","|DCOR0301DCD",$content);
		return $content;
	}
	
	function get_coarri_flt_to_db(){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$DIR = $_SERVER['DOCUMENT_ROOT'].'/files/mailbox/FLT/COARRI/';
		$DIRSUC = $_SERVER['DOCUMENT_ROOT'].'/files/history/success/FLT/COARRI/';
		$DIRERR = $_SERVER['DOCUMENT_ROOT'].'/files/history/error/FLT/COARRI/';
		$error = 0;
		$message = "";
		if(is_dir($DIR)){
			if($dh = opendir($DIR)){
				while (($file = readdir($dh)) !== false){
				  if($file!="." && $file!="..") $file_name = $file;
				}
				if(empty($file_name)) {
					echo "No records data"; exit();
				}else{
					$fp = fopen($DIR.$file_name,'r');
					$content = fread($fp, filesize($DIR.$file_name));
					$data = explode("\n", trim($content));
					$header = $data[0];
					foreach($data as $detail){
						$dtl = substr($detail, 0, 4);
						if($dtl != ''){
							if(strtoupper($dtl) == 'HCOR'){
								$arr['HDR'][] = $detail;
							}else{
								$arr['DTL'][] = $detail;
							}
						}
					}
					if(count($arr['HDR']) > 0){
						$array_header = array('HCOR0101','HCOR0201','HCOR0301','HCOR0401');
						for($a=0; $a<count($arr['HDR']); $a++){
							if(in_array(substr($arr['HDR'][$a],0,8),$array_header)){
								$arrheader[] = $arr['HDR'][$a];
							}
						}
						$KD_ASAL     = substr($arrheader[0],28,3);
						$VOYAGE    	 = substr($arrheader[1],11,17);
						$CALL_SIGN   = substr($arrheader[1],56,9);
						$NM_KAPAL  	 = substr($arrheader[1],68,35);
						$PELABUHAN 	 = substr($arrheader[2],11,25);
						$TYPE_PORT 	 = substr($arrheader[2],8,3);
						
						if(trim($KD_ASAL)=="98"){
							$KD_ASAL = 1;
							$TGL_TIBA = substr($arrheader[3],11,8);
						}else if(trim($KD_ASAL)=="270"){
							$KD_ASAL = 3;
							$TGL_TIBA = substr($arrheader[4],11,8);
						}
						if(trim($TYPE_PORT)=="9") $arrayhdr['KD_PEL_MUAT'] = $PELABUHAN;
						else if(trim($TYPE_PORT)=="11") $arrayhdr['KD_PEL_BONGKAR'] = $PELABUHAN;
						$V_TGL_TIBA = substr($TGL_TIBA,0,4).'-'.substr($TGL_TIBA,4,2).'-'.substr($TGL_TIBA,6,2);
						$arrayhdr['KD_ASAL_BRG'] 	= $KD_ASAL;
						$arrayhdr['KD_TPS'] 	   = 'NCT1';
						$arrayhdr['KD_GUDANG'] 	   = 'NCT1';
						$arrayhdr['KD_KAPAL'] 	   = $this->get_referensi('kapal',$CALL_SIGN,$NM_KAPAL);
						$arrayhdr['NM_ANGKUT'] 	   = $NM_KAPAL;
						$arrayhdr['CALL_SIGN'] 	   = $CALL_SIGN;
						$arrayhdr['NO_VOY_FLIGHT'] = $VOYAGE;
						$arrayhdr['TGL_TIBA'] 	   = $V_TGL_TIBA;
						$arrayhdr['WK_REKAM'] 	   = date('Y-m-d H:i:s');
						$SQL = "SELECT ID FROM t_repohdr A
								WHERE A.KD_ASAL_BRG = ".$this->db->escape(trim($KD_ASAL))."
								AND NO_VOY_FLIGHT = ".$this->db->escape(trim($VOYAGE))."
								AND CALL_SIGN = ".$this->db->escape(trim($CALL_SIGN))."
								AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = ".$this->db->escape(trim($TGL_TIBA));
						$result = $func->main->get_result($SQL);
						if($result){
							foreach($SQL->result_array() as $row => $value){
								$arrdata = $value;
							}
							unset($arrayhdr['KD_ASAL_BRG']);
							unset($arrayhdr['KD_TPS']);
							unset($arrayhdr['KD_GUDANG']);
							$this->db->where(array('ID' => $arrdata['ID']));
							$this->db->update('t_repohdr',$arrayhdr);
							$ID = $arrdata['ID'];
						}else{
							$this->db->insert('t_repohdr',$arrayhdr);
							$ID = $this->db->insert_id();
						}
					}
					if($ID!=""){
						if(count($arr['DTL']) > 0){
							$ararydtl = array();
							$arrRFR = array('CR','RE','RH');
							$arraydtl = array();
							for($a=0; $a<count($arr['DTL']); $a++){
								switch(substr($arr['DTL'][$a],0,8)){
									case "DCOR0201" :
										$b++;
										$tipe = $this->get_referensi('isocode',trim(substr($arr['DTL'][$a],28,10)),'TIPE');
										$arraydtl[$b]['ID'] 			= $ID;
										$arraydtl[$b]['NO_CONT'] 		= trim(substr($arr['DTL'][$a],11,17));
										$arraydtl[$b]['KD_CONT_UKURAN'] = $this->get_referensi('isocode',trim(substr($arr['DTL'][$a],28,10)),'SIZE');
										$arraydtl[$b]['KD_CONT_TIPE'] 	= (in_array($tipe,$arrRFR))?"RFR":"DRY";
										$arraydtl[$b]['KD_ISO_CODE'] 	= trim(substr($arr['DTL'][$a],28,10));
										$JNS_CONT = trim(substr($arr['DTL'][$a],47,3));
										if(trim($KD_ASAL)=="98"){
											if(trim($JNS_CONT)=='5'){
												$arraydtl[$b]['KD_CONT_STATUS_IN'] 	= 'FCL';
												$arraydtl[$b]['FL_CONT_KOSONG'] 	= '2';
											}else if(trim($JNS_CONT)=="4"){
												$arraydtl[$b]['KD_CONT_STATUS_IN'] 	= 'MTY';
												$arraydtl[$b]['FL_CONT_KOSONG'] 	= '1';
											}
										}else if(trim($KD_ASAL)=="270"){
											if(trim($JNS_CONT)=='5'){
												$arraydtl[$b]['KD_CONT_STATUS_OUT'] 	= 'FCL';
											}else if(trim($JNS_CONT)=="4"){
												$arraydtl[$b]['KD_CONT_STATUS_OUT'] 	= 'MTY';
											}
										}
										if(trim($TYPE_PORT)=="9") $arraydtl[$b]['KD_PEL_MUAT'] = $PELABUHAN;
										else if(trim($TYPE_PORT)=="11") $arraydtl[$b]['KD_PEL_BONGKAR'] = $PELABUHAN;
									break;
									case "DCOR0301" :
										$CONT_JENIS = substr($arr['DTL'][$a],46,3);
										if(trim($CONT_JENIS)=='2')
											$arraydtl[$b]['KD_CONT_JENIS'] = 'L';	
										if(trim($CONT_JENIS)=='3')
											$arraydtl[$b]['KD_CONT_JENIS'] = 'F';
										
										if(trim($KD_ASAL)=="1"){
											if(substr(trim($arr['DTL'][$a]),110,3) =='203')
												$arraydtl[$b]['WK_IN'] = trim(substr($arr['DTL'][$a],113,14));
										}else if(trim($KD_ASAL)=="3"){
											if(substr(trim($arr['DTL'][$a]),110,3) =='203')
												$arraydtl[$b]['WK_OUT'] = trim(substr($arr['DTL'][$a],113,14));
										}
									break;
									case "DCOR0401" :
										if(substr(trim($arr['DTL'][$a]),0,9) =='DCOR04019')
											$arraydtl[$b]['KD_PEL_MUAT'] = trim(substr($arr['DTL'][$a],11,25));
										else if(substr(trim($arr['DTL'][$a]),0,10) =='DCOR040111') 
											$arraydtl[$b]['KD_PEL_BONGKAR'] = trim(substr($arr['DTL'][$a],11,25));
										if(substr(trim($arr['DTL'][$a]),0,11) =='DCOR0401147')
											$arraydtl[$b]['KD_TIMBUN_KAPAL'] = trim(substr($arr['DTL'][$a],11,25));
									break;
									case "DCOR0501" :
										if(substr(trim($arr['DTL'][$a]),0,12) =='DCOR0501AAEG')
											$arraydtl[$b]['BRUTO'] = trim(substr($arr['DTL'][$a],17,18));
									break;
									case "DCOR0502" :
										$arraydtl[$b]['TEMPERATURE'] = trim(substr($arr['DTL'][$a],11,3));
									break;
								}							
							}
							if(count($arraydtl) > 0){
								for($a=1; $a<=count($arraydtl); $a++){
									$NOCONT = $this->set_id('t_repocont',$ID,$arraydtl[$a]['NO_CONT']);
									if($NOCONT){
										unset($arraydtl[$a]['ID']);
										unset($arraydtl[$a]['NO_CONT']);
										$this->db->where(array('ID' => $ID, 'NO_CONT' => $NOCONT));
										$result = $this->db->update('t_repocont',$arraydtl[$a]);
									}else{
										$result = $this->db->insert('t_repocont',$arraydtl[$a]);	
									}
									if(!$result){
										$error += 1;
										$message .= "Error insert detail no cont ".$NO_CONT."<br>";
									}
								}
							}
						}
					}else{
						$error += 1;
						$message .= "Error insert header";
					}
					if($error==0){
						$folder_path = date("Ymd");
						$mvdir = $DIRSUC.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);	
						}
						$mvdir .= "/";
						$handleSuc = fopen($mvdir.$file_name, 'w');
						fclose($handleSuc);
						chmod($mvdir.$file_name,0777);
						if(copy($DIR.$file_name,$mvdir.$file_name)){
							unlink($DIR.$file_name);
							$message .= "Success";
						}
					}else{
						$folder_path = date("Ymd");
						$mvdir = $DIRERR.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);
						}
						$mvdir .= "/";
						$handleErr = fopen($mvdir.$file_name, 'w');
						fclose($handleErr);
						chmod($mvdir.$file_name,0777);
						if(copy($DIR.$file_name,$mvdir.$file_name)){
							unlink($DIR.$file_name);
							$message .= "Error";
						}
					}
					echo $message;
				}
			}
		}
	}
	
	function get_codeco_flt_to_db(){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$DIR = $_SERVER['DOCUMENT_ROOT'].'/files/mailbox/FLT/CODECO/';
		$DIRSUC = $_SERVER['DOCUMENT_ROOT'].'/files/history/success/FLT/CODECO/';
		$DIRERR = $_SERVER['DOCUMENT_ROOT'].'/files/history/error/FLT/CODECO/';
		$error = 0;
		$message = "";
		if(is_dir($DIR)){
			if($dh = opendir($DIR)){
				while (($file = readdir($dh)) !== false){
				  if($file!="." && $file!="..") $file_name = $file;
				}
				if(empty($file_name)) {
					echo "No records data"; exit();
				}else{
					$fp = fopen($DIR.$file_name,'r');
					$content = fread($fp, filesize($DIR.$file_name));
					$data = explode("\n", trim($content));
					$header = $data[0];
					foreach($data as $detail){
						$dtl = substr($detail, 0, 4);
						if($dtl != ''){
							if(strtoupper($dtl) == 'HCOR'){
								$arr['HDR'][] = $detail;
							}else{
								$arr['DTL'][] = $detail;
							}
						}
					}
					if(count($arr['HDR']) > 0){
						$array_header = array('HCOR0101','HCOR0201','HCOR0301','HCOR0401');
						for($a=0; $a<count($arr['HDR']); $a++){
							if(in_array(substr($arr['HDR'][$a],0,8),$array_header)){
								$arrheader[] = $arr['HDR'][$a];
							}
						}
						$KD_ASAL     = substr($arrheader[0],28,3);
						$VOYAGE    	 = substr($arrheader[1],11,17);
						$CALL_SIGN   = substr($arrheader[1],59,9);
						$NM_KAPAL  	 = substr($arrheader[1],74,35);
						$PELABUHAN 	 = substr($arrheader[2],11,25);
						$TYPE_PORT 	 = substr($arrheader[2],8,3);
						if(trim($KD_ASAL)=="34"){
							$V_KD_ASAL = 4;
							$TGL_TIBA 	 = substr($arrheader[4],11,8);
						}else if(trim($KD_ASAL)=="36"){
							$V_KD_ASAL = 2;
							$TGL_TIBA 	 = substr($arrheader[3],11,8);
						}
						if(trim($TYPE_PORT)=="9") $arrayhdr['KD_PEL_MUAT'] = $PELABUHAN;
						else if(trim($TYPE_PORT)=="11") $arrayhdr['KD_PEL_BONGKAR'] = $PELABUHAN;
						$V_TGL_TIBA = substr($TGL_TIBA,0,4).'-'.substr($TGL_TIBA,4,2).'-'.substr($TGL_TIBA,6,2);
						$arrayhdr['KD_ASAL_BRG'] 	= $V_KD_ASAL;
						$arrayhdr['KD_TPS'] 	   = 'NCT1';
						$arrayhdr['KD_GUDANG'] 	   = 'NCT1';
						$arrayhdr['KD_KAPAL'] 	   = $this->get_referensi('kapal',$CALL_SIGN,$NM_KAPAL);
						$arrayhdr['NM_ANGKUT'] 	   = $NM_KAPAL;
						$arrayhdr['CALL_SIGN'] 	   = $CALL_SIGN;
						$arrayhdr['NO_VOY_FLIGHT'] = $VOYAGE;
						$arrayhdr['TGL_TIBA'] 	   = $V_TGL_TIBA;
						$arrayhdr['WK_REKAM'] 	   = date('Y-m-d H:i:s');
						$SQL = "SELECT ID FROM t_repohdr A
								WHERE A.KD_ASAL_BRG = ".$this->db->escape(trim($V_KD_ASAL))."
								AND NO_VOY_FLIGHT = ".$this->db->escape(trim($VOYAGE))."
								AND CALL_SIGN = ".$this->db->escape(trim($CALL_SIGN))."
								AND DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') = ".$this->db->escape(trim($TGL_TIBA));
						$result = $func->main->get_result($SQL);
						if($result){
							foreach($SQL->result_array() as $row => $value){
								$arrdata = $value;
							}
							unset($arrayhdr['KD_ASAL_BRG']);
							unset($arrayhdr['KD_TPS']);
							unset($arrayhdr['KD_GUDANG']);
							$this->db->where(array('ID' => $arrdata['ID']));
							$this->db->update('t_repohdr',$arrayhdr);
							$ID = $arrdata['ID'];
						}else{
							$this->db->insert('t_repohdr',$arrayhdr);
							$ID = $this->db->insert_id();
						}
					}
					if($ID!=""){
						if(count($arr['DTL']) > 0){
							$ararydtl = array();
							$arrRFR = array('CR','RE','RH');
							$arraydtl = array();
							for($a=0; $a<count($arr['DTL']); $a++){
								switch(substr($arr['DTL'][$a],0,8)){
									case "DCOR0201" :
										$b++;
										$tipe = $this->get_referensi('isocode',substr($arr['DTL'][$a],28,10),'TIPE');
										$arraydtl[$b]['ID'] 			= $ID;
										$arraydtl[$b]['NO_CONT'] 		= trim(substr($arr['DTL'][$a],11,17));
										$arraydtl[$b]['KD_CONT_UKURAN'] = $this->get_referensi('isocode',trim(substr($arr['DTL'][$a],28,10)),'SIZE');
										$arraydtl[$b]['KD_CONT_TIPE'] 	= (in_array($tipe,$arrRFR))?"RFR":"DRY";
										$arraydtl[$b]['KD_ISO_CODE'] 	= trim(substr($arr['DTL'][$a],28,10));
										$JNS_CONT = substr($arr['DTL'][$a],47,3);
										if(trim($KD_ASAL)=="34"){
											if(trim($JNS_CONT)=='5'){
												$arraydtl[$b]['KD_CONT_STATUS_IN'] 	= 'FCL';
												$arraydtl[$b]['FL_CONT_KOSONG'] 	= '2';
											}else if(trim($JNS_CONT)=="4"){
												$arraydtl[$b]['KD_CONT_STATUS_IN'] 	= 'MTY';
												$arraydtl[$b]['FL_CONT_KOSONG'] 	= '1';
											}
										}else if(trim($KD_ASAL)=="36"){
											if(trim($JNS_CONT)=='5'){
												$arraydtl[$b]['KD_CONT_STATUS_OUT'] = 'FCL';
											}else if(trim($JNS_CONT)=="4"){
												$arraydtl[$b]['KD_CONT_STATUS_OUT'] = 'MTY';
											}
										}
									break;
									case "DCOR0301" :
										$PABEAN = substr($arr['DTL'][$a],0,11);
										$arr_ex_doc = explode("|",$arr['DTL'][$a]);
										$length_no = strlen($arr_ex_doc[0]);
										$length_tgl = strlen($arr_ex_doc[1]);
										if(trim($PABEAN)=='DCOR0301AAE'){
											$arraydtl[$b]['NO_DAFTAR_PABEAN'] = substr($arr_ex_doc[0],11,$length_no);
											$arraydtl[$b]['TGL_DAFTAR_PABEAN'] = substr($arr_ex_doc[1],11,$length_tgl);
										}
										if($KD_ASAL == "34"){
											switch(trim($PABEAN)){
												case "DCOR0301NPE" : 
													$arraydtl[$b]['KD_DOK_IN'] = "6";
													$arraydtl[$b]['NO_DOK_IN'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_IN'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301SP3" : 
													$arraydtl[$b]['KD_DOK_IN'] = "34";
													$arraydtl[$b]['NO_DOK_IN'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_IN'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
											}
										}else if(trim($KD_ASAL)=="36"){
											switch(trim($PABEAN)){
												case "DCOR0301SPB" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "1";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301SPJ" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "19";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301PLP" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "3";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301MTA" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "17";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301SP3" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "20";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
												case "DCOR0301B23" : 
													$arraydtl[$b]['KD_DOK_OUT'] = "2";
													$arraydtl[$b]['NO_DOK_OUT'] = substr($arr_ex_doc[0],11,$length_no);
													$arraydtl[$b]['TGL_DOK_OUT'] = substr($arr_ex_doc[1],11,$length_tgl);
												break;
											}
										}
									break;
									case "DCOR0302" :
										$CONT_JENIS = substr($arr['DTL'][$a],8,1);
										if(trim($CONT_JENIS)=='2'){
											$arraydtl[$b]['KD_CONT_JENIS'] = 'L';	
										}else if(trim($CONT_JENIS)=='3'){
											$arraydtl[$b]['KD_CONT_JENIS'] = 'F';
										}
											
										if($V_KD_ASAL == "4"){
											$arraydtl[$b]['WK_IN'] = trim(substr($arr['DTL'][$a],75,12))."00";
										}else if($V_KD_ASAL == "2"){
											$arraydtl[$b]['WK_OUT'] = trim(substr($arr['DTL'][$a],75,12))."00";
										}
									break;
									case "DCOR0401" :
										if(trim($TYPE_PORT)=="9") $arraydtl[$b]['KD_PEL_MUAT'] = trim($PELABUHAN);
										else if(trim($TYPE_PORT)=="11") $arraydtl[$b]['KD_PEL_BONGKAR'] = trim($PELABUHAN);
										
										if(substr(trim($arr['DTL'][$a]),0,10) =='DCOR040111') 
											$arraydtl[$b]['KD_PEL_BONGKAR'] = trim(substr($arr['DTL'][$a],11,25));
									break;
									case "DCOR0501" :
										if(substr(trim($arr['DTL'][$a]),0,12) =='DCOR0501AAEG')
											$arraydtl[$b]['BRUTO'] = trim(substr($arr['DTL'][$a],17,18));
									break;
									case "DCOR0502" :
										if(trim(substr($arr['DTL'][$a]),18,3)=='SH'){
											$arraydtl[$b]['NO_SEGEL'] = trim(substr($arr['DTL'][$a],8,10));	
										}else if(trim(substr($arr['DTL'][$a]),18,3)=='CU'){
											$arraydtl[$b]['NO_SEGEL_BC'] = trim(substr($arr['DTL'][$a],8,10));	
										}
									break;
								}							
							}
							if(count($arraydtl) > 0){
								for($a=1; $a<=count($arraydtl); $a++){
									$NOCONT = $this->set_id('t_repocont',$ID,$arraydtl[$a]['NO_CONT']);
									if($arraydtl[$a]['TGL_DAFTAR_PABEAN']=="")
										$arraydtl[$a]['TGL_DAFTAR_PABEAN'] = NULL;
									else
										$arraydtl[$a]['TGL_DAFTAR_PABEAN'] = $arraydtl[$a]['TGL_DAFTAR_PABEAN'];
									if($NOCONT){
										unset($arraydtl[$a]['ID']);
										unset($arraydtl[$a]['NO_CONT']);
										$this->db->where(array('ID' => $ID, 'NO_CONT' => $NOCONT));
										$result = $this->db->update('t_repocont',$arraydtl[$a]);
									}else{
										$result = $this->db->insert('t_repocont',$arraydtl[$a]);
									}
									if(!$result){
										$error += 1;
										$message .= "Error insert detail no cont ".$NO_CONT."<br>";
									}
								}
							}
						}
					}else{
						$error += 1;
						$message .= "Error insert header";
					}
					if($error==0){
						$folder_path = date("Ymd");
						$mvdir = $DIRSUC.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);	
						}
						$mvdir .= "/";
						$handleSuc = fopen($mvdir.$file_name, 'w');
						fclose($handleSuc);
						chmod($mvdir.$file_name,0777);
						if(copy($DIR.$file_name,$mvdir.$file_name)){
							unlink($DIR.$file_name);
							$message .= "Success";
						}
					}else{
						$folder_path = date("Ymd");
						$mvdir = $DIRERR.$folder_path;
						if (!is_dir($mvdir)){
							$old = umask(0);
							mkdir($mvdir, 0777);
							umask($old);
						}
						$mvdir .= "/";
						$handleErr = fopen($mvdir.$file_name, 'w');
						fclose($handleErr);
						chmod($mvdir.$file_name,0777);
						if(copy($DIR.$file_name,$mvdir.$file_name)){
							unlink($DIR.$file_name);
							$message .= "Error";
						}
					}
					echo $message;
				}
			}
		}
	}
	
	function get_referensi($type,$kode,$uraian){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$return = NULL;
		switch($type){
			case 'port'  : 
				if($kode!=""){
					$SQL = "SELECT ID, NAMA FROM reff_pelabuhan
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if(!$result){
						$arrdata['ID'] = $kode;
						$arrdata['NAMA'] = $uraian;
						$this->db->insert('reff_pelabuhan',$arrdata);
					}
				}
				$return = $kode;
			break;
			case 'kapal' : 
				#$this->get_referensi('kapal',$CALL_SIGN,$NM_KAPAL);
				if($uraian!=""){
					$SQL = "SELECT ID, NAMA FROM reff_kapal
							WHERE NAMA = ".$this->db->escape(trim($uraian));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$arrdata['CALL_SIGN'] = $kode;
						$this->db->where(array('ID' => $arrdata['ID']));
						$this->db->update('reff_kapal', $arrdata);
						$kode_angkut = $arrdata['ID'];
					}else{
						$arrdata['NAMA'] = $uraian;
						$arrdata['CALL_SIGN'] = $kode;
						$this->db->insert('reff_kapal',$arrdata);
						$kode_angkut = $this->db->insert_id();
					}
				}
				$return = $kode_angkut;
			break;
			case 'cons' :
				if($uraian!=""){
					$SQL = "SELECT ID, NAMA FROM t_organisasi
							WHERE NPWP = ".$this->db->escape(trim($kode))." OR NAMA = ".$this->db->escape(trim($uraian));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						if($kode!=""){
							$this->db->where(array('ID' => $arrdata['ID']));
							$this->db->update('t_organisasi', array('NPWP' => trim($kode)));
						}
						$kode = $arrdata['ID'];
					}else{
						$arrdata['NPWP'] = strtoupper(trim($kode));
						$arrdata['NAMA'] = strtoupper(trim($uraian));
						$arrdata['KD_TIPE_ORGANISASI'] = 'CONS';
						$this->db->insert('t_organisasi',$arrdata);
						$kode = $this->db->insert_id();
					}
				}
				$return = $kode;
			break;
			case 'cont_jenis' :
				if($kode!=""){
					$SQL = "SELECT ID, NAMA FROM reff_cont_jenis
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$kode = $arrdata['ID'];
					}else{
						$kode = NULL;
					}
				}
				$return = $kode;
			break;
			case 'cont_status' :
				if($kode!=""){
					$SQL = "SELECT ID, NAMA FROM reff_cont_status
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$kode = $arrdata['ID'];
					}else{
						$kode = NULL;
					}
				}
				$return = $kode;
			break;
			case 'cont_tipe' :
				if($kode!=""){
					$SQL = "SELECT ID, NAMA FROM reff_cont_tipe
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$kode = $arrdata['ID'];
					}else{
						$kode = NULL;
					}
				}
				$return = $kode;
			break;
			case 'cont_ukuran' :
				if($kode!=""){
					$SQL = "SELECT ID, NAMA FROM reff_cont_ukuran
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$kode = $arrdata['ID'];
					}else{
						$kode = NULL;
					}
				}
				$return = $kode;
			break;
			case 'isocode' :
				if($kode!=""){
					$SQL = "SELECT ID, NAMA, SIZE, HEIGHT, TIPE FROM reff_cont_isocode
							WHERE ID = ".$this->db->escape(trim($kode));
					$result = $func->main->get_result($SQL);
					if($result){
						foreach($SQL->result_array() as $row => $value){
							$arrdata = $value;
						}
						$kode = $arrdata[$uraian];
					}else{
						$kode = NULL;
					}
				}
				$return = $kode;
			break;
		}
		return $return;
	}
	
	function set_id($table,$id,$no_cont){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		if($table=="t_repocont"){
			$SQL = "SELECT NO_CONT AS ID
					FROM $table
					WHERE NO_CONT = ".$this->db->escape(trim($no_cont))."
					AND ID = ".$this->db->escape($id);
		}
		$result = $func->main->get_result($SQL);
		if($result){
			$ID = $SQL->row()->ID;
		}else{
			$ID = false;
		}
		return $ID;
	}
}
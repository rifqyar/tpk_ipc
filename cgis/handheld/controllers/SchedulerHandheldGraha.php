<?php defined('BASEPATH') or exit('No direct script access allowed');

class SchedulerHandheldGraha extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    public function kirim_graha_terbitSpk()
    {

      
            $method = 'kirim_graha_terbitSpk';

            $SQL = "SELECT T.NO_SPK, S.NO_CONT as 'CONT_ID', 'I' as CLS, G.CALL_SIGN as 'KODE_VESSEL', G.VESSEL as 'VESSEL', G.VOY_IN as 'VOY', CASE WHEN G.KD_CONT_JENIS ='F' THEN 'FL' ELSE 'ML' END AS 'STATUS_KONTAINER', G.UKR_CONT as 'EQ_SIZE', G.ISO_CODE, G.TIPE_CONT as EQ_TYPE, G.IMO as IMO_CODE,  DATE_FORMAT(G.DISCHARGE, '%d/%m/%Y') as 'ARRIVAL', DATE_FORMAT(G.DISCHARGE, '%d/%m/%Y %H:%i:%s') as 'STACKING', BC.NAMA as 'JENIS_DOKUMEN', T.NO_DOK as 'NO_DOKUMEN', DATE_FORMAT(T.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', 
            DATE_FORMAT(G.WK_REQ, '%d/%m/%Y %H:%i:%s') as 'REQUEST_GATEPASS', DATE_FORMAT(G.WK_FINISH, '%d/%m/%Y %H:%i:%s') AS APPROVED_GATEPASS, DATE_FORMAT(T.WK_REQ,'%d/%m/%Y %H:%i:%s') as 'TANGGAL_TERBIT_SPK', G.CONSIGNEE as NAMA_CUSTOMER, V.LNSW_NOAJU as DOKUMEN_JI, date_format(V.LNSW_TGLAJU, '%d/%m/%Y') as TGL_DOKUMEN_JI, V.NO_DAFTAR_PABEAN as SPJM_JI, date_format(V.TGL_DAFTAR_PABEAN, '%d/%m/%Y') as TGL_SPJM_JI
            from t_spk_cont as S
            join t_spk as T on T.ID = S.ID
            inner join reff_kode_dok_bc as BC on BC.ID = T.JNS_DOK
            inner join (select D.ID, E.NO_CONT, E.KD_CONT_JENIS,E.UKR_CONT, E.IMO, E.ISO_CODE, D.JNS_DOK, D.NO_DOK,D.TGL_DOK, D.WK_SEND, D.WK_FINISH, D.WK_REKAM, D.WK_REQ, D.CONSIGNEE,E.CALL_SIGN,E.VESSEL,E.VOY_IN, E.TIPE_CONT,E.DISCHARGE from t_request_cont as E inner join t_request as D on E.ID = D.ID order by D.ID DESC) G on 
            G.NO_CONT = S.NO_CONT and G.NO_DOK = T.NO_DOK and G.TGL_DOK = T.TGL_DOK 
            left join v_ppk_permit_join V on V.NO_RESPON = G.NO_DOK and V.TG_RESPON = G.TGL_DOK and V.NO_CONT = G.NO_CONT
            left join log_graha as LG on LG.no_cont = S.NO_CONT and LG.no_dok = T.NO_DOK and LG.tgl_dok = T.TGL_DOK 
            where DATE(T.WK_REQ) >= DATE_ADD(NOW(), interval - 15 day) and LG.no_spk is null and T.KD_STATUS IN('100','200','400', '500') and G.DISCHARGE is not null and YEAR(T.TGL_DOK) >= 2020 order by T.NO_SPK asc limit 20";


            $SQL1 = "SELECT TS.NO_SPK, R.NO_CONT as 'CONT_ID', 'I' as CLS, G.CALL_SIGN as 'KODE_VESSEL', G.VESSEL as 'VESSEL', G.VOY_IN as 'VOY', CASE WHEN G.KD_CONT_JENIS ='F' THEN 'FL' ELSE 'ML' END AS 'STATUS_KONTAINER', G.UKR_CONT as 'EQ_SIZE', G.ISO_CODE, G.TIPE_CONT as EQ_TYPE, G.IMO as IMO_CODE, DATE_FORMAT(G.DISCHARGE, '%d/%m/%Y') as 'ARRIVAL', date_format(G.DISCHARGE, '%d/%m/%Y %H:%i:%s') as 'STACKING',R.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN', date_format(R.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', 
            date_format(G.WK_REQ, '%d/%m/%Y %H:%i:%s') as 'REQUEST_GATEPASS',date_format(G.WK_FINISH, '%d/%m/%Y %H:%i:%s') AS APPROVED_GATEPASS, date_format(TS.WK_REQ,'%d/%m/%Y %H:%i:%s') as 'TANGGAL_TERBIT_SPK', G.CONSIGNEE as NAMA_CUSTOMER, 'Y' as STATUS, LNSW_KD_RESPON
            from t_gatepass as R 
            inner join (select D.ID, E.NO_CONT, E.KD_CONT_JENIS,E.UKR_CONT, E.IMO, E.ISO_CODE, D.JNS_DOK, D.NO_DOK,D.TGL_DOK, D.WK_SEND, D.WK_FINISH, D.WK_REKAM, D.WK_REQ, D.CONSIGNEE,E.CALL_SIGN,E.VESSEL,E.VOY_IN, E.TIPE_CONT,E.DISCHARGE from t_request_cont as E inner join t_request as D on E.ID = D.ID order by D.ID DESC) G on 
            G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK
            left join (select MAX(T.NO_SPK) as NO_SPK, T.NO_DOK, T.TGL_DOK, S.NO_CONT, T.WK_REQ from t_spk_cont as S join t_spk as T on T.ID = S.ID group by S.NO_CONT order by S.NO_CONT DESC) TS on TS.NO_CONT = R.NO_CONT
            left join (select b.NO_CONT, a.NO_DAFTAR_PABEAN, a.TGL_DAFTAR_PABEAN,a.TGL_DOK_INOUT, a.LNSW_KD_RESPON from t_permit_hdr a join t_permit_cont b on a.ID = b.ID ) K on K.NO_CONT = G.NO_CONT and K.NO_DAFTAR_PABEAN = G.NO_DOK and K.TGL_DOK_INOUT = G.TGL_DOK
            left join v_ppk_permit_join V on V.NO_DAFTAR_PABEAN = K.NO_DAFTAR_PABEAN and V.TGL_DAFTAR_PABEAN = K.TGL_DAFTAR_PABEAN and V.NO_CONT = K.NO_CONT
            left join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK 
            where DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 15 day) and R.JNS_KEGIATAN IN ('2') and K.LNSW_KD_RESPON not in ('005')
            and LG.no_spk is null and R.FL_ACTIVE in ('Y') and R.FL_GRAHA IN ('N') and G.DISCHARGE is not null and YEAR(R.TGL_DOK) >= 2020 order by R.ID asc limit 3";



            $SQL2 = "SELECT TS.NO_SPK, R.NO_CONT as 'CONT_ID', 'I' as CLS, G.CALL_SIGN as 'KODE_VESSEL', G.VESSEL as 'VESSEL', G.VOY_IN as 'VOY', CASE WHEN G.KD_CONT_JENIS ='F' THEN 'FL' ELSE 'ML' END AS 'STATUS_KONTAINER', G.UKR_CONT as 'EQ_SIZE', G.ISO_CODE, G.TIPE_CONT as EQ_TYPE, G.IMO as IMO_CODE, DATE_FORMAT(G.DISCHARGE, '%d/%m/%Y') as 'ARRIVAL', date_format(G.DISCHARGE, '%d/%m/%Y %H:%i:%s') as 'STACKING',R.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN', date_format(R.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', 
            date_format(G.WK_REQ, '%d/%m/%Y %H:%i:%s') as 'REQUEST_GATEPASS',date_format(G.WK_FINISH, '%d/%m/%Y %H:%i:%s') AS APPROVED_GATEPASS, date_format(TS.WK_REQ,'%d/%m/%Y %H:%i:%s') as 'TANGGAL_TERBIT_SPK', G.CONSIGNEE as NAMA_CUSTOMER, 'Y' as STATUS, LNSW_KD_RESPON
            from t_gatepass as R 
            inner join (select D.ID, E.NO_CONT, E.KD_CONT_JENIS,E.UKR_CONT, E.IMO, E.ISO_CODE, D.JNS_DOK, D.NO_DOK,D.TGL_DOK, D.WK_SEND, D.WK_FINISH, D.WK_REKAM, D.WK_REQ, D.CONSIGNEE,E.CALL_SIGN,E.VESSEL,E.VOY_IN, E.TIPE_CONT,E.DISCHARGE from t_request_cont as E inner join t_request as D on E.ID = D.ID order by D.ID DESC) G on 
            G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK
            left join (select MAX(T.NO_SPK) as NO_SPK, T.NO_DOK, T.TGL_DOK, S.NO_CONT, T.WK_REQ from t_spk_cont as S join t_spk as T on T.ID = S.ID group by S.NO_CONT order by S.NO_CONT DESC) TS on TS.NO_CONT = R.NO_CONT
            left join (select b.NO_CONT, a.NO_DAFTAR_PABEAN, a.TGL_DAFTAR_PABEAN,a.TGL_DOK_INOUT, a.LNSW_KD_RESPON from t_permit_hdr a join t_permit_cont b on a.ID = b.ID ) K on K.NO_CONT = G.NO_CONT and K.NO_DAFTAR_PABEAN = G.NO_DOK and K.TGL_DOK_INOUT = G.TGL_DOK
            left join v_ppk_permit_join V on V.NO_DAFTAR_PABEAN = K.NO_DAFTAR_PABEAN and V.TGL_DAFTAR_PABEAN = K.TGL_DAFTAR_PABEAN and V.NO_CONT = K.NO_CONT
            left join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK 
            where DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 15 day) and R.JNS_KEGIATAN IN ('2') and K.LNSW_KD_RESPON is null
            and LG.no_spk is null and R.FL_ACTIVE in ('Y') and R.FL_GRAHA IN ('N') and G.DISCHARGE is not null and YEAR(R.TGL_DOK) >= 2020 order by R.ID asc limit 2";



            $nospk ='';
            $nocont ='';
            $jnsdok ='';
            $nodok = '';
            $tgldok ='';

            $hasil_query =$this->db->query($SQL);
            $hasil_query1 =$this->db->query($SQL1);
            $hasil_query2 =$this->db->query($SQL2);


            if ($hasil_query->num_rows() > 0) {
            foreach ($hasil_query->result() as $key => $value) {
                $nospk = $value->NO_SPK;
                $nocont = $value->CONT_ID;
                $jnsdok = $value->JENIS_DOKUMEN;
                $nodok = $value->NO_DOKUMEN;
                $tgldok1 = $value->DOKUMEN_DATE;
                $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
                $NO_SPK = $value->NO_SPK;
                $CONT_ID = $value->CONT_ID;
                $CLS = "I";
                $KODE_VESSEL = $value->KODE_VESSEL;
                $VESSEL = $value->VESSEL;
                $VOY = $value->VOY;
                $STATUS_KONTAINER = $value->STATUS_KONTAINER;
                $EQ_SIZE = $value->EQ_SIZE;
                $ISO_CODE = $value->ISO_CODE;
                $EQ_TYPE = $value->EQ_TYPE;
                $IMO_CODE = $value->IMO_CODE;
                $ARRIVAL= $value->ARRIVAL;
                $STACKING= $value->STACKING;
                $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
                $NO_DOKUMEN = $value->NO_DOKUMEN;
                $DOKUMEN_DATE = $value->DOKUMEN_DATE;
                $REQUEST_GATEPASS = $value->REQUEST_GATEPASS;
                $APPROVED_GATEPASS = $value->APPROVED_GATEPASS;
                $TANGGAL_TERBIT_SPK = $value->TANGGAL_TERBIT_SPK;
                $NAMA_CUSTOMER = $value->NAMA_CUSTOMER;
                $DOKUMEN_JI = $value->DOKUMEN_JI;
                $TGL_DOKUMEN_JI = $value->TGL_DOKUMEN_JI;
                $SPJM_JI = $value->SPJM_JI;
                $TGL_SPJM_JI = $value->TGL_SPJM_JI;
                $NO_CONT = $value->CONT_ID;
               

            
                $postData = array (
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'CLS' => 'I',
                'KODE_VESSEL' => $KODE_VESSEL,
                'VESSEL' => $VESSEL,
                'VOY' => $VOY,
                'STATUS_KONTAINER' => $STATUS_KONTAINER,
                'EQ_SIZE' => $EQ_SIZE,
                'ISO_CODE' => $ISO_CODE,
                'EQ_TYPE' => $EQ_TYPE,
                'IMO_CODE' => $IMO_CODE,
                'ARRIVAL' => $ARRIVAL,
                'STACKING' => $STACKING,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'REQUEST_GATEPASS' => $REQUEST_GATEPASS,
                'APPROVED_GATEPASS' => $APPROVED_GATEPASS,
                'TANGGAL_TERBIT_SPK' => $TANGGAL_TERBIT_SPK,
                'NAMA_CUSTOMER' => $NAMA_CUSTOMER,
                'DOKUMEN_JI' => $DOKUMEN_JI,
                'TGL_DOKUMEN_JI' => $TGL_DOKUMEN_JI,
                'SPJM_JI' => $SPJM_JI,
                'TGL_SPJM_JI' => $TGL_SPJM_JI

                );

                //$data =json_encode($postData);
                $data = http_build_query($postData);
                // var_dump ($data); die();
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
                CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                    "Content-Type: application/x-www-form-urlencoded"
                ),
             ));

                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                  }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl);

                // var_dump ($response); die();
                
                //$response = $string = preg_replace('/\s+/', '', $response);
                $resp = $response;
                $json = json_encode($response);
                if (preg_match("/true/i", $json)) {              
                  if($resp != ""){
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_graha` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp')");
                    echo $nospk." = ---- Succes, Data tersimpan di Tabel Log_Graha --- \r\n";
                  } else {
                    echo " -- Tidak Ada --\r\n";
                  }
                } else if (preg_match("/false/i", $json)) {
                  if($resp != ""){
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_graha` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp')");
                    echo $nospk." = ---- False, Data tersimpan di Tabel Log_Graha --- \r\n";
                  }
                  echo "-- $json --\r\n" ;
                }
              }
            } else if($hasil_query1->num_rows() > 0) {
                foreach ($hasil_query1->result() as $key => $value1) {
                $nospk = $value1->NO_SPK;
                $nocont = $value1->CONT_ID;
                $jnsdok = $value1->JENIS_DOKUMEN;
                $nodok = $value1->NO_DOKUMEN;
                $tgldok1 = $value1->DOKUMEN_DATE;
                $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
                $NO_SPK = $value1->NO_SPK;
                $CONT_ID = $value1->CONT_ID;
                $CLS = "I";
                $KODE_VESSEL = $value1->KODE_VESSEL;
                $VESSEL = $value1->VESSEL;
                $VOY = $value1->VOY;
                $STATUS_KONTAINER = $value1->STATUS_KONTAINER;
                $EQ_SIZE = $value1->EQ_SIZE;
                $ISO_CODE = $value1->ISO_CODE;
                $EQ_TYPE = $value1->EQ_TYPE;
                $IMO_CODE = $value1->IMO_CODE;
                $ARRIVAL= $value1->ARRIVAL;
                $STACKING= $value1->STACKING;
                $JENIS_DOKUMEN = $value1->JENIS_DOKUMEN;
                $NO_DOKUMEN = $value1->NO_DOKUMEN;
                $DOKUMEN_DATE = $value1->DOKUMEN_DATE;
                $REQUEST_GATEPASS = $value1->REQUEST_GATEPASS;
                $APPROVED_GATEPASS = $value1->APPROVED_GATEPASS;
                $TANGGAL_TERBIT_SPK = $value1->TANGGAL_TERBIT_SPK;
                $NAMA_CUSTOMER = $value1->NAMA_CUSTOMER;
                $NO_CONT = $value1->CONT_ID;
                $ID = $value1->ID;
                $STATUS = "Y";
    
            
                $postData = array (
                    'NO_SPK' => $NO_SPK,
                    'CONT_ID' => $CONT_ID,
                    'CLS' => 'I',
                    'KODE_VESSEL' => $KODE_VESSEL,
                    'VESSEL' => $VESSEL,
                    'VOY' => $VOY,
                    'STATUS_KONTAINER' => $STATUS_KONTAINER,
                    'EQ_SIZE' => $EQ_SIZE,
                    'ISO_CODE' => $ISO_CODE,
                    'EQ_TYPE' => $EQ_TYPE,
                    'IMO_CODE' => $IMO_CODE,
                    'ARRIVAL' => $ARRIVAL,
                    'STACKING' => $STACKING,
                    'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                    'NO_DOKUMEN' => $NO_DOKUMEN,
                    'DOKUMEN_DATE' => $DOKUMEN_DATE,
                    'REQUEST_GATEPASS' => $REQUEST_GATEPASS,
                    'APPROVED_GATEPASS' => $APPROVED_GATEPASS,
                    'TANGGAL_TERBIT_SPK' => $TANGGAL_TERBIT_SPK,
                    'NAMA_CUSTOMER' => $NAMA_CUSTOMER,
                    'STATUS' => 'Y'
                );
    
                //$data1 =json_encode($postData);
                $data1 = http_build_query($postData);
                //var_dump ($data1); die();
                //var_dump($data1);
    
            
                $curl = curl_init();
                curl_setopt_array($curl, array(
                // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
                CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data1,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                    "Content-Type: application/x-www-form-urlencoded"
                ),
                ));
    
                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                  }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                
                //$response = $string = preg_replace('/\s+/', '', $response);
                $resp = $response;
    
                $json = json_encode($response);
                if (preg_match("/true/i", $json)) {
                    if($resp != ""){
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_graha` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `fl_graha`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data1', '$resp', 'Y')");
                    echo $nospk." = ---- Succes, Data tersimpan di Tabel Log_Graha --- \r\n";
                    } else {
                      echo " -- Tidak Ada --\r\n";
                    }
                 } else if (preg_match("/false/i", $json)) {
                  echo "-- $json --\n" ;
                }
              }
            } else if($hasil_query2->num_rows() > 0) {
                foreach ($hasil_query2->result() as $key => $value2) {
                $nospk = $value2->NO_SPK;
                $nocont = $value2->CONT_ID;
                $jnsdok = $value2->JENIS_DOKUMEN;
                $nodok = $value2->NO_DOKUMEN;
                $tgldok1 = $value2->DOKUMEN_DATE;
                $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
                $NO_SPK = $value2->NO_SPK;
                $CONT_ID = $value2->CONT_ID;
                $CLS = "I";
                $KODE_VESSEL = $value2->KODE_VESSEL;
                $VESSEL = $value2->VESSEL;
                $VOY = $value2->VOY;
                $STATUS_KONTAINER = $value2->STATUS_KONTAINER;
                $EQ_SIZE = $value2->EQ_SIZE;
                $ISO_CODE = $value2->ISO_CODE;
                $EQ_TYPE = $value2->EQ_TYPE;
                $IMO_CODE = $value2->IMO_CODE;
                $ARRIVAL= $value2->ARRIVAL;
                $STACKING= $value2->STACKING;
                $JENIS_DOKUMEN = $value2->JENIS_DOKUMEN;
                $NO_DOKUMEN = $value2->NO_DOKUMEN;
                $DOKUMEN_DATE = $value2->DOKUMEN_DATE;
                $REQUEST_GATEPASS = $value2->REQUEST_GATEPASS;
                $APPROVED_GATEPASS = $value2->APPROVED_GATEPASS;
                $TANGGAL_TERBIT_SPK = $value2->TANGGAL_TERBIT_SPK;
                $NAMA_CUSTOMER = $value2->NAMA_CUSTOMER;
                $NO_CONT = $value2->CONT_ID;
                $ID = $value2->ID;
                $STATUS = "Y";
    
            
                $postData = array (
                    'NO_SPK' => $NO_SPK,
                    'CONT_ID' => $CONT_ID,
                    'CLS' => 'I',
                    'KODE_VESSEL' => $KODE_VESSEL,
                    'VESSEL' => $VESSEL,
                    'VOY' => $VOY,
                    'STATUS_KONTAINER' => $STATUS_KONTAINER,
                    'EQ_SIZE' => $EQ_SIZE,
                    'ISO_CODE' => $ISO_CODE,
                    'EQ_TYPE' => $EQ_TYPE,
                    'IMO_CODE' => $IMO_CODE,
                    'ARRIVAL' => $ARRIVAL,
                    'STACKING' => $STACKING,
                    'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                    'NO_DOKUMEN' => $NO_DOKUMEN,
                    'DOKUMEN_DATE' => $DOKUMEN_DATE,
                    'REQUEST_GATEPASS' => $REQUEST_GATEPASS,
                    'APPROVED_GATEPASS' => $APPROVED_GATEPASS,
                    'TANGGAL_TERBIT_SPK' => $TANGGAL_TERBIT_SPK,
                    'NAMA_CUSTOMER' => $NAMA_CUSTOMER,
                    'STATUS' => 'Y'
                );
    
                //$data1 =json_encode($postData);
                $data1 = http_build_query($postData);
                // var_dump ($data1); die();
                //var_dump($data1);
    
            
                $curl = curl_init();
                curl_setopt_array($curl, array(
                // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
                CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data1,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                    "Content-Type: application/x-www-form-urlencoded"
                ),
                ));
    
                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                  }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                
                //$response = $string = preg_replace('/\s+/', '', $response);
                $resp = $response;

                // var_dump($response);
    
                $json = json_encode($response);
                if (preg_match("/true/i", $json)) {
                    if($resp != ""){
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_graha` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `fl_graha`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data1', '$resp', 'Y')");
                    echo $nospk." = ---- Succes, Data tersimpan di Tabel Log_Graha --- \r\n";
                    } else {
                      echo " -- Tidak Ada --\r\n";
                    }
                } else if (preg_match("/false/i", $json)) {
                  echo "-- $json --\n" ;
                }
              }
            } else {
            echo "Tidak Ada \r\n";
          }
    }
        
    public function update_graha_behandleIn()
    {
  
        $method = 'update_graha_behandleIn';

        $SQL = "SELECT T.NO_SPK, S.NO_CONT as 'CONT_ID', H.NAMA as 'JENIS_DOKUMEN', T.NO_DOK as 'NO_DOKUMEN',date_format(T.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', date_format(Y.W_BEHANDLE, '%d/%m/%Y %H:%i:%s')  as 'GATE_IN_DATE', Y.ID as 'ID_GATE_IN', K.NO_TRUCK as 'NO_TID', K.NO_PLAT as 'NO_TRUCK', date_format(G.DISCHARGE,'%d/%m/%Y %H:%i:%s') as 'YARD_DATE', Y.ROOM as 'YARD_BLOK', Y.FL_GRAHA 
        from t_spk_cont as S
        join t_spk as T on T.ID = S.ID
        join reff_kode_dok_bc as H on H.ID = T.JNS_DOK
        left join reff_truck as K on K.NO_TRUCK = S.ID_FLAT 
        inner join t_op_behandlein as Y on Y.NO_SPK = T.NO_SPK and Y.NO_CONT = S.NO_CONT 
        left join ( select D.ID as 'ID', E.NO_CONT as 'NO_CONT', D.JNS_DOK as 'JNS_DOK', D.NO_DOK as 'NO_DOK',D.TGL_DOK as 'TGL_DOK', E.DISCHARGE as 'DISCHARGE', E.KD_STATUS, E.REQ_PILIH from t_request_cont as E inner join t_request as D on E.ID = D.ID order by D.ID DESC) G on G.NO_CONT = S.NO_CONT and G.NO_DOK = T.NO_DOK and G.TGL_DOK = T.TGL_DOK
        inner join log_graha as LG on LG.no_cont = S.NO_CONT and LG.no_dok = T.NO_DOK and LG.tgl_dok = T.TGL_DOK  
        where DATE(Y.W_BEHANDLE ) >= DATE_ADD(NOW(), interval - 50 day )  AND T.KD_STATUS IN('400','500') AND Y.FL_GRAHA IN ('N') and G.KD_STATUS in ('INQUIRY') and G.REQ_PILIH in ('Y') and G.DISCHARGE is not null and YEAR(T.TGL_DOK) >= 2020 order by T.NO_SPK desc limit 10";
        
        $SQL1 = "SELECT S.NO_SPK, R.NO_CONT as 'CONT_ID', R.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN',date_format(R.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', date_format(Y.W_BEHANDLE, '%d/%m/%Y %H:%i:%s')  as 'GATE_IN_DATE', Y.ID as 'ID_GATE_IN', K.NO_TRUCK as 'NO_TID', K.NO_PLAT as 'NO_TRUCK', date_format(G.DISCHARGE,'%d/%m/%Y %H:%i:%s') as 'YARD_DATE', Y.ROOM as 'YARD_BLOK', Y.FL_GRAHA2, R.JNS_KEGIATAN 
        from (select b.ID,b.NO_SPK, a.NO_CONT, b.NO_DOK, b.TGL_DOK, a.ID_FLAT from t_spk_cont as a join t_spk as b on a.ID = b.ID ) S
        left join reff_truck as K on K.NO_TRUCK = S.ID_FLAT 
        inner join t_op_behandlein as Y on Y.NO_SPK = S.NO_SPK and Y.NO_CONT = S.NO_CONT
        left join ( select D.ID as 'ID', E.NO_CONT as 'NO_CONT', D.JNS_DOK as 'JNS_DOK', D.NO_DOK as 'NO_DOK',D.TGL_DOK as 'TGL_DOK', E.DISCHARGE as 'DISCHARGE' from t_request_cont as E inner join t_request as D on E.ID = D.ID order by D.ID DESC) G on G.NO_CONT = S.NO_CONT and G.NO_DOK = S.NO_DOK and G.TGL_DOK = S.TGL_DOK
        left join t_gatepass as R on R.NO_CONT = S.NO_CONT
        inner join log_graha as LG on  LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK 
        left join log_graha_behandle as L on L.no_cont = R.no_cont and L.no_dok = R.no_dok and L.tgl_dok = R.tgl_dok 
        where DATE(Y.W_BEHANDLE ) >= DATE_ADD(NOW(), interval - 1 month  ) and R.JNS_KEGIATAN IN ('2') and R.FL_ACTIVE in ('Y') and L.no_spk is null AND Y.FL_GRAHA2 IN ('N') and G.DISCHARGE is not null and YEAR(S.TGL_DOK) >= 2020 order by R.ID DESC limit 10";
        

        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';

        $hasil_query =$this->db->query($SQL);
        $hasil_query1 =$this->db->query($SQL1);

        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value->NO_DOKUMEN;
            $DOKUMEN_DATE = $value->DOKUMEN_DATE;
            $GATE_IN_DATE = $value->GATE_IN_DATE;
            $NO_TID = $value->NO_TID;
            $NO_TRUCK = $value->NO_TRUCK;
            $YARD_DATE = $value->YARD_DATE;
            $YARD_BLOK = $value->YARD_BLOK;
            $NO_CONT = $value->CONT_ID;
            $ID_GATE_IN = $value->ID_GATE_IN;

        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATE_IN_DATE' => $GATE_IN_DATE,
                'NO_TID' => $NO_TID,
                'NO_TRUCK' => $NO_TRUCK,
                'YARD_DATE' => $YARD_DATE,
                'YARD_BLOK' => $YARD_BLOK

        );
        echo json_encode($postData);

        $data = http_build_query($postData);
        //var_dump ($data); die();
        //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;

              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_behandle` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Behandle \r\n";
                } else {
                  echo " -- Tidak Ada --\r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_op_behandlein SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_IN."' AND NO_CONT = '".$NO_CONT."'";
                    echo $SQL." --- Update Success --- "."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                      echo " -- Tidak Ada --\r\n";
                } 
             } else {
                
                echo $json;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_behandle` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Behandle \r\n";
                     
                if($NO_CONT != ""){
                $SQL = "UPDATE t_op_behandlein SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_IN."' AND NO_CONT = '".$NO_CONT."'";
                echo $SQL." --- Update Success --- "."\r\n\r\n";
                $this->db->query($SQL);
                } else {
                  echo " -- Tidak Ada --\r\n";
                } 
                */
            }  
          }
        }  else if ($hasil_query1->num_rows() > 0) {
            foreach ($hasil_query1->result() as $key => $value1) {
              $nospk = $value1->NO_SPK;
              $nocont = $value1->CONT_ID;
              $jnsdok = $value1->JENIS_DOKUMEN;
              $nodok = $value1->NO_DOKUMEN;
              $tgldok1 = $value1->DOKUMEN_DATE;
              $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
              $NO_SPK = $value1->NO_SPK;
              $CONT_ID = $value1->CONT_ID;
              $JENIS_DOKUMEN = $value1->JENIS_DOKUMEN;
              $NO_DOKUMEN = $value1->NO_DOKUMEN;
              $DOKUMEN_DATE = $value1->DOKUMEN_DATE;
              $GATE_IN_DATE = $value1->GATE_IN_DATE;
              $NO_TID = $value1->NO_TID;
              $NO_TRUCK = $value1->NO_TRUCK;
              $YARD_DATE = $value1->YARD_DATE;
              $YARD_BLOK = $value1->YARD_BLOK;
              $NO_CONT = $value1->CONT_ID;
              $ID_GATE_IN = $value1->ID_GATE_IN;
  
          $postData = array (
                                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATE_IN_DATE' => $GATE_IN_DATE,
                'NO_TID' => $NO_TID,
                'NO_TRUCK' => $NO_TRUCK,
                'YARD_DATE' => $YARD_DATE,
                'YARD_BLOK' => $YARD_BLOK     
  
          );
          echo $NO_SPK;
          $data = http_build_query($postData);
          
          //echo $data; die();
    
                $curl = curl_init();
                curl_setopt_array($curl, array(
                // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
                CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                    "Content-Type: application/x-www-form-urlencoded"
                ),
            ));
  
                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                  } else {
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl);
                //$response = $string = preg_replace('/\s+/', '', $response);
                $resp = $response;
  
                $json = json_encode($response);
              if (preg_match("/true/i", $json)) { 
                  if($resp != ""){
                  $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_behandle` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','2')");
                  echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Behandle \r\n";
                  } else {
                     echo " -- Tidak Ada -- \r\n";
                  }

                  if($NO_CONT != ""){
                      $SQL = "UPDATE t_op_behandlein SET FL_GRAHA2  = 'Y' WHERE ID= '".$ID_GATE_IN."' AND NO_CONT = '".$NO_CONT."'";
                      echo $SQL." --- Update Success --- "."\r\n\r\n";
                      $this->db->query($SQL);
                  } else {
                          echo " -- Tidak Ada -- \r\n";
                  } 
               } else {

                  echo $json;
                  /*
                  $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_behandle` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','2')");
                  echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Behandle \r\n";
                  
                  if($NO_CONT != ""){
                  $SQL = "UPDATE t_op_behandlein SET FL_GRAHA2  = 'Y' WHERE ID= '".$ID_GATE_IN."' AND NO_CONT = '".$NO_CONT."'";
                  echo $SQL." --- Update Success --- "."\r\n\r\n";
                  $this->db->query($SQL);
                  } else {
                    echo " -- Tidak Ada --\r\n";
                  } 
                  */
              }
            }
          } else {
              echo "Tidak Ada \r\n";
          }
    }

    public function update_graha_behandleOne()
    {
  
        $method = 'update_graha_behandleOne';

        $SQL = "SELECT LG.no_spk as NO_SPK, R.NO_CONT as 'CONT_ID',R.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN',date_format(R.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', DATE_FORMAT(R.WK_REK, '%d/%m/%Y %H:%i:%s') AS 'GATEPASS_BHD1', R.ID AS 'ID_GATE_PASS'
        from t_spk_cont as S
        join t_spk as T on T.ID = S.ID
        left join t_gatepass as R on R.NO_CONT = S.NO_CONT and R.TGL_DOK = T.TGL_DOK and R.NO_DOK = T.NO_DOK
        inner join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK 
        where DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 20 day) and R.JNS_KEGIATAN IN ('1') and R.FL_ACTIVE in ('Y') AND R.FL_GRAHA in ('N') and YEAR(T.TGL_DOK) >= 2020  order by R.ID DESC limit 10";

        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';

        $hasil_query =$this->db->query($SQL);
        try{
        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value->NO_DOKUMEN;
            $DOKUMEN_DATE = $value->DOKUMEN_DATE;
            $GATEPASS_BHD1 = $value->GATEPASS_BHD1;
            $NO_CONT = $value->CONT_ID;
            $ID_GATE_PASS = $value->ID_GATE_PASS;


        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATEPASS_BHD1' => $GATEPASS_BHD1 

        );
        $data = http_build_query($postData);
        //var_dump ($data); die();
        //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;
              
              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='1'";
                    echo $SQL."--- Update Success --- "."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                        echo " --Tidak Ada-- \r\n";
                }
             } else {
              
                echo $json;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
                   
                if($NO_CONT != ""){
                $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='1'";
                echo $SQL."--- Update Success --- "."\r\n\r\n";
                $this->db->query($SQL);
                } else {
                  echo " --Tidak Ada-- \r\n";
                }
                */
            }  
          }
        } else {
            echo "Tidak Ada \r\n";
        }

      } catch (\Exception $error) {
        echo " exception: " . $error->getMessage();
      } 
  
    }

    public function update_graha_behandleTwo()
    {
  
        $method = 'update_graha_behandleTwo';

        $SQL = "SELECT LG.no_spk as NO_SPK, R.NO_CONT as 'CONT_ID',R.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN',date_format(R.TGL_DOK, '%d/%m/%Y') as 'DOKUMEN_DATE', DATE_FORMAT(R.  WK_REK, '%d/%m/%Y %H:%i:%s') AS 'GATEPASS_BHD2', R.ID AS 'ID_GATE_PASS'
        from t_gatepass as R
        inner join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK
        left join log_graha_gatepass2 as L on L.no_cont = R.NO_CONT 
        where DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 60 DAY) and R.JNS_KEGIATAN in ('2') and L.no_spk is null and R.FL_ACTIVE in ('Y') and YEAR(R.TGL_DOK) >= 2020 group by R.NO_CONT having count(R.NO_CONT) = 1 order by R.ID desc limit 10";

        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';
        
        $hasil_query =$this->db->query($SQL);
        
        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value->NO_DOKUMEN;
            $DOKUMEN_DATE = $value->DOKUMEN_DATE;
            $GATEPASS_BHD2 = $value->GATEPASS_BHD2;
            $NO_CONT = $value->CONT_ID;
            $ID_GATE_PASS = $value->ID_GATE_PASS;


        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATEPASS_BHD2' => $GATEPASS_BHD2,

        );
        $data = http_build_query($postData);
       //var_dump ($data); die();
       //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , ", $info['total_time'] , " This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;
             
              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass2` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '2')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='2'";
                    echo $SQL." --- Update Success --- "."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                  echo " --Tidak Ada-- \r\n";
                } 
            } else {
                    
                echo $json;
                echo $NO_DOKUMEN;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass2` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`, `jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '2')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
    
                    
                if($NO_CONT != ""){
                   $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='2'";
                   echo $SQL." --- Update Success --- "."\r\n\r\n";
                   $this->db->query($SQL);
                } else {
                   echo " --Tidak Ada-- \r\n";
                } 
                */  
            }
          }
        } else {
            echo "Tidak Ada \r\n";
        }   
    }

    public function update_graha_behandleThree()
    {
  
        $method = 'update_graha_behandleThree';

        $SQL = "SELECT LG.no_spk as NO_SPK, R.NO_CONT as 'CONT_ID', R.JNS_DOK AS 'JENIS_DOKUMEN', R.NO_DOK AS 'NO_DOKUMEN', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') AS 'DOKUMEN_DATE', DATE_FORMAT(R.WK_REK,'%d/%m/%Y %H:%i:%s') as 'GATEPASS_BHD3', R.ID AS 'ID_GATE_PASS'
        from t_gatepass as R 
        join reff_kode_dok_bc as B on B.NAMA = R.JNS_DOK
        inner join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK
        left join log_graha_gatepass3 as L on L.no_cont = R.NO_CONT and L.no_dok = R.NO_DOK and L.tgl_dok = R.TGL_DOK 
        where DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 10 DAY ) and R.JNS_KEGIATAN in ('2') and L.no_cont is null and  R.FL_ACTIVE in ('Y') and YEAR(R.TGL_DOK) >= 2020 group by R.NO_CONT having COUNT(R.NO_CONT ) > 1  order by R.ID DESC";

        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';
        
        $hasil_query =$this->db->query($SQL);
        
        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value->NO_DOKUMEN;
            $DOKUMEN_DATE = $value->DOKUMEN_DATE;
            $GATEPASS_BHD3 = $value->GATEPASS_BHD3;
            $NO_CONT = $value->CONT_ID;
            $ID_GATE_PASS = $value->ID_GATE_PASS;


        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATEPASS_BHD3' => $GATEPASS_BHD3,

        );
        $data = http_build_query($postData);
        //var_dump ($data); die();
       //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , ", $info['total_time'] , " This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;
             
              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass3` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '3')");
                echo $nocont." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='2'";
                    echo $SQL." --- Update Success --- "."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                  echo " --Tidak Ada-- \r\n";
                } 
            } else {
                   
                echo $json;
                echo $NO_DOKUMEN;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass3` (`nama`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('BEHANDLE 3','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '3')");
                echo $nocont." = Succes , Data tersimpan di Tabel Log Graha Gatepass \r\n";
                    
                if($NO_CONT != ""){
                   $SQL = "UPDATE t_gatepass SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_GATE_PASS."' AND NO_CONT = '".$NO_CONT."' AND JNS_KEGIATAN ='2'";
                   echo $SQL." --- Update Success --- "."\r\n\r\n";
                   $this->db->query($SQL);
                } else {
                   echo " --Tidak Ada-- \r\n";
                } 
                */
            }
          }
        } else {
            echo "Tidak Ada \r\n";
        }   
    }

    public function update_graha_gateOut()
    {
  
        $method = 'update_graha_gateOut';

        $SQL = "SELECT lg.no_spk as NO_SPK, C.NO_CONT as 'CONT_ID', lg.jns_dok AS 'JENIS_DOKUMEN', T.NO_DOK AS 'NO_DOKUMEN', DATE_FORMAT(T.TGL_DOK,'%d/%m/%Y') AS 'DOKUMEN_DATE',DATE_FORMAT(P.WK_GATEOUT,'%d/%m/%Y %H:%i:%s')  as 'GATE_OUT_DATE', P.ID as 'ID_DELIVERY', C.STATUS_CONT, T.WK_REQ, P.FL_GRAHA
        from t_spk_cont as C join t_spk as T on C.ID = T.ID
        join (select b.ID, b.NO_SPK, a.NO_CONT, a.NO_DOK, a.TGL_DOK, b.WK_GATEOUT, b.FL_GRAHA from t_operation as a left join t_op_delivery as b on a.NO_CONT = b.NO_CONT) P on P.NO_CONT = C.NO_CONT and P.NO_DOK = T.NO_DOK and P.TGL_DOK = T.TGL_DOK 
        inner join log_graha as lg on lg.no_cont = C.NO_CONT and lg.no_dok = T.NO_DOK and lg.tgl_dok = T.TGL_DOK
        left join log_graha_gateout as lgg on lgg.no_cont = C.NO_CONT and lgg.no_dok = T.NO_DOK and lgg.tgl_dok = T.TGL_DOK
        where DATE(P.WK_GATEOUT ) >= DATE_ADD(NOW(), interval - 60 day) and lgg.no_spk is null and C.STATUS_CONT in('900') and P.FL_GRAHA in ('N') and YEAR(T.TGL_DOK) >= 2020 
        order by P.ID desc limit 7";

        $SQL1 = "SELECT LG.no_spk as NO_SPK, R.NO_CONT as 'CONT_ID', U.NAMA AS 'JENIS_DOKUMEN', R.NO_DOK AS 'NO_DOKUMEN', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') AS 'DOKUMEN_DATE',DATE_FORMAT(P.WK_GATEOUT,'%d/%m/%Y %H:%i:%s')  as 'GATE_OUT_DATE', P.ID as 'ID_DELIVERY'
        from t_gatepass as R 
        join reff_kode_dok_bc as U on U.NAMA = R.JNS_DOK 
        join (select T.NO_SPK, C.NO_CONT, T.NO_DOK, T.TGL_DOK, C.STATUS_CONT, T.WK_REQ from t_spk_cont as C join t_spk as T on C.ID = T.ID order by T.NO_SPK DESC) CT on CT.NO_CONT = R.NO_CONT 
        inner join t_op_delivery as P on P.NO_SPK = CT.NO_SPK and P.NO_CONT = R.NO_CONT 
        inner join log_graha as LG on LG.no_cont = R.NO_CONT and LG.no_dok = R.NO_DOK and LG.tgl_dok = R.TGL_DOK 
        left join log_graha_gateout as L on L.no_cont = R.no_cont and L.no_dok = R.no_dok and L.tgl_dok = R.tgl_dok
        where DATE(P.WK_GATEOUT ) >= DATE_ADD(NOW(), interval - 90 day) and R.JNS_KEGIATAN in ('2') and L.no_spk is null and CT.STATUS_CONT in('900') and P.FL_GRAHA2 in ('N') and YEAR(CT.TGL_DOK) >= 2020 
        order by P.ID desc";


        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';

        $hasil_query =$this->db->query($SQL);
        $hasil_query1 =$this->db->query($SQL1);
        
        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value->NO_DOKUMEN;
            $DOKUMEN_DATE = $value->DOKUMEN_DATE;
            $GATE_OUT_DATE = $value->GATE_OUT_DATE;
            $NO_CONT = $value->CONT_ID;
            $ID_DELIVERY = $value->ID_DELIVERY;

        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATE_OUT_DATE' => $GATE_OUT_DATE
               
        );
        $data = http_build_query($postData);
        //var_dump ($data); die();
        //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;

              $json = json_encode($response);
            if (preg_match("/true/i", $json )) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gateout` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gateout \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_op_delivery SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_DELIVERY."' AND NO_CONT= '".$NO_CONT."'";
                    echo $SQL." --- Update Success ---"."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                  echo " --Tidak Ada-- \r\n";
                } 
            } else {

                echo $json;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gateout` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gateout \r\n";
                    
                if($NO_CONT != ""){
                   $SQL = "UPDATE t_op_delivery SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_DELIVERY."' AND NO_CONT= '".$NO_CONT."'";
                   echo $SQL." --- Update Success ---"."\r\n\r\n";
                   $this->db->query($SQL);
                } else {
                   echo " --Tidak Ada-- \r\n";
                } 
                */     
            } 
          }
        } else if ($hasil_query1->num_rows() > 0) {
          foreach ($hasil_query1->result() as $key => $value1) {
            $nospk = $value1->NO_SPK;
            $nocont = $value1->CONT_ID;
            $jnsdok = $value1->JENIS_DOKUMEN;
            $nodok = $value1->NO_DOKUMEN;
            $tgldok1 = $value1->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value1->NO_SPK;
            $CONT_ID = $value1->CONT_ID;
            $JENIS_DOKUMEN = $value1->JENIS_DOKUMEN;
            $NO_DOKUMEN = $value1->NO_DOKUMEN;
            $DOKUMEN_DATE = $value1->DOKUMEN_DATE;
            $GATE_OUT_DATE = $value1->GATE_OUT_DATE;
            $NO_CONT = $value1->CONT_ID;
            $ID_DELIVERY = $value1->ID_DELIVERY;

        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'GATE_OUT_DATE' => $GATE_OUT_DATE
               
        );
        $data = http_build_query($postData);
        //var_dump ($data); die();
        //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/Graha",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/Graha",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
              }else{
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;

              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gateout` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','2')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gateout \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_CONT != ""){
                    $SQL = "UPDATE t_op_delivery SET FL_GRAHA2  = 'Y' WHERE ID= '".$ID_DELIVERY."' AND NO_CONT= '".$NO_CONT."'";
                    echo $SQL." --- Update Success ---"."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                  echo " --Tidak Ada-- \r\n";
                } 
            } else {
                
                echo $json;
                /*
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gateout` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp','2')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Gateout \r\n";
               
                if($NO_CONT != ""){
                    $SQL = "UPDATE t_op_delivery SET FL_GRAHA2  = 'Y' WHERE ID= '".$ID_DELIVERY."' AND NO_CONT= '".$NO_CONT."'";
                    echo $SQL." --- Update Success ---"."\r\n\r\n";
                    $this->db->query($SQL);
                } else {
                        echo " --Tidak Ada-- \r\n";
                } 
                */
            } 
          }
        } else {
            echo "Tidak Ada \r\n";
        }   
    }

    public function get_graha_dataSeal()
    {
      
        $method = 'get_graha_dataSeal';
        // $alamat = 'http://103.130.242.88/service_kalibaru/api/Graha?';
        $alamat = 'http://103.130.242.82/service_kalibaru/api/Graha?';

        $SQL = "SELECT distinct L.no_spk as NO_SPK, R.NO_CONT as 'CONT_ID', L.jns_dok as 'JENIS_DOKUMEN', L.no_dok as 'NO_DOKUMEN', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') as 'DOKUMEN_DATE',R.JNS_KEGIATAN AS 'BEHANDLE1', R.ID as 'ID_INSPECTION'
        from t_op_inspection as R
        inner join t_gatepass as G on G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK
        inner join (select a.NO_CONT, b.NO_DOK, b.TGL_DOK from t_spk_cont as a inner join t_spk as b on a.ID = b.ID ) K on K.NO_CONT = R.NO_CONT and K.NO_DOK = R.NO_DOK and K.TGL_DOK = R.TGL_DOK
        left join log_graha as L ON L.no_cont = R.NO_CONT AND L.no_dok = R.NO_DOK AND L.tgl_dok = R.TGL_DOK
        LEFT JOIN log_graha_getseal as LG ON LG.no_cont = R.NO_CONT AND LG.no_dok = R.NO_DOK AND LG.tgl_dok = R.TGL_DOK
        WHERE DATE(R.WK_REK) >= DATE_ADD(NOW(), interval - 30 day) AND R.FL_GRAHA IN('N') and LG.no_spk is null and R.JNS_KEGIATAN IN('1') AND R.STATUS in ('DONE') AND YEAR(R.TGL_DOK) >= 2020 ORDER BY R.ID DESC LIMIT 1";


        $nospk='';
        $nocont='';
        $jnsdok='';
        $nodok='';
        $tgldok='';
        $hasil_query =$this->db->query($SQL);

        if ($hasil_query->num_rows() > 0) {
            foreach ($hasil_query->result() as $key => $value) {
              $nospk = $value->NO_SPK;
              $nocont = $value->CONT_ID;
              $jnsdok = $value->JENIS_DOKUMEN;
              $nodok = $value->NO_DOKUMEN;
              $NO_SPK = $value->NO_SPK;
              $CONT_ID = $value->CONT_ID;
              $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
              $NO_DOKUMEN = $value->NO_DOKUMEN;
              $DOKUMEN_DATE = $value->DOKUMEN_DATE;
              $BEHANDLE1 = $value->BEHANDLE1;
              $ID_INSPECTION = $value->ID_INSPECTION;
              $NO_CONT = $value->CONT_ID;
              $tgldok1 = $value->DOKUMEN_DATE;
              $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));


          $postData = array (
                  'NO_SPK' => $NO_SPK,
                  'CONT_ID' => $CONT_ID,
                  'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
                  'NO_DOKUMEN' => $NO_DOKUMEN,
                  'DOKUMEN_DATE' => $DOKUMEN_DATE,
                  'BEHANDLE1' => $BEHANDLE1
          );
          $data = http_build_query($postData, '', '&');
          
        
          $alamat .= $data;

          //echo urldecode($alamat); die();

          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => "$alamat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA=="
            ),
          ));
          
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
              }else{
                echo "Connection Failed =".curl_error($curl);
            }
            curl_close($curl);
            //echo $response; die();

            $baris = json_decode($response);
            foreach($baris as $key=>$value){
                //$response = str_replace($value, '', $response);
                $NO_SPK = $value->NO_SPK;
                $CONT_ID = $value->CONT_ID;
                $NO_DOKUMEN = $value->NO_DOKUMEN;
                $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
                $DOKUMEN_DATE1 = $value->DOKUMEN_DATE;
                $DOKUMEN_DATE = Date('Y-m-d', strtotime(str_replace("/","-",($DOKUMEN_DATE1))));
                $START_BEHANDLE3 = $value->START_BEHANDLE1;
                $START_BEHANDLE1 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($START_BEHANDLE3))));
                $END_BEHANDLE3 = $value->END_BEHANDLE1;
                $END_BEHANDLE1 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($END_BEHANDLE3))));
                $NO_SEGEL_BEHANDLE1 = $value->NO_SEGEL_BEHANDLE1;

            }

            //$response = $string = preg_replace('/\s+/', '', $response);
            $resp = $response;

            $json = json_encode($response);
            if (preg_match("/true/i", $json )) {
                if($resp != ""){
                $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','1')");
                echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

                if($NO_SEGEL_BEHANDLE1 != ""){
                $SQL = "UPDATE t_op_inspection SET NO_SEAL = '".$NO_SEGEL_BEHANDLE1."', START_INSP='".$START_BEHANDLE1."', FINISH_INSP='".$END_BEHANDLE1."', FL_GRAHA ='Y' WHERE ID = '".$ID_INSPECTION."'  and NO_CONT = '".$CONT_ID."' and NO_DOK = '".$NO_DOKUMEN."' and TGL_DOK = '".$DOKUMEN_DATE."' AND JNS_KEGIATAN ='1'";
                echo $SQL." --- Update Success --- "."\r\n\r\n";
                $this->db->query($SQL);
                echo "----------------------------------------------------------"."\r\n";
                } else {
                    echo " --Tidak Ada-- \r\n";
                }
            }else if(preg_match("/false/i", $json)){
                
                echo $json;
                echo "<xmp><br>----------------------</xmp>"."\r\n";
                
                // // $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','1')");
                // // echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
                   
                    
                // if($NO_CONT != ""){
                //    $SQL = "UPDATE t_op_inspection SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_INSPECTION."' AND NO_CONT= '".$NO_CONT."' AND JNS_KEGIATAN ='1' ";
                //    echo $SQL." --- Update Success ---"."\r\n\r\n";
                //    $this->db->query($SQL);
                // } else {
                //    echo " --Tidak Ada-- \r\n";
                // } 
                  
            }
          }
        }  else {
            echo "Tidak Ada \r\n";
        }   
    }

    public function get_graha_dataSeal2()
    {
      
        $method = 'get_graha_dataSeal2';
        // $alamat = 'http://103.130.242.88/service_kalibaru/api/Graha?';
        $alamat = 'http://103.130.242.82/service_kalibaru/api/Graha?';

        $SQL1 = "SELECT distinct R.NO_SPK, R.NO_CONT as 'CONT_ID', G.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') as 'DOKUMEN_DATE',R.JNS_KEGIATAN AS 'BEHANDLE2', R.ID as 'ID_INSPECTION', R.FL_GRAHA
        FROM t_op_inspection as R
        inner join t_gatepass as G on G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK
        left join (select B.NO_CONT, A.NO_DOK_INOUT, A.TGL_DOK_INOUT, A.LNSW_KD_RESPON from t_permit_hdr as A  join t_permit_cont as B on A.ID = B.ID where A.LNSW_KD_RESPON is null ) K on K.NO_CONT = R.NO_CONT and K.NO_DOK_INOUT = R.NO_DOK and K.TGL_DOK_INOUT = R.TGL_DOK 
        left join (select C.NO_CONT, D.NO_RESPON, D.TG_RESPON, D.LNSW_KD_RESPON from t_ppk_hdr as D inner join t_ppk_cont as C on D.ID_IJIN = C.ID_IJIN where D.LNSW_KD_RESPON is null ) N on N.NO_CONT = R.NO_CONT and N.NO_RESPON = R.NO_DOK and N.TG_RESPON = R.TGL_DOK 
        LEFT JOIN log_graha_getseal as LG ON LG.no_cont = R.NO_CONT AND LG.no_dok = R.NO_DOK AND LG.tgl_dok = R.TGL_DOK  and LG.jns_kegiatan = R.JNS_KEGIATAN 
        WHERE DATE(R.WK_REK ) >= DATE_ADD(NOW(), interval - 43 day) AND R.FL_GRAHA IN('N')  and LG.no_spk is null  AND R.JNS_KEGIATAN IN('2') AND R.STATUS in ('DONE') AND YEAR(R.TGL_DOK) >= 2020 ORDER BY R.ID desc LIMIT 1";


        $SQL2 = "SELECT R.NO_SPK, R.NO_CONT as 'CONT_ID', G.JNS_DOK as 'JENIS_DOKUMEN', R.NO_DOK as 'NO_DOKUMEN', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') as 'DOKUMEN_DATE',R.JNS_KEGIATAN AS 'BEHANDLE2', R.ID as 'ID_INSPECTION'
        FROM t_op_inspection as R
        inner join (select B.NO_CONT, A.NO_DOK_INOUT, A.TGL_DOK_INOUT, A.LNSW_KD_RESPON from t_permit_hdr as A  join t_permit_cont as B on A.ID = B.ID where A.LNSW_KD_RESPON in ('005')) K on K.NO_CONT = R.NO_CONT and K.NO_DOK_INOUT = R.NO_DOK and K.TGL_DOK_INOUT = R.TGL_DOK 
        inner join t_gatepass as G on G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK
        LEFT JOIN log_graha_getseal as LG ON LG.no_cont = R.NO_CONT AND LG.no_dok = R.NO_DOK AND LG.tgl_dok = R.TGL_DOK
        WHERE DATE(R.WK_REK ) >= DATE_ADD(NOW(), interval - 43 day) AND R.FL_GRAHA IN('N')  and LG.no_spk is null  AND R.JNS_KEGIATAN IN('2') AND R.STATUS in ('DONE') AND YEAR(R.TGL_DOK) >= 2020 ORDER BY R.ID DESC LIMIT 1";


        $nospk='';
        $nocont='';
        $jnsdok='';
        $nodok='';
        $tgldok='';

        $hasil_query1 =$this->db->query($SQL1);
        $hasil_query2 =$this->db->query($SQL2);

          if ($hasil_query2->num_rows() > 0) {
          foreach ($hasil_query2->result() as $key => $value1) {
            $nospk = $value1->NO_SPK;
            $nocont = $value1->CONT_ID;
            $jnsdok = $value1->JENIS_DOKUMEN;
            $nodok = $value1->NO_DOKUMEN;
            $tgldok1 = $value1->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value1->NO_SPK;
            $CONT_ID = $value1->CONT_ID;
            $NO_DOKUMEN = $value1->NO_DOKUMEN;
            $DOKUMEN_DATE = $value1->DOKUMEN_DATE;
            $BEHANDLE2 = $value1->BEHANDLE2;
            $ID_INSPECTION = $value1->ID_INSPECTION;
            $NO_CONT = $value1->CONT_ID;

        $postData = array (
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'NO_DOKUMEN' => $NO_DOKUMEN,
                'DOKUMEN_DATE' => $DOKUMEN_DATE,
                'BEHANDLE2' => $BEHANDLE2,
                'JI' => 'Y'
        );
        $data = http_build_query($postData, '', '&');
        
        $alamat .= $data;

       // echo urldecode($alamat); die();

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "$alamat",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA=="
          ),
        ));
        
          $response = curl_exec($curl);
          if (!curl_errno($curl)) {
              $info = curl_getinfo($curl);
              echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            }else{
              echo "Connection Failed =".curl_error($curl);
          }
          curl_close($curl);
          //echo $response; die();

          $baris = json_decode($response);

          foreach($baris as $key=>$value1){
             
              $NO_SPK = $value1->NO_SPK;
              $CONT_ID = $value1->CONT_ID;
              $NO_SPJM_JI = $value1->NO_SPJM_JI;
              $TGL_SPJM_JI1 = $value1->TGL_SPJM_JI;
              $TGL_SPJM_JI = Date('Y-m-d', strtotime(str_replace("/","-",($TGL_SPJM_JI1))));
              $CONT_ID = $value1->CONT_ID;
              $START_BEHANDLE4 = $value1->START_BEHANDLE2;
              $START_BEHANDLE2 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($START_BEHANDLE4))));
              $END_BEHANDLE4 = $value1->END_BEHANDLE2;
              $END_BEHANDLE2 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($END_BEHANDLE4))));
              $NO_SEGEL_BEHANDLE2 = $value1->NO_SEGEL_BEHANDLE2;
          }

          //$response = $string = preg_replace('/\s+/', '', $response);
          $resp = $response;

          $json = json_encode($response);
          if (preg_match("/true/i", $json)) {
              if($resp != ""){
              $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','2')");
              echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
              } else {
                echo " --Tidak Ada-- \r\n";
              }

              if($NO_SEGEL_BEHANDLE2 != ""){
              $SQL1= "UPDATE t_op_inspection SET NO_SEAL = '".$NO_SEGEL_BEHANDLE2."', START_INSP='".$START_BEHANDLE2."', FINISH_INSP='".$END_BEHANDLE2."', FL_GRAHA ='Y' WHERE ID = '".$ID_INSPECTION."' and NO_SPK = '".$NO_SPK."' and NO_CONT = '".$CONT_ID."' and NO_DOK = '".$NO_SPJM_JI."' and TGL_DOK = '".$TGL_SPJM_JI."' AND JNS_KEGIATAN ='2'";
              echo $SQL1." --- Update Success --- "."\r\n\r\n";
              $this->db->query($SQL1);
              }else {
                  echo " --Tidak Ada-- \r\n";
              }
          }else if(preg_match("/false/i", $json)){
            
              echo $json;;
              /*
              $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','2')");
              echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
                  
              if($NO_CONT != ""){
                 $SQL = "UPDATE t_op_inspection SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_INSPECTION."' AND NO_CONT= '".$NO_CONT."' AND JNS_KEGIATAN ='2' ";
                 echo $SQL." --- Update Success ---"."\r\n\r\n";
                 $this->db->query($SQL);
              } else {
                 echo " --Tidak Ada-- \r\n";
              } 
              */
          }
        }
      } else if ($hasil_query1->num_rows() > 0) {
        foreach ($hasil_query1->result() as $key => $value) {
          $nospk = $value->NO_SPK;
          $nocont = $value->CONT_ID;
          $jnsdok = $value->JENIS_DOKUMEN;
          $nodok = $value->NO_DOKUMEN;
          $tgldok1 = $value->DOKUMEN_DATE;
          $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
          $NO_SPK = $value->NO_SPK;
          $CONT_ID = $value->CONT_ID;
          $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
          $NO_DOKUMEN = $value->NO_DOKUMEN;
          $DOKUMEN_DATE = $value->DOKUMEN_DATE;
          $BEHANDLE2 = $value->BEHANDLE2;
          $ID_INSPECTION = $value->ID_INSPECTION;
          $NO_CONT = $value->CONT_ID;

      $postData = array (
              'NO_SPK' => $NO_SPK,
              'CONT_ID' => $CONT_ID,
              'JENIS_DOKUMEN' => $JENIS_DOKUMEN,
              'NO_DOKUMEN' => $NO_DOKUMEN,
              'DOKUMEN_DATE' => $DOKUMEN_DATE,
              'BEHANDLE2' => $BEHANDLE2
      );
      $data = http_build_query($postData, '', '&');
      
      $alamat .= $data;

     // echo urldecode($alamat); die();

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "$alamat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA=="
        ),
      ));
      
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
          }else{
            echo "Connection Failed =".curl_error($curl);
        }
        curl_close($curl);
        //echo $response; die();

        $baris = json_decode($response);

        foreach($baris as $key=>$value1){
           
            $NO_SPK = $value1->NO_SPK;
            $CONT_ID = $value1->CONT_ID;
            $NO_DOKUMEN = $value1->NO_DOKUMEN;
            $JENIS_DOKUMEN = $value1->JENIS_DOKUMEN;
            $DOKUMEN_DATE1 = $value1->DOKUMEN_DATE;
            $DOKUMEN_DATE = Date('Y-m-d', strtotime(str_replace("/","-",($DOKUMEN_DATE1))));
            $CONT_ID = $value1->CONT_ID;
            $START_BEHANDLE4 = $value1->START_BEHANDLE2;
            $START_BEHANDLE2 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($START_BEHANDLE4))));
            $END_BEHANDLE4 = $value1->END_BEHANDLE2;
            $END_BEHANDLE2 = Date('Y-m-d H:i:s', strtotime(str_replace("/","-",($END_BEHANDLE4))));
            $NO_SEGEL_BEHANDLE2 = $value1->NO_SEGEL_BEHANDLE2;
        }

        //$response = $string = preg_replace('/\s+/', '', $response);
        $resp = $response;

        $json = json_encode($response);
        if (preg_match("/true/i", $json)) {
            if($resp != ""){
            $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','2')");
            echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
            } else {
              echo " --Tidak Ada-- \r\n";
            }

            if($NO_SEGEL_BEHANDLE2 != ""){
            $SQL1= "UPDATE t_op_inspection SET NO_SEAL = '".$NO_SEGEL_BEHANDLE2."', START_INSP='".$START_BEHANDLE2."', FINISH_INSP='".$END_BEHANDLE2."', FL_GRAHA ='Y' WHERE ID = '".$ID_INSPECTION."' and NO_SPK = '".$NO_SPK."' and NO_CONT = '".$CONT_ID."' and NO_DOK = '".$NO_DOKUMEN."' and TGL_DOK = '".$DOKUMEN_DATE."' AND JNS_KEGIATAN ='2'";
            echo $SQL1." --- Update Success --- "."\r\n\r\n";
            $this->db->query($SQL1);
            }else {
                echo " --Tidak Ada-- \r\n";
            }
        }else if(preg_match("/false/i", $json)){
          
            echo $json;
            /*
            $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_getseal` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$alamat', '$resp','2')");
            echo $nospk." = Succes , Data tersimpan di Tabel Log Graha Get Seal \r\n";
                
            if($NO_CONT != ""){
               $SQL = "UPDATE t_op_inspection SET FL_GRAHA  = 'Y' WHERE ID= '".$ID_INSPECTION."' AND NO_CONT= '".$NO_CONT."' AND JNS_KEGIATAN ='2' ";
               echo $SQL." --- Update Success ---"."\r\n\r\n";
               $this->db->query($SQL);
            } else {
               echo " --Tidak Ada-- \r\n";
            } 
            */
        }
      }
      } else {
              echo "Tidak Ada \r\n";
      }   
    }

    public function update_graha_aju()
    {
  
        $method = 'update_graha_aju';

        $SQL = " SELECT R.NO_SPK, R.NO_CONT as 'CONT_ID',  K.NO_AJU as DOKUMEN_JI, DATE_FORMAT(K.LNSW_TGLAJU,'%d/%m/%Y') as TGL_DOKUMEN_JI, R.NO_DOK as 'NO_SPJM', DATE_FORMAT(R.TGL_DOK,'%d/%m/%Y') as 'TGL_SPJM',R.JNS_KEGIATAN AS 'BEHANDLE2', R.ID as 'ID_INSPECTION', R.FL_GRAHA 
        FROM t_op_inspection as R
        inner join (select B.NO_CONT, A.NO_DOK_INOUT, A.TGL_DOK_INOUT, A.LNSW_KD_RESPON, A.CAR as NO_AJU, A.LNSW_TGLAJU from t_permit_hdr as A  join t_permit_cont as B on A.ID = B.ID where A.LNSW_KD_RESPON in ('005')) K on K.NO_CONT = R.NO_CONT and K.NO_DOK_INOUT = R.NO_DOK and K.TGL_DOK_INOUT = R.TGL_DOK 
        inner join t_gatepass as G on G.NO_CONT = R.NO_CONT and G.NO_DOK = R.NO_DOK and G.TGL_DOK = R.TGL_DOK 
        LEFT JOIN log_graha_getseal as LG ON LG.no_cont = R.NO_CONT AND LG.no_dok = R.NO_DOK AND LG.tgl_dok = R.TGL_DOK
        WHERE DATE(R.WK_REK ) >= DATE_ADD(NOW(), interval - 63 day) AND R.FL_GRAHA IN('N')  and LG.no_spk is null  AND R.JNS_KEGIATAN IN('2') AND R.STATUS in ('DONE') AND YEAR(R.TGL_DOK) >= 2020 ORDER BY R.ID desc";

        $nospk ='';
        $nocont ='';
        $jnsdok ='';
        $nodok = '';
        $tgldok ='';
        $noaju ='';
        
        $hasil_query =$this->db->query($SQL);
        
        if ($hasil_query->num_rows() > 0) {
          foreach ($hasil_query->result() as $key => $value) {
            $nospk = $value->NO_SPK;
            $nocont = $value->CONT_ID;
            $noaju = $value->DOKUMEN_JI;
            $jnsdok = $value->JENIS_DOKUMEN;
            $nodok = $value->NO_DOKUMEN;
            $tgldok1 = $value->DOKUMEN_DATE;
            $tgldok = Date('Y-m-d', strtotime(str_replace("/","-",($tgldok1))));
            $NO_SPK = $value->NO_SPK;
            $CONT_ID = $value->CONT_ID;
            $DOKUMEN_JI = $value->DOKUMEN_JI;
            $TGL_DOKUMEN_JI = $value->TGL_DOKUMEN_JI;
            $JENIS_DOKUMEN = $value->JENIS_DOKUMEN;
            $NO_SPJM = $value->NO_SPJM;
            $TGL_SPJM = $value->TGL_SPJM;
            $GATEPASS_BHD3 = $value->GATEPASS_BHD3;
            $NO_CONT = $value->CONT_ID;
            $ID_GATE_PASS = $value->ID_GATE_PASS;


        $postData = array (
                
                'NO_SPK' => $NO_SPK,
                'CONT_ID' => $CONT_ID,
                'DOKUMEN_JI' => $DOKUMEN_JI,
                'TGL_DOKUMEN_JI' => $TGL_DOKUMEN_JI,
                'NO_SPJM' => $NO_SPJM,
                'TGL_SPJM' => $TGL_SPJM,
        );
        $data = http_build_query($postData);
        //var_dump ($data); die();
       //echo $data; die();
  
              $curl = curl_init();
              curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://103.130.242.88/service_kalibaru/api/MTI",
              CURLOPT_URL => "http://103.130.242.82/service_kalibaru/api/MTI",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS => $data,
              CURLOPT_HTTPHEADER => array(
                  "Authorization: Basic TVRJOkdSQUhBTVRJMjAyMA==",
                  "Content-Type: application/x-www-form-urlencoded"
              ),
          ));

              $response = curl_exec($curl);
              if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , ", $info['total_time'] , " This is Url : ", $info['url'], "\r\n";
              } else {
                echo "Connection Failed =".curl_error($curl);
              }
              curl_close($curl);
              //$response = $string = preg_replace('/\s+/', '', $response);
              $resp = $response;
             
              $json = json_encode($response);
            if (preg_match("/true/i", $json)) {
                if($resp != ""){
                // $this->db->query("INSERT INTO `tpk_ipc`.`log_graha_gatepass3` (`no_spk`,`no_cont`, `jns_dok`, `no_dok`, `tgl_dok`, `raw_data`, `respon_data`,`jns_kegiatan`) VALUES ('$nospk','$nocont','$jnsdok','$nodok', '$tgldok', '$data', '$resp', '3')");
                echo $noaju." = Succes Dokumen Aju , Data terkirim \r\n";
                } else {
                  echo " --Tidak Ada-- \r\n";
                }

            } else {
                echo $json;
               
            }
          }
        } else {
            echo "Tidak Ada \r\n";
        }   
    }

}

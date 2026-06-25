<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ServicePercepatan extends CI_Controller {
    public $content;
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        $this->load->model("m_service_materai");
        $header_nota = $this->m_service_materai->setting_point();
        $data_nota['maindata'] = $this->m_service_materai->monitoring_all_nota();
        $data_nota['faildata'] = $this->m_service_materai->failed_nota();

        $data = $this->load->view('content/monitoring/service_materai', $data_nota);
        echo $data;
    }

    //Service 1
    public function trackingbehandle(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/xml');
        $input = file_get_contents('php://input');

        $xml = simplexml_load_string($input);
        $access_key = $xml->header->key;
        if($access_key != 'a92221edd3d41141160e1e274902728d'){
            echo '<respon>
                    <status>NOK</status>
                    <msg>INVALID KEY</msg>
                </respon>'; die();
        }


        $json = json_encode($xml);
        $array = json_decode($json,false);

        $container = $array->container;
        $voyage = $array->voyage;
        $vessel = $array->vessel;

        //cek dok utama

        $sql = "SELECT trc.NO_CONT, trc.UKR_CONT, trc.VOY_IN, trc.VOY_OUT, trc.VESSEL, trc.REF_NUMBER, trc.CALL_SIGN,
        concat(tsc.LOKASI, '-', tsc.TIER) as 'LOKASI', 
        tr.NO_DOK, tr.JNS_DOK, tr.TGL_DOK,
        tph.LNSW_KD_RESPON as 'SPJM_JOIN', tph2.LNSW_KD_RESPON as 'SPPMP_JOIN',
        ts.NO_SPK,
        DATE_FORMAT(tob.W_BEHANDLE, '%Y%m%d%H%i%s') as 'WK_BEHANDLE',
        DATE_FORMAT(tod.WK_GATEOUT, '%Y%m%d%H%i%s') as 'WK_GATEOUT'
        from t_request_cont trc join t_request tr on trc.ID = tr.ID
        left join t_permit_hdr tph on tr.NO_DOK = tph.NO_DOK_INOUT and tr.TGL_DOK = tph.TGL_DOK_INOUT
        left join t_ppk_hdr tph2 on tr.NO_DOK = tph2.NO_RESPON 
        join t_spk ts on tr.NO_DOK = ts.NO_DOK and ts.TGL_DOK = tr.TGL_DOK
        join t_spk_cont tsc on ts.ID = tsc.ID 
        left join t_op_behandlein tob on tob.NO_SPK = ts.NO_SPK and tob.NO_CONT = trc.NO_CONT
        left join t_op_delivery tod on ts.NO_SPK = tod.NO_SPK and trc.NO_CONT = tod.NO_CONT
        where trc.NO_CONT = '$container' and trc.VESSEL like '%$vessel%' and VOY_IN like '%$voyage%' and trc.KD_STATUS = 'INQUIRY' limit 1";

        $Query =$this->db->query($sql);
        $result = $Query->result();

        if ($result[0]->SPJM_JOIN == '005' || $result[0]->SPPMP_JOIN == '005') {
            $FL_JOIN = 'Y';
        } else {
            $FL_JOIN = 'N';
        }
        // header xml ==========================================================================================================================================
        $xmlhasil = '<response>
                    <containers>';

        //tambah hasil header ==========================================================================================================================================
        $xmlhasil .= '<reff_number>'.$result[0]->REF_NUMBER.'</reff_number>
                    <vessel_name>'.$result[0]->VESSEL.'</vessel_name>
                    <call_sign>'.$result[0]->CALL_SIGN.'</call_sign>
                    <voyage_in>'.$result[0]->VOY_IN.'</voyage_in>
                    <voyage_out>'.$result[0]->VOY_OUT.'</voyage_out>
                    <cont_no>'.$result[0]->NO_CONT.'</cont_no>
                    <location>'.$result[0]->LOKASI.'</location>
                    <join_inspection>'.$FL_JOIN.'</join_inspection>';

        // Dokumen Pemeriksaan ==========================================================================================================================================
        // behandle 1, buat request ppk sama respon ppk
        $SQLPENARIKAN1 = "SELECT trc.NO_CONT, trc.UKR_CONT, trc.VOY_IN, trc.VOY_OUT, trc.VESSEL, trc.REF_NUMBER
        ,rkdb.KODE_NPCT1, tg1.NO_DOK, date_format(tg1.TGL_DOK, '%Y%m%d') as TG,
        date_format(tg1.WK_REK, '%Y%m%d%H%i%s') as 'WK_REQ',
        date_format(tg1.WK_RESPON, '%Y%m%d%H%i%s') as 'WK_RESPON',
        date_format(tjs.WK_STATUS, '%Y%m%d%H%i%s') as 'PLANNING_INSPECTION',
        date_format(toi.START_INSP, '%Y%m%d%H%i%s') as 'START_INSPECTION',
        date_format(toi.FINISH_INSP, '%Y%m%d%H%i%s') as 'END_INSPECTION',
        date_format(tjs1.WK_STATUS, '%Y%m%d%H%i%s') as 'EX_BEHANDLE',
        REPLACE(REPLACE(tg1.NPWP ,'-','') ,'.','') as 'NPWP'
        from t_request_cont trc join t_request tr on trc.ID = tr.ID
        join t_gatepass tg1 on trc.NO_CONT = tg1.NO_CONT and tg1.NO_DOK = tr.NO_DOK
        join reff_kode_dok_bc rkdb on rkdb.NAMA = tg1.JNS_DOK
        left join t_job_slip tjs on tjs.NO_CONT = tg1.NO_CONT and tjs.NO_DOK = tg1.NO_DOK and tjs.JENIS = 'BEHANDLE 1'
        left join t_job_slip tjs1 on tjs.NO_CONT = tg1.NO_CONT and tjs1.NO_DOK = tg1.NO_DOK and tjs1.JENIS = 'EX BEHANDLE 1'
        left join t_op_inspection toi on tg1.NO_DOK = toi.NO_DOK and tg1.NO_CONT = toi.NO_CONT
        where trc.NO_CONT = '$container' and trc.VESSEL like '%$vessel%' and VOY_IN like '%$voyage%' and trc.KD_STATUS = 'INQUIRY' limit 1";

        $QueryPenarikan =$this->db->query($SQLPENARIKAN1);
        $resultpenarikan = $QueryPenarikan->result();
        $xmlhasil .= '<in_behandle>';
        $xmlhasil .= '<loop>
                        <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                        <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                        <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                    </loop>';

        // behandle 2    
        $SQLPENARIKAN2 = "SELECT trc.NO_CONT, trc.UKR_CONT, trc.VOY_IN, trc.VOY_OUT, trc.VESSEL, trc.REF_NUMBER
                    ,rkdb.KODE_NPCT1, tg1.NO_DOK, date_format(tg1.TGL_DOK, '%Y%m%d') as TG,
                    date_format(tg1.WK_REK, '%Y%m%d%H%i%s') as 'WK_REQ',
                    date_format(tg1.WK_RESPON, '%Y%m%d%H%i%s') as 'WK_RESPON',
                    date_format(tjs.WK_STATUS , '%Y%m%d%H%i%s') as 'PLANNING_INSPECTION_2',
                    date_format(toi.START_INSP, '%Y%m%d%H%i%s') as 'START_INSPECTION',
                    date_format(toi.FINISH_INSP, '%Y%m%d%H%i%s') as 'END_INSPECTION',
                    date_format(tjs1.WK_STATUS, '%Y%m%d%H%i%s') as 'EX_BEHANDLE'
                    from t_request_cont trc join t_request tr on trc.ID = tr.ID
                    join t_gatepass tg1 on trc.NO_CONT = tg1.NO_CONT
                    join reff_kode_dok_bc rkdb on rkdb.NAMA = tg1.JNS_DOK
                    left join t_job_slip tjs on tjs.NO_CONT = tg1.NO_CONT and tjs.NO_DOK = tg1.NO_DOK and tjs.JENIS = 'BEHANDLE 2'
                    left join t_job_slip tjs1 on tjs.NO_CONT = tg1.NO_CONT and tjs1.NO_DOK = tg1.NO_DOK and tjs1.JENIS = 'EX BEHANDLE 2'
                    left join t_op_inspection toi on tg1.NO_DOK = toi.NO_DOK and tg1.NO_CONT = toi.NO_CONT
                    where trc.NO_CONT = '$container' and trc.VESSEL like '%$vessel%' and VOY_IN like '%$voyage%' and trc.KD_STATUS = 'INQUIRY' and tg1.JNS_KEGIATAN = 2
                    limit 1";
            
        $QueryPenarikan2 =$this->db->query($SQLPENARIKAN2);
        $resultpenarikan2 = $QueryPenarikan2->result();
        
        if ($resultpenarikan2[0] !== null ) {
        $xmlhasil .= '
        <loop>
            <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
            <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
            <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
        </loop>';
        }

        $xmlhasil .= '
        <action_time>'.$result[0]->WK_BEHANDLE.'</action_time>
        </in_behandle>';
        // in behandle done ===================================================================================================================================
        // stacking_yard_before ===============================================================================================================================
        $xmlhasil .= '<stacking_yard_before>
                        <loop>
                            <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                        </loop>
                        <action_time>'.$result[0]->WK_BEHANDLE.'</action_time>
                    </stacking_yard_before>';


        // stacking_yard_before DONE ===========================================================================================================================
        // request ppk ==========================================================================================================================================
        // ambil datanya dari gatepass 1
        $xmlhasil .= '<request_ppk>
                        <loop>
                            <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan[0]->WK_REQ.'</action_time>
                        </loop>';
        if ($resultpenarikan2[0] !== null ) {
                            $xmlhasil .= '
                        <loop>
                            <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan2[0]->WK_REQ.'</action_time>
                        </loop>';}    
        $xmlhasil .='</request_ppk>';
        // request ppk done ====================================================================================================================================
        // respon ppk ==========================================================================================================================================
        $xmlhasil .= '<response_ppk>
                        <loop>
                            <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan[0]->WK_RESPON.'</action_time>
                        </loop>';
        if ($resultpenarikan2[0] !== null ) {
                            $xmlhasil .= '
                        <loop>
                            <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan2[0]->WK_RESPON.'</action_time>
                        </loop>';}  
        $xmlhasil .= '</response_ppk>';
        // respon ppk done ==========================================================================================================================================
        // PLANNING INSPECTION ======================================================================================================================================
        $xmlhasil .= '<planning_inspection>
                        <loop>
                            <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan[0]->PLANNING_INSPECTION.'</action_time>
                        </loop>';
            // JIKA BEHANDLE 2 TIDAK KOSONG
                        if ($resultpenarikan2[0] !== null ) {
                            $xmlhasil .= '
                            <loop>
                                <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                                <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                                <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                                <action_time>'.$resultpenarikan2[0]->PLANNING_INSPECTION_2.'</action_time>
                            </loop>';
                            }
                        // kelar  
                        $xmlhasil .='
                    </planning_inspection>';
        // PLANNING INSPECTION done ==================================================================================================================================
        // START INSPECTION ==========================================================================================================================================
        $xmlhasil .= '<start_inspection>
                        <loop>
                            <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan[0]->START_INSPECTION.'</action_time>
                        </loop>';
        if ($resultpenarikan2[0] !== null ) {
                            $xmlhasil .= '
                        <loop>
                            <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                            <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                            <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                            <action_time>'.$resultpenarikan2[0]->START_INSPECTION.'</action_time>
                        </loop>';}  
        $xmlhasil .= '</start_inspection>';
        // START INSPECTION done ===================================================================================================================================
        // END INSPECTION ==========================================================================================================================================
        $xmlhasil .= '<end_inspection>
                <loop>
                    <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan[0]->END_INSPECTION.'</action_time>
                </loop>';
        if ($resultpenarikan2[0] !== null ) {
        $xmlhasil .= '
                <loop>
                    <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan2[0]->END_INSPECTION.'</action_time>
                </loop>';}  
        $xmlhasil .= '</end_inspection>';
        // END INSPECTION done =====================================================================================================================================
        // END INSPECTION ==========================================================================================================================================
                $xmlhasil .= '<end_inspection>
                <loop>
                    <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan[0]->END_INSPECTION.'</action_time>
                </loop>';
        if ($resultpenarikan2[0] !== null ) {
        $xmlhasil .= '
                <loop>
                    <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan2[0]->END_INSPECTION.'</action_time>
                </loop>';}  
        $xmlhasil .= '</end_inspection>';
        // END INSPECTION done =====================================================================================================================================
        // END INSPECTION ==========================================================================================================================================
                $xmlhasil .= '<end_inspection>
                <loop>
                    <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan[0]->END_INSPECTION.'</action_time>
                </loop>';
        if ($resultpenarikan2[0] !== null ) {
        $xmlhasil .= '
                <loop>
                    <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan2[0]->END_INSPECTION.'</action_time>
                </loop>';}  
        $xmlhasil .= '</end_inspection>';
        // END INSPECTION done ==========================================================================================================================================
        // STACKING YARD AFTER ==========================================================================================================================================
        $xmlhasil .= '<stacking_yard_after>
                <loop>
                    <document_code>'.$resultpenarikan[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan[0]->EX_BEHANDLE.'</action_time>
                </loop>';
        if ($resultpenarikan2[0] !== null ) {
        $xmlhasil .= '
                <loop>
                    <document_code>'.$resultpenarikan2[0]->KODE_NPCT1.'</document_code>
                    <document_no>'.$resultpenarikan2[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultpenarikan2[0]->TG.'</document_date>
                    <action_time>'.$resultpenarikan2[0]->EX_BEHANDLE.'</action_time>
                </loop>';}  
        $xmlhasil .= '</stacking_yard_after>';
        // STACKING YARD AFTER done ==========================================================================================================================
        // gatepass ==========================================================================================================================================
        $npwp = $resultpenarikan[0]->NPWP;
        $container = $result[0]->NO_CONT;

        // delivery
        $sqlg3 = "SELECT JNS_DOK, NO_DOK, NO_CONT, date_format(TGL_DOK, '%Y%m%d') as 'TG_DOK', date_format(wk_rek, '%Y%m%d%H%i%s') as 'TIME'
                from t_gatepass where NPWP = '$npwp' and NO_CONT = '$container'";

        $Queryg3 =$this->db->query($sqlg3);
        $resultg3 = $Queryg3->result();
        $xmlhasil .= '<gatepass>
                <loop>
                    <document_code>'.$resultg3[0]->JNS_DOK.'</document_code>
                    <document_no>'.$resultg3[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultg3[0]->TG_DOK.'</document_date>
                    <action_time>'.$resultg3[0]->TIME.'</action_time>
                </loop>';
        $xmlhasil .= '</gatepass>';
        // gatepass done ======================================================================================================================================
        // out delivery ==========================================================================================================================================
        $spk = $result[0]->NO_SPKs;
        $container = $result[0]->NO_CONT;

        // delivery
        $xmlhasil .= '<out_behandle>
                <loop>
                    <document_code>'.$resultg3[0]->JNS_DOK.'</document_code>
                    <document_no>'.$resultg3[0]->NO_DOK.'</document_no>
                    <document_date>'.$resultg3[0]->TG_DOK.'</document_date>
                    <action_time>'.$result[0]->WK_GATEOUT.'</action_time>
                </loop>';
        $xmlhasil .= '</out_behandle>';
        // out delivery done ======================================================================================================================================

        //tutup xml ==========================================================================================================================================
        $xmlhasil .= '</containers>
                    </response>';
        echo $xmlhasil;
    }

    // Service 2 Pembuat Service Tracking Behandle Data (Get)
    public function gatepassrekon(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/xml');
        $input = file_get_contents('php://input');

        $xml = simplexml_load_string($input);
        $access_key = $xml->header->key;

        $keysec = json_encode($xml->header->key);
        $request = json_encode($xml->containers);

        if($access_key != 'a92221edd3d41141160e1e274902728d'){
            echo '<respon>
                    <status>NOK</status>
                    <msg>INVALID KEY</msg>
                </respon>'; die();
        }
        $SQL = "INSERT INTO t_log_auto_gatepass (XML_RECEIVED)
        VALUES ('$request');";
        $Query =$this->db->query($SQL);
        $hasil = $this->db->affected_rows();

        if ($hasil == '1'){
            echo '<respon>
            <status>OK</status>
            <msg>SUKSES SIMPAN DATA</msg>
        </respon>';
        } else {
            echo '<respon>
            <status>NOK</status>
            <msg>GAGAL SIMPAN DATA</msg>
        </respon>';
        }
    }

    // Reconsile Container SSM (Get)
    public function rekon_dokumen(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/xml');
        $input = file_get_contents('php://input');

        $xml = simplexml_load_string($input);
        $access_key = $xml->header->key;
        if($access_key != 'a92221edd3d41141160e1e274902728d'){
            echo '<respon>
                    <status>NOK</status>
                    <msg>INVALID KEY</msg>
                </respon>'; die();
        }

        $json = json_encode($xml->containers);
        $allResponse = json_encode($xml);

        $SQL = "INSERT INTO t_log_rekon_dokumen (XML_RECEIVED, RAW_XML)
        VALUES ('$json', '$allResponse');";
        $Query =$this->db->query($SQL);
        $hasil = $this->db->affected_rows();

        if ($hasil == '1'){
            echo '<respon>
            <status>OK</status>
            <msg>SUKSES SIMPAN DATA</msg>
        </respon>';
        } else {
            echo '<respon>
            <status>NOK</status>
            <msg>GAGAL SIMPAN DATA</msg>
        </respon>';
        }
    }

    //========================================================================================================================================================================//
    //PROSES DATA KIRIMAN DARI NPCT1
    // public function rekon_gatepass(){
    //     $Q = $this->db->query("SELECT * FROM t_log_auto_gatepass WHERE FL_PROSES = 'N' limit 50");
    //     if(empty($Q->result())){
    //         echo "NO DATA TO PROCESS"."\r\n";
    //     } else {
    //         foreach ($Q->result() as $key => $value1) {
    //             echo "******************************************************************************************"."\r\n";
    //             $id_transaksi = $xmlditerima = $value1->ID;
    //             $xmlditerima = $value1->XML_RECEIVED;
    //             // PROSES XML YANG SUDAH JADI JSON==================================//
    //             $encodeddata = json_decode($xmlditerima);
    //             $cont_no = $encodeddata->cont_no;
    //             $isocode = $encodeddata->isocode;
    //             $weight = $encodeddata->weight;
    //             $full_empty = $encodeddata->full_empty;
    //             $in_out = $encodeddata->in_out;
    //             $tar = $encodeddata->tar;
    //             $vessel_name = $encodeddata->vessel_name;
    //             $voyage_in = $encodeddata->voyage_in;
    //             $voyage_out = $encodeddata->voyage_out;
    //             $paidthrough = $this->gantiformattglgblk2($encodeddata->paidthrough);
    //             $pod = $encodeddata->pod;
    //             $spod = $encodeddata->spod;
    //             $customer_name = $encodeddata->customer_name;
    //             $cust_type = $encodeddata->cust_type;
    //             $cust_no = $encodeddata->cust_no;
    //             $cust_date = $this->gantiformattglgblk($encodeddata->cust_date);
    //             $imdg = $encodeddata->imdg;
    //             $imdg_value = $encodeddata->imdg_value;
    //             $reff_number = $encodeddata->reff_number;
    //             $remark = $encodeddata->remark;

    //             // CEK APA SUDAH ADA DATA DI T_REQUEST_CONT  ==================================//
    
    //             $Q1 = $this->db->query("SELECT tr.ID, trc.NO_CONT, trc.TAR FROM t_request tr JOIN t_request_cont trc on tr.ID = trc.ID
    //              WHERE tr.NO_DOK = '$cust_no' and tr.TGL_DOK = '$cust_date'");
    //             if(empty($Q1->result())){
    //                 echo "REQUEST DATA NOT FOUND"."\r\n";
    //                 $SQL = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'NO REQUEST DATA' WHERE ID = '$id_transaksi'";
    //                 $this->db->query($SQL);
    //             } else {
    //                 echo "found request data for container '$cont_no'"."\r\n";
    //                 foreach ($Q1->result() as $key => $value2) {
    //                     $id_t_request = $value2->ID;
    //                     //UPDATE PAIDTROUGH =========================================================//
    //                     $SQLUPDATE = "UPDATE t_request tr set WK_REQ = '$paidthrough'
    //                     WHERE tr.ID = '$id_t_request'";
    //                     $this->db->query($SQLUPDATE);
    //                     if ($this->db->affected_rows() != 0) {
    //                         echo "PAIDTROUGH UPDATED"."\r\n";
    //                         $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK_2 = 'PAIDTROUGH UPDATED' WHERE ID = '$id_transaksi'";
    //                         $this->db->query($SQLEND);
    //                     } else {
    //                         echo "Failed UPDATE PAIDTROUGH"."\r\n";
    //                         $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK_2 = 'Failed UPDATE PAIDTROUGH' WHERE ID = '$id_transaksi'";
    //                         $this->db->query($SQLEND);
    //                     }
    //                     //UPDATE PAIDTROUGH =========================================================//
    //                     echo "updating TAR for container '$cont_no'"."\r\n";
    //                     echo "TAR VALUE IS '$tar'"."\r\n";
    //                     // CEK UDAH ADA TAR APA BELON  ==================================//
    //                     if($value2->TAR == null){
    //                         echo "saving tar"."\r\n";
    //                         $SQLUPDATE = "UPDATE t_request_cont trc set TAR = '$tar', KD_STATUS = 'INQUIRY', REF_NUMBER = '$reff_number'
    //                         WHERE trc.ID = '$id_t_request' and trc.NO_CONT = '$cont_no'";
    //                         $this->db->query($SQLUPDATE);
    //                         if ($this->db->affected_rows() != 0) {
    //                             echo "TAR saved succesfully"."\r\n";
    //                             $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'TAR saved succesfully' WHERE ID = '$id_transaksi'";
    //                             $this->db->query($SQLEND);
    //                         } else {
    //                             echo "Failed Save TAR, check database"."\r\n";
    //                             $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'FAILED SAVE TAR' WHERE ID = '$id_transaksi'";
    //                             $this->db->query($SQLEND);
    //                         }
    //                     } else {
    //                         echo "tar is already exist"."\r\n";
    //                         $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'TAR ALREADY EXIST' WHERE ID = '$id_transaksi'";
    //                         $this->db->query($SQLEND);
    //                     }
    //                 }
    //             }
    
    
    
    
    //             // $SQL = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y' WHERE ID = '$id_transaksi'";
    //             // $this->db->query($SQL);
    //         }
    //     }
    // }

    // public function proses_rekon_dokumen(){
    //     $Q = $this->db->query("SELECT * FROM t_log_rekon_dokumen WHERE FL_PROSES = 'N'");
    //     if(empty($Q->result())){
    //         echo "NO DATA TO PROCESS"."\r\n";
    //     } else {
    //         foreach ($Q->result() as $key => $value1) {
    //             $id_transaksi = $xmlditerima = $value1->ID;
    //             $xmlditerima = $value1->XML_RECEIVED;
    //             // PROSES XML YANG SUDAH JADI JSON==================================//
    //             $encodeddata = json_decode($xmlditerima);
    //             $request_no = $encodeddata->request_no;
    //             $request_date = $this->gantiformattglgblk($encodeddata->request_date);
    //             $document_type = $encodeddata->document_type;
    //             $document_no = $encodeddata->document_no;
    //             $document_date = $this->gantiformattglgblk($encodeddata->document_date);
    //             $vessel_name = $encodeddata->vessel_name;
    //             $call_sign = $encodeddata->call_sign;
    //             $voyage = $encodeddata->voyage;
    //             $cont_no = $encodeddata->cont_no;
    //             $cont_size = $encodeddata->cont_size;
    //             $inspection = $encodeddata->inspection;
    //             $status = $encodeddata->status;


    //             // cek udah ada value sebelumnya di tabel
    //             $QC = $this->db->query("SELECT * from t_rekon_dokumen_npct1 trdn where NO_CONT = '$cont_no' and NO_DOK  = '$document_no' and TGL_DOK = '$document_date'");
    //             if(empty($QC->result())){
    //                 echo "NO EXISTING DATA FOUND, BEGIN PROCES INSERT "."$cont_no"."\r\n";
    //                 $QInsert = "INSERT INTO t_rekon_dokumen_npct1
    //                 (LNSW_NO_AJU, LNSW_TANGGAL_AJU, VESSEL, CALL_SIGN, VOYAGE, NO_CONT, NO_DOK, TYPE_DOK, PERIKSA, STATUS_NPCT1, TGL_DOK)
    //                 VALUES('$request_no', '$request_date', '$vessel_name', '$call_sign', '$voyage', '$cont_no', '$document_no', '$document_type', '$inspection', '$status', '$document_date')";
    //                 $this->db->query($QInsert);
    //                 $SQLEND = "UPDATE t_log_rekon_dokumen SET FL_PROSES= 'Y', REMARK_PROSES = 'SUCCESS' WHERE ID = '$id_transaksi'";
    //                 $this->db->query($SQLEND);
    //             } else {
    //                 echo "DATA "."$cont_no"." ALREADY EXIST"."\r\n";
    //                 $SQLEND = "UPDATE t_log_rekon_dokumen SET FL_PROSES= 'Y', REMARK_PROSES = 'DATA ALREADY EXIST' WHERE ID = '$id_transaksi'";
    //                 $this->db->query($SQLEND);
    //             }
    //         }
    //     }
    // }
}
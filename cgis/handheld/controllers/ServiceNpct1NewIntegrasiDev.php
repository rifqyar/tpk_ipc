<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceNpct1NewIntegrasiDev extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
    public function parsedate($x) {
        if (strlen($x)<9) {
            if (strlen($x)==0){
                return $x;
            }
            return substr_replace(substr_replace($x,"-",4,0),"-",7,0);
        }
        else
            return substr_replace(substr_replace(substr_replace(substr_replace(substr_replace($x,"-",4,0),"-",7,0)," ",10,0),":",13,0),":",16,0);
    }
    public function tipekont($x) {
        if ($x == 'Y') {
            return 'RFR';
        }
        else
            return 'DRY';
    }
    public function getcoarri(){
        $start = date("YmdHis",strtotime("-15 minutes",strtotime("now")));
        $end = date("YmdHis");
        echo $start."<br>";
        echo $end;
        $url    = "http://10.244.20.14:83/api/v1/get-coarri";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
           $addXML ='<request>
                        <start>'.$start.'</start>
                        <end>'.$end.'</end>
                    </request>

                ';
            $addXML .='</request>
            ';

            $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
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
            $xml1 = str_replace('xmlns="cococont.xsd">',">",$response);
            $xml2 = str_replace('</DOCUMENT">',"</DOCUMENT>",$xml1);

            $xml = simplexml_load_string($xml2);

            foreach ($xml->DOCUMENT->COCOCONT as $hdrdata){
                foreach ($hdrdata->DETIL->CONT as $contdata){
                    $KD_DOK = $hdrdata->HEADER->KD_DOK;
                    $KD_TPS = $hdrdata->HEADER->KD_TPS;
                    $NM_ANGKUT = $hdrdata->HEADER->NM_ANGKUT;
                    $NO_VOY_FLIGHT = $hdrdata->HEADER->NO_VOY_FLIGHT;
                    $CALL_SIGN = $hdrdata->HEADER->CALL_SIGN;;
                    $TGL_TIBA = $this->parsedate($hdrdata->HEADER->TGL_TIBA);
                    $KD_GUDANG = $hdrdata->HEADER->KD_GUDANG;
                    $REF_NUMBER = $hdrdata->HEADER->REF_NUMBER;
                    $NO_CONT = $contdata->NO_CONT;
                    $UK_CONT = $contdata->UK_CONT;
                    $NO_SEGEL = $contdata->NO_SEGEL;
                    $JNS_CONT = $contdata->JNS_CONT;
                    $NO_BL_AWB = $contdata->NO_BL_AWB;
                    $TGL_BL_AWB = $this->parsedate($contdata->TGL_BL_AWB);
                    $NO_MASTER_BL_AWB = $contdata->NO_MASTER_BL_AWB;
                    $TGL_MASTER_BL_AWB = $this->parsedate($contdata->TGL_MASTER_BL_AWB);
                    $ID_CONSIGNEE = $contdata->ID_CONSIGNEE;
                    $CONSIGNEE = $contdata->CONSIGNEE;
                    $BRUTO = $contdata->BRUTO;
                    $NO_BC11 = $contdata->NO_BC11;
                    $TGL_BC11 = $this->parsedate($contdata->TGL_BC11);
                    $NO_POS_BC11 = $contdata->NO_POS_BC11;
                    $KD_TIMBUN = $contdata->KD_TIMBUN;
                    $KD_DOK_INOUT = $contdata->KD_DOK_INOUT;
                    $NO_DOK_INOUT = $contdata->NO_DOK_INOUT;
                    $TGL_DOK_INOUT = $this->parsedate($contdata->TGL_DOK_INOUT);
                    $WK_INOUT = $this->parsedate($contdata->WK_INOUT);
                    $WK_EXE = $this->parsedate($contdata->WK_EXE);
                    $KD_SAR_ANGKUT_INOUT = $contdata->KD_SAR_ANGKUT_INOUT;
                    $NO_POL = $contdata->NO_POL;
                    $FL_CONT_KOSONG = $contdata->FL_CONT_KOSONG;
                    $ISO_CODE = $contdata->ISO_CODE;
                    $PEL_MUAT = $contdata->PEL_MUAT;
                    $PEL_TRANSIT = $contdata->PEL_TRANSIT;
                    $PEL_BONGKAR = $contdata->PEL_BONGKAR;
                    $GUDANG_TUJUAN = $contdata->GUDANG_TUJUAN;
                    $KODE_KANTOR = $contdata->KODE_KANTOR;
                    $NO_DAFTAR_PABEAN = $contdata->NO_DAFTAR_PABEAN;
                    $TGL_DAFTAR_PABEAN = $this->parsedate($contdata->TGL_DAFTAR_PABEAN);
                    $NO_SEGEL_BC = $contdata->NO_SEGEL_BC;
                    $TGL_SEGEL_BC = $this->parsedate($contdata->TGL_SEGEL_BC);
                    $NO_IJIN_TPS = $contdata->NO_IJIN_TPS;
                    $TGL_IJIN_TPS = $this->parsedate($contdata->TGL_IJIN_TPS);
                    $KD_CONT_TYPE = $this->tipekont($contdata->REEFER);
                    $OOG = $contdata->OOG;
                    $IMDG = $contdata->IMDG;
                    $WK_REKAM = date("Y-m-d H:i:s");

                    // echo $NM_ANGKUT." + "
                    //         ."KD_DOK =".$KD_DOK." ,\r\n "
                    //         ."KD_TPS = ".$KD_TPS." ,\r\n "
                    //         ."NO_VOY_FLIGHT = ".$NO_VOY_FLIGHT." ,\r\n "
                    //         ."CALL_SIGN = ".$CALL_SIGN." ,\r\n "
                    //         ."TGL_TIBA = ".$TGL_TIBA." ,\r\n "
                    //         ."KD_GUDANG = ".$KD_GUDANG." ,\r\n "
                    //         ."REF_NUMBER = ".$REF_NUMBER." ,\r\n "
                    //         ."############# DETIL CONT ########## \r\n "
                    //         ."NO_CONT = ".$NO_CONT." ,\r\n "
                    //         ."UK_CONT = ".$UK_CONT." ,\r\n "
                    //         ."NO_SEGEL = ".$NO_SEGEL." ,\r\n "
                    //         ."JNS_CONT = ".$JNS_CONT." ,\r\n "
                    //         ."NO_BL_AWB = ".$NO_BL_AWB." ,\r\n "
                    //         ."TGL_BL_AWB = ".$TGL_BL_AWB." ,\r\n "
                    //         ."NO_MASTER_BL_AWB = ".$NO_MASTER_BL_AWB." ,\r\n "
                    //         ."TGL_MASTER_BL_AWB = ".$TGL_MASTER_BL_AWB." ,\r\n "
                    //         ."ID_CONSIGNEE = ".$ID_CONSIGNEE." ,\r\n "
                    //         ."CONSIGNEE = ".$CONSIGNEE." ,\r\n "
                    //         ."BRUTO = ".$BRUTO." ,\r\n "
                    //         ."NO_BC11 = ".$NO_BC11." ,\r\n "
                    //         ."TGL_BC11 = ".$TGL_BC11." ,\r\n "
                    //         ."NO_POS_BC11 = ".$NO_POS_BC11." ,\r\n "
                    //         ."KD_TIMBUN = ".$KD_TIMBUN." ,\r\n "
                    //         ."KD_DOK_INOUT = ".$KD_DOK_INOUT." ,\r\n "
                    //         ."NO_DOK_INOUT = ".$NO_DOK_INOUT." ,\r\n "
                    //         ."TGL_DOK_INOUT = ".$TGL_DOK_INOUT." ,\r\n "
                    //         ."WK_INOUT = ".$WK_INOUT." ,\r\n "
                    //         ."WK_EXE = ".$WK_EXE." ,\r\n "
                    //         ."KD_SAR_ANGKUT_INOUT = ".$KD_SAR_ANGKUT_INOUT." ,\r\n "
                    //         ."NO_POL = ".$NO_POL." ,\r\n "
                    //         ."FL_CONT_KOSONG = ".$FL_CONT_KOSONG." ,\r\n "
                    //         ."ISO_CODE = ".$ISO_CODE." ,\r\n "
                    //         ."PEL_MUAT = ".$PEL_MUAT." ,\r\n "
                    //         ."PEL_TRANSIT = ".$PEL_TRANSIT." ,\r\n "
                    //         ."PEL_BONGKAR = ".$PEL_BONGKAR." ,\r\n "
                    //         ."GUDANG_TUJUAN = ".$GUDANG_TUJUAN." ,\r\n "
                    //         ."KODE_KANTOR = ".$KODE_KANTOR." ,\r\n "
                    //         ."NO_DAFTAR_PABEAN = ".$NO_DAFTAR_PABEAN." ,\r\n "
                    //         ."TGL_DAFTAR_PABEAN = ".$TGL_DAFTAR_PABEAN." ,\r\n "
                    //         ."NO_SEGEL_BC = ".$NO_SEGEL_BC." ,\r\n "
                    //         ."TGL_SEGEL_BC = ".$TGL_SEGEL_BC." ,\r\n "
                    //         ."NO_IJIN_TPS = ".$NO_IJIN_TPS." ,\r\n "
                    //         ."KD_CONT_TYPE = ".$KD_CONT_TYPE."\r\n"
                    //         ."OOG = ".$OOG."\r\n"
                    //         ."IMDG = ".$IMDG."\r\n";

                            // INSERT TO COCOSTHDR/COCOSTCONT
                            // check data ada di cocosthdr
                            $query = $this->db->query("SELECT * from dum_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                            $count = $query->num_rows();
                            if ($count === 0){
                                echo $NO_VOY_FLIGHT." + ".$CALL_SIGN."belum ada \r\n";
                                $this->db->query("INSERT INTO dum_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, CALL_SIGN, NM_ANGKUT, NO_VOY_FLIGHT, TGL_TIBA)  VALUES ('$KD_DOK', '$KD_TPS', '$KD_GUDANG', '$CALL_SIGN', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$TGL_TIBA')");
                                $insert_id = $this->db->insert_id();

                                echo  "selanjutnya insert ke cocostcont pake id = ".$insert_id."\r\n";
                                $query = $this->db->query("INSERT INTO dum_cocostscont
                                    (ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING)
                                    VALUES($insert_id, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL', '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR', NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL, '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN', '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N');
                                    ");

                            }
                            else{
                                $q = $this->db->query("SELECT * from dum_cocostshdr where CALL_SIGN = '$CALL_SIGN' and NM_ANGKUT = '$NM_ANGKUT' and NO_VOY_FLIGHT = '$NO_VOY_FLIGHT'");
                                foreach ($q->result() as $key => $value1) {
                                    $cocosthdrid = $value1->ID;
                                    //cek dulu sudah ada di cocostcont
                                    $query = $this->db->query("SELECT * from dum_cocostshdr dc join dum_cocostscont dc2 on dc.ID = dc2.ID where dc.NM_ANGKUT = '$NM_ANGKUT' and dc.NO_VOY_FLIGHT = '$NO_VOY_FLIGHT' and dc.CALL_SIGN  = '$CALL_SIGN' and dc2.NO_CONT = '$NO_CONT'");
                                    $count = $query->num_rows();
                                    if ($count === 0){
                                        //kalau belum ada maka di insert
                                        echo  "insert ke cocostcont pake id = ".$cocosthdrid."\r\n";
                                        $query = $this->db->query("INSERT INTO dum_cocostscont
                                            (ID, NO_CONT, UK_CONT, JNS_CONT, ISO_CODE, TEMPERATURE, KD_CONT_TIPE, BRUTO, NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, KD_TIMBUN, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN, FL_CONT_KOSONG_IN, KD_SARANA_ANGKUT_IN, NO_POL_IN, GUDANG_TUJUAN_IN, NO_DAFTAR_PABEAN_IN, TGL_DAFTAR_PABEAN_IN, NO_SEGEL_BC_IN, TGL_SEGEL_BC_IN, NO_IJIN_TPS_IN, TGL_IJIN_TPS_IN, KODE_KANTOR_IN, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT, FL_CONT_KOSONG_OUT, KD_SARANA_ANGKUT_OUT, NO_POL_OUT, GUDANG_TUJUAN_OUT, NO_DAFTAR_PABEAN_OUT, TGL_DAFTAR_PABEAN_OUT, NO_SEGEL_BC_OUT, TGL_SEGEL_BC_OUT, NO_IJIN_TPS_OUT, TGL_IJIN_TPS_OUT, KODE_KANTOR_OUT, WK_REKAM, FL_BILLING)
                                            VALUES($cocosthdrid, '$NO_CONT', '$UK_CONT', '$JNS_CONT', '$ISO_CODE', NULL, '$KD_CONT_TYPE', '$BRUTO', '$NO_SEGEL', '$NO_BL_AWB', '$TGL_BL_AWB', NULL, NULL, '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$ID_CONSIGNEE', '$CONSIGNEE', '$KD_TIMBUN', '$PEL_MUAT', '$PEL_TRANSIT', '$PEL_BONGKAR', NULL, NULL, NULL, '$WK_INOUT', '$FL_CONT_KOSONG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '040300', NULL, NULL, NULL, NULL, '$FL_CONT_KOSONG', '$KD_SARANA_ANGKUT_OUT', '$NO_POL', '$GUDANG_TUJUAN', '$NO_DAFTAR_PABEAN', '$TGL_DAFTAR_PABEAN', '$NO_SEGEL_BC', '$TGL_SEGEL_BC', '$NO_IJIN_TPS', '$TGL_IJIN_TPS', '$KODE_KANTOR', '$WK_REKAM', 'N');
                                            ");

                                    } else {
                                        echo "belum ada data baru"."\r\n";
                                    }
                                }

                            }

                        }
                    }
                }
    public function getondemand()
    {
        $start = date("YmdHis",strtotime("-15 minutes",strtotime("now")));
        $end = date("YmdHis");
        echo $start."<br>";
        echo $end;
        $url    = "http://10.244.20.14:83/api/v1/get-ondemand";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML ='<request>
                <document_code>1</document_code>
                <document_no>476951/KPU.01/2022</document_no>
                <document_date>20220905</document_date>
                <npwp>013618822073000</npwp>
                </request>

                ';
            $addXML .='</request>
            ';

            $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
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
            $xml1 = str_replace('xmlns="cococont.xsd">',">",$response);
            $xml2 = str_replace('</DOCUMENT">',"</DOCUMENT>",$xml1);

            $xml = simplexml_load_string($xml2);
            echo $response;
    }

    public function sendcodeco(){
        $q = $this->db->query("SELECT ts.NO_SPK, tc.NM_ANGKUT, tc.NO_VOY_FLIGHT, tc.CALL_SIGN, DATE_FORMAT(tc.TGL_TIBA, '%Y%m%d') as 'TGL_TIBA', tr.REF_NUMBER,
tr.NO_CONT, tr.UKR_CONT, tr.KD_CONT_JENIS, tg.NPWP, tg.NAMA_CUST, tc2.BRUTO, tph.KD_DOK_INOUT,
tph.NO_BC11, DATE_FORMAT(tph.TGL_BC11, '%Y%m%d') as 'TGL_BC11',
tph.NO_POS_BC11, tg.NO_DOK, DATE_FORMAT(tph.TGL_DOK_INOUT , '%Y%m%d') as 'TGL_DOK_INOUT', DATE_FORMAT(tod.WK_GATEOUT, '%Y%m%d%H%i%s') as 'WK_GATEOUT',
tr.ISO_CODE, tc2.PEL_MUAT, tc2.PEL_BONGKAR, tph.NO_DAFTAR_PABEAN, DATE_FORMAT(tph.NO_DAFTAR_PABEAN, '%Y%m%d') as 'NO_DAFTAR_PABEAN'
from t_spk ts join t_gatepass tg on ts.NO_SPK = tg.NO_SPK
join (select tr.NO_DOK, trc.NO_CONT, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, trc.UKR_CONT, trc.KD_CONT_JENIS, trc.REF_NUMBER,
trc.BRUTO, trc.ISO_CODE from t_request tr join t_request_cont trc on tr.ID = trc.ID)    
tr on tr.NO_DOK = ts.NO_DOK and tr.NO_CONT = tg.NO_CONT
join t_cocostshdr tc on tr.VESSEL = tc.NM_ANGKUT and tr.VOY_IN = tc.NO_VOY_FLIGHT
join t_cocostscont tc2 on tc.ID = tc2.ID and tg.NO_CONT = tc2.NO_CONT
join t_op_delivery tod on tg.NO_SPK = tod.NO_SPK and tg.NO_CONT = tod.NO_CONT
join t_permit_hdr tph on tg.NO_DOK = tph.NO_DOK_INOUT
where tg.WK_REK > '2022-09-24' and tg.JNS_KEGIATAN = '3' and tod.WK_GATEOUT is not null");
        foreach ($q->result() as $key => $value1) {
            $xmlpost = '<soapenv:Envelope
                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                    xmlns:ser="http://services.beacukai.go.id/">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <ser:CoarriCodeco_Container>
                            <!--Optional:-->
                            <ser:fStream><![CDATA[<?xml version="1.0" encoding="utf-8"?>
                                <DOCUMENT
                                    xmlns="cococont.xsd">
                                    <COCOCONT>
                                        <HEADER>
                                            <KD_DOK>3</KD_DOK>
                                            <KD_TPS>NCT1</KD_TPS>
                                            <NM_ANGKUT>'.$value1->NM_ANGKUT.'</NM_ANGKUT>
                                            <NO_VOY_FLIGHT>'.$value1->NO_VOY_FLIGHT.'</NO_VOY_FLIGHT>
                                            <CALL_SIGN>'.$value1->CALL_SIGN.'</CALL_SIGN>
                                            <TGL_TIBA>'.$value1->TGL_TIBA.'</TGL_TIBA>
                                            <KD_GUDANG>NCT1</KD_GUDANG>
                                            <REF_NUMBER>NCT1'.$value1->REF_NUMBER.'2</REF_NUMBER>
                                        </HEADER>
                                        <DETIL>
                                            <CONT>
                                                <NO_CONT>'.$value1->NO_CONT.'</NO_CONT>
                                                <UK_CONT>'.$value1->UKR_CONT.'</UK_CONT>
                                                <NO_SEGEL></NO_SEGEL>
                                                <JNS_CONT>'.$value1->KD_CONT_JENIS.'</JNS_CONT>
                                                <NO_BL_AWB>'.$value1->NO_BL_AWB.'</NO_BL_AWB>
                                                <TGL_BL_AWB></TGL_BL_AWB>
                                                <NO_MASTER_BL_AWB></NO_MASTER_BL_AWB>
                                                <TGL_MASTER_BL_AWB></TGL_MASTER_BL_AWB>
                                                <ID_CONSIGNEE></ID_CONSIGNEE>
                                                <CONSIGNEE>'.$value1->NAMA_CUST.'</CONSIGNEE>
                                                <BRUTO>'.$value1->BRUTO.'</BRUTO>
                                                <NO_BC11>'.$value1->NO_BC11.'</NO_BC11>
                                                <TGL_BC11>'.$value1->TGL_BC11.'</TGL_BC11>
                                                <NO_POS_BC11></NO_POS_BC11>
                                                <KD_TIMBUN></KD_TIMBUN>
                                                <KD_DOK_INOUT>'.$value1->KD_DOK_INOUT.'</KD_DOK_INOUT>
                                                <NO_DOK_INOUT>'.$value1->NO_DOK.'</NO_DOK_INOUT>
                                                <TGL_DOK_INOUT>'.$value1->TGL_DOK_INOUT.'</TGL_DOK_INOUT>
                                                <WK_INOUT>'.$value1->WK_GATEOUT.'</WK_INOUT>
                                                <KD_SAR_ANGKUT_INOUT></KD_SAR_ANGKUT_INOUT>
                                                <NO_POL></NO_POL>
                                                <FL_CONT_KOSONG></FL_CONT_KOSONG>
                                                <ISO_CODE></ISO_CODE>
                                                <PEL_MUAT></PEL_MUAT>
                                                <PEL_TRANSIT></PEL_TRANSIT>
                                                <PEL_BONGKAR></PEL_BONGKAR>
                                                <GUDANG_TUJUAN></GUDANG_TUJUAN>
                                                <KODE_KANTOR></KODE_KANTOR>
                                                <NO_DAFTAR_PABEAN>'.$value1->NO_DAFTAR_PABEAN.'</NO_DAFTAR_PABEAN>
                                                <TGL_DAFTAR_PABEAN>'.$value1->TGL_DAFTAR_PABEAN.'</TGL_DAFTAR_PABEAN>
                                                <NO_SEGEL_BC></NO_SEGEL_BC>
                                                <TGL_SEGEL_BC></TGL_SEGEL_BC>
                                                <NO_IJIN_TPS></NO_IJIN_TPS>
                                                <TGL_IJIN_TPS></TGL_IJIN_TPS>
                                            </CONT>
                                        </DETIL>
                                    </COCOCONT>
                                </DOCUMENT>]]></ser:fStream>
                            <!--Optional:-->
                            <ser:Username>NCT1</ser:Username>
                            <!--Optional:-->
                            <ser:Password>NCT1123456</ser:Password>
                        </ser:CoarriCodeco_Container>
                    </soapenv:Body>
                </soapenv:Envelope>';
$url    = "https://tpsonline.beacukai.go.id/tps/service.asmx";
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlpost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'Cookie: Customs_Cookie=!Mfh1Pq7UpgpIO5pnxDXzvI+DQ/LmjzFTaznyycvhjWAuGJdU5/1/qn8kiAfdRoKCNo5m8Djpvp3fHQI='
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
            $dirtyxml = str_ireplace('SOAP-ENV:','', $response);
            $clean_xml = str_ireplace('SOAP:','', $dirtyxml);
            $xml = simplexml_load_string($clean_xml);
            $responnyagan = $xml->Body->CoarriCodeco_ContainerResponse->CoarriCodeco_ContainerResult;
            $datenow = date("Y-m-d H:i:s");

            $this->db->query("INSERT INTO log_send_bc (NO_SPK, NO_CONTAINER, RESPONDATA, XML, WK_SEND)  VALUES ('$value1->NO_SPK', '$value1->NO_CONT', '$responnyagan', '$xmlpost', '$datenow')");

            $this->db->query("UPDATE t_op_delivery set FL_SEND_BC = 'Y' where NO_SPK = '$value1->NO_SPK' and NO_CONT = '$value1->NO_CONT')");
        }
    }
}
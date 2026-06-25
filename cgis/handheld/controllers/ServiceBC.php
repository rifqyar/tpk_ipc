<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceBC extends CI_Controller
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
            where tg.WK_REK > '2022-09-24' and tg.JNS_KEGIATAN = '3' and tod.FL_SEND_BC = 'N' and tod.WK_GATEOUT is not null");
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
                                            <REF_NUMBER>NCT1'.$value1->REF_NUMBER.'</REF_NUMBER>
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

            $this->db->query("UPDATE t_op_delivery set FL_SEND_BC = 'Y' where NO_SPK = '$value1->NO_SPK' and NO_CONT = '$value1->NO_CONT'");
        }
    }

    public function sendcodecomanual(){
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
            where tg.WK_REK > '2022-09-24' and tg.JNS_KEGIATAN = '3' and tod.FL_SEND_BC = 'N' and tod.WK_GATEOUT is not null");
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
                                            <REF_NUMBER>NCT1'.$value1->REF_NUMBER.'</REF_NUMBER>
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

            $this->db->query("UPDATE t_op_delivery set FL_SEND_BC = 'Y' where NO_SPK = '$value1->NO_SPK' and NO_CONT = '$value1->NO_CONT'");
        }
    }
}
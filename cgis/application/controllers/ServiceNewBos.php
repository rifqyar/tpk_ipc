<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceNewBos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');

        $sql = "SELECT distinct A.ID, B.NAMA , A.NO_DOK, A.TGL_DOK, 	CASE WHEN C.FL_MANUAL = 'Y' THEN 'INPUT MANUAL'
        WHEN C.FL_MANUAL = 'N' THEN  'INTEGRASI' end as 'STATUS_INPUT', A.KD_REQ, A.CONSIGNEE, A.RESPONSE_REQ, CASE WHEN A.WK_FINISH IS NOT NULL THEN 'SELESAI' ELSE '-' END AS KETERANGAN
        FROM t_request A
                            LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
                            LEFT JOIN t_request_cont F ON A.ID = F.ID
                            LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK  AND date(C.TGL_DAFTAR_PABEAN) = date(A.TGL_DOK)
                            LEFT JOIN t_permit_cont D ON C.ID = D.ID 
                            LEFT JOIN (SELECT * FROM t_permit_cont WHERE FL_PERIKSA = 'Y') Z on Z.ID = C.ID
                            LEFT JOIN t_cocostscont E ON E.NO_CONT = F.NO_CONT
                            LEFT JOIN t_cocostshdr H ON H.NM_ANGKUT = C.ANGKUTNAMA_TPS AND H.NO_VOY_FLIGHT = C.ANGKUTNO_TPS
                            WHERE A.JNS_DOK != '83' order by C.ID desc limit 500";

        $Query = $this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }

    public function get_detail_spjm()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $id = $_POST["id"];
        $sql = "SELECT B.*, E.NAMA, A.CONSIGNEE, '83' AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL'
        FROM t_request A
        LEFT JOIN t_request_cont B ON B.ID = A.ID
        LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
        LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
        LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
        LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
        LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
        WHERE A.id = '$id'
        GROUP BY B.NO_CONT
        ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";

        $Query = $this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }

    public function npeget(){
        $url    = "https://api.npct1.co.id:9443/api/v1/get-customs-ondemand";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML ='<request>
	<document_code>19</document_code>
	<document_no>824397</document_no>
	<document_date>25072024</document_date>
	<npwp>991801010416000</npwp>
</request>';


        $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
    // print_r($addXML);die();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
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
            echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
        }else{
            echo "Connection Failed =".curl_error($curl);
            echo $response;
            die();
        }
        curl_close($curl); 
        $xml1 = str_replace('<?xml version="1.0"?>',"",$response);
        $xml2 = str_replace('&apos;',"",$xml1);

        echo $xml2;
    }
}
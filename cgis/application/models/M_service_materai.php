<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_service_materai extends CI_Model {
    
    public function __construct(){
        parent::__construct();
    }
    // on localhost
    // function setting_point(){
    //     $data = array (
    //      'KODE_CABANG' => '003',
    //      'KODE_LOKASI' => '100',
    //      'KODE_JNS_DOK' => 'NOTA-BOSCA',
    //      'SIMOP' => '-',
    //      'PATHNOTA' => 'C:/xampp5/htdocs/cgis/cetakpdf/',
    //      'LINK_NOTA' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumen/',
    //      'LINK_AUTH' => 'https://devapi.multiterminal.co.id:2040/services/SvcAuth/Auth',
    //      'LINK_STAMP' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumenProses/stamp/',
    //      'AUTH_INFO' => 'USERNAME=mtiadmin&PASSWORD=mtiadmin2023&APP_ID=APP-BOS_CA',
    //      'LINK_CEK_STATUS_STAMP' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumen?TIPE=APP-BOS_CA&NO_DOK=',
    //      'LINK_STAMPED_NOTA' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumenProses/result/APP-BOS_CA/',
    //  );
    //     return $data;
    // }

    // on server
    // function setting_point(){
    //     $data = array (
    //      'KODE_CABANG' => '003',
    //      'KODE_LOKASI' => '100',
    //      'KODE_JNS_DOK' => 'NOTA-BOSCA',
    //      'SIMOP' => '-',
    //      'PATHNOTA' => '/home/tpk_ipc/cgis/cetakpdf/',
    //      'LINK_NOTA' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumen/',
    //      'LINK_AUTH' => 'https://devapi.multiterminal.co.id:2040/services/SvcAuth/Auth',
    //      'LINK_STAMP' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumenProses/stamp/',
    //      'AUTH_INFO' => 'USERNAME=mtiadmin&PASSWORD=mtiadmin2023&APP_ID=APP-BOS_CA',
    //      'LINK_CEK_STATUS_STAMP' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumen?TIPE=APP-BOS_CA&NO_DOK=',
    //      'LINK_STAMPED_NOTA' => 'https://devmat.multiterminal.co.id:2045/services/SvcDokumenProses/result/APP-BOS_CA/',
    //  );
    //     return $data;
    // } //dev
    function setting_point(){
        $data = array (
         'KODE_CABANG' => '003',
         'KODE_LOKASI' => '100',
         'KODE_JNS_DOK' => 'NOTA-BOSCA',
         'SIMOP' => '-',
         'PATHNOTA' => '/home/tpk_ipc/cgis/cetakpdf/',
         'LINK_NOTA' => 'https://emeterai.multiterminal.co.id:2045/services/SvcDokumen/',
         'LINK_AUTH' => 'https://api.multiterminal.co.id:2040/services/SvcAuth/Auth',
         'LINK_STAMP' => 'https://emeterai.multiterminal.co.id:2045/services/SvcDokumenProses/stamp/',
         'AUTH_INFO' => 'USERNAME=mtiadmin&PASSWORD=mtiadmin2023&APP_ID=APP-BOS_CA',
         'LINK_CEK_STATUS_STAMP' => 'https://emeterai.multiterminal.co.id:2045/services/SvcDokumen/?TIPE=APP-BOS_CA&NO_DOK=',
         'LINK_STAMPED_NOTA' => 'https://api.multiterminal.co.id:2040/services/SvcDokumenProses/result/APP-BOS_CA/',
     );
        return $data;
    }
    // ini prod
    function get_list_nota_delivery(){
        $SQL = "SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY, rdh.TGL_NOTA, mp.NPWP, mp.NAMA_CUST, rdh.TOTAL, rdh.BIAYA_MATERAI from req_delivery_hdr rdh
        join m_pelanggan mp on rdh.NPWP = mp.NPWP 
        where rdh.TGL_NOTA > '2023-12-01' and rdh.BIAYA_MATERAI = 10000 and (rdh.FL_SEND_EMATERAI_SERVICE = 'X' or rdh.FL_SEND_EMATERAI_SERVICE is null) limit 1";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function get_list_nota_behanle(){
        $SQL = "SELECT rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE, rbh.TGL_NOTA, mp.NPWP, mp.NAMA_CUST, rbh.TOTAL_JUMLAH, rbh.BIAYA_MATERAI 
        from req_behandle_hdr rbh 
        join m_pelanggan mp on rbh.NPWP = mp.NPWP
        where rbh.BIAYA_MATERAI >= 10000 and rbh.TGL_NOTA >= '2023-12-01' and rbh.FL_SEND_EMATERAI_SERVICE = 'X'
        limit 1";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function update_stat_nota($id){
        // $id = '31.2023.020309';
        $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'W' where ID_REQ = '$id'";
        $Query =$this->db->query($SQL);
    }
    function update_stat_nota_bhd($id){
        // $id = '31.2023.020309';
        $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'W' where ID_REQ = '$id'";
        $Query =$this->db->query($SQL);
    }
    function postman($url, $postdata){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $postdata,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ),
      ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function insert_token($access_token, $expire, $additionalinfo){
        $SQL = "INSERT INTO e_materai_access_token
        (ACCESS_TOKEN, EXPIRE, ADDITIONAL_INFO)
        VALUES('$access_token', '$expire', '$additionalinfo')";
        $Query = $this->db->query($SQL);
        if ($Query == 1) {
            $output = 'access_token sukses direkam';
            return $output;
        } else {
            $output = 'GAGAL REKAM ACCESS_TOKEN';
            return $output;
        }
    }
    function get_latest_token(){
        $SQL = "SELECT * from e_materai_access_token emat order by ID desc limit 1";
        $QUERY = $this->db->query($SQL);
        $data = $QUERY->result();
        $infologin = $data[0]->ADDITIONAL_INFO;
        $jsondata = json_decode($infologin);

        $tokendata = array(
            'ACCESS_TOKEN' => $data[0]->ACCESS_TOKEN,
            'ID_LOGIN' => $jsondata->ID,
            'APP_ID' => $jsondata->APP_ID,
            'ROLE_ID' => $jsondata->ROLE_ID,
        );
        return $tokendata;
    }
    function nota_bhd_tercetak(){
        $SQL = "SELECT rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE, rbh.TGL_NOTA, mp.NPWP, mp.NAMA_CUST, rbh.TOTAL_JUMLAH, rbh.BIAYA_MATERAI 
        from req_behandle_hdr rbh 
        join m_pelanggan mp on rbh.NPWP = mp.NPWP
        where rbh.BIAYA_MATERAI >= 10000 and rbh.TGL_NOTA >= '2023-07-01' and rbh.FL_SEND_EMATERAI_SERVICE = 'W'
        limit 1";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function nota_del_tercetak(){
        $SQL = "SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY, rdh.TGL_NOTA, mp.NPWP, mp.NAMA_CUST, rdh.TOTAL, rdh.BIAYA_MATERAI from req_delivery_hdr rdh
        join m_pelanggan mp on rdh.NPWP = mp.NPWP 
        where rdh.TGL_NOTA > '2023-07-01' and rdh.BIAYA_MATERAI = 10000 and rdh.FL_SEND_EMATERAI_SERVICE = 'W' limit 1";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function nota_del_siap_stamp(){
        $SQL = "(SELECT rbh.ID_REQ, emsm.RESPONSE_ID, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA', emsm.RAW_RESPONSE from req_behandle_hdr rbh 
                join e_materai_services_main emsm on rbh.NO_NOTA_BEHANDLE = emsm.NO_NOTA 
                where rbh.FL_SEND_EMATERAI_SERVICE = 'S' and emsm.RESPONSE = 'success' limit 50)
                union
                (SELECT rdh.ID_REQ, emsm.RESPONSE_ID, rdh.NO_NOTA_DELIVERY  as 'NO_NOTA', emsm.RAW_RESPONSE from req_delivery_hdr rdh 
                join e_materai_services_main emsm on rdh.NO_NOTA_DELIVERY = emsm.NO_NOTA 
                where rdh.FL_SEND_EMATERAI_SERVICE = 'S' and emsm.RESPONSE = 'success' limit 50)";

        // $SQL = "SELECT rbh.ID_REQ, emsm.RESPONSE_ID, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA', emsm.RAW_RESPONSE from req_behandle_hdr rbh 
        //         join e_materai_services_main emsm on rbh.NO_NOTA_BEHANDLE = emsm.NO_NOTA 
        //         where rbh.FL_SEND_EMATERAI_SERVICE = 'S' and emsm.RESPONSE = 'success' and RBH.NO_NOTA_BEHANDLE = '31.2023.041235'";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }

    function monitoring_all_nota(){
        $SQL = "SELECT * from (select rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE AS 'NO_NOTA', rbh.TGL_NOTA, 
                case WHEN rbh.FL_SEND_EMATERAI_SERVICE = 'X' then 'Nota Belum Diproses'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'D' then 'Nota Selesai Stamp' 
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'Y' then 'Nota Menunggu Dikirim'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'S' then 'Nota Sukses Dikirim, Menunggu Antrian Stamp'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'F' then 'Nota Gagal Dikirim'
                else 'Nota Belum Diproses' end as 'FL_SEND_EMATERAI_SERVICE'
                from req_behandle_hdr rbh where rbh.BIAYA_MATERAI = '10000' and rbh.TGL_NOTA > '2023-07-01'
                    union all
                select rdh.ID_REQ, rdh.NO_NOTA_DELIVERY AS 'NO_NOTA', rdh.TGL_NOTA, 
                case WHEN rdh.FL_SEND_EMATERAI_SERVICE = 'X' then 'Nota Belum Diproses'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'D' then 'Nota Selesai Stamp' 
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'Y' then 'Nota Menunggu Dikirim'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'S' then 'Nota Sukses Dikirim, Menunggu Antrian Stamp'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'F' then 'Nota Gagal Dikirim'
                else 'Nota Belum Diproses' end as 'FL_SEND_EMATERAI_SERVICE'
                from req_delivery_hdr rdh where rdh.BIAYA_MATERAI = '10000' and rdh.TGL_NOTA > '2023-07-01') a
                order by a.TGL_NOTA desc";

        $Query =$this->db->query($SQL);
        return $Query->result();
    }

    function failed_nota(){
        $SQL = "SELECT * from (select rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE AS 'NO_NOTA', rbh.TGL_NOTA, 
                case WHEN rbh.FL_SEND_EMATERAI_SERVICE = 'X' then 'Nota Belum Diproses'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'D' then 'Nota Selesai Stamp' 
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'Y' then 'Nota Menunggu Dikirim'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'S' then 'Nota Sukses Dikirim, Menunggu Antrian Stamp'
                    when rbh.FL_SEND_EMATERAI_SERVICE = 'F' then 'Nota Gagal Dikirim'
                else 'Nota Belum Diproses' end as 'FL_SEND_EMATERAI_SERVICE'
                from req_behandle_hdr rbh where rbh.BIAYA_MATERAI = '10000' and rbh.TGL_NOTA > '2023-07-01' and rbh.FL_SEND_EMATERAI_SERVICE = 'F'
                    union all
                select rdh.ID_REQ, rdh.NO_NOTA_DELIVERY AS 'NO_NOTA', rdh.TGL_NOTA, 
                case WHEN rdh.FL_SEND_EMATERAI_SERVICE = 'X' then 'Nota Belum Diproses'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'D' then 'Nota Selesai Stamp' 
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'Y' then 'Nota Menunggu Dikirim'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'S' then 'Nota Sukses Dikirim, Menunggu Antrian Stamp'
                    when rdh.FL_SEND_EMATERAI_SERVICE = 'F' then 'Nota Gagal Dikirim'
                else 'Nota Belum Diproses' end as 'FL_SEND_EMATERAI_SERVICE'
                from req_delivery_hdr rdh where rdh.BIAYA_MATERAI = '10000' and rdh.TGL_NOTA > '2023-07-01' and rdh.FL_SEND_EMATERAI_SERVICE = 'F') a
                order by a.TGL_NOTA desc";

        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function get_id_nota($nonota){
        $SQL = "SELECT * from e_materai_stamp_log emsl where NO_NOTA = '$nonota' and RESPONSE = 'success' order by id desc limit 1";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function stamp_status(){
        $SQL = "(SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY as 'NO_NOTA', rdh.TGL_NOTA from req_delivery_hdr rdh 
where rdh.FL_SEND_EMATERAI_SERVICE = 'V' or rdh.FL_SEND_EMATERAI_SERVICE = 'P' and rdh.TGL_NOTA > '2024-01-01' limit 15)
        union
(SELECT rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA', rbh.TGL_NOTA from req_behandle_hdr rbh 
where rbh.FL_SEND_EMATERAI_SERVICE = 'V' or rbh.FL_SEND_EMATERAI_SERVICE = 'P' and rbh.TGL_NOTA > '2024-01-01' limit 15)";

        // $SQL = "SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY as 'NO_NOTA', rdh.TGL_NOTA from req_delivery_hdr rdh where ID_REQ = 'DEL/2024-01-03/121867'";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
    function stamp_status_manual(){
        $SQL = "(SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY as 'NO_NOTA', rdh.TGL_NOTA from req_delivery_hdr rdh 
where rdh.FL_SEND_EMATERAI_SERVICE = 'V' or rdh.FL_SEND_EMATERAI_SERVICE = 'P' and rdh.TGL_NOTA > '2024-01-01' limit 1)
        union
(SELECT rbh.ID_REQ, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA', rbh.TGL_NOTA from req_behandle_hdr rbh 
where rbh.FL_SEND_EMATERAI_SERVICE = 'V' or rbh.FL_SEND_EMATERAI_SERVICE = 'P' and rbh.TGL_NOTA > '2024-01-01' limit 1)";

        // $SQL = "SELECT rdh.ID_REQ, rdh.NO_NOTA_DELIVERY as 'NO_NOTA', rdh.TGL_NOTA from req_delivery_hdr rdh where ID_REQ = 'DEL/2024-01-03/121867'";
        $Query =$this->db->query($SQL);
        return $Query->result();
    }
}
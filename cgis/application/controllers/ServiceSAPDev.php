<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceSAPDev extends CI_Controller
{
    public $content;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        $headers = getallheaders();
        
        if (substr($headers['Authorization'], 0, 7) !== 'Bearer ') {
            return 'Bearer token missing';
        } else {
            if (substr($headers['Authorization'], 0, 7) !== 'asdasdasd ') {
                return 'Bearer token missing';
            } else {
                return 'Access Valid';
            }
        }
    }

    public function token_validation($data)
    {
    }

    public function buat_json()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $idreq = $_POST['ID_REQ'];
        ;

        $sql = "SELECT
        rdh.ID,
        rdh.ID_REQ,
        rdh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rdh.NM_KAPAL,
        rdh.NO_VOY,
        rdh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN PENUMPUKAN COMMON AREA') as 'REMARK',
        rdh.SUBTOTAL,
        concat('11') as 'PPN_PERSEN',
        rdh.PPN,
        rdh.TOTAL,
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('DELIVERY') as 'JENIS_KEGIATAN'
        from req_delivery_hdr rdh
        join m_pelanggan mp on rdh.NPWP = mp.NPWP
        where ID_REQ = '$idreq'
        order by mp.ID_CUST desc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "select RDD.ID_REQ,rdd.NO_CONT, rdd.UKR_CONT,rdd.STATUS, rdd.ISO_CODE, rdd.TARIF_ID, mt.JENIS_BIAYA,rdd.CHARGE, rdd.TOTAL from req_delivery_dtl rdd left join m_tarif2 mt on rdd.TARIF_ID = mt.TARIF_ID
        where ID_REQ = '$idreq'";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();
        foreach ($result as $hasil) {
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "TOTAL" => $hasil->TOTAL,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->ISO_CODE,
                    "UKR_CONT" => $detail->UKR_CONT,
                    "STATUS_CONT" => $detail->STATUS,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }


            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($headernota),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;

        }
    }
    public function delivery_to_stg()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $arrid = explode('~', $this->input->post('id'));
        $idreq = $arrid[0];
        $header = substr($idreq, 0, 3);
        if ($header == 'DEL') {
            $jenis_req = 'DEL';
        } else {
            $jenis_req = 'EXT';
        }
        $sql = "SELECT
        concat('DEL',rdh.ID) as 'ID',
        concat(rdh.ID_REQ) as 'ID_REQ',
        rdh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rdh.NM_KAPAL,
        rdh.NO_VOY,
        rdh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN PENUMPUKAN COMMON AREA') as 'REMARK',
        rdh.SUBTOTAL,
        concat('11') as 'PPN_PERSEN',
        rdh.PPN,
        rdh.SUBTOTAL+rdh.PPN as 'TOTAL',
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('DELIVERY') as 'JENIS_KEGIATAN'
        from req_delivery_hdr rdh
        JOIN m_pelanggan mp ON REPLACE(REPLACE(mp.NPWP, '.', ''), '-', '') = REPLACE(REPLACE(rdh.NPWP, '.', ''), '-', '')
        where ID_REQ = '$idreq'
        order by mp.ID_CUST asc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "SELECT RDD.ID_REQ,rdd.NO_CONT, rdd.UKR_CONT,rdd.STATUS, rdd.ISO_CODE, rdd.TARIF_ID, mt.JENIS_BIAYA,rdd.CHARGE, IFNULL(rdd.TOTAL_UNIT, 1) as 'TOTAL_UNIT',rdd.TOTAL from req_delivery_dtl rdd left join m_tarif2 mt on rdd.TARIF_ID = mt.TARIF_ID
        where ID_REQ = '$idreq'
        ";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();
        foreach ($result as $hasil) {
            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "ADMIN" => '0',
                "TOTAL" => $hasil->TOTAL,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'DELIVERY',
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->ISO_CODE,
                    "QTY" => $detail->TOTAL_UNIT,
                    "UKR_CONT" => $detail->UKR_CONT,
                    "STATUS_CONT" => $detail->STATUS,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }

            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);
            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }

            // if ($namacust == null) {
            //     echo 'Error, data user belum ada di staging';
            //     die();
            // }

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($headernota),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
            $datenow = date("Y-m-d H:i:s");
            $sendrequest = json_encode($headernota);
            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('SEND BILLING CSS', '$sendrequest', '$response', '$datenow', 'N', 'N')");
            //CEK APA SUDAH ADA PROFORMA DI LOG_KODE_BAYAR
            $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            $result = $this->db->query($sqlcek)->result_array();
            $jumlah = count($result);
            if ($jumlah == 0) {
                $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA)
                VALUES ('$ID_REQ');";
                $Query = $this->db->query($SQL1);
            } else {
                echo 'sudah ada data';
            }

        }
    }
    public function delivery_to_stgdev()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $arrid = explode('~', $this->input->post('id'));
        $idreq = $arrid[0];
        $header = substr($idreq, 0, 3);
        if ($header == 'DEL') {
            $jenis_req = 'DEL';
        } else {
            $jenis_req = 'EXT';
        }
        $sql = "SELECT
        concat('DEL',rdh.ID) as 'ID',
        concat(rdh.ID_REQ) as 'ID_REQ',
        rdh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rdh.NM_KAPAL,
        rdh.NO_VOY,
        rdh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN PENUMPUKAN COMMON AREA') as 'REMARK',
        rdh.SUBTOTAL,
        concat('11') as 'PPN_PERSEN',
        rdh.PPN,
        rdh.SUBTOTAL+rdh.PPN as 'TOTAL',
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('DELIVERY') as 'JENIS_KEGIATAN'
        from req_delivery_hdr rdh
        JOIN m_pelanggan mp ON REPLACE(REPLACE(mp.NPWP, '.', ''), '-', '') = REPLACE(REPLACE(rdh.NPWP, '.', ''), '-', '')
        where ID_REQ = '$idreq'
        order by mp.ID_CUST asc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "SELECT RDD.ID_REQ,rdd.NO_CONT, rdd.UKR_CONT,rdd.STATUS, rdd.ISO_CODE, rdd.TARIF_ID, mt.JENIS_BIAYA,rdd.CHARGE, IFNULL(rdd.TOTAL_UNIT, 1) as 'TOTAL_UNIT',rdd.TOTAL from req_delivery_dtl rdd left join m_tarif2 mt on rdd.TARIF_ID = mt.TARIF_ID
        where ID_REQ = '$idreq'
        ";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();
        foreach ($result as $hasil) {
            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "ADMIN" => '0',
                "TOTAL" => $hasil->TOTAL,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'DELIVERY',
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->ISO_CODE,
                    "QTY" => $detail->TOTAL_UNIT,
                    "UKR_CONT" => $detail->UKR_CONT,
                    "STATUS_CONT" => $detail->STATUS,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }

            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);
            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }

            // if ($namacust == null) {
            //     echo 'Error, data user belum ada di staging';
            //     die();
            // }

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/getinvnew',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($headernota),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
            $datenow = date("Y-m-d H:i:s");
            $sendrequest = json_encode($headernota);
            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('SEND BILLING CSS', '$sendrequest', '$response', '$datenow', 'N', 'N')");
            //CEK APA SUDAH ADA PROFORMA DI LOG_KODE_BAYAR
            $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            $result = $this->db->query($sqlcek)->result_array();
            $jumlah = count($result);
            if ($jumlah == 0) {
                $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA)
                VALUES ('$ID_REQ');";
                $Query = $this->db->query($SQL1);
            } else {
                echo 'sudah ada data';
            }

        }
    }

    public function behandle_to_stg()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $arrid = explode('~', $this->input->post('id'));
        $idreq = $arrid[0];

        $sql = "SELECT concat('BHD',rbh.ID) as 'ID',
        concat(rbh.ID_REQ) as 'ID_REQ',
        rbh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rbh.NM_KAPAL,
        rbh.NO_VOY,
        rbh.BIAYA_ADMIN,
        rbh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN LAYANAN BEHANDLE COMMON AREA') as 'REMARK',
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN as 'SUBTOTAL',
        concat('11') as 'PPN_PERSEN',
        rbh.PPN,
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN+rbh.PPN as 'TOTAL_JUMLAH',
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('BEHANDLE') as 'JENIS_KEGIATAN'
        from req_behandle_hdr rbh
        JOIN m_pelanggan mp ON REPLACE(REPLACE(mp.NPWP, '.', ''), '-', '') = REPLACE(REPLACE(rbh.NPWP, '.', ''), '-', '')
        where rbh.ID_REQ = '$idreq'
        order by mp.ID_CUST asc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "SELECT distinct rbd.ID_REQ, rbd.NO_CONT, tc.KD_CONT_TIPE as 'KD_CONT_TIPE', rbd.UK_CONT, tc.JNS_CONT  as 'JNS_CONT',
			mt.JENIS_BIAYA,
			mt.TARIF_ID,
            rbd.TOTAL as 'CHARGE',	
            rbd.TOTAL,
            concat('1') as 'TOTAL_UNIT'
            from req_behandle_dtl rbd
            join t_cocostscont tc on tc.NO_CONT = rbd.NO_CONT and tc.KD_CONT_TIPE is not null and tc.JNS_CONT is not null
            join m_tarif2 mt on rbd.TARIF_ID = mt.TARIF_ID 
            where rbd.ID_REQ = '$idreq'     
            union 
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('SEAL')  as 'JENIS_BIAYA',concat('175') as 'TARIF_ID', rbh.SEAL as 'CHARGE', rbh.SEAL as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'
            UNION
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('ADMINISTRASI')  as 'JENIS_BIAYA',concat('65') as 'TARIF_ID', rbh.BIAYA_ADMIN as 'CHARGE', rbh.BIAYA_ADMIN as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();

        foreach ($result as $hasil) {
            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "ADMIN" => '0',
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "TOTAL" => $hasil->TOTAL_JUMLAH,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'BEHANDLE',
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->KD_CONT_TIPE,
                    "QTY" => $detail->TOTAL_UNIT,
                    "UKR_CONT" => $detail->UK_CONT,
                    "STATUS_CONT" => $detail->JNS_CONT,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }
            //cek user dulu udah ada di css apa belum
            // $npwp= '41.316.613.3-454.000';
            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);
            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }

            // if ($namacust == null) {
            //     echo 'Error, data user belum ada di staging';
            //     die();
            // }

            $data = $headernota;
            $calculatedSubtotal = 0;
            foreach ($data['DETAIL'] as $detail) {
                $calculatedSubtotal += $detail['TOTAL'];
            }

            // Validate the SUBTOTAL
            if ($calculatedSubtotal != $data['SUBTOTAL']) {
                // echo "SUBTOTAL is valid.\n";
                // echo json_encode($headernota);
                $sendrequest = json_encode($headernota);
                echo "Gagal Kirim karena data stacking belum lengkap, lakukan sinkronisasi stacking terlebih dahulu dengan kapal " . $data['NM_KAPAL'] . " " . $data['NO_VOY'] . ".\n";
                $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('SEND BILLING CSS', '$sendrequest', '$response', '$datenow', 'N', 'N')");
                die();
            }
            // echo json_encode($headernota);


            // send fata nota 
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($headernota),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
            $datenow = date("Y-m-d H:i:s");
            $sendrequest = json_encode($headernota);
            $this->db->query("INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `XML_REQUEST`, `XML_RESPONSE`, `WK_REKAM`, `FL_NPCT1`, `FL_SENT_RIZKI`) VALUES ('SEND BILLING CSS', '$sendrequest', '$response', '$datenow', 'N', 'N')");
            //CEK APA SUDAH ADA PROFORMA DI LOG_KODE_BAYAR
            $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            $result = $this->db->query($sqlcek)->result_array();
            $jumlah = count($result);
            if ($jumlah == 0) {
                $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA)
                VALUES ('$ID_REQ');";
                $Query = $this->db->query($SQL1);

            } else {
                echo 'sudah ada data';
            }
        }
    }

    public function behandle_to_stg_json()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $arrid = explode('~', $this->input->post('id'));
        $idreq = $arrid[0];

        $sql = "SELECT concat('BHD',rbh.ID) as 'ID',
        concat(rbh.ID_REQ) as 'ID_REQ',
        rbh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rbh.NM_KAPAL,
        rbh.NO_VOY,
        rbh.BIAYA_ADMIN,
        rbh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN LAYANAN BEHANDLE COMMON AREA') as 'REMARK',
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN as 'SUBTOTAL',
        concat('11') as 'PPN_PERSEN',
        rbh.PPN,
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN+rbh.PPN as 'TOTAL_JUMLAH',
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('BEHANDLE') as 'JENIS_KEGIATAN'
        from req_behandle_hdr rbh
        join m_pelanggan mp on rbh.NPWP = mp.NPWP
        where rbh.ID_REQ = '$idreq'
        order by mp.ID_CUST desc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "SELECT distinct rbd.ID_REQ, rbd.NO_CONT, tc.KD_CONT_TIPE as 'KD_CONT_TIPE', rbd.UK_CONT, tc.JNS_CONT  as 'JNS_CONT', case 
        when rbd.JNS_KEGIATAN = 1 then 'BEHANDLE 1'
        when rbd.JNS_KEGIATAN = 2 then 'BEHANDLE 2'
        else 'JOIN'
            end as 'JENIS_BIAYA',
            case 
                when rbd.JNS_KEGIATAN = 1 then '1'
                when rbd.JNS_KEGIATAN = 2 then '2'
                else '3'
            end as 'TARIF_ID',
            rbd.TOTAL as 'CHARGE',	
            rbd.TOTAL,
            concat('1') as 'TOTAL_UNIT'
            from req_behandle_dtl rbd
            join t_cocostscont tc on tc.NO_CONT = rbd.NO_CONT and tc.KD_CONT_TIPE is not null and tc.JNS_CONT is not null
            where rbd.ID_REQ = '$idreq'     
            union 
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('SEAL')  as 'JENIS_BIAYA',concat('175') as 'TARIF_ID', rbh.SEAL as 'CHARGE', rbh.SEAL as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'
            UNION
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('ADMINISTRASI')  as 'JENIS_BIAYA',concat('65') as 'TARIF_ID', rbh.BIAYA_ADMIN as 'CHARGE', rbh.BIAYA_ADMIN as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();

        foreach ($result as $hasil) {
            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "ADMIN" => '0',
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "TOTAL" => $hasil->TOTAL_JUMLAH,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'BEHANDLE',
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->KD_CONT_TIPE,
                    "QTY" => $detail->TOTAL_UNIT,
                    "UKR_CONT" => $detail->UK_CONT,
                    "STATUS_CONT" => $detail->JNS_CONT,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }
            //cek user dulu udah ada di css apa belum
            // $npwp= '41.316.613.3-454.000';
            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);
            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }


            echo json_encode($headernota);

            // if ($namacust == null) {
            //     echo 'Error, data user belum ada di staging';
            //     die();
            // }


            // send fata nota 
            // $curl = curl_init();

            // curl_setopt_array(
            //     $curl,
            //     array(
            //         CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging/index.php/SendStg/getinv',
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => '',
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 0,
            //         CURLOPT_FOLLOWLOCATION => true,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_POSTFIELDS => json_encode($headernota),
            //         CURLOPT_HTTPHEADER => array(
            //             'Content-Type: application/json'
            //         ),
            //     )
            // );

            // $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;
            // //CEK APA SUDAH ADA PROFORMA DI LOG_KODE_BAYAR
            // $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            // $result = $this->db->query($sqlcek)->result_array();
            // $jumlah = count($result);
            // if ($jumlah == 0) {
            //     $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA)
            //     VALUES ('$ID_REQ');";
            //     $Query = $this->db->query($SQL1);
            // } else {
            //     echo 'sudah ada data';
            // }
        }
    }

    public function behandle_to_stg_test()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $arrid = explode('~', $this->input->post('id'));
        $idreq = 'BHD109591';

        $sql = "SELECT concat('BHD',rbh.ID) as 'ID',
        concat(rbh.ID_REQ) as 'ID_REQ',
        rbh.TGL_REQ,
        mp.ID_CUST,
        mp.NAMA_CUST,
        mp.NPWP,
        mp.ALAMAT,
        mp.EMAIL,
        rbh.NM_KAPAL,
        rbh.NO_VOY,
        rbh.BIAYA_ADMIN,
        rbh.NO_BL,
        concat('IDR') as 'VALUTA' ,
        concat('PEMBAYARAN LAYANAN BEHANDLE COMMON AREA') as 'REMARK',
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN as 'SUBTOTAL',
        concat('11') as 'PPN_PERSEN',
        rbh.PPN,
        rbh.SUBTOTAL+rbh.SEAL+rbh.BIAYA_ADMIN+rbh.PPN as 'TOTAL_JUMLAH',
        concat('COMMON AREA NPCT1') as 'LOKASI',
        concat('BEHANDLE') as 'JENIS_KEGIATAN'
        from req_behandle_hdr rbh
        join m_pelanggan mp on rbh.NPWP = mp.NPWP
        where rbh.ID_REQ = '$idreq'
        order by mp.ID_CUST desc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "SELECT distinct rbd.ID_REQ, rbd.NO_CONT, tc.KD_CONT_TIPE as 'KD_CONT_TIPE', rbd.UK_CONT, tc.JNS_CONT  as 'JNS_CONT', case 
        when rbd.JNS_KEGIATAN = 1 then 'BEHANDLE 1'
        when rbd.JNS_KEGIATAN = 2 then 'BEHANDLE 2'
        else 'JOIN'
            end as 'JENIS_BIAYA',
            case 
                when rbd.JNS_KEGIATAN = 1 then '1'
                when rbd.JNS_KEGIATAN = 2 then '2'
                else '3'
            end as 'TARIF_ID',
            rbd.TOTAL as 'CHARGE',	
            rbd.TOTAL,
            concat('1') as 'TOTAL_UNIT'
            from req_behandle_dtl rbd
            join t_cocostscont tc on tc.NO_CONT = rbd.NO_CONT and tc.KD_CONT_TIPE is not null and tc.JNS_CONT is not null
            where rbd.ID_REQ = '$idreq'     
            union 
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('SEAL')  as 'JENIS_BIAYA',concat('175') as 'TARIF_ID', rbh.SEAL as 'CHARGE', rbh.SEAL as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'
            UNION
            select rbh.ID_REQ, concat('') as 'NO_CONT',concat('') as 'KD_CONT_TIPE',concat('') as 'UK_CONT',concat('') as 'JNS_CONT', 
            concat('ADMINISTRASI')  as 'JENIS_BIAYA',concat('65') as 'TARIF_ID', rbh.BIAYA_ADMIN as 'CHARGE', rbh.BIAYA_ADMIN as 'TOTAL', concat('1') as 'TOTAL_UNIT'
            from req_behandle_hdr rbh where rbh.ID_REQ = '$idreq'";
        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();

        foreach ($result as $hasil) {
            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;
            $headernota = array(
                "ID" => $hasil->ID,
                "ID_REQ" => $hasil->ID_REQ,
                "TGL_REQ" => $hasil->TGL_REQ,
                "ID_CUST" => $hasil->ID_CUST,
                "NAMA_CUST" => $hasil->NAMA_CUST,
                "NPWP" => $hasil->NPWP,
                "ALAMAT" => $hasil->ALAMAT,
                "EMAIL" => $hasil->EMAIL,
                "NM_KAPAL" => $hasil->NM_KAPAL,
                "NO_VOY" => $hasil->NO_VOY,
                "NO_BL" => $hasil->NO_BL,
                "VALUTA" => $hasil->VALUTA,
                "REMARK" => $hasil->REMARK,
                "SUBTOTAL" => $hasil->SUBTOTAL,
                "ADMIN" => '0',
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => $hasil->PPN,
                "TOTAL" => $hasil->TOTAL_JUMLAH,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'BEHANDLE',
                "DETAIL" => array()
            );
            foreach ($resultdetail as $detail) {
                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->KD_CONT_TIPE,
                    "QTY" => $detail->TOTAL_UNIT,
                    "UKR_CONT" => $detail->UK_CONT,
                    "STATUS_CONT" => $detail->JNS_CONT,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => $detail->TOTAL
                );
            }
            //cek user dulu udah ada di css apa belum
            // $npwp= '41.316.613.3-454.000';
            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);
            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }


            $data = $headernota;
            $calculatedSubtotal = 0;
            foreach ($data['DETAIL'] as $detail) {
                $calculatedSubtotal += $detail['TOTAL'];
            }

            // Validate the SUBTOTAL
            if ($calculatedSubtotal != $data['SUBTOTAL']) {
                // echo "SUBTOTAL is valid.\n";
                // echo json_encode($headernota);
                echo "Gagal Kirim karena data stacking tidak lengkap, lakukan stacking terlebih dahulu dengan kapal " . $data['NM_KAPAL'] . " " . $data['NO_VOY'] . ".\n";
                die();
            }
            echo json_encode($headernota);
            // else {
            //     echo "Gagal Kirim karena data stacking tidak lengkap, lakukan stacking terlebih dahulu dengan kapal " . $data['NM_KAPAL'] . " " . $data['NO_VOY'] . ".\n";
            // }

            // if ($namacust == null) {
            //     echo 'Error, data user belum ada di staging';
            //     die();
            // }


            // send fata nota 
            // $curl = curl_init();

            // curl_setopt_array(
            //     $curl,
            //     array(
            //         CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging/index.php/SendStg/getinv',
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => '',
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 0,
            //         CURLOPT_FOLLOWLOCATION => true,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_POSTFIELDS => json_encode($headernota),
            //         CURLOPT_HTTPHEADER => array(
            //             'Content-Type: application/json'
            //         ),
            //     )
            // );

            // $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;
            // //CEK APA SUDAH ADA PROFORMA DI LOG_KODE_BAYAR
            // $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            // $result = $this->db->query($sqlcek)->result_array();
            // $jumlah = count($result);
            // if ($jumlah == 0) {
            //     $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA)
            //     VALUES ('$ID_REQ');";
            //     $Query = $this->db->query($SQL1);
            // } else {
            //     echo 'sudah ada data';
            // }
        }
    }

    public function cek_user_exist($npwp)
    {

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/get_user',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('npwp' => $npwp),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    public function sync_kode_bayar()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.SAP_KODE_BAYAR is null or tlkbs.SAP_KODE_BAYAR = '' ");
        foreach ($q->result() as $key => $value1) {
            echo 'memeriksa ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            session_start();
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/get_nota_terkirim',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('noprof' => $value1->PROFORMA),
                )
            );
            session_write_close();
            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            $decoded_json = json_decode($response, false);
            $proforma = $decoded_json[0]->PROFORMA;
            $nofaktur = $decoded_json[0]->SAP_NO_FAKTUR;
            $kodebbayar = $decoded_json[0]->SAP_KD_BAYAR;


            // echo $msg;

            $SQL = "UPDATE tpk_ipc.t_log_kode_bayar_sap
            SET SAP_KODE_BAYAR='$kodebbayar', SAP_NO_FAKTUR='$nofaktur'
            WHERE PROFORMA = '$proforma';";

            $Queryupdate = $this->db->query($SQL);
            if ($this->db->affected_rows() == 1) {
                echo 'Sukses Ambil KODE BAYAR';
            } else {
                echo 'Ada kesalahan/belum ada data';
            }
            echo "\r\n";
        }
    }

    public function sync_kode_bayar_new()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $QUERY = "SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.SAP_KODE_BAYAR is null or tlkbs.SAP_KODE_BAYAR = ''";
        $Query = $this->db->query($QUERY);
        $result = $Query->result();
        echo json_encode($result);
    }

    public function sync_tgl_pelunasan()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.SAP_TGL_PELUNASAN is null");
        foreach ($q->result() as $key => $value1) {
            echo 'memeriksa pelunasan ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            session_start();
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://10.1.5.49/tpk_ipc/staging_dev/index.php/SendStg/get_nota_terkirim',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('noprof' => $value1->PROFORMA),
                )
            );
            session_write_close();
            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            echo "\r\n";

            $decoded_json = json_decode($response, false);
            $proforma = $decoded_json[0]->PROFORMA;
            $nofaktur = $decoded_json[0]->SAP_NO_FAKTUR;
            $kodebbayar = $decoded_json[0]->SAP_KD_BAYAR;
            $pelunasan = $decoded_json[0]->SAP_TGL_PELUNASAN;
            // echo $pelunasan;
            if ($pelunasan == null) {
                echo 'nota ' . $proforma . ' belum lunas';
                echo "\r\n";
            } else {
                echo 'nota ' . $proforma . ' sudah lunas di tgl ' . $pelunasan;
                $SQL = "UPDATE tpk_ipc.t_log_kode_bayar_sap
                SET SAP_TGL_PELUNASAN='$pelunasan'
                WHERE PROFORMA = '$proforma';";

                $Queryupdate = $this->db->query($SQL);
                if ($this->db->affected_rows() == 1) {
                    echo 'Sukses ';
                } else {
                    echo 'Ada kesalahan';
                }
                echo "\r\n";
            }
        }
    }
    public function sync_nota_bos()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.UPDATE_NOTA_BOS = 0 AND SAP_TGL_PELUNASAN is null");
        foreach ($q->result() as $key => $value1) {
            echo 'Memproses Nota ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            $header = substr($value1->PROFORMA, 0, 3);
            $id = substr($value1->PROFORMA, 3);
            $nomor = $value1->SAP_NO_FAKTUR;
            $SAP_TGL_PELUNASAN = date("Y-m-d h:i:s");
            if ($nomor == null) {
                echo 'data belum terbit';
                echo "\r\n";
            } else {
                if ($header == 'BHD') {
                    echo 'jenis nota adalah behandle ' . $id;
                    echo "\r\n";
                    $query_update = "UPDATE req_behandle_hdr set NO_FAKTUR = '$nomor', TGL_FAKTUR = '$SAP_TGL_PELUNASAN', 
                    NO_NOTA_BEHANDLE = '$nomor', TGL_NOTA = '$SAP_TGL_PELUNASAN' where ID_REQ = '$value1->PROFORMA'";
                    // echo $query_update;
                    $Queryupdate = $this->db->query($query_update);

                    echo "\r\n";
                } else {
                    echo 'jenis nota adalah delivery/ext ' . $id;
                    echo "\r\n";
                    $query_update = "UPDATE req_delivery_hdr set NO_FAKTUR = '$nomor', TGL_FAKTUR = '$SAP_TGL_PELUNASAN', NO_NOTA_DELIVERY = '$nomor', TGL_NOTA = '$SAP_TGL_PELUNASAN' where ID_REQ = '$value1->PROFORMA'";
                    // echo $query_update;
                    $Queryupdate = $this->db->query($query_update);

                    echo "\r\n";
                }
            }
        }
    }
    public function sync_kode_bayar_nota()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap A where A.SAP_TGL_PELUNASAN is null");
        foreach ($q->result() as $key => $value1) {
            echo 'Memproses kode bayar nota ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            $iddata = $value1->id;
            $header = substr($value1->PROFORMA, 0, 3);
            $id = substr($value1->PROFORMA, 3);
            $VAID = $value1->SAP_KODE_BAYAR;
            $SAP_TGL_PELUNASAN = $value1->SAP_TGL_PELUNASAN;
            if ($VAID == null) {
                echo 'kode bayar nota ' . $value1->PROFORMA . ' belum terbit';
                echo "\r\n";
            } else {
                if ($header == 'BHD') {
                    echo 'jenis nota adalah behandle ' . $id;
                    echo "\r\n";
                    $query_update = "UPDATE req_behandle_hdr set VAID = '$VAID', BANK_ID = '1' where ID_REQ = '$value1->PROFORMA'";
                    // echo $query_update;
                    $Queryupdate = $this->db->query($query_update);
                    $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.UPDATE_KODE_BAYAR = 'Y' where A.id = '$iddata'");
                    echo "\r\n";
                } else {
                    echo 'jenis nota adalah delivery/ext ' . $id;
                    echo "\r\n";
                    $query_update = "UPDATE req_delivery_hdr set VAID = '$VAID', BANK_ID = '1' where ID_REQ = '$value1->PROFORMA'";
                    $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.UPDATE_KODE_BAYAR = 'Y' where A.id = '$iddata'");
                    // echo $query_update;
                    $Queryupdate = $this->db->query($query_update);

                    echo "\r\n";
                }
            }
        }
    }

    public function send_payment_notif_ihub()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from log_payment_notify a where a.processed = 'N'");
        foreach ($q->result() as $key => $value1) {
            $data_payment = $value1->string_recieved;
            $json = json_decode($data_payment, true);
            $billingid = $json['billingId'];
            $paymentId = $json['paymentId'];
            $journalNo = $json['journalNo'];
            $journalDate = $json['journalDate'];
            echo "\r\n";

        }
    }

    public function create_gatepass_delivery_bypass()
    {
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.SAP_TGL_PELUNASAN is not null and create_gatepass_delivery = 'N'");
        foreach ($q->result() as $key => $value1) {
            echo 'Memproses kode bayar nota ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            $iddata = $value1->id;
            $proforma = $value1->PROFORMA;
            $header = substr($value1->PROFORMA, 0, 3);
            if ($header == 'BHD') {
                echo 'NOTA BEHANDLE';
                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                echo "\r\n";
            } else if ($header == 'DEL') {
                echo 'nota delivery lunas, cek apakah behandle sudah dibayar';
                echo "\r\n";
                $ceknodoksql = $this->db->query("SELECT NO_DOK, EXPIRED from req_delivery_hdr rdh where ID_REQ = '$proforma'");
                foreach ($ceknodoksql->result() as $key => $value2) {
                    $ceknodok = $value2->NO_DOK;
                    $cek_exp = $value2->EXPIRED;
                    //cek apasudah bayar behandle

                    //backup lama
                    // $SQLInsGatePAss = "SELECT A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                    // FROM t_permit_hdr A
                    // INNER JOIN t_permit_cont B ON A.ID = B.ID
                    // LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                    // LEFT JOIN t_spk D ON C.ID = D.ID
                    // LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                    // INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                    // INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                    // WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT NULL
                    // GROUP BY G.NO_CONT";
                    $SQLInsGatePAss = "SELECT * from ( 
                        SELECT distinct A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                                FROM t_permit_hdr A
                                INNER JOIN t_permit_cont B ON A.ID = B.ID
                                LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                                LEFT JOIN t_spk D ON C.ID = D.ID
                                LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                                INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                                INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                                WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' 
                                AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT null 
                                order by D.NO_SPK desc) AA
                                group by AA.NO_CONT";

                    $result = $this->db->query($SQLInsGatePAss)->result_array();
                    $totalCont = count($result);
                    // echo $totalCont;
                    for ($i = 0; $i < $totalCont; $i++) {
                        $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
                        $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
                        if (count($resultGatePass) == 0) {
                            $tmpData = array(
                                "JNS_DOK" => $result[$i]['JNS_DOK'],
                                "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                "STATUS" => $result[$i]['STATUS'],
                                "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                "NO_CONT" => $result[$i]['NO_CONT'],
                                "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                "EXPIRED_DATE" => $cek_exp,
                                "NO_SPK" => $result[$i]['NO_SPK'],
                                "WK_REK" => date('Y-m-d H:i:s')
                            );
                            $this->db->insert('t_gatepass', $tmpData);
                        } else {
                            $tmpData = array(
                                "JNS_DOK" => $result[$i]['JNS_DOK'],
                                "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                "STATUS" => $result[$i]['STATUS'],
                                "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                "NO_CONT" => $result[$i]['NO_CONT'],
                                "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                "EXPIRED_DATE" => $cek_exp,
                                "NO_SPK" => $result[$i]['NO_SPK'],
                                "WK_REK" => date('Y-m-d H:i:s')
                            );
                            $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                            $this->db->update('t_gatepass', $tmpData);
                        }
                        // $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                        // $this->db->update('t_permit_cont',array('FL_GATEPASS' => 'Y'));
                    }
                }
                echo "\r\n";
                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");

            }
        }
    }

    public function create_gatepass_delivery()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where tlkbs.SAP_TGL_PELUNASAN is not null and create_gatepass_delivery = 'N'");
        foreach ($q->result() as $key => $value1) {
            echo 'Memproses kode bayar nota ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            $iddata = $value1->id;
            $proforma = $value1->PROFORMA;
            $header = substr($value1->PROFORMA, 0, 3);
            if ($header == 'BHD') {
                echo 'NOTA BEHANDLE';
                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                echo "\r\n";
            } else if ($header == 'DEL') {
                echo 'nota delivery lunas, cek apakah behandle sudah dibayar';
                echo "\r\n";
                $ceknodoksql = $this->db->query("SELECT NO_DOK, EXPIRED from req_delivery_hdr rdh where ID_REQ = '$proforma'");
                foreach ($ceknodoksql->result() as $key => $value2) {
                    $ceknodok = $value2->NO_DOK;
                    $cek_exp = $value2->EXPIRED;
                    //cek apasudah bayar behandle

                    $ceknodoksql1 = $this->db->query("SELECT count(A.ID_REQ) as 'NOTA' from (SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and b.SAP_TGL_PELUNASAN is null
                    union
                    SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    join t_gatepass c on c.NO_DOK = rdh.NO_DOK and c.TGL_DOK = rdh.TGL_DOK
                    join t_spk d on c.NO_SPK = d.NO_SPK
                    join req_behandle_hdr e on e.NO_DOK = d.NO_DOK and e.TGL_DOK = d.TGL_DOK
                    join t_log_kode_bayar_sap f on e.ID_REQ = f.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and f.SAP_TGL_PELUNASAN is null) A");


                    foreach ($ceknodoksql1->result() as $key => $value2) {
                        $cekproforma = $value2->NOTA;
                    }
                    if ($cekproforma != 0) {
                        echo 'ada nota belum dibayar, gagal buat gatepass';
                    } else {
                        // proses buat gatepass
                        $SQLInsGatePAss = "SELECT * from ( 
                            SELECT distinct A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                                    FROM t_permit_hdr A
                                    INNER JOIN t_permit_cont B ON A.ID = B.ID
                                    LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                                    LEFT JOIN t_spk D ON C.ID = D.ID
                                    LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                                    INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                                    INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                                    WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' 
                                    AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT null 
                                    order by D.NO_SPK desc) AA
                                    group by AA.NO_CONT";

                        $result = $this->db->query($SQLInsGatePAss)->result_array();
                        $totalCont = count($result);
                        // echo $totalCont;
                        for ($i = 0; $i < $totalCont; $i++) {
                            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
                            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
                            if (count($resultGatePass) == 0) {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->insert('t_gatepass', $tmpData);
                            } else {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                                $this->db->update('t_gatepass', $tmpData);


                                echo "\r\n";
                                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                            }

                        }

                    }
                }

            } else if ($header == 'EXT') {

                echo 'nota delivery lunas, cek apakah behandle sudah dibayar';
                echo "\r\n";
                $ceknodoksql = $this->db->query("SELECT NO_DOK, EXPIRED from req_delivery_hdr rdh where ID_REQ = '$proforma'");
                foreach ($ceknodoksql->result() as $key => $value2) {
                    $ceknodok = $value2->NO_DOK;
                    $cek_exp = $value2->EXPIRED;
                    //cek apasudah bayar behandle

                    $ceknodoksql1 = $this->db->query("SELECT count(A.ID_REQ) as 'NOTA' from (SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and b.SAP_TGL_PELUNASAN is null
                    union
                    SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    join t_gatepass c on c.NO_DOK = rdh.NO_DOK and c.TGL_DOK = rdh.TGL_DOK
                    join t_spk d on c.NO_SPK = d.NO_SPK
                    join req_behandle_hdr e on e.NO_DOK = d.NO_DOK and e.TGL_DOK = d.TGL_DOK
                    join t_log_kode_bayar_sap f on e.ID_REQ = f.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and f.SAP_TGL_PELUNASAN is null) A");


                    foreach ($ceknodoksql1->result() as $key => $value2) {
                        $cekproforma = $value2->NOTA;
                    }
                    if ($cekproforma != 0) {
                        echo 'ada nota belum dibayar, gagal buat gatepass';
                    } else {
                        $SQLInsGatePAss = "SELECT * from ( 
                            SELECT distinct A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                                    FROM t_permit_hdr A
                                    INNER JOIN t_permit_cont B ON A.ID = B.ID
                                    LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                                    LEFT JOIN t_spk D ON C.ID = D.ID
                                    LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                                    INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                                    INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                                    WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' 
                                    AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT null 
                                    order by D.NO_SPK desc) AA
                                    group by AA.NO_CONT";
                        $result = $this->db->query($SQLInsGatePAss)->result_array();
                        $totalCont = count($result);
                        // echo $totalCont;
                        for ($i = 0; $i < $totalCont; $i++) {
                            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
                            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
                            if (count($resultGatePass) == 0) {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->insert('t_gatepass', $tmpData);
                            } else {
                                $tmpData = array(
                                    // "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    // "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    // "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    // "STATUS" => $result[$i]['STATUS'],
                                    // "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    // "NO_CONT" => $result[$i]['NO_CONT'],
                                    // "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    // "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    // "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    // "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    // "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    // "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );

                                echo json_encode($tmpData);
                                $this->db->where(array('NO_DOK' => $result[$i]['NO_DOK_INOUT'], 'NO_CONT' => $result[$i]['NO_CONT']));
                                $this->db->update('t_gatepass', $tmpData);

                                echo "\r\n";
                                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                            }
                        }

                    }
                }

            }
        }
    }

    public function create_gatepass_delivery_post()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $q = $this->db->query("SELECT * from t_log_kode_bayar_sap tlkbs where PROFORMA = 'EXT148606'");
        foreach ($q->result() as $key => $value1) {
            echo 'Memproses kode bayar nota ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            $iddata = $value1->id;
            $proforma = $value1->PROFORMA;
            $header = substr($value1->PROFORMA, 0, 3);
            if ($header == 'BHD') {
                echo 'NOTA BEHANDLE';
                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                echo "\r\n";
            } else if ($header == 'DEL') {
                echo 'nota delivery lunas, cek apakah behandle sudah dibayar';
                echo "\r\n";
                $ceknodoksql = $this->db->query("SELECT NO_DOK, EXPIRED from req_delivery_hdr rdh where ID_REQ = '$proforma'");
                foreach ($ceknodoksql->result() as $key => $value2) {
                    $ceknodok = $value2->NO_DOK;
                    $cek_exp = $value2->EXPIRED;
                    //cek apasudah bayar behandle

                    $ceknodoksql1 = $this->db->query("SELECT count(A.ID_REQ) as 'NOTA' from (SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and b.SAP_TGL_PELUNASAN is null
                    union
                    SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    join t_gatepass c on c.NO_DOK = rdh.NO_DOK and c.TGL_DOK = rdh.TGL_DOK
                    join t_spk d on c.NO_SPK = d.NO_SPK
                    join req_behandle_hdr e on e.NO_DOK = d.NO_DOK and e.TGL_DOK = d.TGL_DOK
                    join t_log_kode_bayar_sap f on e.ID_REQ = f.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and f.SAP_TGL_PELUNASAN is null) A");


                    foreach ($ceknodoksql1->result() as $key => $value2) {
                        $cekproforma = $value2->NOTA;
                    }
                    if ($cekproforma != 0) {
                        echo 'ada nota belum dibayar, gagal buat gatepass';
                    } else {
                        // proses buat gatepass
                        $SQLInsGatePAss = "SELECT * from ( 
                            SELECT distinct A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                                    FROM t_permit_hdr A
                                    INNER JOIN t_permit_cont B ON A.ID = B.ID
                                    LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                                    LEFT JOIN t_spk D ON C.ID = D.ID
                                    LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                                    INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                                    INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                                    WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' 
                                    AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT null 
                                    order by D.NO_SPK desc) AA
                                    group by AA.NO_CONT";

                        $result = $this->db->query($SQLInsGatePAss)->result_array();
                        $totalCont = count($result);
                        // echo $totalCont;
                        for ($i = 0; $i < $totalCont; $i++) {
                            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
                            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
                            if (count($resultGatePass) == 0) {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->insert('t_gatepass', $tmpData);
                            } else {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                                $this->db->update('t_gatepass', $tmpData);


                                echo "\r\n";
                                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                            }

                        }

                    }
                }

            } else if ($header == 'EXT') {

                echo 'nota delivery lunas, cek apakah behandle sudah dibayar';
                echo "\r\n";
                $ceknodoksql = $this->db->query("SELECT NO_DOK, EXPIRED from req_delivery_hdr rdh where ID_REQ = '$proforma'");
                foreach ($ceknodoksql->result() as $key => $value2) {
                    $ceknodok = $value2->NO_DOK;
                    $cek_exp = $value2->EXPIRED;
                    //cek apasudah bayar behandle

                    $ceknodoksql1 = $this->db->query("SELECT count(A.ID_REQ) as 'NOTA' from (SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and b.SAP_TGL_PELUNASAN is null
                    union
                    SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
                    join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
                    join t_gatepass c on c.NO_DOK = rdh.NO_DOK and c.TGL_DOK = rdh.TGL_DOK
                    join t_spk d on c.NO_SPK = d.NO_SPK
                    join req_behandle_hdr e on e.NO_DOK = d.NO_DOK and e.TGL_DOK = d.TGL_DOK
                    join t_log_kode_bayar_sap f on e.ID_REQ = f.PROFORMA
                    where rdh.NO_DOK = '$ceknodok'
                    and f.SAP_TGL_PELUNASAN is null) A");


                    foreach ($ceknodoksql1->result() as $key => $value2) {
                        $cekproforma = $value2->NOTA;
                    }
                    if ($cekproforma != 0) {
                        echo 'ada nota belum dibayar, gagal buat gatepass';
                        die();
                    } else {
                        $SQLInsGatePAss = "SELECT * from ( 
                            SELECT distinct A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
                                    FROM t_permit_hdr A
                                    INNER JOIN t_permit_cont B ON A.ID = B.ID
                                    LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
                                    LEFT JOIN t_spk D ON C.ID = D.ID
                                    LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
                                    INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
                                    INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
                                    WHERE  F.ID_REQ='$proforma' AND A.NO_DOK_INOUT = '$ceknodok' 
                                    AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT null 
                                    order by D.NO_SPK desc) AA
                                    group by AA.NO_CONT";
                        $result = $this->db->query($SQLInsGatePAss)->result_array();
                        $totalCont = count($result);
                        // echo $totalCont;
                        for ($i = 0; $i < $totalCont; $i++) {
                            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
                            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
                            if (count($resultGatePass) == 0) {
                                $tmpData = array(
                                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    "STATUS" => $result[$i]['STATUS'],
                                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    "NO_CONT" => $result[$i]['NO_CONT'],
                                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );
                                $this->db->insert('t_gatepass', $tmpData);
                            } else {
                                $tmpData = array(
                                    // "JNS_DOK" => $result[$i]['JNS_DOK'],
                                    // "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                                    // "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                                    // "STATUS" => $result[$i]['STATUS'],
                                    // "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                                    // "NO_CONT" => $result[$i]['NO_CONT'],
                                    // "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                                    // "NPWP" => $result[$i]['ID_CONSIGNEE'],
                                    // "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                                    // "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                                    // "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                                    "EXPIRED_DATE" => $cek_exp,
                                    // "NO_SPK" => $result[$i]['NO_SPK'],
                                    "WK_REK" => date('Y-m-d H:i:s')
                                );

                                echo json_encode($tmpData);
                                $this->db->where(array('NO_DOK' => $result[$i]['NO_DOK_INOUT'], 'NO_CONT' => $result[$i]['NO_CONT']));
                                $this->db->update('t_gatepass', $tmpData);

                                echo "\r\n";
                                $q = $this->db->query("UPDATE t_log_kode_bayar_sap A set A.create_gatepass_delivery = 'Y' where A.id = '$iddata'");
                            }
                        }

                    }
                }

            }
        }
    }

    public function tesphp(){
       $curl = curl_init();

$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
        <soapenv:Header/>
        <soapenv:Body>
        <ser:getContainerPeriksaOnRequest>
            <!--Optional:-->
            <USERNAME>wster3</USERNAME>
            <!--Optional:-->
            <PASSWORD>pass123abc</PASSWORD>
            <!--Optional:-->
            <INSTANSI></INSTANSI>
            <!--Optional:-->
            <NO_AJU>20120363063D20241217000006</NO_AJU>
            <!--Optional:-->
            <TGL_AJU></TGL_AJU>
            <!--Optional:-->
            <NO_DOC></NO_DOC>
            <!--Optional:-->
            <TGL_DOC></TGL_DOC>
            <!--Optional:-->
            <JNS_DOC></JNS_DOC>
        </ser:getContainerPeriksaOnRequest>
    </soapenv:Body>
    </soapenv:Envelope>';
// var_dump($xml);
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.insw.go.id/webservice-prod/ssm-qc',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>$xml,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/xml',
        'Cookie: dtCookie=v_4_srv_8_sn_4F53128D6162A4D9E3869E2DED1A8A65_perc_100000_ol_0_mul_1_app-3A9c242b3160c53254_0; cookiesession1=678B290321AE5B5741FABA65FC7CB615'
    ),
));

$response = curl_exec($curl);
echo $response;
curl_close($curl);
    }
}

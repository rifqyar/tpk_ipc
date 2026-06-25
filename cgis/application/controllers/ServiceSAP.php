<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceSAP extends CI_Controller
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

    public function token_validation($data) {}

    public function buat_json()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $idreq = $_POST['ID_REQ'];;

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
                    CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/getinv',
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


    public function delivery_to_stg_no_diskon()
    {
        // INI YANG ASLI GAK PAKE DISKON
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
                    CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => false,
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
                // echo 'sudah ada data';
            }
        }
    }

    public function delivery_to_stg()
    {
        //INI YANG ADA IMPLMENTASI DISKON
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

        // PERIODE PROMO
        $promo_start = strtotime('2026-03-13');
        $promo_end   = strtotime('2026-03-29');
        $promo_diskon = 0.50;

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
            concat('PEMBAYARAN PENUMPUKAN COMMON AREA (DISKON 50% MAR 2026)') as 'REMARK',
            concat('11') as 'PPN_PERSEN',
            concat('COMMON AREA NPCT1') as 'LOKASI',
            concat('DELIVERY') as 'JENIS_KEGIATAN'
            from req_delivery_hdr rdh
            JOIN m_pelanggan mp 
            ON REPLACE(REPLACE(mp.NPWP,'.',''),'-','') = REPLACE(REPLACE(rdh.NPWP,'.',''),'-','')
            where ID_REQ = '$idreq'
            order by mp.ID_CUST asc limit 1";

        $Query = $this->db->query($sql);
        $result = $Query->result();

        $sqldetail = "
            SELECT rdd.*, mt.JENIS_BIAYA
            FROM req_delivery_dtl rdd
            LEFT JOIN m_tarif2 mt ON rdd.TARIF_ID = mt.TARIF_ID
            WHERE ID_REQ = '$idreq'
        ";

        $Querydetail = $this->db->query($sqldetail);
        $resultdetail = $Querydetail->result();

        foreach ($result as $hasil) {

            $npwp = $hasil->NPWP;
            $ID_REQ = $hasil->ID_REQ;

            $subtotal = 0;
            $keterangan_log = "";

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
                "SUBTOTAL" => 0,
                "PPN_PERSEN" => $hasil->PPN_PERSEN,
                "PPN" => 0,
                "ADMIN" => '0',
                "TOTAL" => 0,
                "LOKASI" => $hasil->LOKASI,
                "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
                "SERVICE_CODE" => 'DELIVERY',
                "DETAIL" => array()
            );

            foreach ($resultdetail as $detail) {

                // default (non penumpukan tetap pakai total asli)
                $total = (float)$detail->TOTAL;

                if ($detail->JENIS_BIAYA == 'PENUMPUKAN') {

                    // =========================
                    // HITUNG PENUMPUKAN + NHI
                    // =========================
                    $total_penumpukan =
                        (float)$detail->TOTAL_M2 +
                        (float)$detail->TOTAL_M3 +
                        (float)$detail->TOTAL_M4;

                    // NHI (tidak kena diskon)
                    $total_nhi = (float)$detail->TOTAL_NHI4;

                    $diskon_total = 0;

                    $periode = array(

                        array(
                            "start" => $detail->M2_START_DATE,
                            "end" => $detail->M2_END_DATE,
                            "hari" => $detail->SELISIH_M2,
                            "total" => $detail->TOTAL_M2
                        ),

                        array(
                            "start" => $detail->M3_START_DATE,
                            "end" => $detail->M3_END_DATE,
                            "hari" => $detail->SELISIH_M3,
                            "total" => $detail->TOTAL_M3
                        ),

                        array(
                            "start" => $detail->M4_START_DATE,
                            "end" => $detail->M4_END_DATE,
                            "hari" => $detail->SELISIH_M4,
                            "total" => $detail->TOTAL_M4
                        )

                    );

                    foreach ($periode as $p) {

                        if ($p["start"] == null) continue;
                        if ($p["start"] == "0000-00-00") continue;
                        if ($p["hari"] <= 0) continue;
                        if ($p["total"] <= 0) continue;

                        $start = strtotime($p["start"]);
                        $end   = strtotime($p["end"]);

                        $overlap_start = max($start, $promo_start);
                        $overlap_end   = min($end, $promo_end);

                        if ($overlap_start <= $overlap_end) {

                            $hari_diskon = floor(($overlap_end - $overlap_start) / 86400) + 1;

                            $tarif_harian = $p["total"] / $p["hari"];

                            $diskon = $tarif_harian * $promo_diskon * $hari_diskon;

                            $diskon_total += $diskon;

                            $keterangan_log .= "[KONTAINER " . $detail->NO_CONT .
                                " DISKON " . $hari_diskon .
                                " HARI (" .
                                date('d-m-Y', $overlap_start) .
                                " - " .
                                date('d-m-Y', $overlap_end) .
                                ") NORMAL " .
                                round($tarif_harian) .
                                " DISKON " .
                                round($tarif_harian * (1 - $promo_diskon)) .
                                " POTONGAN " .
                                round($diskon) .
                                "] ";
                        }
                    }

                    // =========================
                    // FINAL TOTAL (FIX DI SINI)
                    // =========================
                    $total_penumpukan_after_diskon = max(0, $total_penumpukan - $diskon_total);

                    // NHI tetap full (tidak kena diskon)
                    $total = $total_penumpukan_after_diskon + $total_nhi;

                    // LOG NHI
                    if (!empty($detail->TOTAL_NHI4) && $detail->TOTAL_NHI4 > 0) {
                        $keterangan_log .= "[KONTAINER " . $detail->NO_CONT .
                            " NHI " . $detail->SELISIH_NHI . " HARI TIDAK DISKON (" .
                            date('d-m-Y', strtotime($detail->NHI_START_DATE)) .
                            " - " .
                            date('d-m-Y', strtotime($detail->NHI_END_DATE)) .
                            ") TOTAL " .
                            round($detail->TOTAL_NHI4) .
                            "] ";
                    }
                }

                $subtotal += $total;

                $headernota['DETAIL'][] = array(
                    "ID_REQ" => $detail->ID_REQ,
                    "NO_CONT" => $detail->NO_CONT,
                    "ISO_CODE" => $detail->ISO_CODE,
                    "QTY" => $detail->TOTAL_UNIT ? $detail->TOTAL_UNIT : 1,
                    "UKR_CONT" => $detail->UKR_CONT,
                    "STATUS_CONT" => $detail->STATUS,
                    "SERVICE_CODE" => $detail->TARIF_ID,
                    "JENIS_BIAYA" => $detail->JENIS_BIAYA,
                    "CHARGE" => $detail->CHARGE,
                    "TOTAL" => round($total)
                );
            }

            $ppn = round($subtotal * 0.11);
            $total_invoice = $subtotal + $ppn;

            $headernota["SUBTOTAL"] = $subtotal;
            $headernota["PPN"] = $ppn;
            $headernota["TOTAL"] = $total_invoice;
            $headernota["LOG_KETERANGAN"] = $keterangan_log;

            $payload = json_encode($headernota);

            // LOG PROMO DISKON
            $this->db->query("
                INSERT INTO log_send_portal
                (id_request,payload,keterangan,created_at)
                VALUES
                ('$ID_REQ','" . $this->db->escape_str($payload) . "','" . $this->db->escape_str($keterangan_log) . "',NOW())
            ");

            $data_user = $this->cek_user_exist($npwp);
            $array = json_decode($data_user, true);

            foreach ($array as $values) {
                $namacust = $values['NAMA'];
                $alamatcust = $values['ALAMAT'];
                $kotacust = $values['KOTA'];
                $telpcust = $values['TELEPON'];
            }

            // =====================
            // MODIFIKASI CURL DENGAN HARD-TIMEOUT
            // =====================
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_CONNECTTIMEOUT => 20, // Maksimal 10 detik untuk proses TCP/SSL Handshake
                    CURLOPT_TIMEOUT => 25,        // Maksimal 15 detik eksekusi keseluruhan
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);
            $curl_error = curl_error($curl);

            curl_close($curl);
            $datenow = date("Y-m-d H:i:s");

            $response_to_frontend = $response;
            $response_to_db = $response;
            if ($response === false) {
                $response_to_frontend = "Gagal terhubung ke server CSS. Jaringan sedang sibuk. Silakan coba beberapa saat lagi.";

                $response_to_db = json_encode(array(
                    "status" => false,
                    "message" => "CURL FAILED",
                    "debug_error" => $curl_error
                ));
            }

            // Echo response khusus frontend ke user
            echo $response_to_frontend;

            // Insert log ke database menggunakan response_to_db (berisi error teknis jika gagal)
            $this->db->query("
                INSERT INTO `tpk_ipc`.`log_services`
                (`METHOD`,`XML_REQUEST`,`XML_RESPONSE`,`WK_REKAM`,`FL_NPCT1`,`FL_SENT_RIZKI`)
                VALUES
                ('SEND BILLING CSS','$payload','" . $this->db->escape_str($response_to_db) . "','$datenow','N','N')
            ");

            $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
            $result = $this->db->query($sqlcek)->result_array();
            $jumlah = count($result);

            if ($jumlah == 0) {
                $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA) VALUES ('$ID_REQ')";
                $this->db->query($SQL1);
            }
        }
    }

    // BACKUP
    // public function delivery_to_stg()
    // {
    //     //INI YANG ADA IMPLMENTASI DISKON
    //     header("Access-Control-Allow-Origin: *");
    //     header("Access-Control-Allow-Headers: *");
    //     header('Content-Type: application/json');

    //     $arrid = explode('~', $this->input->post('id'));
    //     $idreq = $arrid[0];

    //     $header = substr($idreq, 0, 3);
    //     if ($header == 'DEL') {
    //         $jenis_req = 'DEL';
    //     } else {
    //         $jenis_req = 'EXT';
    //     }

    //     // PERIODE PROMO
    //     $promo_start = strtotime('2026-03-13');
    //     $promo_end   = strtotime('2026-03-29');
    //     $promo_diskon = 0.50;

    //     $sql = "SELECT
    //         concat('DEL',rdh.ID) as 'ID',
    //         concat(rdh.ID_REQ) as 'ID_REQ',
    //         rdh.TGL_REQ,
    //         mp.ID_CUST,
    //         mp.NAMA_CUST,
    //         mp.NPWP,
    //         mp.ALAMAT,
    //         mp.EMAIL,
    //         rdh.NM_KAPAL,
    //         rdh.NO_VOY,
    //         rdh.NO_BL,
    //         concat('IDR') as 'VALUTA' ,
    //         concat('PEMBAYARAN PENUMPUKAN COMMON AREA (DISKON 50% MAR 2026)') as 'REMARK',
    //         concat('11') as 'PPN_PERSEN',
    //         concat('COMMON AREA NPCT1') as 'LOKASI',
    //         concat('DELIVERY') as 'JENIS_KEGIATAN'
    //         from req_delivery_hdr rdh
    //         JOIN m_pelanggan mp 
    //         ON REPLACE(REPLACE(mp.NPWP,'.',''),'-','') = REPLACE(REPLACE(rdh.NPWP,'.',''),'-','')
    //         where ID_REQ = '$idreq'
    //         order by mp.ID_CUST asc limit 1";

    //     $Query = $this->db->query($sql);
    //     $result = $Query->result();

    //     $sqldetail = "
    //         SELECT rdd.*, mt.JENIS_BIAYA
    //         FROM req_delivery_dtl rdd
    //         LEFT JOIN m_tarif2 mt ON rdd.TARIF_ID = mt.TARIF_ID
    //         WHERE ID_REQ = '$idreq'
    //     ";

    //     $Querydetail = $this->db->query($sqldetail);
    //     $resultdetail = $Querydetail->result();

    //     foreach ($result as $hasil) {

    //         $npwp = $hasil->NPWP;
    //         $ID_REQ = $hasil->ID_REQ;

    //         $subtotal = 0;
    //         $keterangan_log = "";

    //         $headernota = array(
    //             "ID" => $hasil->ID,
    //             "ID_REQ" => $hasil->ID_REQ,
    //             "TGL_REQ" => $hasil->TGL_REQ,
    //             "ID_CUST" => $hasil->ID_CUST,
    //             "NAMA_CUST" => $hasil->NAMA_CUST,
    //             "NPWP" => $hasil->NPWP,
    //             "ALAMAT" => $hasil->ALAMAT,
    //             "EMAIL" => $hasil->EMAIL,
    //             "NM_KAPAL" => $hasil->NM_KAPAL,
    //             "NO_VOY" => $hasil->NO_VOY,
    //             "NO_BL" => $hasil->NO_BL,
    //             "VALUTA" => $hasil->VALUTA,
    //             "REMARK" => $hasil->REMARK,
    //             "SUBTOTAL" => 0,
    //             "PPN_PERSEN" => $hasil->PPN_PERSEN,
    //             "PPN" => 0,
    //             "ADMIN" => '0',
    //             "TOTAL" => 0,
    //             "LOKASI" => $hasil->LOKASI,
    //             "JENIS_KEGIATAN" => $hasil->JENIS_KEGIATAN,
    //             "SERVICE_CODE" => 'DELIVERY',
    //             "DETAIL" => array()
    //         );

    //         foreach ($resultdetail as $detail) {

    //             // default (non penumpukan tetap pakai total asli)
    //             $total = (float)$detail->TOTAL;

    //             if ($detail->JENIS_BIAYA == 'PENUMPUKAN') {

    //                 // =========================
    //                 // HITUNG PENUMPUKAN + NHI
    //                 // =========================
    //                 $total_penumpukan = 
    //                     (float)$detail->TOTAL_M2 +
    //                     (float)$detail->TOTAL_M3 +
    //                     (float)$detail->TOTAL_M4;

    //                 // NHI (tidak kena diskon)
    //                 $total_nhi = (float)$detail->TOTAL_NHI4;

    //                 $diskon_total = 0;

    //                 $periode = array(

    //                     array(
    //                         "start"=>$detail->M2_START_DATE,
    //                         "end"=>$detail->M2_END_DATE,
    //                         "hari"=>$detail->SELISIH_M2,
    //                         "total"=>$detail->TOTAL_M2
    //                     ),

    //                     array(
    //                         "start"=>$detail->M3_START_DATE,
    //                         "end"=>$detail->M3_END_DATE,
    //                         "hari"=>$detail->SELISIH_M3,
    //                         "total"=>$detail->TOTAL_M3
    //                     ),

    //                     array(
    //                         "start"=>$detail->M4_START_DATE,
    //                         "end"=>$detail->M4_END_DATE,
    //                         "hari"=>$detail->SELISIH_M4,
    //                         "total"=>$detail->TOTAL_M4
    //                     )

    //                 );

    //                 foreach ($periode as $p) {

    //                     if ($p["start"] == null) continue;
    //                     if ($p["start"] == "0000-00-00") continue;
    //                     if ($p["hari"] <= 0) continue;
    //                     if ($p["total"] <= 0) continue;

    //                     $start = strtotime($p["start"]);
    //                     $end   = strtotime($p["end"]);

    //                     $overlap_start = max($start,$promo_start);
    //                     $overlap_end   = min($end,$promo_end);

    //                     if ($overlap_start <= $overlap_end) {

    //                         $hari_diskon = floor(($overlap_end-$overlap_start)/86400)+1;

    //                         $tarif_harian = $p["total"] / $p["hari"];

    //                         $diskon = $tarif_harian * $promo_diskon * $hari_diskon;

    //                         $diskon_total += $diskon;

    //                         $keterangan_log .= "[KONTAINER ".$detail->NO_CONT.
    //                             " DISKON ".$hari_diskon.
    //                             " HARI (".
    //                             date('d-m-Y',$overlap_start).
    //                             " - ".
    //                             date('d-m-Y',$overlap_end).
    //                             ") NORMAL ".
    //                             round($tarif_harian).
    //                             " DISKON ".
    //                             round($tarif_harian*(1-$promo_diskon)).
    //                             " POTONGAN ".
    //                             round($diskon).
    //                         "] ";
    //                     }
    //                 }

    //                 // =========================
    //                 // FINAL TOTAL (FIX DI SINI)
    //                 // =========================
    //                 $total_penumpukan_after_diskon = max(0, $total_penumpukan - $diskon_total);

    //                 // NHI tetap full (tidak kena diskon)
    //                 $total = $total_penumpukan_after_diskon + $total_nhi;

    //                 // LOG NHI
    //                 if (!empty($detail->TOTAL_NHI4) && $detail->TOTAL_NHI4 > 0) {
    //                     $keterangan_log .= "[KONTAINER ".$detail->NO_CONT.
    //                         " NHI ".$detail->SELISIH_NHI." HARI TIDAK DISKON (".
    //                         date('d-m-Y',strtotime($detail->NHI_START_DATE)).
    //                         " - ".
    //                         date('d-m-Y',strtotime($detail->NHI_END_DATE)).
    //                         ") TOTAL ".
    //                         round($detail->TOTAL_NHI4).
    //                     "] ";
    //                 }
    //             }

    //             $subtotal += $total;

    //             $headernota['DETAIL'][] = array(
    //                 "ID_REQ" => $detail->ID_REQ,
    //                 "NO_CONT" => $detail->NO_CONT,
    //                 "ISO_CODE" => $detail->ISO_CODE,
    //                 "QTY" => $detail->TOTAL_UNIT ? $detail->TOTAL_UNIT : 1,
    //                 "UKR_CONT" => $detail->UKR_CONT,
    //                 "STATUS_CONT" => $detail->STATUS,
    //                 "SERVICE_CODE" => $detail->TARIF_ID,
    //                 "JENIS_BIAYA" => $detail->JENIS_BIAYA,
    //                 "CHARGE" => $detail->CHARGE,
    //                 "TOTAL" => round($total)
    //             );
    //         }

    //         $ppn = round($subtotal * 0.11);
    //         $total_invoice = $subtotal + $ppn;

    //         $headernota["SUBTOTAL"] = $subtotal;
    //         $headernota["PPN"] = $ppn;
    //         $headernota["TOTAL"] = $total_invoice;
    //         $headernota["LOG_KETERANGAN"] = $keterangan_log;

    //         $payload = json_encode($headernota);

    //         // LOG PROMO DISKON
    //         $this->db->query("
    //             INSERT INTO log_send_portal
    //             (id_request,payload,keterangan,created_at)
    //             VALUES
    //             ('$ID_REQ','".$this->db->escape_str($payload)."','".$this->db->escape_str($keterangan_log)."',NOW())
    //         ");

    //         // =====================
    //         // KODE CURL LAMA (TIDAK DIUBAH)
    //         // =====================

    //         $data_user = $this->cek_user_exist($npwp);
    //         $array = json_decode($data_user, true);

    //         foreach ($array as $values) {
    //             $namacust = $values['NAMA'];
    //             $alamatcust = $values['ALAMAT'];
    //             $kotacust = $values['KOTA'];
    //             $telpcust = $values['TELEPON'];
    //         }

    //         // echo $payload;die();

    //         $curl = curl_init();

    //         curl_setopt_array(
    //             $curl,
    //             array(
    //                 CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/getinv',
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_ENCODING => '',
    //                 CURLOPT_SSL_VERIFYHOST => 0,
    //                 CURLOPT_SSL_VERIFYPEER => false,
    //                 CURLOPT_MAXREDIRS => 10,
    //                 CURLOPT_TIMEOUT => 0,
    //                 CURLOPT_FOLLOWLOCATION => true,
    //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                 CURLOPT_CUSTOMREQUEST => 'POST',
    //                 CURLOPT_POSTFIELDS => $payload,
    //                 CURLOPT_HTTPHEADER => array(
    //                     'Content-Type: application/json'
    //                 ),
    //             )
    //         );

    //         $response = curl_exec($curl);

    //         curl_close($curl);

    //         echo $response;

    //         $datenow = date("Y-m-d H:i:s");

    //         $this->db->query("
    //             INSERT INTO `tpk_ipc`.`log_services`
    //             (`METHOD`,`XML_REQUEST`,`XML_RESPONSE`,`WK_REKAM`,`FL_NPCT1`,`FL_SENT_RIZKI`)
    //             VALUES
    //             ('SEND BILLING CSS','$payload','$response','$datenow','N','N')
    //         ");

    //         $sqlcek = "SELECT * from t_log_kode_bayar_sap where PROFORMA='$ID_REQ'";
    //         $result = $this->db->query($sqlcek)->result_array();
    //         $jumlah = count($result);

    //         if ($jumlah == 0) {
    //             $SQL1 = "INSERT into t_log_kode_bayar_sap (PROFORMA) VALUES ('$ID_REQ')";
    //             $this->db->query($SQL1);
    //         }
    //     }
    // }

    public function delivery_to_stgdevdiskon()
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');

        $idreq = $this->input->post('idreq');

        $promo_start = strtotime('2026-03-13');
        $promo_end   = strtotime('2026-03-29');

        $sql = "SELECT
            concat('DEL',rdh.ID) as ID,
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
            'IDR' as VALUTA,
            'PEMBAYARAN PENUMPUKAN COMMON AREA (DISKON 20% MAR 2026)' as REMARK,
            '11' as PPN_PERSEN,
            'COMMON AREA NPCT1' as LOKASI,
            'DELIVERY' as JENIS_KEGIATAN
        from req_delivery_hdr rdh
        JOIN m_pelanggan mp 
        ON REPLACE(REPLACE(mp.NPWP,'.',''),'-','') =
        REPLACE(REPLACE(rdh.NPWP,'.',''),'-','')
        where ID_REQ = '$idreq'
        limit 1";

        $header = $this->db->query($sql)->row();

        $sqldetail = "
            SELECT rdd.*, mt.JENIS_BIAYA
            FROM req_delivery_dtl rdd
            LEFT JOIN m_tarif2 mt ON rdd.TARIF_ID = mt.TARIF_ID
            WHERE ID_REQ = '$idreq'
        ";

        $details = $this->db->query($sqldetail)->result();

        $subtotal = 0;
        $keterangan_log = "";

        $headernota = array(
            "ID" => $header->ID,
            "ID_REQ" => $header->ID_REQ,
            "TGL_REQ" => $header->TGL_REQ,
            "ID_CUST" => $header->ID_CUST,
            "NAMA_CUST" => $header->NAMA_CUST,
            "NPWP" => $header->NPWP,
            "ALAMAT" => $header->ALAMAT,
            "EMAIL" => $header->EMAIL,
            "NM_KAPAL" => $header->NM_KAPAL,
            "NO_VOY" => $header->NO_VOY,
            "NO_BL" => $header->NO_BL,
            "VALUTA" => $header->VALUTA,
            "REMARK" => $header->REMARK,
            "SUBTOTAL" => 0,
            "PPN_PERSEN" => $header->PPN_PERSEN,
            "PPN" => 0,
            "ADMIN" => "0",
            "TOTAL" => 0,
            "LOKASI" => $header->LOKASI,
            "JENIS_KEGIATAN" => $header->JENIS_KEGIATAN,
            "SERVICE_CODE" => "DELIVERY",
            "DETAIL" => array()
        );

        foreach ($details as $d) {

            $total = $d->TOTAL;

            if ($d->JENIS_BIAYA == 'PENUMPUKAN') {

                $diskon_total = 0;

                $periode = array(

                    array(
                        "start" => $d->M2_START_DATE,
                        "end" => $d->M2_END_DATE,
                        "hari" => $d->SELISIH_M2,
                        "total" => $d->TOTAL_M2
                    ),

                    array(
                        "start" => $d->M3_START_DATE,
                        "end" => $d->M3_END_DATE,
                        "hari" => $d->SELISIH_M3,
                        "total" => $d->TOTAL_M3
                    ),

                    array(
                        "start" => $d->M4_START_DATE,
                        "end" => $d->M4_END_DATE,
                        "hari" => $d->SELISIH_M4,
                        "total" => $d->TOTAL_M4
                    )

                );

                foreach ($periode as $p) {

                    if ($p["start"] == null) continue;
                    if ($p["start"] == "0000-00-00") continue;
                    if ($p["hari"] == 0) continue;

                    $start = strtotime($p["start"]);
                    $end   = strtotime($p["end"]);

                    $overlap_start = max($start, $promo_start);
                    $overlap_end   = min($end, $promo_end);

                    if ($overlap_start <= $overlap_end) {

                        $hari_diskon = floor(($overlap_end - $overlap_start) / 86400) + 1;

                        $tarif_harian = $p["total"] / $p["hari"];

                        $diskon = $tarif_harian * 0.50 * $hari_diskon;

                        $diskon_total += $diskon;

                        $keterangan_log .= "[KONTAINER " . $d->NO_CONT .
                            " DISKON " . $hari_diskon .
                            " HARI (" .
                            date('d-m-Y', $overlap_start) .
                            " - " .
                            date('d-m-Y', $overlap_end) .
                            ") NORMAL " .
                            round($tarif_harian) .
                            " DISKON " .
                            round($tarif_harian * 0.8) .
                            " POTONGAN " .
                            round($diskon) .
                            "] ";
                    }
                }

                $total = $total - $diskon_total;
            }

            $subtotal += $total;

            $detail_item = array(
                "ID_REQ" => $d->ID_REQ,
                "NO_CONT" => $d->NO_CONT,
                "ISO_CODE" => $d->ISO_CODE,
                "QTY" => $d->TOTAL_UNIT,
                "UKR_CONT" => $d->UKR_CONT,
                "STATUS_CONT" => $d->STATUS,
                "SERVICE_CODE" => $d->TARIF_ID,
                "JENIS_BIAYA" => $d->JENIS_BIAYA,
                "CHARGE" => $d->CHARGE,
                "TOTAL" => round($total)
            );

            $headernota["DETAIL"][] = $detail_item;
        }

        $ppn = round($subtotal * 0.11);
        $total_invoice = $subtotal + $ppn;

        $headernota["SUBTOTAL"] = $subtotal;
        $headernota["PPN"] = $ppn;
        $headernota["TOTAL"] = $total_invoice;
        $headernota["LOG_KETERANGAN"] = $keterangan_log;

        echo json_encode($headernota);
    }

    public function test_response()
    {
        echo 'ini respon';
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

        $sqldetail = "SELECT rbd.ID_REQ, rbd.NO_CONT, tc.TIPE_CONT as 'KD_CONT_TIPE', rbd.UK_CONT, tc.KD_CONT_JENIS  as 'JNS_CONT',
			mt.JENIS_BIAYA,
			mt.TARIF_ID,
            rbd.TOTAL as 'CHARGE',	
            rbd.TOTAL,
            concat('1') as 'TOTAL_UNIT'
            from req_behandle_dtl rbd
            join req_behandle_hdr rbh on rbd.ID_REQ = rbh.ID_REQ
            join t_request tr on rbh.NO_DOK = tr.NO_DOK and rbh.TGL_DOK = tr.TGL_DOK
            join t_request_cont tc on tc.NO_CONT = rbd.NO_CONT and tr.ID = tc.ID and tc.TIPE_CONT  is not null and tc.KD_CONT_JENIS  is not null
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
                    CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/getinv',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => false,
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
                // echo 'sudah ada data';
            }
        }
    }

    public function behandle_to_stg_aseli()
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

        $sqldetail = "SELECT distinct rbd.ID_REQ, rbd.NO_CONT, tc.KD_CONT_TIPE as 'KD_CONT_TIPE', rbd.UK_CONT, tc.JNS_CONT  as 'JNS_CONT', case 
        when rbd.JNS_KEGIATAN = 1 then 'BEHANDLE 1'
        when rbd.JNS_KEGIATAN = 2 then 'BEHANDLE 2'
        when rbd.JNS_KEGIATAN = 'HICOSCAN' then 'HICO SCAN'
        else 'JOIN'
            end as 'JENIS_BIAYA',
            case 
                when rbd.JNS_KEGIATAN = '1' then '1'
                when rbd.JNS_KEGIATAN = '2' then '2'
				when rbd.JNS_KEGIATAN = 'HICOSCAN' and rbd.UK_CONT = '20' then '203'
				when rbd.JNS_KEGIATAN = 'HICOSCAN' and rbd.UK_CONT = '40' then '204'
				when rbd.JNS_KEGIATAN = 'HICOSCAN' and rbd.UK_CONT = '45' then '205'
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
                    CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/getinv',
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
            //         CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/getinv',
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
            //         CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/getinv',
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
        // https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/getinv
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SendStg/get_user',
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
        // SELECT * from t_log_kode_bayar_sap tlkbs 
        //                         where  
        //                             tlkbs.PROFORMA IN (
        //                                     'DEL207972',
        //                                     'DEL208024',
        //                                     'DEL208018',
        //                                     'DEL207975',
        //                                     'DEL207902'
        //                                 )
        foreach ($q->result() as $key => $value1) {
            echo 'memeriksa ' . $value1->PROFORMA . ' dari staging css';
            echo "\r\n";
            session_start();
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/get_nota_terkirim',
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
                    CURLOPT_URL => 'http://103.147.228.122/api/staging/index.php/SendStg/get_nota_terkirim',
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
                                $this->db->insert('t_gatepass_temp', $tmpData);
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

                                $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                                $this->db->update('t_gatepass_temp', $tmpData);



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

    public function preview_delivery()
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Content-Type: application/json");

        $idreq = $this->input->post('idreq');

        $promo_start = strtotime('2026-03-13');
        $promo_end   = strtotime('2026-03-29');
        $promo_diskon = 0.50;

        $sql = "
            SELECT rdd.*, mt.JENIS_BIAYA
            FROM req_delivery_dtl rdd
            LEFT JOIN m_tarif2 mt ON rdd.TARIF_ID = mt.TARIF_ID
            WHERE rdd.ID_REQ = '$idreq'
        ";

        $rows = $this->db->query($sql)->result();

        $containers = array();

        $subtotal = 0;

        foreach ($rows as $r) {

            if ($r->JENIS_BIAYA == 'PENUMPUKAN') {

                $detail = array();

                $total_penumpukan = 0;
                $total_diskon = 0;

                $tiers = array(

                    array(
                        "TIER" => "M1",
                        "START" => $r->M1_START_DATE,
                        "END" => $r->M1_END_DATE,
                        "HARI" => $r->SELISIH_M1,
                        "TOTAL" => $r->TOTAL_M1
                    ),

                    array(
                        "TIER" => "1",
                        "START" => $r->M2_START_DATE,
                        "END" => $r->M2_END_DATE,
                        "HARI" => $r->SELISIH_M2,
                        "TOTAL" => $r->TOTAL_M2
                    ),

                    array(
                        "TIER" => "1.1",
                        "START" => $r->M3_START_DATE,
                        "END" => $r->M3_END_DATE,
                        "HARI" => $r->SELISIH_M3,
                        "TOTAL" => $r->TOTAL_M3
                    ),

                    array(
                        "TIER" => "2",
                        "START" => $r->M4_START_DATE,
                        "END" => $r->M4_END_DATE,
                        "HARI" => $r->SELISIH_M4,
                        "TOTAL" => $r->TOTAL_M4
                    )

                );

                foreach ($tiers as $t) {

                    if ($t["HARI"] <= 0) continue;

                    $tarif = $t["TOTAL"] / $t["HARI"];

                    $start = strtotime($t["START"]);
                    $end   = strtotime($t["END"]);

                    $overlap_start = max($start, $promo_start);
                    $overlap_end   = min($end, $promo_end);

                    $hari_diskon = 0;

                    if ($overlap_start <= $overlap_end) {
                        $hari_diskon = floor(($overlap_end - $overlap_start) / 86400) + 1;
                    }

                    $diskon = $tarif * $promo_diskon * $hari_diskon;

                    $detail[] = array(
                        "TIER" => $t["TIER"],
                        "START" => $t["START"],
                        "END" => $t["END"],
                        "HARI" => $t["HARI"],
                        "TARIF" => round($tarif),
                        "TOTAL" => $t["TOTAL"],
                        "HARI_DISKON" => $hari_diskon,
                        "DISKON" => round($diskon)
                    );

                    $total_penumpukan += $t["TOTAL"];
                    $total_diskon += $diskon;
                }

                $after_diskon = $total_penumpukan - $total_diskon;

                $containers[] = array(
                    "NO_CONT" => $r->NO_CONT,
                    "UKR_CONT" => $r->UKR_CONT,
                    "ISO_CODE" => $r->ISO_CODE,

                    "PENUMPUKAN_SEBELUM_DISKON" => round($total_penumpukan),
                    "TOTAL_DISKON" => round($total_diskon),
                    "PENUMPUKAN_SETELAH_DISKON" => round($after_diskon),

                    "PENUMPUKAN_DETAIL" => $detail
                );

                $subtotal += $after_diskon;
            } else {

                $subtotal += $r->TOTAL;
            }
        }

        $ppn = round($subtotal * 0.11);
        $total = $subtotal + $ppn;

        $response = array(
            "ID_REQ" => $idreq,
            "CONTAINER_PREVIEW" => $containers,
            "DPP" => round($subtotal),
            "PPN" => $ppn,
            "TOTAL" => $total
        );

        echo json_encode($response);
    }
}

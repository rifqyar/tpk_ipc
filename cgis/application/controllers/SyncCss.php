<?php defined('BASEPATH') or exit('No direct script access allowed');

class SyncCss extends CI_Controller
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
        header('Content-Type: application/json');

        // Batasi waktu eksekusi agar cron tidak menggantung terlalu lama
        @ini_set('max_execution_time', 300);
        @set_time_limit(300);

        /*
        * Ambil data batch kecil saja.
        * Jangan ambil semua data sekaligus.
        */
        $limit = 100;

        $sql = "
        SELECT A.PROFORMA
            FROM t_log_kode_bayar_sap A
            WHERE A.UPDATE_NOTA_BOS = 0
            AND A.SAP_TGL_PELUNASAN IS NULL
            AND A.PROFORMA IS NOT NULL
            AND A.PROFORMA <> ''
            ORDER BY A.id DESC
            LIMIT " . (int) $limit . "
        ";

        $query = $this->db->query($sql);
        $result = $query->result();

        if (!$result || count($result) == 0) {
            echo "Tidak ada data yang perlu diproses.\r\n";
            return;
        }

        echo "Total data diproses: " . count($result) . "\r\n";

        /*
        * CURL ke API
        * Timeout wajib ada supaya tidak menggantung selamanya.
        */
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SyncFunction/sync_bos_css',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_MAXREDIRS => 3,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($result),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($response === false || $curl_error != '') {
            echo "CURL Error: " . $curl_error . "\r\n";
            return;
        }

        if ($http_code < 200 || $http_code >= 300) {
            echo "API HTTP Error: " . $http_code . "\r\n";
            echo "Response: " . substr($response, 0, 500) . "\r\n";
            return;
        }

        $array = json_decode($response, true);

        if (!is_array($array)) {
            echo "Response API bukan JSON array valid.\r\n";
            echo "Response: " . substr($response, 0, 500) . "\r\n";
            return;
        }

        $success_count = 0;
        $failed_count = 0;

        foreach ($array as $item) {
            if (!isset($item['PROFORMA']) || trim($item['PROFORMA']) == '') {
                $failed_count++;
                echo "Skip: PROFORMA kosong dari response API\r\n";
                continue;
            }

            $proforma = trim($item['PROFORMA']);

            $sap_kode_bayar = null;
            $sap_no_faktur = null;
            $sap_tgl_pelunasan = null;

            if (isset($item['SAP_KD_BAYAR'])) {
                $sap_kode_bayar = $item['SAP_KD_BAYAR'];
            }

            if (isset($item['SAP_NO_FAKTUR'])) {
                $sap_no_faktur = $item['SAP_NO_FAKTUR'];
            }

            if (isset($item['SAP_TGL_PELUNASAN']) && $item['SAP_TGL_PELUNASAN'] != '') {
                $sap_tgl_pelunasan = $item['SAP_TGL_PELUNASAN'];
            }

            echo "Memproses Nota " . $proforma . " dari staging CSS\r\n";

            /*
         * Update data pakai Query Builder CI 2.
         * Lebih aman daripada concat SQL manual.
         */
            $update_data = array(
                'SAP_KODE_BAYAR' => $sap_kode_bayar,
                'SAP_NO_FAKTUR' => $sap_no_faktur
            );

            if ($sap_tgl_pelunasan != null && $sap_tgl_pelunasan != '') {
                $update_data['SAP_TGL_PELUNASAN'] = $sap_tgl_pelunasan;
                $update_data['UPDATE_NOTA_BOS'] = 1;
            }

            $this->db->where('PROFORMA', $proforma);
            $update = $this->db->update('tpk_ipc.t_log_kode_bayar_sap', $update_data);

            if ($update) {
                $success_count++;

                if ($sap_tgl_pelunasan == null || $sap_tgl_pelunasan == '') {
                    echo "Nota " . $proforma . " belum lunas\r\n";
                } else {
                    echo "Nota " . $proforma . " sudah lunas di tgl " . $sap_tgl_pelunasan . "\r\n";
                    echo "Sukses cek pelunasan\r\n";
                }
            } else {
                $failed_count++;
                echo "Gagal update nota " . $proforma . "\r\n";
            }

            echo "\r\n";
        }

        echo "Selesai.\r\n";
        echo "Success: " . $success_count . "\r\n";
        echo "Failed: " . $failed_count . "\r\n";
    }

    // public function index()
    // {
    //     header("Access-Control-Allow-Origin: *");
    //     header("Access-Control-Allow-Headers: *");
    //     header('Content-Type: application/json');
    //     $sql = "SELECT A.PROFORMA from t_log_kode_bayar_sap A where
    //     A.UPDATE_NOTA_BOS = 0
    //     AND SAP_TGL_PELUNASAN is null order by A.id desc
    //     --  and 
    //     -- A.PROFORMA = 'DEL133413'
    //      ";

    //     $Query = $this->db->query($sql);
    //     $result = $Query->result();

    //     $curl = curl_init();

    //     curl_setopt_array(
    //         $curl,
    //         array(
    //             CURLOPT_URL => 'https://apiserver.multiterminal.co.id/api/staging/index.php/SyncFunction/sync_bos_css',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_SSL_VERIFYHOST => 0,
    //             CURLOPT_SSL_VERIFYPEER => false,
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => json_encode($result),
    //             CURLOPT_HTTPHEADER => array(
    //                 'Content-Type: application/json',
    //                 'Cookie: ci_session=ff6788e18975a77f1bca9f8d3332162b26d9b9e6'
    //             ),
    //         )
    //     );

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     // echo $response;
    //     $array = json_decode($response, true);
    //     foreach ($array as $item) { //foreach element in $arr
    //         $proforma = $item['PROFORMA']; //etc 
    //         echo 'Memproses Nota ' . $proforma . ' dari staging css';
    //         echo "\r\n";
    //         $SAP_KODE_BAYAR = $item['SAP_KD_BAYAR'];
    //         echo $SAP_KODE_BAYAR . "\r\n";
    //         $SAP_NO_FAKTUR = $item['SAP_NO_FAKTUR'];
    //         echo $SAP_NO_FAKTUR . "\r\n";
    //         $SAP_TGL_PELUNASAN = $item['SAP_TGL_PELUNASAN'];;
    //         echo $SAP_TGL_PELUNASAN . "\r\n";

    //         $SQL = "UPDATE tpk_ipc.t_log_kode_bayar_sap
    //         SET SAP_KODE_BAYAR='$SAP_KODE_BAYAR', SAP_NO_FAKTUR='$SAP_NO_FAKTUR'
    //         WHERE PROFORMA = '$proforma'";
    //         $Queryupdate = $this->db->query($SQL);
    //         if ($this->db->affected_rows() == 1) {
    //             echo 'Sukses Sinkron CSS' . "\r\n";;
    //         } else {
    //             echo 'Ada kesalahan/belum ada update';
    //         }
    //         if ($SAP_TGL_PELUNASAN == null) {
    //             echo 'nota ' . $proforma . ' belum lunas';
    //             echo "\r\n";
    //         } else {
    //             echo 'nota ' . $proforma . ' sudah lunas di tgl ' . $SAP_TGL_PELUNASAN;
    //             $SQL = "UPDATE tpk_ipc.t_log_kode_bayar_sap
    //             SET SAP_TGL_PELUNASAN='$SAP_TGL_PELUNASAN'
    //             WHERE PROFORMA = '$proforma';";

    //             $Queryupdate = $this->db->query($SQL);
    //             if ($this->db->affected_rows() == 1) {
    //                 echo 'Sukses cek pelunasan';
    //             } else {
    //                 echo 'Ada kesalahan';
    //             }
    //             echo "\r\n";
    //         }
    //         echo "\r\n";
    //     }
    // }
}

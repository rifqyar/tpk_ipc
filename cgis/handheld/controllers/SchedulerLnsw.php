<?php defined('BASEPATH') or exit('No direct script access allowed');
class SchedulerLnsw extends CI_Controller
{
    private $url = 'http://10.1.6.206/SSMJIQC/server_insw.php';
    //private $url = 'http://services.insw.go.id/SSMServicesDev/Services';
    //private $url = 'http://services.insw.go.id/SSMServices/Services';
    //private $url = 'http://10.1.5.27/SSMServices/Services';
    //private $url = 'http://10.1.6.217/services/server_insw_npct1.php';
    private $user = 'wsnpct1';
    private $pass = 'pass123abc';
    private $kodetps = 'NPCT1';
    private $jumlahdoc = 10;

    /**
     * service get data contaoner
     */
    public function getDocFromLnsw()
    {
        //xml untuk get dari server edii
        $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
        <soapenv:Header/>
        <soapenv:Body>
           <ser:getContainer soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
              <kd_tps xsi:type="xsd:string">' . $this->kodetps . '</kd_tps>
              <jml_dok xsi:type="xsd:string">' . $this->jumlahdoc . '</jml_dok>
              <user xsi:type="xsd:string">' . $this->user . '</user>
              <password xsi:type="xsd:string">' . $this->pass . '</password>
           </ser:getContainer>
        </soapenv:Body>
      </soapenv:Envelope>';


        //     $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
        //     <soapenv:Header/>
        //     <soapenv:Body>
        //         <ser:getContainerPeriksa>
        //         <!--Optional:-->
        //         <USERNAME>wsnpct1</USERNAME>
        //         <!--Optional:-->
        //         <PASSWORD>pass123abc</PASSWORD>
        //         <!--Optional:-->
        //         <KD_TPS>NPCT1</KD_TPS>
        //         <JML_DOC>1</JML_DOC>
        //         </ser:getContainerPeriksa>
        //     </soapenv:Body>
        // </soapenv:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: text/xml',
            'Content-length: ' . strlen($xml)
        ));
        $curl1_response = curl_exec($ch);
        if (!curl_errno($ch)) {
            echo "Connection Success , Message from Curl : " . curl_getinfo($ch) . "\r\n";
            echo "Get Data XML .... \r\n";
        } else {
            echo "Connection Failed =" . curl_error($ch);
            die();
        }

        $response = $this->db->escape($curl1_response);
        $insert = $this->db->query("INSERT INTO `t_log_lnsw` (`typelog`, `raw_request`, `raw_respon`) VALUES ('getdok', '$xml', $response)");

        if ($insert) {
            echo "Insert raw To Database Success \r\n";
        } else {
            echo "Insert raw To Database Failed \r\n";
        }

        echo "<pre>";

echo "================ RAW RESPONSE ================\n";
echo htmlspecialchars($curl1_response);
echo "\n\n";

libxml_use_internal_errors(true);

$raw = trim($curl1_response);

/*
 * Kadang SOAP response ada karakter aneh sebelum XML.
 * Ambil mulai dari tag < pertama.
 */
$pos = strpos($raw, '<');
if ($pos !== false) {
    $raw = substr($raw, $pos);
}

$soapXml = simplexml_load_string($raw);

if ($soapXml === false) {
    echo "Gagal membaca SOAP XML\n";

    foreach (libxml_get_errors() as $error) {
        echo "XML Error: " . trim($error->message) . "\n";
    }

    libxml_clear_errors();
    echo "</pre>";
    return;
}

echo "================ DAFTAR TAG XML ================\n";

/*
 * Cari semua tag dalam SOAP response
 */
$nodes = $soapXml->xpath('//*');

if ($nodes) {
    foreach ($nodes as $node) {
        echo $node->getName() . " => " . substr(trim((string) $node), 0, 300) . "\n";
    }
}

echo "\n================ CARI TAG RETURN ================\n";

/*
 * Cari kemungkinan tag yang berisi response asli
 */
$returnNodes = $soapXml->xpath(
    '//*[contains(local-name(), "return") 
    or contains(local-name(), "Return") 
    or contains(local-name(), "Result") 
    or contains(local-name(), "result")]'
);

if (!$returnNodes) {
    echo "Tag return/result tidak ditemukan.\n";
    echo "Lihat DAFTAR TAG XML di atas untuk nama tag sebenarnya.\n";
    echo "</pre>";
    return;
}

foreach ($returnNodes as $node) {
    $innerXml = trim((string) $node);

    echo "Tag ditemukan: " . $node->getName() . "\n";
    echo "Isi awal:\n";
    echo htmlspecialchars($innerXml);
    echo "\n\n";

    /*
     * Decode jika isi XML masih berupa &lt;TAG&gt;
     */
    $innerXml = html_entity_decode($innerXml, ENT_QUOTES, 'UTF-8');
    $innerXml = trim($innerXml);

    echo "Setelah decode:\n";
    echo htmlspecialchars($innerXml);
    echo "\n\n";

    /*
     * Kalau isinya bukan XML, tampilkan saja
     */
    if (substr($innerXml, 0, 1) != '<') {
        echo "Isi return bukan XML, value:\n";
        echo $innerXml . "\n";
        continue;
    }

    /*
     * Parse XML bagian dalam
     */
    $dataXml = simplexml_load_string($innerXml);

    if ($dataXml === false) {
        echo "Gagal membaca XML bagian dalam\n";

        foreach (libxml_get_errors() as $error) {
            echo "XML Error: " . trim($error->message) . "\n";
        }

        libxml_clear_errors();
        continue;
    }

    echo "================ LOOP DATA XML ================\n";

    foreach ($dataXml->children() as $key => $value) {
        echo $key . " : " . trim((string) $value) . "\n";

        foreach ($value->children() as $childKey => $childValue) {
            echo " - " . $childKey . " : " . trim((string) $childValue) . "\n";

            foreach ($childValue->children() as $subKey => $subValue) {
                echo "   - " . $subKey . " : " . trim((string) $subValue) . "\n";
            }
        }
    }
}

echo "</pre>";
    }

    /**
     * parsing data untuk menyimpan dokumen ke permit / ppk
     * flag yg di tambahkan header( FL_LNSW,LNSW_KD_RESPON,LNSW_IDLOG,LNSW_NOAJU )
     * flag yg di tambahkan container ( FL_LNSW )
     */
    public function parsingdataCont()
    {
        $log = $this->db->query("SELECT id,raw_respon from t_log_lnsw where rekondata = 'N'")->result();

        foreach ($log as $val1) {
            $response = $val1->raw_respon;
            $arrayName = array(
                '<?xml version="1.0" encoding="ISO-8859-1"?>',
                '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                '<SOAP-ENV:Body>',
                '<ns1:getContainerResponse xmlns:ns1="http://services.insw.go.id/"><getContainerResult xsi:type="xsd:string">',
                '</getContainerResult>',
                '</ns1:getContainerResponse>',
                '</SOAP-ENV:Body>',
                '</SOAP-ENV:Envelope>'
            );
            echo "Start Parsing respon get to string \r\n";
            foreach ($arrayName as $key => $value) {

                $response = str_replace($value, '', $response);
            }
            $response = str_replace('&lt;', '<', $response);
            $response = str_replace('&gt;', '>', $response);
            $response = str_replace('&quot;', '"', $response);
            try {
                $str = explode('<GETCONTAINERPERIKSA>', $response);
                $str = explode('</GETCONTAINERPERIKSA>', $str[1]);
                $json = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><GETCONTAINERPERIKSA>' . $str[0] . '</GETCONTAINERPERIKSA>';
                $json = simplexml_load_string($json);
                if ($json->KODE != '404') {
                    foreach ($json as $val2) {
                        //INSERT INTO `tpk_ipc_dev`.`t_log_detail_insw` (`idlog`, `KODE_RESPONSE`, `NO_AJU`, `TGL_AJU`, `JML_CONTAINER`, `JML_CONTAINER_PERIKSA`, `IMP_ID`, `IMP_NAMA`, `IMP_ALAMAT`, `PJAWAB_NAMA`, `PJAWAB_JABATAN`, `PJAWAB_ALAMAT`, `PJAWAB_TELP`, `PJAWAB_EMAIL`, `TRANSPORT_MODA`, `TRANSPORT_NOMOR`, `TRANSPORT_KODE_TERMINAL`, `TRANSPORT_NAMA`, `TRANSPORT_TGL_TIBA`) VALUES ('1', '1', '1', '2020-10-11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2020-10-01');
                        if ($val2->KODE_RESPONSE == '005' or $val2->KODE_RESPONSE == '006' or $val2->KODE_RESPONSE == '507' or $val2->KODE_RESPONSE == '007') {
                            $uniqid = $val2->NO_AJU;
                            echo "-id = " . $uniqid . " respon = " . $val2->KODE_RESPONSE . " jumlah kontainer = " . $val2->JML_CONTAINER . "\r\n";
                            echo "-id imp = " . $val2->IMP->ID . "- nama = " . $val2->IMP->NAMA . "- alamat = " . $val2->IMP->ALAMAT . "\r\n";
                            echo "-moda = " . $val2->TRANSPORT->LIST->MODA . "-NOMOR = " . $val2->TRANSPORT->LIST->NOMOR . "-KODE_TERMINAL = " . $val2->TRANSPORT->LIST->KODE_TERMINAL . "-NAMA = " . $val2->TRANSPORT->LIST->NAMA . "-TGL_TIBA = " . $val2->TRANSPORT->LIST->TGL_TIBA . "\r\n";
                            foreach ($val2->INSTANSI->LOOP as $val3) {
                                //var_dump($val3);
                                echo "---instansi = " . $val3->INSTANSI . " KODE_KANTOR = " . $val3->KODE_KANTOR . "\r\n";
                                echo "---NAMA_KANTOR = " . $val3->NAMA_KANTOR . " NO_DOC = " . $val3->NO_DOC . $val3->NAMA_KANTOR . " TGL_DOC = " . $val3->TGL_DOC . "\r\n";
                                $conttransport = $val2->TRANSPORT->LIST->CONTLIST->CONTAINER;
                                $arr11 = array('02', '03', '04');
                                if (in_array($val3->INSTANSI, $arr11)) {
                                    $this->datamasukbos('krhdr', $val2, $val3, $dt = array(), $val1);
                                    //echo "karantina \r\n";
                                } else {
                                    $this->datamasukbos('bchdr', $val2, $val3, $dt = array(), $val1);
                                    //echo "bea cukai \r\n";
                                }
                                foreach ($val3->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                                    foreach ($conttransport as $val5) {
                                        // echo "-".$val4->NOCONTAINER."\r\n";
                                        // echo "--".$val5->NOCONT."\r\n";
                                        if (trim($val4->NOCONTAINER) == trim($val5->NOCONT)) {
                                            echo "------kontainer = " . $val4->NOCONTAINER . " ukuran = " . $val5->UKCONT . " jenis = " . $val5->TPCONT . " periksa = " . $val4->FLAGPERIKSA . "\r\n";
                                            if ($val4->FLAGPERIKSA == 'true') {
                                                $plagperiksa = 'Y';
                                                $tpft = '1';
                                            } else {
                                                $plagperiksa = 'N';
                                                $tpft = '1';
                                            }
                                            echo "periksa : " . $plagperiksa . "\r\n";
                                            if ($val5->TPCONT == 'GP') {
                                                $typecont = 'DRY';
                                            } else if ($val5->TPCONT == 'RF') {
                                                $typecont = 'RFR';
                                            } else {
                                                $typecont = $val5->TPCONT;
                                            }
                                            $val4g = array(
                                                'cont' => $val4->NOCONTAINER,
                                                'ukuran' => $val5->UKCONT,
                                                'jenis' => $typecont,
                                                'periksa' => $plagperiksa,
                                                'tpft' => $tpft
                                            );
                                            $arr112 = array('02', '03', '04');
                                            if (in_array($val3->INSTANSI, $arr112)) {
                                                $this->datamasukbos('krcont', $val2, $val4g, $val3, $dt = array());
                                            } else {
                                                $this->datamasukbos('bccont', $val2, $val4g, $val3, $dt = array());
                                            }
                                        }
                                    }
                                }
                            }
                            echo "\r\n";
                            echo "----------------------------------------------------------------------------------------------------------";
                            echo "\r\n";
                            $this->datamasukbos('logrespon', $val2, $dt = array(), $dt2 = array(), $val1);
                            $this->datamasukbos('lg', $val2, $dt = array(), $dt2 = array(), $val1);
                        } else {
                            echo $val2->KODE_RESPONSE . " kode respon tersebut tidak masuk list \r\n";
                        }
                    }
                }
            } catch (\Throwable $th) {
                echo "kosong \r\n";
            }

            echo "\r\n";
            echo "###################################################################################################################";
            echo "\r\n";
            $this->db->query("UPDATE `t_log_lnsw` SET `rekondata`='Y' WHERE  `id`=$val1->id");
        }
    }

    public function parsingdataOnRequest()
    {

        $response = "<GETCONTAINERPERIKSAONREQUEST>
    <LOOP>
        <KODE_RESPONSE>006</KODE_RESPONSE>
        <URAIAN_RESPONSE>INSW - KARANTINA PERIKSA MANDIRI</URAIAN_RESPONSE>
        <NO_AJU>201201768F3420241007000011</NO_AJU>
        <TGL_AJU>2024-10-07</TGL_AJU>
        <IMP>
            <ID>411832405042000</ID>
            <NAMA>RATU SAMUDRA SUKSES</NAMA>
            <ALAMAT>JALAN TENGGIRI NOMOR 72/2A, RT 002, RW 008</ALAMAT>
            <PJAWAB>
                <NAMA>INDRA SETIAWAN</NAMA>
                <JABATAN>DIREKTUR</JABATAN>
                <ALAMAT>Komp. Tugu Gading Permai B1/5</ALAMAT>
                <TELP>082113000964</TELP>
                <EMAIL>indrasetiawan1695@gmail.com</EMAIL>
            </PJAWAB>
            <PPJK>
                <IDPPJK>954207163042000</IDPPJK>
                <NMPPJK>RADEN ADIPATI KELING</NMPPJK>
                <ALPPJK>JALAN TENGGIRI NOMOR 72 / 2A, RT 002, RW 008</ALPPJK>
            </PPJK>
        </IMP>
        <JML_CONTAINER>1</JML_CONTAINER>
        <JML_CONTAINER_PERIKSA>1</JML_CONTAINER_PERIKSA>
        <TRANSPORT>
            <LIST>
                <MODA>1</MODA>
                <NOMOR>433W</NOMOR>
                <KODE_TERMINAL>null</KODE_TERMINAL>
                <NAMA>ZHONG GU SHEN YANG</NAMA>
                <TGL_TIBA>2024-10-06T00:00:00.000Z</TGL_TIBA>
                <CONTLIST>
                    <CONTAINER>
                        <NOCONT>ESDU4237733</NOCONT>
                        <NOSEAL>G156770</NOSEAL>
                        <TPCONT>FCL</TPCONT>
                        <UKCONT>40</UKCONT>
                        <FLPERIKSA>true</FLPERIKSA>
                    </CONTAINER>
                </CONTLIST>
            </LIST>
        </TRANSPORT>
        <INSTANSI>
            <LOOP>
                <INSTANSI>04</INSTANSI>
                <KODE_KANTOR>3100</KODE_KANTOR>
                <NAMA_KANTOR>Balai Besar Karantina Hewan, Ikan, dan Tumbuhan DKI Jakarta - UPT Induk</NAMA_KANTOR>
                <NO_DOC>2024-T2.0-3100.0-K.3.10-000565</NO_DOC>
                <TGL_DOC>2024-10-16</TGL_DOC>
                <JNS_DOC>04203</JNS_DOC>
                <RISK_LEVEL>L</RISK_LEVEL>
                <CONTAINER_LIST>
                    <CONTLIST_LOOP>
                        <NOCONTAINER>ESDU4237733</NOCONTAINER>
                        <FLAGPERIKSA>true</FLAGPERIKSA>
                    </CONTLIST_LOOP>
                </CONTAINER_LIST>
            </LOOP>
        </INSTANSI>
    </LOOP>
</GETCONTAINERPERIKSAONREQUEST>";
        $arrayName = array(
            '<?xml version="1.0" encoding="ISO-8859-1"?>',
            '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            '<ns1:getContainerResponse xmlns:ns1="http://services.insw.go.id/"><getContainerResult xsi:type="xsd:string">',
            '</getContainerResult>',
            '</ns1:getContainerResponse>',
            '</SOAP-ENV:Body>',
            '</SOAP-ENV:Envelope>'
        );
        echo "Start Parsing respon get to string \r\n";
        foreach ($arrayName as $key => $value) {

            $response = str_replace($value, '', $response);
        }
        $response = str_replace('&lt;', '<', $response);
        $response = str_replace('&gt;', '>', $response);
        $response = str_replace('&quot;', '"', $response);
        try {
            $str = explode('<GETCONTAINERPERIKSAONREQUEST>', $response);
            $str = explode('</GETCONTAINERPERIKSAONREQUEST>', $str[1]);
            $json = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><GETCONTAINERPERIKSAONREQUEST>' . $str[0] . '</GETCONTAINERPERIKSAONREQUEST>';
            $json = simplexml_load_string($json);
            if ($json->KODE != '404') {
                foreach ($json as $val2) {
                    //INSERT INTO `tpk_ipc_dev`.`t_log_detail_insw` (`idlog`, `KODE_RESPONSE`, `NO_AJU`, `TGL_AJU`, `JML_CONTAINER`, `JML_CONTAINER_PERIKSA`, `IMP_ID`, `IMP_NAMA`, `IMP_ALAMAT`, `PJAWAB_NAMA`, `PJAWAB_JABATAN`, `PJAWAB_ALAMAT`, `PJAWAB_TELP`, `PJAWAB_EMAIL`, `TRANSPORT_MODA`, `TRANSPORT_NOMOR`, `TRANSPORT_KODE_TERMINAL`, `TRANSPORT_NAMA`, `TRANSPORT_TGL_TIBA`) VALUES ('1', '1', '1', '2020-10-11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2020-10-01');
                    if ($val2->KODE_RESPONSE == '005' or $val2->KODE_RESPONSE == '006' or $val2->KODE_RESPONSE == '507' or $val2->KODE_RESPONSE == '007') {
                        $uniqid = $val2->NO_AJU;
                        echo "-id = " . $uniqid . " respon = " . $val2->KODE_RESPONSE . " jumlah kontainer = " . $val2->JML_CONTAINER . "\r\n";
                        echo "-id imp = " . $val2->IMP->ID . "- nama = " . $val2->IMP->NAMA . "- alamat = " . $val2->IMP->ALAMAT . "\r\n";
                        echo "-moda = " . $val2->TRANSPORT->LIST->MODA . "-NOMOR = " . $val2->TRANSPORT->LIST->NOMOR . "-KODE_TERMINAL = " . $val2->TRANSPORT->LIST->KODE_TERMINAL . "-NAMA = " . $val2->TRANSPORT->LIST->NAMA . "-TGL_TIBA = " . $val2->TRANSPORT->LIST->TGL_TIBA . "\r\n";
                        foreach ($val2->INSTANSI->LOOP as $val3) {
                            //var_dump($val3);
                            echo "---instansi = " . $val3->INSTANSI . " KODE_KANTOR = " . $val3->KODE_KANTOR . "\r\n";
                            echo "---NAMA_KANTOR = " . $val3->NAMA_KANTOR . " NO_DOC = " . $val3->NO_DOC . $val3->NAMA_KANTOR . " TGL_DOC = " . $val3->TGL_DOC . "\r\n";
                            $conttransport = $val2->TRANSPORT->LIST->CONTLIST->CONTAINER;
                            $arr11 = array('02', '03', '04');
                            if (in_array($val3->INSTANSI, $arr11)) {
                                $this->datamasukbos('krhdr', $val2, $val3, $dt = array(), $val1);
                                //echo "karantina \r\n";
                            } else {
                                $this->datamasukbos('bchdr', $val2, $val3, $dt = array(), $val1);
                                //echo "bea cukai \r\n";
                            }
                            foreach ($val3->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                                foreach ($conttransport as $val5) {
                                    // echo "-".$val4->NOCONTAINER."\r\n";
                                    // echo "--".$val5->NOCONT."\r\n";
                                    if (trim($val4->NOCONTAINER) == trim($val5->NOCONT)) {
                                        echo "------kontainer = " . $val4->NOCONTAINER . " ukuran = " . $val5->UKCONT . " jenis = " . $val5->TPCONT . " periksa = " . $val4->FLAGPERIKSA . "\r\n";
                                        if ($val4->FLAGPERIKSA == 'true') {
                                            $plagperiksa = 'Y';
                                            $tpft = '1';
                                        } else {
                                            $plagperiksa = 'N';
                                            $tpft = '1';
                                        }
                                        echo "periksa : " . $plagperiksa . "\r\n";
                                        if ($val5->TPCONT == 'GP') {
                                            $typecont = 'DRY';
                                        } else if ($val5->TPCONT == 'RF') {
                                            $typecont = 'RFR';
                                        } else {
                                            $typecont = $val5->TPCONT;
                                        }
                                        $val4g = array(
                                            'cont' => $val4->NOCONTAINER,
                                            'ukuran' => $val5->UKCONT,
                                            'jenis' => $typecont,
                                            'periksa' => $plagperiksa,
                                            'tpft' => $tpft
                                        );
                                        $arr112 = array('02', '03', '04');
                                        if (in_array($val3->INSTANSI, $arr112)) {
                                            $this->datamasukbos('krcont', $val2, $val4g, $val3, $dt = array());
                                        } else {
                                            $this->datamasukbos('bccont', $val2, $val4g, $val3, $dt = array());
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n";
                        echo "----------------------------------------------------------------------------------------------------------";
                        echo "\r\n";
                        $this->datamasukbos('logrespon', $val2, $dt = array(), $dt2 = array(), $val1);
                        $this->datamasukbos('lg', $val2, $dt = array(), $dt2 = array(), $val1);
                    } else {
                        echo $val2->KODE_RESPONSE . " kode respon tersebut tidak masuk list \r\n";
                    }
                }
            }
        } catch (\Throwable $th) {
            echo "kosong \r\n";
        }

        echo "\r\n";
        echo "###################################################################################################################";
        echo "\r\n";

    }

    /**
     * fungsi buat kirim respon ke lnsw
     */
    public function sendRespon($typeque, $koderespon, $statuscont, $noaju)
    {
        //status buat coba

        $datajoin = $this->db->query("SELECT a.id idd,b.* from t_log_lnsw_respon_cont a 
        JOIN t_log_detail_lnsw b ON binary a.no_aju = binary b.NO_AJU AND a.tgl_aju = b.TGL_AJU
        WHERE $typeque = 'N' AND a.no_aju = '$noaju'")->result();
        foreach ($datajoin as $key => $val1) {

            $conta = $this->db->query("SELECT b.NO_CONT FROM t_permit_hdr a JOIN t_permit_cont b
            ON a.ID = b.ID WHERE a.CAR = '$val1->NO_AJU'");
            if ($conta->num_rows() > 0) {
                $contab = $conta->result();
            } else {
                //$conta = $this->db->query("SELECT b.NO_CONT FROM t_permit_hdr a JOIN t_permit_cont b 
                //ON a.ID = b.ID WHERE a.CAR = '$val1->NO_AJU'");
                //$contab = $conta->result();
            }
            $contlist = '';
            foreach ($contab as $key => $value) {
                $contlist = $contlist . '<CONTAINER>
                <NOCONT>' . $value->NO_CONT . '</NOCONT>
                <NOSEAL></NOSEAL>
                <STATTIME></STATTIME>
                <KODE_TERMINAL_PERIKSA>NCT1</KODE_TERMINAL_PERIKSA>
                <LOCCONT></LOCCONT>
                <STATCONT>' . $statuscont . '</STATCONT>
            </CONTAINER>';
            }

            $payload = '<SENDRESPONSECONTAINER>
             <KODE_RESPONSE>' . $koderespon . '</KODE_RESPONSE>
             <NO_AJU>' . $val1->NO_AJU . '</NO_AJU>
             <TGL_AJU>' . $val1->TGL_AJU . '</TGL_AJU>
             <NPWP></NPWP>
             <CONTLIST>' . $contlist . '</CONTLIST>
             <TRANSPORT>
                 <MODA>' . $val1->TRANSPORT_MODA . '</MODA>
                 <NOMOR>' . $val1->TRANSPORT_NOMOR . '</NOMOR>
                 <KODE_TERMINAL>' . $val1->TRANSPORT_KODE_TERMINAL . '</KODE_TERMINAL>
                 <NAMA>' . $val1->TRANSPORT_NAMA . '</NAMA>
                 <TGL_TIBA>' . $val1->TRANSPORT_TGL_TIBA . '</TGL_TIBA>
             </TRANSPORT>
             </SENDRESPONSECONTAINER>';

            $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
             <soapenv:Header/>
             <soapenv:Body>
                <ser:getResponseContainer soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                   <user xsi:type="xsd:string">' . $this->user . '</user>
                   <password xsi:type="xsd:string">' . $this->pass . '</password>
                   <payload xsi:type="xsd:string"><![CDATA[' . $payload . ']]></payload>
                </ser:getResponseContainer>
             </soapenv:Body>
          </soapenv:Envelope>';
            //echo var_dump($xml);die();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: text/xml',
                'Content-length: ' . strlen($xml)
            ));
            $response = curl_exec($ch);
            if (!curl_errno($ch)) {
                echo "Connection Success , Message from Curl : " . curl_getinfo($ch) . "\r\n";
                echo "Get Send Respon .... \r\n";
            } else {
                echo "Connection Failed =" . curl_error($ch);
                die();
            }

            $response = str_replace('&lt;', '<', $response);
            $response = str_replace('&gt;', '>', $response);
            $response = str_replace('&quot;', '"', $response);
            $str = explode('<RESPONSE>', $response);
            $str = explode('</RESPONSE>', $str[1]);
            $json = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><RESPONSE>' . $str[0] . '</RESPONSE>';

            $json = simplexml_load_string($json);
            echo json_encode($json);
            echo "\r\n";

            $typestat = $koderespon . '#' . $statuscont;
            $log = array(
                'typestat' => $typestat,
                'no_aju' => $val1->NO_AJU,
                'raw_request' => $xml,
                'raw_respon' => $response
            );

            $this->db->insert('t_log_lnsw_respon', $log);
            // echo "UPDATE `t_log_lnsw_respon_cont` SET `$typeque`='Y' WHERE  `id`=$val1->idd";
            $this->db->query("UPDATE `t_log_lnsw_respon_cont` SET `$typeque`='Y' WHERE  `id`=$val1->idd");
        }
    }

    /**
     * fungsi antrian yg di pakai di sceduler
     */
    public function QuequeSendRespon()
    {
        $data1 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_400 = 'N' AND aa.kd_status IS null
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data1 as $key1 => $value1) {
            $this->sendRespon('r_400', '400', '411', $value1->LNSW_NOAJU);
            echo 'r_400-' . '400-' . '411-' . $value1->LNSW_NOAJU . "\r\n";
        }

        $data2 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_411 = 'N' AND aa.kd_status IS null
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data2 as $key2 => $value2) {
            $this->sendRespon('r_411', '410', '411', $value2->LNSW_NOAJU);
            echo 'r_411-' . '410-' . '411-' . $value2->LNSW_NOAJU . "\r\n";
        }

        $data3 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_412 = 'N' AND aa.kd_status = '100'
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data3 as $key3 => $value3) {
            $this->sendRespon('r_412', '410', '412', $value3->LNSW_NOAJU);
            echo 'r_412-' . '410-' . '412-' . $value3->LNSW_NOAJU . "\r\n";
        }

        $data4 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_413 = 'N' AND aa.kd_status = '400'
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data4 as $key4 => $value4) {
            $this->sendRespon('r_413', '410', '413', $value4->LNSW_NOAJU);
            echo 'r_413-' . '410-' . '413-' . $value4->LNSW_NOAJU . "\r\n";
        }

        $data5 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_414 = 'N' AND aa.kd_status = '400' AND aa.status_cont = '460'
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data5 as $key5 => $value5) {
            $this->sendRespon('r_414', '410', '415', $value5->LNSW_NOAJU);
            echo 'r_414-' . '410-' . '415-' . $value5->LNSW_NOAJU . "\r\n";
        }

        $data6 = $this->db->query("SELECT bb.lnsw_noaju,aa.kd_status,aa.status_cont FROM v_ppk_permit_join bb 
        left join (SELECT a.no_dok,a.TGL_DOK,a.kd_status,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.id) aa ON aa.no_dok = bb.no_respon AND aa.tgl_dok = bb.tg_respon AND aa.no_cont = bb.no_cont
        JOIN t_log_lnsw_respon_cont cc ON bb.lnsw_noaju = cc.no_aju
        WHERE r_415 = 'N' AND aa.kd_status = '500' AND aa.status_cont = '900'
        GROUP BY bb.lnsw_noaju,aa.kd_status,aa.status_cont")->result();

        foreach ($data6 as $key6 => $value6) {
            $this->sendRespon('r_415', '410', '415', $value6->LNSW_NOAJU);
            echo 'r_415-' . '410-' . '415-' . $value6->LNSW_NOAJU . "\r\n";
        }

    }

    /**
     * fungsi buat memasukan data dari lnsw ke BOS
     */
    public function datamasukbos($type, $data1, $data2, $data3, $tmbah)
    {

        if ($type == 'bchdr') {
            $cekkr = '';
            $ke = 1;
            foreach ($data2->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                if ($ke > 1) {
                    $cekkr .= ',';
                }
                $cekkr .= "'" . $val4->NOCONTAINER . "'";
                $ke++;
            }
            $cekkr2 = "(" . $cekkr . ")";

            $permithdr = array(
                'CAR' => $data1->NO_AJU,
                'KD_KANTOR' => $data2->KODE_KANTOR,
                'KD_DOK_INOUT' => '19',
                'NO_DOK_INOUT' => $data2->NO_DOC,
                'TGL_DOK_INOUT' => $data2->TGL_DOC,
                'NO_DAFTAR_PABEAN' => $data2->NO_DOC,
                'TGL_DAFTAR_PABEAN' => $data2->TGL_DOC,
                'ID_CONSIGNEE' => $data1->IMP->ID,
                'CONSIGNEE' => $data1->IMP->NAMA,
                'ALAMAT_CONSIGNEE' => $data1->IMP->NAMA,
                'NPWP_PPJK' => NULL,
                'NAMA_PPJK' => NULL,
                'ALAMAT_PPJK' => NULL,
                'NM_ANGKUT' => NULL,
                'NO_VOY_FLIGHT' => NULL,
                'KD_GUDANG' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'JML_CONT' => $data1->JML_CONTAINER,
                'BRUTO' => NULL,
                'NETTO' => NULL,
                'NO_BC11' => NULL,
                'TGL_BC11' => NULL,
                'NO_POS_BC11' => NULL,
                'NO_BL_AWB' => NULL,
                'TGL_BL_AWB' => NULL,
                'NO_MASTER_BL_AWB' => NULL,
                'TGL_MASTER_BL_AWB' => NULL,
                'KD_KANTOR_PENGAWAS' => NULL,
                'KD_KANTOR_BONGKAR' => NULL,
                'FL_SEGEL' => NULL,
                'STATUS_JALUR' => NULL,
                'FL_KARANTINA' => NULL,
                'KD_STATUS' => '100',
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'FL_BAPLIE' => '0',
                'BAPLIE_DATE' => NULL,
                'ANGKUTKODE_TPS' => NULL,
                'ANGKUTNAMA_TPS' => NULL,
                'ANGKUTNO_TPS' => NULL,
                'TMP_TIMBUN_TPS' => NULL,
                'STATUS' => 'N',
                'STATUS_MAIL' => NULL,
                'KD_STATUS_BIL' => NULL,
                'WK_STATUS' => NULL,
                'PATH' => NULL,
                'FL_MANUAL' => 'N',
                'OPERATOR' => NULL,
                'FL_MIGRASI' => 'N',
                'FL_NHI' => 'N',
                'FL_LNSW' => 'Y',
                'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                'LNSW_IDLOG' => $tmbah->id,
                'LNSW_NOAJU' => $data1->NO_AJU,
                'LNSW_TGLAJU' => $data1->TGL_AJU
            );
            $permithdrup = array(
                'CAR' => $data1->NO_AJU,
                'KD_KANTOR' => $data2->KODE_KANTOR,
                'KD_DOK_INOUT' => '19',
                'NO_DOK_INOUT' => $data2->NO_DOC,
                'TGL_DOK_INOUT' => $data2->TGL_DOC,
                'NO_DAFTAR_PABEAN' => $data2->NO_DOC,
                'TGL_DAFTAR_PABEAN' => $data2->TGL_DOC,
                'ID_CONSIGNEE' => $data1->IMP->ID,
                'CONSIGNEE' => $data1->IMP->NAMA,
                'ALAMAT_CONSIGNEE' => $data1->IMP->NAMA,
                'KD_GUDANG' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'JML_CONT' => $data1->JML_CONTAINER,
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'FL_LNSW' => 'Y',
                'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                'LNSW_IDLOG' => $tmbah->id,
                'LNSW_NOAJU' => $data1->NO_AJU,
                'LNSW_TGLAJU' => $data1->TGL_AJU
            );
            $datatreq = array(
                'no_dok' => $data2->NO_DOC,
                'tgl_dok' => $data2->TGL_DOC
            );
            $jmpermithdr = $this->db->query("SELECT distinct a.id,a.NO_DAFTAR_PABEAN,a.TGL_DAFTAR_PABEAN,a.car from t_permit_hdr a
            JOIN t_permit_cont b ON a.ID = b.id
            WHERE a.NO_DAFTAR_PABEAN = '$data2->NO_DOC' and no_cont IN $cekkr2");
            if ($jmpermithdr->num_rows() == 0) {
                $this->db->insert('t_permit_hdr', $permithdr);
            } else {

                $tprhdr = $this->db->where('id', $jmpermithdr->row()->id);
                $tprhdr = $this->db->set($permithdrup);
                $tprhdr = $this->db->update('t_permit_hdr');

                $treq = $this->db->query("SELECT id,no_dok,tgl_dok FROM t_request WHERE jns_dok != 83 AND no_dok = '$data2->NO_DOC' and year(tgl_dok) = year('$data2->TGL_DOC')");
                if ($treq->num_rows() > 0) {
                    $treq1 = $this->db->where('id', $treq->row()->id);
                    $treq1 = $this->db->set($datatreq);
                    $treq1 = $this->db->update("t_request");
                }
            }

        } else if ($type == 'bccont') {
            $idcont = $this->db->query("SELECT id FROM t_permit_hdr WHERE no_daftar_pabean = '$data3->NO_DOC' AND lnsw_noaju = '$data1->NO_AJU'")->row();
            $permitcont = array(
                'ID' => $idcont->id,
                'NO_CONT' => $data2['cont'],
                'KD_CONT_UKURAN' => $data2['ukuran'],
                'KD_CONT_JENIS' => $data2['jenis'],
                'ISO_CODE' => NULL,
                'TIPE_CONT' => NULL,
                'KD_GUDANG' => NULL,
                'KD_TIMBUN' => NULL,
                'KD_GUDANG_PERIKSA' => NULL,
                'IMO_CODE' => NULL,
                'STATUS_CONT' => 'ND',
                'FL_PERIKSA' => $data2['periksa'],
                'STATUS_RELOKASI' => NULL,
                'KD_STATUS' => '0',
                'TGL_STATUS' => date('Y-m-d H:i:s'),
                'KD_STATUS_BIL' => NULL,
                'WK_STATUS_BIL' => NULL,
                'FL_RELOCATION' => '0',
                'TGL_RELOCATION' => NULL,
                'FL_GATEPASS' => 'N',
                'FL_LNSW' => 'Y'
            );
            $permitcont2 = array(
                'NO_CONT' => $data2['cont'],
                'KD_CONT_UKURAN' => $data2['ukuran'],
                'KD_CONT_JENIS' => $data2['jenis'],
                'FL_PERIKSA' => $data2['periksa'],
                'FL_LNSW' => 'Y'
            );
            $prcont = $data2['cont'];
            $jmlprmitcont = $this->db->query("SELECT id from t_permit_cont where ID = '$idcont->id' and NO_CONT = '$prcont'")->num_rows();

            if ($jmlprmitcont == 0) {
                $this->db->insert('t_permit_cont', $permitcont);
            } else {
                $treqcont = $this->db->where('id', $idcont->id);
                $treqcont = $this->db->where('no_cont', $data2['cont']);
                $treqcont = $this->db->set($permitcont2);
                $treqcont = $this->db->update('t_permit_cont');
            }


        } else if ($type == 'krhdr') {
            $cekkr = '';
            $ke = 1;
            foreach ($data2->CONTAINER_LIST->CONTLIST_LOOP as $val4) {
                if ($ke > 1) {
                    $cekkr .= ',';
                }
                $cekkr .= "'" . $val4->NOCONTAINER . "'";
                $ke++;
            }
            $cekkr2 = "(" . $cekkr . ")";
            $nodok1 = explode('.', $data2->NO_DOC);
            $nodok1 = $nodok1[count($nodok1) - 1];
            $cekdok = $this->db->query("SELECT a.id_ijin,a.NO_RESPON,a.TG_RESPON,LEFT(a.no_respon,4),RIGHT(a.no_respon,6),b.no_cont FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.id_ijin = b.ID_IJIN 
            WHERE LEFT(a.no_respon,4) = YEAR(NOW()) AND RIGHT(a.no_respon,6) = '$nodok1' AND b.no_cont IN  $cekkr2 ");
            if ($cekdok->num_rows() == 0) {
                $t_lic_hdr = array(
                    'ID_IJIN_INSPEKSI' => NULL,
                    'JENIS_DOK' => 'SPPMP',
                    'NO_IJIN' => $data2->NO_DOC,
                    'TGL_AWAL' => NULL,
                    'TGL_IJIN' => $data2->TGL_DOC,
                    'TGL_AKHIR' => NULL,
                    'KETERANGAN' => NULL,
                    'NPWP' => NULL,
                    'NM_TRADER' => $data1->IMP->NAMA,
                    'ALM_TRADER' => $data1->IMP->ALAMAT,
                    'ID_GA' => NULL,
                    'WKPROSES' => NULL,
                    'KD_IJIN' => NULL,
                    'KODE_STATUS' => $data2->KODE_KANTOR,
                    'JNS_IJIN' => NULL,
                    'USED_BY_CAR' => NULL,
                    'JNS_REKAM' => NULL,
                    'REKAM_BY' => NULL,
                    'WK_REKAM' => date('Y-m-d H:i:s'),
                    'UPD_BY' => NULL,
                    'UPD_DATE' => NULL,
                    'FL_BAPLIE' => '0',
                    'BAPLIE_DATE' => NULL
                );
                $idkar = $this->db->query("SELECT id_ijin from t_lic_hdr where NO_IJIN = '$data2->NO_DOC'");

                if ($idkar->num_rows() == 0) {
                    $this->db->insert('t_lic_hdr', $t_lic_hdr);
                }
                $idkar = $this->db->query("SELECT id_ijin from t_lic_hdr where NO_IJIN = '$data2->NO_DOC'");
                //echo "SELECT id_ijin from t_lic_hdr where 'NO_IJIN' = '$data2->NO_DOC' and 'TGL_IJIN' = '$data2->TGL_DOC'";
                $ppkhdr = array(
                    'ID_IJIN' => $idkar->row()->id_ijin,
                    'JN_RESPON' => NULL,
                    'NM_PARTNER' => NULL,
                    'KD_UPT' => NULL,
                    'ALM_PARTNER' => NULL,
                    'NEG_PARTNER' => NULL,
                    'PEL_BKR' => NULL,
                    'PEL_MUAT' => NULL,
                    'TMP_TIMBUN' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                    'MODA' => NULL,
                    'ANGKUTNAMA' => NULL,
                    'ANGKUTNO' => NULL,
                    'TG_TIBA' => NULL,
                    'JM_CONT' => NULL,
                    'JM_BRG' => NULL,
                    'TUJ_MASUK' => NULL,
                    'NO_RESPON' => $data2->NO_DOC,
                    'NEG_TUJU' => NULL,
                    'DRH_TUJU' => NULL,
                    'TG_RESPON' => $data2->TGL_DOC,
                    'NO_DAFTPPK' => $data2->NO_DOC,
                    'TG_DAFTPPK' => $data2->TGL_DOC,
                    'ISI_RESPON' => NULL,
                    'NIP_JAB' => NULL,
                    'NM_JAB' => NULL,
                    'JAB' => NULL,
                    'TMP_INSTALASI' => NULL,
                    'ALM_INSTALASI' => NULL,
                    'ANGKUTKODE_TPS' => NULL,
                    'ANGKUTNAMA_TPS' => NULL,
                    'ANGKUTNO_TPS' => NULL,
                    'TMP_TIMBUN_TPS' => NULL,
                    'UPDATE_BY' => NULL,
                    'FL_SEND' => 0,
                    'DATE_SEND' => NULL,
                    'STATUS' => 'N',
                    'STATUS_MAIL' => NULL,
                    'WK_STATUS' => NULL,
                    'FL_MANUAL' => 'N',
                    'OPERATOR' => NULL,
                    'FL_LNSW' => 'Y',
                    'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                    'LNSW_IDLOG' => $tmbah->id,
                    'LNSW_NOAJU' => $data1->NO_AJU,
                    'LNSW_TGLAJU' => $data1->TGL_AJU
                );
                $idjin = $idkar->row()->id_ijin;
                $jmhdrppk = $this->db->query("SELECT id_ijin from t_ppk_hdr where id_ijin = '$idjin'")->num_rows();
                if ($jmhdrppk == 0) {
                    $this->db->insert('t_ppk_hdr', $ppkhdr);
                }
            } else {
                if ($data1->KODE_RESPONSE == '005') {
                    $t_lic_hdr = array(
                        'JENIS_DOK' => 'SPPMP',
                        'NO_IJIN' => $data2->NO_DOC,
                        'TGL_IJIN' => $data2->TGL_DOC,
                        'NM_TRADER' => $data1->IMP->NAMA,
                        'ALM_TRADER' => $data1->IMP->ALAMAT,
                        'KODE_STATUS' => $data2->KODE_KANTOR,
                        'WK_REKAM' => date('Y-m-d H:i:s'),
                        'FL_BAPLIE' => '0'
                    );
                    $ppkhdr = array(
                        'ID_IJIN' => $cekdok->row()->id_ijin,
                        'TMP_TIMBUN' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                        'NO_RESPON' => $data2->NO_DOC,
                        'TG_RESPON' => $data2->TGL_DOC,
                        'NO_DAFTPPK' => $data2->NO_DOC,
                        'TG_DAFTPPK' => $data2->TGL_DOC,
                        'OPERATOR' => 'LNSW',
                        'FL_LNSW' => 'Y',
                        'LNSW_KD_RESPON' => $data1->KODE_RESPONSE,
                        'LNSW_IDLOG' => $tmbah->id,
                        'LNSW_NOAJU' => $data1->NO_AJU,
                        'LNSW_TGLAJU' => $data1->TGL_AJU
                    );

                    $datatreq = array(
                        'no_dok' => $data2->NO_DOC,
                        'tgl_dok' => $data2->TGL_DOC,
                        'consignee' => $data1->IMP->NAMA
                    );

                    $lic = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                    $lic = $this->db->set($t_lic_hdr);
                    $lic = $this->db->update('t_lic_hdr');

                    $hdr = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                    $hdr = $this->db->set($ppkhdr);
                    $hdr = $this->db->update('t_ppk_hdr');

                    $treq = $this->db->query("SELECT id,no_dok,tgl_dok FROM t_request WHERE jns_dok = 83 AND LEFT(no_dok,4) = YEAR(NOW()) and RIGHT(no_dok,12) = '$nodok1' ORDER BY id desc");
                    if ($treq->num_rows() > 0) {
                        $treq1 = $this->db->where('id', $treq->row()->id);
                        $treq1 = $this->db->set($datatreq);
                        $treq1 = $this->db->update("t_request");
                    }
                }
            }

        } else if ($type == 'krcont') {
            $nodok1 = explode('.', $data3->NO_DOC);
            $nodok1 = $nodok1[count($nodok1) - 1];
            $nocd = $data2['cont'];
            $cekdok = $this->db->query("SELECT a.id_ijin,a.NO_RESPON,a.TG_RESPON,LEFT(a.no_respon,4),RIGHT(a.no_respon,6),b.no_cont FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.id_ijin = b.ID_IJIN 
            WHERE LEFT(a.no_respon,4) = YEAR(NOW()) AND RIGHT(a.no_respon,6) = '$nodok1' AND b.no_cont = '$nocd' ");

            if ($cekdok->num_rows() == 0) {
                $idcont = $this->db->query("SELECT id_ijin FROM t_ppk_hdr WHERE no_respon = '$data3->NO_DOC' AND tg_respon = '$data3->TGL_DOC' ")->row();
                $ppkcont = array(
                    'ID_IJIN' => $idcont->id_ijin,
                    'NO_CONT' => $data2['cont'],
                    'SEGEL' => NULL,
                    'UKURAN' => $data2['ukuran'],
                    'ISO_CODE' => NULL,
                    'TIPE_CONT' => $data2['jenis'],
                    'IMO_CODE' => NULL,
                    'NO_TPFT' => $data2['tpft'],
                    'TGL_TPFT' => $data3->TGL_DOC,
                    'KD_GUDANG' => NULL,
                    'KD_GUDANG_PERIKSA' => NULL,
                    'KD_TIMBUN' => NULL,
                    'STATUS_CONT' => 'ND',
                    'STATUS_RELOKASI' => NULL,
                    'KD_STATUS' => '0',
                    'TGL_STATUS' => date('Y-m-d H:i:s'),
                    'FL_RELOCATION' => '0',
                    'TGL_RELOCATION' => NULL,
                    'FL_GATEPASS' => 'N',
                    'FL_TPS' => 'N',
                    'WK_FL_TPS' => NULL,
                    'FL_XML' => 'N',
                    'WK_FL_XML' => NULL,
                    'FL_LNSW' => 'Y',
                    'FL_LNSW_PERIKSA' => $data2['periksa']
                );
                $nc = $data2['cont'];
                $jmlcont = $this->db->query("SELECT id_ijin from t_ppk_cont where id_ijin = '$idcont->id_ijin' and no_cont = '$nc' ")->num_rows();
                if ($jmlcont == 0) {
                    if ($data1->KODE_RESPONSE == '005') {
                        $this->db->insert('t_ppk_cont', $ppkcont);
                    } else {
                        $this->db->insert('t_ppk_cont', $ppkcont);
                    }
                }
            } else {
                $ppkcont = array(
                    'NO_CONT' => $data2['cont'],
                    'UKURAN' => $data2['ukuran'],
                    'TIPE_CONT' => $data2['jenis'],
                    'NO_TPFT' => $data2['tpft'],
                    'TGL_TPFT' => $data3->TGL_DOC,
                    'TGL_STATUS' => date('Y-m-d H:i:s'),
                    'FL_LNSW' => 'Y',
                    'FL_LNSW_PERIKSA' => $data2['periksa']
                );
                $nc = $data2['cont'];
                $cont5 = $this->db->set($ppkcont);
                $cont5 = $this->db->where('id_ijin', $cekdok->row()->id_ijin);
                $cont5 = $this->db->where('no_cont', $data2['cont']);
                $cont5 = $this->db->update('t_ppk_cont');
            }
        } else if ($type == 'lg') {
            $data22 = array(
                'idlog' => $tmbah->id,
                'KODE_RESPONSE' => $data1->KODE_RESPONSE,
                'NO_AJU' => $data1->NO_AJU,
                'TGL_AJU' => $data1->TGL_AJU,
                'JML_CONTAINER' => $data1->JML_CONTAINER,
                'JML_CONTAINER_PERIKSA' => $data1->JML_CONTAINER_PERIKSA,
                'IMP_ID' => $data1->IMP->ID,
                'IMP_NAMA' => $data1->IMP->NAMA,
                'IMP_ALAMAT' => $data1->IMP->ALAMAT,
                'PJAWAB_NAMA' => $data1->IMP->PJAWAB->NAMA,
                'PJAWAB_JABATAN' => $data1->IMP->PJAWAB->JABATAN,
                'PJAWAB_ALAMAT' => $data1->IMP->PJAWAB->ALAMAT,
                'PJAWAB_TELP' => $data1->IMP->PJAWAB->TELP,
                'PJAWAB_EMAIL' => $data1->IMP->PJAWAB->EMAIL,
                'TRANSPORT_MODA' => $data1->TRANSPORT->LIST->MODA,
                'TRANSPORT_NOMOR' => $data1->TRANSPORT->LIST->NOMOR,
                'TRANSPORT_KODE_TERMINAL' => $data1->TRANSPORT->LIST->KODE_TERMINAL,
                'TRANSPORT_NAMA' => $data1->TRANSPORT->LIST->NAMA,
                'TRANSPORT_TGL_TIBA' => $data1->TRANSPORT->LIST->TGL_TIBA
            );
            $this->db->insert('t_log_detail_lnsw', $data22);
        } else if ($type == 'logrespon') {

            $respon = array(
                'no_aju' => $data1->NO_AJU,
                'tgl_aju' => $data1->TGL_AJU
            );
            $noaju5 = $data1->NO_AJU;
            $tglaj5 = $data1->TGL_AJU;
            $cekrespon = $this->db->query("SELECT id FROM t_log_lnsw_respon_cont WHERE no_aju = '$noaju5' AND tgl_aju = '$tglaj5'")->num_rows();
            if ($cekrespon == 0) {
                $this->db->insert('t_log_lnsw_respon_cont', $respon);
            }

        }
    }



}
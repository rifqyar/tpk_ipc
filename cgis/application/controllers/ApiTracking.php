<?php defined('BASEPATH') or exit('No direct script access allowed');

class ApiTracking extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->load->view('content/tracking/tracking');
    }

    public function getToken()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $access_token = md5(uniqid() . rand(1000000, 9999999));
        $expire = date('Y-m-d H:i:s', strtotime('+1 week'));
        $tmpData = array(
            "Token" => $access_token,
            "ValidUntil" => $expire
        );
        $this->db->insert('t_tracking_token', $tmpData);
        if ($this->db->affected_rows()) {
            $status = array(
                "Status" => "Success",
                "Data" => $tmpData
            );
            echo json_encode($status);
        }

    }
    public function getHistoryContainer()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');

        $nocont = $_POST['container'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //get authnya dulu
            $headers = getallheaders();

            // Check if Authorization header is present
            if (isset($headers['Authorization'])) {
                $authHeader = $headers['Authorization'];
            } else {
                $tmpData = array(
                    "Message" => "Authorization header not found.",
                );
                $status = array(
                    "Status" => "Error",
                    "Data" => $tmpData
                );
                echo json_encode($status);
                die();
            }
            if (substr($authHeader, 0, 6) == 'Bearer') {
                $token = substr($authHeader, 7);
                // cek auth bearer valid apa kagak
                $cektoken = $this->db->query("select * from t_tracking_token where Token = '$token'");
                foreach ($cektoken->result() as $key => $value2) {
                    $valuetoken = $value2->Token;
                    $expire = $value2->ValidUntil;
                }
                $currentDatetime = new DateTime();

                // Create DateTime objects for comparison
                $givenDatetime = DateTime::createFromFormat('Y-m-d H:i:s', $expire);
                if ($valuetoken == $token && $currentDatetime < $givenDatetime) {
                    //proses disini
                    $getData = $this->db->query("SELECT distinct A.NO_CONT,A.LOKASI, A.TIER, F.KETERANGAN, D.UKR_CONT, D.TIPE_CONT, D.KD_CONT_JENIS, B.NO_SPK, C.PRN_BEHANDLE_IN, C.PB1_START_PERIKSA, D.VESSEL, D.VOY_IN, D.DISCHARGE,
                    E.WK_GATEOUT
                    from t_spk_cont A
                    join t_spk B on A.ID = B.ID
                    left join report_behandle C on B.NO_SPK = C.RB1_NO_SPK and A.NO_CONT = C.NO_CONT
                    left join (select tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.VESSEL, trc.VOY_IN, trc.VOY_OUT, trc.DISCHARGE, trc.UKR_CONT, trc.TIPE_CONT, trc.KD_CONT_JENIS
                    from t_request tr join t_request_cont trc on tr.ID = trc.ID) D on D.NO_CONT = A.NO_CONT and B.NO_DOK = D.NO_DOK
                    left join (select NO_CONT ,NO_SPK, WK_GATEOUT from t_op_delivery) E on A.NO_CONT = E.NO_CONT and B.NO_SPK = E.NO_SPK
                    join reff_status_spk F on A.STATUS_CONT = F.ID
                    where A.NO_CONT = '$nocont'
                    order by A.ID desc");

                    foreach ($getData->result() as $key => $value3) {
                        $vessel = array(
                            "NM_KAPAL" => $value3->VESSEL,
                            "VOYAGE_IN" => $value3->VOY_IN,
                            "VOYAGE_OUT" => $value3->VOY_IN,
                            "TGL_TIBA" => $value3->DISCHARGE
                        );
                        $containerhdr["vessel"] = $vessel;
                        $container = array(
                            "NO_CONTAINER" => $value3->NO_CONT,
                            "SIZE_" => $value3->UKR_CONT,
                            "TYPE_" => $value3->TIPE_CONT,
                            "LOCATION" => $value3->KETERANGAN,
                            "COUNTER" => $value3->NO_SPK,
                            "NM_KAPAL" => $value3->VESSEL,
                            "VOYAGE_IN" => $value3->VOY_IN
                        );
                        $containerhdr["container"] = $container;
                        
                        $handlebehandlein = array(
                            "NO_CONTAINER" => $value3->NO_CONT,
                            "STATUS_CONT" => $value3->KD_CONT_JENIS,
                            "KEGIATAN" => "BEHANDLE IN",
                            "TGL_UPDATE" => $value3->PRN_BEHANDLE_IN,
                            "NO_REQUEST" => $value3->NO_SPK
                        );
                        $handlehdr = array();
                        $handlehdr[] = $handlebehandlein;
                        $handleinspection = array(
                            "NO_CONTAINER" => $value3->NO_CONT,
                            "STATUS_CONT" => $value3->KD_CONT_JENIS,
                            "KEGIATAN" => "INSPECTION",
                            "TGL_UPDATE" => $value3->PB1_START_PERIKSA,
                            "NO_REQUEST" => $value3->NO_SPK
                        );
                        $handlehdr[] = $handleinspection;

                        $handlegateout = array(
                            "NO_CONTAINER" => $value3->NO_CONT,
                            "STATUS_CONT" => $value3->KD_CONT_JENIS,
                            "KEGIATAN" => "GATE OUT",
                            "TGL_UPDATE" => $value3->WK_GATEOUT,
                            "NO_REQUEST" => $value3->NO_SPK
                        );
                        $handlehdr[] = $handlegateout;
                        $containerhdr["handling"] = $handlehdr;
                        $containers[] = $containerhdr;

                    }
                    $respon = array(
                        "Status" => "Success",
                        "Data" => $containers
                    );

                    echo json_encode($respon);
                } else {
                    $tmpData = array(
                        "Message" => "Authorization Token invalid.",
                    );
                    $status = array(
                        "Status" => "Error",
                        "Data" => $tmpData
                    );
                    echo json_encode($status);
                }
                die();
            } else {
                $tmpData = array(
                    "Message" => "Authorization header invalid.",
                );
                $status = array(
                    "Status" => "Error",
                    "Data" => $tmpData
                );
                echo json_encode($status);
                die();
            }
        } else {
            $tmpData = array(
                "Message" => "Method Not Allowed",
            );
            $status = array(
                "Status" => "Error",
                "Data" => $tmpData
            );
            echo json_encode($status);
        }
    }

    public function getData(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');

        $nocont = $_POST['container'];
        // $vessel = $_POST['vessel'];
        // $voyage = $_POST['voyage'];

        $sql = "SELECT distinct A.NO_CONT,A.LOKASI, A.TIER, F.KETERANGAN, D.UKR_CONT, D.TIPE_CONT, D.KD_CONT_JENIS, B.NO_SPK, C.PRN_BEHANDLE_IN, C.PB1_START_PERIKSA, D.VESSEL, D.VOY_IN, D.DISCHARGE,
        E.WK_GATEOUT
        from t_spk_cont A
        join t_spk B on A.ID = B.ID
        left join report_behandle C on B.NO_SPK = C.RB1_NO_SPK and A.NO_CONT = C.NO_CONT
        left join (select tr.NO_DOK, tr.TGL_DOK, trc.NO_CONT, trc.VESSEL, trc.VOY_IN, trc.VOY_OUT, trc.DISCHARGE, trc.UKR_CONT, trc.TIPE_CONT, trc.KD_CONT_JENIS
        from t_request tr join t_request_cont trc on tr.ID = trc.ID) D on D.NO_CONT = A.NO_CONT and B.NO_DOK = D.NO_DOK
        left join (select NO_CONT ,NO_SPK, WK_GATEOUT from t_op_delivery) E on A.NO_CONT = E.NO_CONT and B.NO_SPK = E.NO_SPK
        join reff_status_spk F on A.STATUS_CONT = F.ID
        where A.NO_CONT = '$nocont'
        order by A.ID desc";

        $Query =$this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class ApiKarantina extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $statusMap = array(
            'WAITING' => array('000'),
            'ANNOUNCE' => array('100'),
            'PICKUP' => array('200'),
            'HOLD' => array('300'),

            'BEHANDLE IN' => array('400'),

            'STACKING' => array('450','460'),   // YARD + CIC
            'STACKING YARD' => array('450'),
            'STACKING CIC' => array('460'),

            'PLACEMENT' => array('50'),
            'SELESAI PERIKSA' => array('500'),

            'MARSHALLING' => array('510','520','530','540'),
            'MARSHALLING BEHANDLE' => array('510','530'),
            'MARSHALLING EX BEHANDLE' => array('520','540'),
            'MARSHALLING BEHANDLE 1' => array('510'),
            'MARSHALLING EX BEHANDLE 1' => array('520'),
            'MARSHALLING BEHANDLE 2' => array('530'),
            'MARSHALLING EX BEHANDLE 2' => array('540'),

            'DELIVERY' => array('900'),
        );
        $hasDateFilter = false;

        try {
            // auth bearer stateless
            $auth = $this->input->get_request_header('Authorization');

            if (!$auth || !preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
                return $this->responseJson(false, 401, 'Unauthorized', null);
            }

            $token = $matches[1];
            $decoded = base64_decode($token);

            if (!$decoded || strpos($decoded, ':') === false) {
                return $this->responseJson(false, 401, 'Unauthorized', null);
            }

            list($username, $password) = explode(':', $decoded, 2);

            $user = $this->db
                ->where('USER_NAME', $username)
                ->where_in('KD_GROUP', array('SPA', 'KAR', 'KARANTINA'))
                ->get('reff_user')
                ->row();

            if (!$user || md5($password) !== $user->PASS) {
                $this->responseJson(false, 401, 'Unauthorized', null);
            }
            // ambil POST (JSON atau form-data)
            $input = json_decode($this->input->raw_input_stream, true);
            if (!$input) {
                $input = $this->input->post();
            }

            // ==== BUILD WHERE DINAMIS ====
            $where = array();
            $binds = array();
            $where[] = "B.JNS_DOK = '83'";
            // NO CONT
            if (!empty($input['no_cont'])) {
                $where[] = "A.NO_CONT = ?";
                $binds[] = $input['no_cont'];
            }

            // NO DOK
            if (!empty($input['no_dok'])) {
                $where[] = "B.NO_DOK = ?";
                $binds[] = $input['no_dok'];
            }

            // NPWP (normalize)
            if (!empty($input['npwp'])) {
                $where[] = "REPLACE(REPLACE(REPLACE(REPLACE(A.NPWP,'.',''),'-',''),'/',''),' ','') = ?";
                $binds[] = $input['npwp'];
            }

            // TGL_DOK logic
            if (!empty($input['tgl_dok'])) {
                $where[] = "A.TGL_DOK = ?";
                $binds[] = $input['tgl_dok'];
                $hasDateFilter = true;
            } else {
                if (!empty($input['start_date'])) {
                    $where[] = "A.TGL_DOK >= ?";
                    $binds[] = $input['start_date'];
                    $hasDateFilter = true;
                }
                if (!empty($input['end_date'])) {
                    $where[] = "A.TGL_DOK <= ?";
                    $binds[] = $input['end_date'];
                    $hasDateFilter = true;
                }
            }

            // Kalau tidak ada filter tanggal batasi 3 bulan terakhir biar gak nangid data dari awal prod nongol
            if (!$hasDateFilter) {
                $where[] = "A.TGL_DOK >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
            }


            // STATUS CONT
            if (!empty($input['status_cont'])) {

                $key = strtoupper(trim($input['status_cont']));
                $key = preg_replace('/\s+/', ' ', $key); 

                if (!isset($statusMap[$key])) {
                    return $this->responseJson(false, 400, 'Parameter status kontainer tidak valid', array(
                        'allowed' => array_keys($statusMap)
                    ));
                }

                $codes = $statusMap[$key];

                // bikin ?,?,? untuk IN clause
                $in = implode(',', array_fill(0, count($codes), '?'));

                $where[] = "C.STATUS_CONT IN ($in)";

                foreach ($codes as $c) {
                    $binds[] = $c;
                }
            }


            // default safety
            if (empty($where)) {
                return $this->responseJson(false, 400, 'Parameter tidak valid', null);
            }

            $whereSql = implode(" AND ", $where);
            $sql = "
            SELECT 
                    A.NO_CONT,
                    CC.TIPE_CONT,
                    B.NO_DOK,
                    B.TGL_DOK,
                    A.RESPON,
                    CASE
                        WHEN D.WK_IN IS NULL THEN 
                            CONCAT('TERMINAL - ', E.KETERANGAN)
                        WHEN LEFT(C.LOKASI, 2) = '1B' THEN 
                            CONCAT('BEFORE AREA - ', E.KETERANGAN)
                        WHEN LEFT(C.LOKASI, 3) = 'CIC' THEN 
                            CONCAT('LONG ROOM - ', E.KETERANGAN)
                        WHEN LEFT(C.LOKASI, 2) = '1A' THEN 
                            CONCAT('AFTER BEHANDLE - ', E.KETERANGAN)
                        ELSE 
                            E.KETERANGAN
                    END AS LOCATION,
                    CONCAT(C.LOKASI ,' - ', C.TIER ) as 'POSITION',
                    E.KETERANGAN,
                    CC.DISCHARGE as 'DATE_STACK',
                    D.WK_TERMINAL_OUT as 'DATE_GATEOUT_TERMINAL',
                    D.WK_IN AS 'DATE_GATE_IN_CA',
                    J1.WK_STATUS as 'DATE_SIAP_PERIKSA',
                    INS.START_INSP as 'DATE_START_PERIKSA',
                    INS.FINISH_INSP as 'DATE_SELESAI_PERIKSA',
                    J2.WK_STATUS as 'DATE_STACK_AFTER_BEHANDLE',
                    DD.WK_GATEOUT as 'DATE_GATEOUT',
                    A.NPWP as 'NPWP',
                    A.NAMA_CUST 'COMPANY_NAME'
                FROM t_gatepass A
                JOIN t_spk B 
                    ON A.NO_DOK = B.NO_DOK 
                AND A.TGL_DOK = B.TGL_DOK
                JOIN t_spk_cont C 
                    ON B.ID = C.ID 
                AND A.NO_CONT = C.NO_CONT
                join t_request BB on B.NO_DOK = BB.NO_DOK and B.TGL_DOK = BB.TGL_DOK
                join t_request_cont CC on BB.ID = CC.ID and C.NO_CONT = CC.NO_CONT
                LEFT JOIN (
                    SELECT *
                    FROM t_operation x
                    WHERE x.ID = (
                        SELECT MAX(y.ID)
                        FROM t_operation y
                        WHERE y.NO_SPK = x.NO_SPK
                        AND y.NO_CONT = x.NO_CONT
                    )
                ) D
                    ON D.NO_SPK = B.NO_SPK
                AND D.NO_CONT = C.NO_CONT
                LEFT JOIN (
                    SELECT *
                    FROM t_op_delivery tod
                    WHERE tod.ID = (
                        SELECT MAX(y.ID)
                        FROM t_op_delivery y
                        WHERE y.NO_SPK = tod.NO_SPK
                        AND y.NO_CONT = tod.NO_CONT
                    )
                ) DD
                    ON DD.NO_SPK = B.NO_SPK
                AND DD.NO_CONT = C.NO_CONT
                JOIN reff_status_spk E 
                    ON C.STATUS_CONT = E.ID 
                left join t_job_slip J1 on B.NO_SPK = J1.NO_SPK and C.NO_CONT = J1.NO_CONT and J1.JENIS = 'BEHANDLE 1' and J1.STATUS = 'DONE'
                left join t_job_slip J2 on B.NO_SPK = J2.NO_SPK and C.NO_CONT = J2.NO_CONT and J2.JENIS = 'EX BEHANDLE 1' and J2.STATUS = 'DONE'
                left join t_op_inspection INS on B.NO_SPK = INS.NO_SPK and C.NO_CONT = INS.NO_CONT
            WHERE $whereSql
            ORDER BY A.TGL_DOK DESC
            ";
            $query = $this->db->query($sql, $binds);
            $data = $query->result_array();

            $this->responseJson(true, 200, 'OK', array(
                'count' => count($data),
                'rows' => $data
            ));
        } catch (Exception $e) {
            $this->responseJson(false, 500, 'Internal Server Error', null);
        }
    }

    function responseJson($status, $httpCode = 200, $message = '', $data = null)
    {
        // PHP 5.3 compatible
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('HTTP/1.1 ' . $httpCode);
        }

        $payload = array(
            'status'  => $status,
            'code'    => $httpCode,
            'message' => $message,
            'data'    => $data
        );

        echo json_encode($payload);
        exit; // penting: stop script
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class ProsesPercepatan extends CI_Controller
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
        $this->load->model("m_service_materai");
        $header_nota = $this->m_service_materai->setting_point();
        $data_nota['maindata'] = $this->m_service_materai->monitoring_all_nota();
        $data_nota['faildata'] = $this->m_service_materai->failed_nota();

        $data = $this->load->view('content/monitoring/service_materai', $data_nota);
        echo $data;
    }

    public function gantiformattglgblk($tgl)
    {
        $date = date_create_from_format("Ymd", $tgl);
        $date1 = date_format($date, "Y-m-d");
        return $date1;
    }
    public function gantiformattglgblk2($tgl)
    {
        $date = date_create_from_format("YmdHis", $tgl);
        $date1 = date_format($date, "Y-m-d H:i:s");
        return $date1;
    }

    //========================================================================================================================================================================//
    //PROSES DATA KIRIMAN DARI NPCT1
    public function rekon_gatepass()
    {
        $Q = $this->db->query("SELECT * FROM t_log_auto_gatepass WHERE FL_PROSES = 'N' limit 10");
        if (count($Q->result()) == 0) {
            echo "NO DATA TO PROCESS" . "\r\n";
        } else {
            foreach ($Q->result() as $key => $value1) {
                echo "******************************************************************************************" . "\r\n";
                $id_transaksi = $xmlditerima = $value1->ID;
                $xmlditerima = $value1->XML_RECEIVED;
                // PROSES XML YANG SUDAH JADI JSON==================================//
                $encodeddata = json_decode($xmlditerima);
                $cont_no = $encodeddata->cont_no;
                $isocode = $encodeddata->isocode;
                $weight = $encodeddata->weight;
                $full_empty = $encodeddata->full_empty;
                $in_out = $encodeddata->in_out;
                $tar = $encodeddata->tar;
                $vessel_name = $encodeddata->vessel_name;
                $voyage_in = $encodeddata->voyage_in;
                $voyage_out = $encodeddata->voyage_out;
                $paidthrough = $this->gantiformattglgblk2($encodeddata->paidthrough);
                $pod = $encodeddata->pod;
                $spod = $encodeddata->spod;
                $customer_name = $encodeddata->customer_name;
                $cust_type = $encodeddata->cust_type;
                $cust_no = $encodeddata->cust_no;
                $cust_date = $this->gantiformattglgblk($encodeddata->cust_date);
                $imdg = $encodeddata->imdg;
                $imdg_value = $encodeddata->imdg_value;
                $reff_number = $encodeddata->reff_number;
                $remark = $encodeddata->remark;

                // CEK APA SUDAH ADA DATA DI T_REQUEST_CONT  ==================================//

                $Q1 = $this->db->query("SELECT tr.ID, trc.NO_CONT, trc.TAR FROM t_request tr JOIN t_request_cont trc on tr.ID = trc.ID
                 WHERE tr.NO_DOK = '$cust_no' and tr.TGL_DOK = '$cust_date'");
                if (count($Q1->result()) == 0) {
                    echo "REQUEST DATA NOT FOUND" . "\r\n";
                    $SQL = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'NO REQUEST DATA' WHERE ID = '$id_transaksi'";
                    $this->db->query($SQL);
                } else {
                    echo "found request data for container '$cont_no'" . "\r\n";
                    foreach ($Q1->result() as $key => $value2) {
                        $id_t_request = $value2->ID;
                        //UPDATE PAIDTROUGH =========================================================//
                        $SQLUPDATE = "UPDATE t_request tr set WK_REQ = '$paidthrough'
                        WHERE tr.ID = '$id_t_request'";
                        $this->db->query($SQLUPDATE);
                        if ($this->db->affected_rows() != 0) {
                            echo "PAIDTROUGH UPDATED" . "\r\n";
                            $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK_2 = 'PAIDTROUGH UPDATED' WHERE ID = '$id_transaksi'";
                            $this->db->query($SQLEND);
                        } else {
                            echo "Failed UPDATE PAIDTROUGH" . "\r\n";
                            $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK_2 = 'Failed UPDATE PAIDTROUGH' WHERE ID = '$id_transaksi'";
                            $this->db->query($SQLEND);
                        }
                        //UPDATE PAIDTROUGH =========================================================//
                        echo "updating TAR for container '$cont_no'" . "\r\n";
                        echo "TAR VALUE IS '$tar'" . "\r\n";
                        // CEK UDAH ADA TAR APA BELON  ==================================//
                        if ($value2->TAR == null) {
                            echo "saving tar" . "\r\n";
                            $SQLUPDATE = "UPDATE t_request_cont trc set TAR = '$tar', KD_STATUS = 'INQUIRY', REF_NUMBER = '$reff_number'
                            WHERE trc.ID = '$id_t_request' and trc.NO_CONT = '$cont_no'";
                            $this->db->query($SQLUPDATE);
                            if ($this->db->affected_rows() != 0) {
                                echo "TAR saved succesfully" . "\r\n";
                                $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'TAR saved succesfully' WHERE ID = '$id_transaksi'";
                                $this->db->query($SQLEND);
                            } else {
                                echo "Failed Save TAR, check database" . "\r\n";
                                $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'FAILED SAVE TAR' WHERE ID = '$id_transaksi'";
                                $this->db->query($SQLEND);
                            }
                        } else {
                            echo "tar is already exist" . "\r\n";
                            $SQLEND = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y', REMARK = 'TAR ALREADY EXIST' WHERE ID = '$id_transaksi'";
                            $this->db->query($SQLEND);
                        }
                    }
                }




                // $SQL = "UPDATE t_log_auto_gatepass SET FL_PROSES= 'Y' WHERE ID = '$id_transaksi'";
                // $this->db->query($SQL);
            }
        }
    }

    public function proses_rekon_dokumen()
    {
        $Q = $this->db->query("SELECT * FROM t_log_rekon_dokumen WHERE FL_PROSES = 'N' limit 25");
        if (count($Q->result()) == 0) {
            echo "NO DATA TO PROCESS" . "\r\n";
        } else {
            foreach ($Q->result() as $key => $value1) {
                $id_transaksi = $xmlditerima = $value1->ID;
                $xmlditerima = $value1->XML_RECEIVED;
                // PROSES XML YANG SUDAH JADI JSON==================================//
                $encodeddata = json_decode($xmlditerima);
                $request_no = $encodeddata->request_no;
                $request_date = $this->gantiformattglgblk($encodeddata->request_date);
                $document_type = $encodeddata->document_type;
                $document_no = $encodeddata->document_no;
                $document_date = $this->gantiformattglgblk($encodeddata->document_date);
                $vessel_name = $encodeddata->vessel_name;
                $call_sign = $encodeddata->call_sign;
                $voyage = $encodeddata->voyage;
                $cont_no = $encodeddata->cont_no;
                $cont_size = $encodeddata->cont_size;
                $cont_size = explode(".", $cont_size);
                $cont_size = $cont_size[0];
                $inspection = $encodeddata->inspection;
                $status = $encodeddata->status;
                $consignee = is_object($encodeddata->consignee_name)
                    ? null
                    : $encodeddata->consignee_name;

                $consignee_npwp = is_object($encodeddata->consignee_id)
                    ? null
                    : $encodeddata->consignee_id;

                $ppjk = is_object($encodeddata->ppjk_name)
                    ? null
                    : $encodeddata->ppjk_name;

                $ppjk_npwp = is_object($encodeddata->ppjk_id)
                    ? null
                    : $encodeddata->ppjk_id;

                // cek udah ada value sebelumnya di tabel
                $QC = $this->db->query("SELECT * from t_rekon_dokumen_npct1 trdn where NO_CONT = '$cont_no' and NO_DOK  = '$document_no' and TGL_DOK = '$document_date'");
                if (count($QC->result()) == 0) {
                    echo "NO EXISTING DATA FOUND, BEGIN PROCES INSERT " . "$cont_no" . "\r\n";
                    $QInsert = "INSERT INTO t_rekon_dokumen_npct1
                    (LNSW_NO_AJU, LNSW_TANGGAL_AJU, VESSEL, CALL_SIGN, VOYAGE, NO_CONT, NO_DOK, TYPE_DOK, PERIKSA, STATUS_NPCT1, TGL_DOK, CONT_SIZE, CONSIGNEE, CONSIGNEE_NPWP, PPJK, PPJK_NPWP)
                    VALUES('$request_no', '$request_date', '$vessel_name', '$call_sign', '$voyage', '$cont_no', '$document_no', '$document_type', '$inspection', '$status', '$document_date', '$cont_size', '$consignee', '$consignee_npwp', '$ppjk', '$ppjk_npwp')";
                    $this->db->query($QInsert);
                    // //
                    $actualstack = $this->gantiformattglgblk2($encodeddata->actual_time);

                    $SQLUPDATESTACK = "UPDATE t_cocostscont a join t_cocostshdr b
                                        on a.ID = b.ID set a.WK_IN = '$actualstack'
                                        where b.NM_ANGKUT = '$vessel_name' and b.NO_VOY_FLIGHT = '$voyage' and 
                                        a.NO_CONT = '$cont_no'";
                    $this->db->query($SQLUPDATESTACK);

                    $SQLEND = "UPDATE t_log_rekon_dokumen SET FL_PROSES= 'Y', REMARK_PROSES = 'SUCCESS' WHERE ID = '$id_transaksi'";
                    $this->db->query($SQLEND);
                } else {
                    echo "DATA " . "$cont_no" . " ALREADY EXIST" . "\r\n";
                    echo "UPDATING DATA " . "$cont_no" . "\r\n";
                    $QUpdate = "UPDATE
                                    tpk_ipc.t_rekon_dokumen_npct1
                                set
                                    LNSW_NO_AJU = '$request_no',
                                    LNSW_TANGGAL_AJU = '$request_date',
                                    VESSEL = '$vessel_name',
                                    CALL_SIGN = '$call_sign',
                                    VOYAGE = '$voyage',
                                    NO_CONT = '$cont_no',
                                    NO_DOK = '$document_no',
                                    TYPE_DOK = '$document_type',
                                    PERIKSA = '$inspection',
                                    STATUS_NPCT1 = '$status',
                                    TGL_DOK = '$document_date',
                                    `TIMESTAMP` = CURRENT_TIMESTAMP,
                                    CONT_SIZE = '$cont_size',
                                    CONSIGNEE = '$consignee',
                                    CONSIGNEE_NPWP = '$consignee_npwp',
                                    PPJK = '$ppjk',
                                    PPJK_NPWP = '$ppjk_npwp'
                                where
                                    NO_DOK = '$document_no' and TGL_DOK = '$document_date' and NO_CONT = '$cont_no'";
                    // $SQLEND = "DELETE FROM t_log_rekon_dokumen WHERE ID = '$id_transaksi'";
                    $this->db->query($QUpdate);
                    $SQLEND = "UPDATE t_log_rekon_dokumen SET FL_PROSES= 'Y', REMARK_PROSES = 'SUCCESS' WHERE ID = '$id_transaksi'";
                    $this->db->query($SQLEND);
                }
            }
        }
    }
}

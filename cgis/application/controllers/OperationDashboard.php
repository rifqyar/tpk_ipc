<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class OperationDashboard extends CI_Controller
{

    public function set_announce()
    {
        // Manually set the NO_CONT and NO_SPK for now
        $no_cont = $this->input->get('no_cont');
        $no_spk = $this->input->get('no_spk');

        // Load the database library
        $this->load->database();

        // Initialize log array to store the status of each query
        $log = array();

        // 1. Fetch records based on NO_CONT and NO_SPK
        $sql_select = "SELECT tr.ID as ID_T_REQUEST, ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.ID as ID_SPK 
                       FROM t_spk ts 
                       JOIN t_spk_cont tsc ON ts.ID = tsc.ID 
                       JOIN t_request tr ON tr.NO_DOK = ts.NO_DOK AND tr.TGL_DOK = tr.TGL_DOK
                       WHERE tsc.NO_CONT = ? AND ts.NO_SPK = ?";

        $query = $this->db->query($sql_select, array($no_cont, $no_spk));
        $result = $query->row();

        if ($result) {
            $log['select_query'] = 'Success';
            $id_spk = $result->ID_SPK;
            $id_t_request = $result->ID_T_REQUEST;

            // 2. Update t_spk_cont
            $sql_update_spk_cont = "UPDATE t_spk_cont 
                                    SET STATUS_CONT = '100', FL_SEND_NPCT1 = 'N', ID_FLAT = NULL 
                                    WHERE NO_CONT = ? AND ID = ?";
            if ($this->db->query($sql_update_spk_cont, array($no_cont, $id_spk))) {
                $log['update_spk_cont'] = 'Success';
            } else {
                $log['update_spk_cont'] = 'Failed';
            }

            // 3. Delete operations from various tables
            $sql_delete_operation = "DELETE FROM t_operation WHERE NO_CONT = ? AND NO_SPK = ?";
            if ($this->db->query($sql_delete_operation, array($no_cont, $id_spk))) {
                $log['delete_operation'] = 'Success';
            } else {
                $log['delete_operation'] = 'Failed';
            }

            $sql_delete_pickup = "DELETE FROM t_op_pickup WHERE NO_CONT = ? AND NO_SPK = ?";
            if ($this->db->query($sql_delete_pickup, array($no_cont, $id_spk))) {
                $log['delete_pickup'] = 'Success';
            } else {
                $log['delete_pickup'] = 'Failed';
            }

            $sql_delete_behandlein = "DELETE FROM t_op_behandlein WHERE NO_CONT = ? AND NO_SPK = ?";
            if ($this->db->query($sql_delete_behandlein, array($no_cont, $id_spk))) {
                $log['delete_behandlein'] = 'Success';
            } else {
                $log['delete_behandlein'] = 'Failed';
            }

            $sql_delete_job_slip = "DELETE FROM t_job_slip WHERE NO_CONT = ? AND NO_SPK = ? AND JENIS = 'BEHANDLE 1'";
            if ($this->db->query($sql_delete_job_slip, array($no_cont, $id_spk))) {
                $log['delete_job_slip'] = 'Success';
            } else {
                $log['delete_job_slip'] = 'Failed';
            }

            // 4. Update job slip for 'PICKUP'
            $sql_update_job_slip = "UPDATE t_job_slip 
                                    SET STATUS = 'WAITING', KD_STATUS = '10' 
                                    WHERE NO_SPK = ? AND NO_CONT = ? AND JENIS = 'PICKUP'";
            if ($this->db->query($sql_update_job_slip, array($id_spk, $no_cont))) {
                $log['update_job_slip'] = 'Success';
            } else {
                $log['update_job_slip'] = 'Failed';
            }

            // 5. Update request container
            $sql_update_request_cont = "UPDATE t_request_cont 
                                        SET FL_PERBAIKI = 'N' 
                                        WHERE NO_CONT = ? AND ID = ?";
            if ($this->db->query($sql_update_request_cont, array($no_cont, $id_t_request))) {
                $log['update_request_cont'] = 'Success';
            } else {
                $log['update_request_cont'] = 'Failed';
            }

        } else {
            $log['select_query'] = 'No data found for the specified NO_CONT and NO_SPK.';
        }

        // Return the log as JSON response
        echo json_encode($log);
    }

    public function set_antrian_periksa()
    {
        $no_cont = $this->input->get('no_cont');
        $no_spk = $this->input->get('no_spk');

        // Load the database library
        $this->load->database();

        // First query to fetch from t_spk, t_spk_cont, and t_request
        $sql_select = "SELECT tr.ID as ID_T_REQUEST, ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.ID as ID_SPK 
        FROM t_spk ts 
        JOIN t_spk_cont tsc ON ts.ID = tsc.ID 
        JOIN t_request tr ON tr.NO_DOK = ts.NO_DOK AND tr.TGL_DOK = tr.TGL_DOK
        WHERE tsc.NO_CONT = ? AND ts.NO_SPK = ?";

        $query = $this->db->query($sql_select, array($no_cont, $no_spk));
        $result = $query->row();

        if ($result) {
            $log['select_query'] = 'Success';
            $id_spk = $result->ID_SPK;
            $id_t_request = $result->ID_T_REQUEST;
            $no_dok = $result->NO_DOK; // Get NO_DOK from the result

            // Additional query to fetch LOKASI_AWAL and TIER_AWAL from t_job_slip & update spk cont status
            $sql_select_job_slip = "SELECT A.LOKASI_AWAL, A.TIER_AWAL 
            FROM t_job_slip A 
            WHERE A.NO_CONT = ? 
            AND A.NO_SPK = ? 
            AND A.JNS_JOB_SLIP = 'MARSHALLING' 
            AND A.JENIS = 'BEHANDLE 1'";

            $query_job_slip = $this->db->query($sql_select_job_slip, array($no_cont, $no_spk));
            $job_slip_result = $query_job_slip->row();

            if ($job_slip_result) {
                $log['FIND_job_slip_query'] = 'Success';
                $lokasi_awal = $job_slip_result->LOKASI_AWAL;
                $tier_awal = $job_slip_result->TIER_AWAL;

                $sql_update_spk_cont = "UPDATE t_spk_cont 
                SET STATUS_CONT = '100', FL_SEND_NPCT1 = 'N', ID_FLAT = NULL, LOKASI = ?, TIER = ?
                WHERE NO_CONT = ? AND ID = ?";

                if ($this->db->query($sql_update_spk_cont, array($lokasi_awal, $tier_awal, $no_cont, $id_spk))) {
                    $log['update_spk_cont'] = 'Success';
                } else {
                    $log['update_spk_cont'] = 'Failed';
                }
            } else {
                $log['job_slip_query'] = 'No data found in t_job_slip for the specified conditions.';
            }

            // Update t_gatepass to set STATUS to 'WAITING'
            $sql_update_gatepass = "UPDATE t_gatepass 
            SET STATUS = 'WAITING' 
            WHERE NO_CONT = ? AND NO_DOK = ?";

            if ($this->db->query($sql_update_gatepass, array($no_cont, $no_dok))) {
                $log['update_gatepass'] = 'Success';
            } else {
                $log['update_gatepass'] = 'Failed';
            }

            // Delete job_slip rows where JENIS is null
            $sql_delete_job_slip = "DELETE FROM t_job_slip WHERE NO_CONT = ? AND NO_SPK = ? AND JENIS IS NULL";
            if ($this->db->query($sql_delete_job_slip, array($no_cont, $id_spk))) {
                $log['delete_job_slip_NULL'] = 'Success';
            } else {
                $log['delete_job_slip_NULL'] = 'Failed';
            }

            // Delete job_slip rows where JENIS is 'EX BEHANDLE 1'
            $sql_delete_job_slip1 = "DELETE FROM t_job_slip WHERE NO_CONT = ? AND NO_SPK = ? AND JENIS = 'EX BEHANDLE 1'";
            if ($this->db->query($sql_delete_job_slip1, array($no_cont, $id_spk))) {
                $log['delete_job_slip_EXBEHANDLE_1'] = 'Success';
            } else {
                $log['delete_job_slip_EXBEHANDLE_1'] = 'Failed';
            }

            // Delete t_op_inspection rows
            $sql_delete_INSPECTION = "DELETE FROM t_op_inspection WHERE NO_CONT = ? AND NO_SPK = ?";
            if ($this->db->query($sql_delete_INSPECTION, array($no_cont, $id_spk))) {
                $log['delete_inspection'] = 'Success';
            } else {
                $log['delete_inspection'] = 'Failed';
            }

        } else {
            $log['select_query'] = 'No data found for the specified NO_CONT and NO_SPK.';
        }

    }



}

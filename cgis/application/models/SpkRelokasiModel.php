<?php
class SpkRelokasiModel extends CI_Model {

    public function get_all_relocations() {
        $this->db->select('hdr.*, cont.*');
        $this->db->from('t_spk_relocation_hdr hdr');
        $this->db->join('t_spk_relocation_cont cont', 'hdr.ID = cont.ID_SPK', 'left');
        $query = $this->db->get();
        return $query->result_array(); // Return result as an array
    }
    public function get_header_by_id($id_spk) {
        $this->db->where('ID', $id_spk);
        $query = $this->db->get('t_spk_relocation_hdr');
        return $query->row_array(); // Return result as a single array
    }

    public function get_all_headers() {
        $query = $this->db->get('t_spk_relocation_hdr');
        return $query->result_array(); // Return result as an array
    }

    // Fetch container details for a specific header
    public function get_containers_by_spk($id_spk) {
        $this->db->select('A.*, C.ID as gatepass_status'); // Select all columns from A and rename C.ID to gatepass_status
        $this->db->from('t_spk_relocation_cont A'); // From t_spk_relocation_cont
        $this->db->join('t_spk_relocation_hdr B', 'A.ID_SPK = B.ID'); // Inner join with t_spk_relocation_hdr
        $this->db->join('t_gatepass C', 'B.NO_DOK = C.NO_DOK AND A.NO_CONT = C.NO_CONT', 'left'); // Left join with t_gatepass
        $this->db->where('A.ID_SPK', $id_spk); // Keep the WHERE condition
    
        $query = $this->db->get(); // Execute the query
        return $query->result_array(); // Return result as an array
    }
    

    public function get_permits_by_no_dok($no_dok_inout) {

        $sql = "SELECT A.ID, A.NO_DOK_INOUT, A.TGL_DOK_INOUT, B.NAMA
                FROM t_permit_hdr A
                JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
                WHERE A.NO_DOK_INOUT = ?";
    
        $query = $this->db->query($sql, array($no_dok_inout));
        return $query->result_array(); // Return result as an array of records
    }
    
    
    public function get_permit_by_id($id) {

        $sql = "SELECT A.*, B.NAMA as 'JENIS_DOKUMEN'
                FROM t_permit_hdr A
                JOIN reff_kode_dok_bc B ON A.KD_DOK_INOUT = B.ID
                WHERE A.ID = ?";
    
        $query = $this->db->query($sql, array($id));
        return $query->row_array(); // Return a single row as an associative array
    }
    
    // Get containers related to a specific permit ID
    public function get_containers_by_permit_id($permit_id) {
        $this->db->where('ID', $permit_id);
        $query = $this->db->get('t_permit_cont');
        return $query->result_array();
    }
    public function get_container_by_id($id_container) {
        $this->db->select('B.NO_DOK, D.NO_DOK_INOUT as PERMIT_DOK_RELEASE, F.NAMA as PERMIT_DOK_NAME, E.NO_CONT as PERMIT_CONT, D.CONSIGNEE as PERMIT_CONSIGNEE, B.TGL_DOK, A.*, C.ID as GATEPASS');
        $this->db->from('t_spk_relocation_cont A'); // From t_spk_relocation_cont
        $this->db->join('t_spk_relocation_hdr B', 'A.ID_SPK = B.ID'); // Inner join with t_spk_relocation_hdr
        $this->db->join('t_gatepass C', 'B.NO_DOK = C.NO_DOK AND A.NO_CONT = C.NO_CONT', 'left'); // Left join with t_gatepass
        $this->db->join('t_permit_hdr D', 'B.NO_DOK = D.NO_DOK_INOUT AND D.TGL_DOK_INOUT = B.TGL_DOK', 'left'); // Left join with t_permit_hdr
        $this->db->join('t_permit_cont E', 'D.ID = E.ID AND E.NO_CONT = A.NO_CONT', 'left'); // Left join with t_permit_cont
        $this->db->join('reff_kode_dok_bc F', 'D.KD_DOK_INOUT = F.ID', 'left'); // Left join with reff_kode_dok_bc
        $this->db->where('A.ID', $id_container); // Keep the WHERE condition to filter by container ID
    
        $query = $this->db->get(); // Execute the query
        return $query->row_array(); // Return a single row as an array
    }
    
    
    
    public function search_containers_by_dok($no_dok, $tgl_dok) {
        $this->db->select('A.NO_CONT, A.NO_DOK, A.TGL_DOK');
        $this->db->from('t_gatepass A');
        $this->db->join('t_permit_hdr B', 'A.NO_DOK = B.NO_DOK_INOUT AND A.TGL_DOK = B.TGL_DOK_INOUT');
        $this->db->join('t_permit_cont C', 'B.ID = C.ID');
        $this->db->join('t_spk F', 'A.NO_DOK = F.NO_DOK AND A.TGL_DOK = F.TGL_DOK');
        $this->db->where('A.NO_DOK', $no_dok);
        $this->db->where('A.TGL_DOK', $tgl_dok);
        
        $query = $this->db->get();
        return $query->result_array(); // Return results as an array
    }

    public function search_by_nodok($no_dok) {
        $query = $this->db->query("
            SELECT A.NO_CONT, A.UKR_CONT, E.TIPE_CONT, E.ISO_CODE, A.NPWP, A.NAMA_CUST, E.VESSEL, E.VOY_IN,
                   B.BRUTO, B.NO_BC11, B.NO_POS_BC11, A.NO_DOK, A.TGL_DOK
            FROM t_gatepass A
            JOIN t_permit_hdr B ON A.NO_DOK = B.NO_DOK_INOUT AND A.TGL_DOK = B.TGL_DOK_INOUT
            JOIN t_permit_cont C ON B.ID = C.ID
            LEFT JOIN t_request D ON B.NO_DOK_INOUT = D.NO_DOK AND B.TGL_DOK_INOUT = D.TGL_DOK
            LEFT JOIN t_request_cont E ON D.ID = E.ID
            JOIN t_spk F ON A.NO_DOK = F.NO_DOK AND A.TGL_DOK = F.TGL_DOK
            WHERE A.NO_DOK = ?", array($no_dok)
        );
    
        return $query->result_array();
    }
    
    public function update_container($id, $data) {
        $this->db->where('ID', $id);
        return $this->db->update('t_spk_relocation_cont', $data);
    }

    public function get_spk_by_container_id($container_id) {
        $this->db->select('ID_SPK');
        $this->db->from('t_spk_relocation_cont');
        $this->db->where('ID', $container_id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->ID_SPK; // Return the single ID_SPK value
        }
        
        return null; // Or handle the case when no record is found
    }   
    public function get_spk_by_id($id_spk) {
        $this->db->from('t_spk_relocation_hdr');
        $this->db->where('ID', $id_spk);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row(); // Return the single row of data
        }
        
        return null; // Or handle the case when no record is found
    }
    public function insert_gatepass($gatepass_data) {
        // Insert the data into the t_gatepass table
        return $this->db->insert('t_gatepass', $gatepass_data);
    }

    //new

    public function get_query_data() {
        $query = $this->db->query("
            SELECT DISTINCT 
                DATE_FORMAT(D.WK_RESPON, '%Y%m%d') AS TGL_PPK,
                A.NO_CONT,
                A.TIPE_CONT,
                A.UKR_CONT,
                A.KD_CONT_JENIS,
                A.VESSEL,
                A.VOY_IN,
                B.NPWP,
                B.CONSIGNEE,
                C.NO_BC11,
                DATE_FORMAT(C.TGL_BC11, '%Y%m%d') AS TGL_BC11,
                C.NO_POS_BC11,
                A.BRUTO,
                C.NO_BL_AWB,
                DATE_FORMAT(C.TGL_BL_AWB, '%Y%m%d') AS TGL_BL_AWB,
                C.NO_DAFTAR_PABEAN,
                DATE_FORMAT(C.TGL_DAFTAR_PABEAN, '%Y%m%d') AS TGL_DAFTAR_PABEAN
            FROM t_request_cont A
            JOIN t_request B ON A.ID = B.ID
            JOIN t_permit_hdr C ON B.NO_DOK = C.NO_DOK_INOUT AND B.TGL_DOK = C.TGL_DOK_INOUT
            JOIN t_gatepass D ON B.NO_DOK = D.NO_DOK AND D.NO_CONT = A.NO_CONT
            JOIN t_spk E ON B.NO_DOK = E.NO_DOK AND E.TGL_DOK = D.TGL_DOK
            JOIN t_spk_cont F ON E.ID = F.ID
            WHERE D.WK_RESPON BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND CURDATE()
              AND D.JNS_DOK != 'SPPMP'
              AND D.STATUS = 'WAITING'
        ");
        
        return $query->result_array();
    }

    public function get_documents_by_no_dok($no_dok_inout) {
        $this->db->select('NO_DOK_INOUT, TGL_DOK_INOUT');
        $this->db->from('t_permit_hdr A');
        $this->db->where('A.NO_DOK_INOUT', $no_dok_inout);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return all matching records
        } else {
            return false;
        }
    }  
    public function update_document($no_spk, $no_dok, $tgl_dok) {
        $this->db->set('NO_DOK', $no_dok);
        $this->db->set('TGL_DOK', $tgl_dok);
        $this->db->where('NO_SPK', $no_spk);
        return $this->db->update('t_spk_relocation_hdr'); // Returns TRUE on success
    }
      
}

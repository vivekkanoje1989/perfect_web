<?php
class Lr_records_Model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function record_count($year, $month) {
        if ($year != 0 && $month != 0) {
            //$this->db->where("EXTRACT(YEAR FROM Lr_Date) = $year AND EXTRACT(MONTH FROM Lr_Date) = $month");        
            //return $this->db->count_all("lr_tbl");
           // $query = $this->db->get("lr_tbl");
            $query = $this->db->query("SELECT * FROM lr_tbl WHERE EXTRACT(YEAR FROM Lr_Date) = '".$year."' AND EXTRACT(MONTH FROM Lr_Date) = '".$month."' ");
             
            return $query->num_rows();
        }else{
            return $this->db->count_all("lr_tbl");
        }
       
    }

    public function fetch_records($limit, $start, $year, $month) {
        $this->db->limit($limit, $start);
        if ($year != 0 && $month != 0) {
            $this->db->where("EXTRACT(YEAR FROM Lr_Date) = $year AND EXTRACT(MONTH FROM Lr_Date) = $month");
            $this->db->order_by("created","desc");
            $query = $this->db->get("lr_tbl");
        } else{
            $this->db->order_by("created","desc");
            $query = $this->db->get("lr_tbl");
        }  
              

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}

?>
<?php
class memo_records_Model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function memo_count($check_lr_no) {
        return $this->db->count_all("memo_tbl");

        if ($check_lr_no != "") {
            //$this->db->where("EXTRACT(YEAR FROM date) = $year AND EXTRACT(MONTH FROM date) = $month");        
            //return $this->db->count_all("memo_tbl");
           // $query = $this->db->get("memo_tbl");
            //$query = $this->db->query("SELECT * FROM memo_tbl WHERE EXTRACT(YEAR FROM date) = '".$year."' AND EXTRACT(MONTH FROM date) = '".$month."' ");
           $query = $this->db->query("SELECT * FROM memo_tbl WHERE lr_no = $check_lr_no");             
           return $query->num_rows();
        }else{
            return $this->db->count_all("memo_tbl");
        }
    }

    public function memo_get_advance($lr_nos){
        if($lr_nos){
            $query = $this->db->query("SELECT advance FROM memo_tbl WHERE lr_no = '$lr_nos'");  
            if ($query->num_rows() > 0){        
                $r = $query->result_array();
                $r = $r[0]['advance'];          
                return $r;
            }else{
                $r = 0;          
                return $r;
            }
        }else{
            $r = 0;          
            return $r;
        }        
    }

    public function fetch_memo($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->order_by("created","desc");
        $query = $this->db->get("memo_tbl");
       
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
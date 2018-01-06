<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Perfect extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
		$this->load->helper("url");
        $this->load->model("Lr_records_Model");
        $this->load->library("pagination");
	}
		
	public function index()
	{		
		$fp = fopen("log.txt", "a+");
		fwrite($fp,"\r\n index --  " .date('Y-m-d h:m:s'));
		$data = file_get_contents("php://input");		
		fwrite($fp,"\r\n data initial --  " .print_r(json_decode($data), true));
		if($data == null){
			$this->load->view("login");			
		}else{			
			$data = json_decode($data);
			fwrite($fp,"\r\n data --  " .print_r($data, true));
			if (array_key_exists('data', $data)) {
				if(array_key_exists('memo', $data->data)){
					fwrite($fp,"\r\n data -memo- key found  ");				
					$results = $this->save_appMemoData($data);
				}else{
					fwrite($fp,"\r\n data -- key found  ");				
					$results = $this->save_appData($data);
				}
			}else if(array_key_exists('users', $data)){
				fwrite($fp,"\r\n sync_users- key  found  ");				
				$results = $this->sync_users();
				print_r(json_encode($results));
				fwrite($fp,"\r\n sync_users return ". print_r($results, true));
			}else{}
			fclose($fp);
		}		
	}

	public function godashboard(){
		$check_date = date('Y-m-d');
		$check_date = (string)$check_date;
		$query = $this->db->query("SELECT * FROM `lr_tbl` WHERE `created`= '$check_date'");
		$count_lr = count($query->result());

		$query = $this->db->query("SELECT * FROM `memo_tbl` WHERE `created`= '$check_date'");
		$count_memo = count($query->result());

		$data = array(
			'count_lr' => $count_lr,
			'count_memo' => $count_memo
		);
		
		$this->load->view('dashboard', $data);
	}

	public function goMemo(){
		$this->load->view('lr_records', $data);
	}

	public function goLR(){
		$this->pagination_rec();
	}

	public function login(){
		$this->load->database();
		$creds = array(
			"user_id"=> $this->input->post('username'),
			"password"=> $this->input->post('password')
		);
		$query = $this->db->get_where('users', $creds);
		
		if($query->num_rows() > 0){
			$v = $query->result();
			$session_data = array(
							'name' => $v[0]->name,
							'user_type' => $v[0]->user_type,
							);
			// Add user data in session
			$this->session->set_userdata('logged_in', $session_data);
			$id = 0;
			//$data['result'] = $this->show_lr($id);
			if ($v[0]->user_type == "admin") {
				// $this->pagination_rec();
				$this->godashboard();
			}else{
				$data = array(
					'error_message' => 'Use Admin Username and Password Only !'
				);
				$this->load->view('login', $data);
			}
			
			//print_r($v);
			//print_r($session_data);
		}else{
			$data = array(
				'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('login', $data);
		}
			
	}

	public function back() {
		/*$id = 0;
		$data['result'] = $this->show_lr($id);
		$this->load->view('lr_records', $data);*/
		$this->pagination_rec();
	}

	// Logout from admin page
	public function logout() {

		// Removing session data
		$sess_array = array(
							'name' => '',
							'user_type' => '',
							);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['logout_message'] = 'Successfully Logout';
		$this->load->view('login', $data);
	}

	public function pagination_rec() {
		$year =0; $month =0;
		$config = array();
        $config["base_url"] = base_url() . "index.php/perfect/pagination_rec/";        
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;

		if (isset($_POST['year']) && isset($_POST['month'])) {
			//print_r($_POST);
			$year = $_POST['year'];
			$month = $_POST['month'];
			$config["total_rows"] = $this->Lr_records_Model->record_count($year, $month);
		}else{
			$year = 0;
			$month = 0;
			$config["total_rows"] = $this->Lr_records_Model->record_count($year, $month);
		}
		
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->Lr_records_Model->
            fetch_records($config["per_page"], $page, $year, $month);
        $data["links"] = $this->pagination->create_links();
        $this->load->view('lr_records', $data);
    }

	
	public function refresh() {
		$this->pagination_rec();
	}
	public function sync_users() {
		$query = $this->db->query("SELECT * FROM users");
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}else{
			echo "";
		}
	}

	
	public function save_appData($data) {

		$fp = fopen("log.txt", "a+");
		fwrite($fp,"\r\n save_appData --  " .date('Y-m-d h:m:s'));		
		fwrite($fp,"\r\n save_appData initial --  " .print_r($data, true));
		fwrite($fp,"\r\n save_appData lrno --  " .print_r($data->data->lrno, true));

		$Lr_Date = date("d-m-Y", strtotime($data->data->Lr_Date));		

		$query = $this->db->query("SELECT * FROM lr_tbl WHERE `lrno`= '".$data->data->lrno."' AND `Lr_Date`= '".$Lr_Date."' AND `from_l`= '".$data->data->from."' AND `to_l`= '".$data->data->to."' AND `consignee_name`= '".$data->data->consignee_name."' AND `invoice_no`= '".$data->data->invoice_no."' ");
		$upadaterec = $query->result();
		$updateID = 0;
		if($query->num_rows() > 0){
			$proceed = 1;
			foreach($upadaterec as $record){ 
				$updateID = $record->id;
			}
			fwrite($fp,"\r\n save_appData  select query:updateID====> " . print_r($updateID, true));
		}else{
			$proceed = 0;			
		}

		fwrite($fp,"\r\n save_appData  select query: " . $this->db->last_query());		
		$created = date("Y-m-d");
		//save data to database
			$rec  = array( 
				'servicetaxno' => $data->data->servicetaxno,
				'lrno' => $data->data->lrno,
				'invoice_div' => $data->data->invoice_div,
				'Lr_Date' => $Lr_Date,
				'from_l' => $data->data->from, 
				'to_l' => $data->data->to, 
				'consigner_name' => $data->data->consigner_name,
				'consigner_Addr' => $data->data->consigner_Addr,
				'consignee_name' => $data->data->consignee_name,
				'consignee_Addr' => $data->data->consignee_Addr,
				'invoice_no' => $data->data->invoice_no,
				'vehicle_no' => $data->data->vehicle_no,
				'material_type' => $data->data->material_type,
				'num_packages' => $data->data->num_packages,				
				'actual_weight' => $data->data->actual_weight,
				'gst_tax' => $data->data->gst_tax,
				'created' => $created
			);


			
			if ($proceed == 0) {
				//insert data
				$query = $this->db->insert('lr_tbl', $rec);
			    fwrite($fp,"\r\n save_appData  proceed insert: 0 ");
			}else{
				//update data

	    		$this->db->where(array( 'id' => $updateID));
				$this->db->update('lr_tbl', $rec);
				
			    fwrite($fp,"\r\n save_appData update : 1 ");				
			}			
			/*fwrite($fp,"\r\n save_appData  last insert qry: " . $this->db->last_query());*/		
		fclose($fp);	
	}


	public function save_appMemoData($data){
		$fp = fopen("log.txt", "a+");
		fwrite($fp,"\r\n save_appData --  " .date('Y-m-d h:m:s'));		
		fwrite($fp,"\r\n save_appData initial --  " .print_r($data, true));
		fwrite($fp,"\r\n save_appData lr_no --  " .print_r($data->data->lr_no, true));

		$date = date("Y-m-d", strtotime($data->data->date));		

		$query = $this->db->query("SELECT * FROM memo_tbl WHERE `lr_no`= '".$data->data->lr_no."' AND `date`= '".$date."' AND `memo_from`= '".$data->data->memo_from."' AND `memo_to`= '".$data->data->memo_to."' AND `lorry_no`= '".$data->data->lorry_no."' AND `invoice_no`= '".$data->data->invoice_no."' ");
		$upadaterec = $query->result();
		$updateID = 0;
		if($query->num_rows() > 0){
			$proceed = 1;
			foreach($upadaterec as $record){ 
				$updateID = $record->id;
			}
			fwrite($fp,"\r\n save_appData  select query:updateID====> " . print_r($updateID, true));
		}else{
			$proceed = 0;			
		}

		fwrite($fp,"\r\n save_appData  select query: " . $this->db->last_query());		
		$created = date("Y-m-d");
		//save data to database
			$rec  = array( 
				'memo_from' => $data->data->memo_from,		
				'memo_to' => $data->data->memo_to,		
				'lr_no' => $data->data->lr_no,			
				'invoice_no' => $data->data->invoice_no,		
				'lorry_no' => $data->data->lorry_no,		
				'date' => $data->data->date,		
				'veh_type' => $data->data->veh_type,				
				'freight' => $data->data->freight,
				'created' => $created
			);

			
			if ($proceed == 0) {
				//insert data
				$query = $this->db->insert('memo_tbl', $rec);
			    fwrite($fp,"\r\n save_appData  proceed insert: 0 ");
			}else{
				//update data

	    		$this->db->where(array( 'id' => $updateID));
				$this->db->update('memo_tbl', $rec);
				
			    fwrite($fp,"\r\n save_appData update : 1 ");				
			}			
			/*fwrite($fp,"\r\n save_appData  last insert qry: " . $this->db->last_query());*/		
		fclose($fp);
	}

	public function addUser() {
		$this->load->view('add_users');
	}

	public function save_User() {
		if (isset($_POST)) {
			if ($_POST['submit'] == "Register") {
				$name = $_POST['name'];
				$user_id = $_POST['user_id'];
				$password = $_POST['password'];
				$id = $_POST['id'];
				if ($id) {					
					$query = $this->db->query("UPDATE `users` SET `name`= '$name',`user_id`='$user_id',`password`= '$password' WHERE 'id' = '$id' ");
					//print_r($this->db->last_query());
					$this->load->view('add_users');
				}else{
					$query = $this->db->query("INSERT INTO `users`(`name`, `user_id`, `password`, `user_type`) VALUES ('$name','$user_id','$password', 'user') ");
					//print_r($this->db->last_query());
					$this->load->view('add_users');
				}
			}
		}
	}

	public function delete_User() {
		$idd = $_GET['id'];
		$query = $this->db->query("DELETE FROM `users` WHERE id = $idd ");
		//print_r($this->db->last_query());
		$this->load->view('add_users');
	}

	public function show_lr($id) {
		if ($id == 0) {
			$query = $this->db->query("SELECT * FROM lr_tbl ORDER BY id DESC");
		}else{			
			$query = $this->db->query("SELECT * FROM lr_tbl WHERE id= '".$id."' ");
		}
		$records = $query->result();
        	$rs = array();	

		foreach($records as $record){
        	$tmp = array();	
			   
			if ($record->id !== null) {
        		$tmp['id'] = $record->id;
        	}else{
        		$tmp['id'] = "";
        	}  

        	  if ($record->servicetaxno) {         
                $tmp['servicetaxno'] =  $record->servicetaxno;
              }else{
                $tmp['servicetaxno'] = "";
              }

             	if ($record->invoice_div) {
                $tmp['invoice_div'] = $record->invoice_div;
              }else{
                $tmp['invoice_div'] = "";
              }

              if ($record->lrno) {
                $tmp['lrno'] = $record->lrno;
              }else{
                $tmp['lrno'] = "";
              }    

              if ($record->Lr_Date) { 
                $tmp['Lr_Date'] = $record->Lr_Date;
              }else{
                $tmp['Lr_Date'] = "";
              }

              if ($record->from_l) { 
                $tmp['from'] = $record->from_l;
              }else{
                $tmp['from'] = "";
              }

              if ($record->to_l) { 
                $tmp['to'] = $record->to_l;
              }else{
                $tmp['to'] = "";
              }

              if ($record->consigner_name) { 
               $tmp['consigner_name'] = $record->consigner_name;
              }else{
                $tmp['consigner_name'] = "";
              }

              if ($record->consigner_Addr) { 
               $tmp['consigner_Addr'] = $record->consigner_Addr;
              }else{
                $tmp['consigner_Addr'] = "";
              }

              if ($record->consignee_name) { 
               $tmp['consignee_name'] = $record->consignee_name;
              }else{
                $tmp['consignee_name'] = "";
              }

              if ($record->consignee_Addr) { 
               $tmp['consignee_Addr'] = $record->consignee_Addr;
              }else{
                $tmp['consignee_Addr'] = "";
              }

              if ($record->invoice_no) {
                $tmp['invoice_no'] = $record->invoice_no;
              }else{
               $tmp['invoice_no'] = "";
              }

              if ($record->vehicle_no) { 
                $tmp['vehicle_no'] = $record->vehicle_no;
              }else{
                $tmp['vehicle_no'] = "";
              }

              if ($record->material_type) { 
                $tmp['material_type'] = $record->material_type;
              }else{
                $tmp['material_type'] = "";
              }

              if ($record->num_packages) { 
                $tmp['num_packages'] = $record->num_packages;
              }else{
                $tmp['num_packages'] = "";
              }

              if ($record->actual_weight) { 
                $tmp['actual_weight'] = $record->actual_weight;
              }else{
                $tmp['actual_weight'] = "";
              }

              if ($record->gst_tax) { 
                $tmp['gst_tax'] = $record->gst_tax;
              }else{
                $tmp['gst_tax'] = "";
              }

              if ($record->delivery_date) { 
                $tmp['delivery_date'] = $record->delivery_date;
              }else{
                $tmp['delivery_date'] = "";
              }

               if ($record->POD_receiptno) { 
                $tmp['POD_receiptno'] = $record->POD_receiptno;
              }else{
                $tmp['POD_receiptno'] = "";
              }

               if ($record->type_transportation) { 
                $tmp['type_transportation'] = $record->type_transportation;
              }else{
                $tmp['type_transportation'] = "";
              }

               if ($record->vehicle_type) { 
                $tmp['vehicle_type'] = $record->vehicle_type;
              }else{
                $tmp['vehicle_type'] = "";
              }

              if ($record->frieght_rate) { 
                $tmp['frieght_rate'] = $record->frieght_rate;
              }else{
                $tmp['frieght_rate'] = "";
              }

              if ($record->detaintion) { 
                $tmp['detaintion'] = $record->detaintion;
              }else{
                $tmp['detaintion'] = "";
              }

              if ($record->loading_charge) { 
                $tmp['loading_charge'] = $record->loading_charge;
              }else{
                $tmp['loading_charge'] = "";
              }

              if ($record->unloading_charge) {
                $tmp['unloading_charge'] = $record->unloading_charge;                
              }else{
                $tmp['unloading_charge'] = "";
              }

              if ($record->extracollectioncharge) {
                $tmp['extracollectioncharge'] = $record->extracollectioncharge;                
              }else{
                $tmp['extracollectioncharge'] = "";
              }

              if ($record->statsticalcharge) {
                $tmp['statsticalcharge'] = $record->statsticalcharge;                
              }else{
                $tmp['statsticalcharge'] = "";
							}
							
							if ($record->mail_box) {
                $tmp['mail_box'] = $record->mail_box;                
              }else{
                $tmp['mail_box'] = "";
              }
              array_push($rs, $tmp);   	
        }

        return $rs;
	}

	public function edit_lr($id) {
		//$query = $this->db->query("SELECT * FROM lr_tbl WHERE id = '".$id."' ");
		//$data = $query->result();
		$data['result'] = $this->show_lr($id);
		//print_r($data);
		$this->load->view('lr_records_edit', $data);
	}

	//convert currency number to word
	private function convert_number_to_words($number) {
		
	    $hyphen      = '-';
	    $conjunction = ' and ';
	    $separator   = ', ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
	        0                   => 'zero',
	        1                   => 'one',
	        2                   => 'two',
	        3                   => 'three',
	        4                   => 'four',
	        5                   => 'five',
	        6                   => 'six',
	        7                   => 'seven',
	        8                   => 'eight',
	        9                   => 'nine',
	        10                  => 'ten',
	        11                  => 'eleven',
	        12                  => 'twelve',
	        13                  => 'thirteen',
	        14                  => 'fourteen',
	        15                  => 'fifteen',
	        16                  => 'sixteen',
	        17                  => 'seventeen',
	        18                  => 'eighteen',
	        19                  => 'nineteen',
	        20                  => 'twenty',
	        30                  => 'thirty',
	        40                  => 'fourty',
	        50                  => 'fifty',
	        60                  => 'sixty',
	        70                  => 'seventy',
	        80                  => 'eighty',
	        90                  => 'ninety',
	        100                 => 'hundred',
	        1000                => 'thousand',
	        1000000             => 'million',
	        1000000000          => 'billion',
	        1000000000000       => 'trillion',
	        1000000000000000    => 'quadrillion',
	        1000000000000000000 => 'quintillion'
	    );

	    if (!is_numeric($number)) {
	        return false;
	    }

	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }

	    if ($number < 0) {
	        return $negative . $this->convert_number_to_words(abs($number));
	    }

	    $string = $fraction = null;

	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }

	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction . $this->convert_number_to_words($remainder);
	            }
	            break;
	        default:
	            $baseUnit = pow(1000, floor(log($number, 1000)));
	            $numBaseUnits = (int) ($number / $baseUnit);
	            $remainder = $number % $baseUnit;
	            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
	            if ($remainder) {
	                $string .= $remainder < 100 ? $conjunction : $separator;
	                $string .= $this->convert_number_to_words($remainder);
	            }
	            break;
	    }

	    if (null !== $fraction && is_numeric($fraction)) {
	        $string .= $decimal;
	        $words = array();
	        foreach (str_split((string) $fraction) as $number) {
	            $words[] = $dictionary[$number];
	        }
	        $string .= implode(' ', $words);
	    }

	    return $string;
	}

	//cutomise LR
	public function custom_lr() {
	
		if ($_POST) {		
			$id = $_POST['id'];
			$servicetaxno = $_POST['servicetaxno'];
			$lrno = $_POST['lrno'];
			$invoice_div = $_POST['invoice_div'];
			$Lr_Date = $_POST['Lr_Date'];
			$from_l = $_POST['from_l'];
			$to_l = $_POST['to_l'];
			$consigner_name = $_POST['consigner_name'];
			$consigner_Addr = $_POST['consigner_Addr'];
			$consignee_name = $_POST['consignee_name'];
			$consignee_Addr = $_POST['consignee_Addr'];			 
			$invoice_no = $_POST['invoice_no'];
			$vehicle_no = $_POST['vehicle_no'];
			$material_type = $_POST['material_type'];
			$num_packages = $_POST['num_packages'];
			$actual_weight = $_POST['actual_weight'];
			$gst_tax = $_POST['gst_tax'];
			$delivery_date = $_POST['delivery_date'];
			$POD_receiptno = $_POST['POD_receiptno'];
			$type_transportation = $_POST['type_transportation'];
			$vehicle_type = $_POST['vehicle_type'];
			$frieght_rate = $_POST['frieght_rate'];
			$detaintion = $_POST['detaintion'];
			$loading_charge = $_POST['loading_charge'];
			$unloading_charge = $_POST['unloading_charge'];
			$loading_unloading = $loading_charge + $unloading_charge;
			$extracollectioncharge = $_POST['extracollectioncharge'];
			$statsticalcharge = $_POST['statsticalcharge']; 
			$total = round(($frieght_rate + $detaintion + $loading_unloading + $extracollectioncharge + $statsticalcharge), 2);
			$mail_box = $_POST['mail_box'];

			$bill_word = $this->convert_number_to_words($total);
		}else{}

		if ($_POST['submit'] == "Update") {
			
			$charges = array(
					'material_type' => $material_type,
					'delivery_date' => $delivery_date,
					'POD_receiptno' => $POD_receiptno,
					'type_transportation' => $type_transportation,
					'vehicle_type' => $vehicle_type,
					'frieght_rate' => $frieght_rate,
					'detaintion' => $detaintion,
					'loading_charge' => $loading_charge,
					'unloading_charge' => $unloading_charge,
					'extracollectioncharge' => $extracollectioncharge,
					'statsticalcharge' => $statsticalcharge,
					'mail_box' => $mail_box
				);
			$this->db->where(array( 'id' =>$id));
			$this->db->update('lr_tbl', $charges);
		}else if ($_POST['submit'] == "Generate Invoice") {
			//echo "Generate Invoice";
			

			//load our new PHPExcel library
			$this->load->library('excel');
			//activate worksheet number 1
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setShowGridlines(false);
			//ORIENTATION_LANDSCAPE
			$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			//PAPERSIZE_A4
			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Invoice'.$id .'');
			/*$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(16);
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(16);*/
			$rowNumber = 2;
			$header_style = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '#000000'),
						'size'  => 14,
						'name'  => 'Times'
				)
			);
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.':K'.$rowNumber.'')->applyFromArray($header_style);
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A'.$rowNumber.'', 'PERFECT TRANSPORT SOLUTIONS');
			//merge cell A1 until D1
			$this->excel->getActiveSheet()->mergeCells('A'.$rowNumber.':K'.$rowNumber.'');
			//set aligment to center for that merged cell (A1 to D1)
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(25);
			$rowNumber++;

			$header_style1 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '#000000'),
						'size'  => 9,
						'name'  => 'san-serif'
				)
			);	
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.':K'.$rowNumber.'')->applyFromArray($header_style1);
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A'.$rowNumber.'', 'A/p Near Chawala School, Spine Road, Gate No- 1264, Sharad Nagar, Chickali, Pune- 411 019');
			//merge cell A1 until D1
			$this->excel->getActiveSheet()->mergeCells('A'.$rowNumber.':K'.$rowNumber.'');
			//set aligment to center for that merged cell (A1 to D1)
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(12);
			$rowNumber++;
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.':K'.$rowNumber.'')->applyFromArray($header_style1);
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A'.$rowNumber.'', 'Email : perfectransportsolutions@gmail.com');
			//merge cell A1 until D1
			$this->excel->getActiveSheet()->mergeCells('A'.$rowNumber.':K'.$rowNumber.'');
			//set aligment to center for that merged cell (A1 to D1)
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(12);
			$rowNumber++;
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.':K'.$rowNumber.'')->applyFromArray($header_style1);
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A'.$rowNumber.'', 'Mob. No. : +919158470310, +917769888817');
			//merge cell A1 until D1
			$this->excel->getActiveSheet()->mergeCells('A'.$rowNumber.':K'.$rowNumber.'');
			//set aligment to center for that merged cell (A1 to D1)
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(12);
			$rowNumber = $rowNumber + 3;
			
			$text_style = array(
				'font'  => array(
						'color' => array('rgb' => '#000000'),
						'size'  => 10,
						'name'  => 'san-serif'
				)
			);	

			$rowNumber6 = $rowNumber + 6;
			
			$this->excel->getActiveSheet()->getStyle('A'.$rowNumber.':K'.$rowNumber6.'')->applyFromArray($text_style);
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'PAN No. : ');
			$this->excel->getActiveSheet()->setCellValue('I'.$rowNumber.'', 'VENDOR CODE. : ');
			$rowNumber++;
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'To,');
			$rowNumber++;
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'M/S. Mahindra Logistics Limited Automotive ');			
			$this->excel->getActiveSheet()->setCellValue('I'.$rowNumber.'', 'Bill No : '.$lrno.'');
			$rowNumber++;
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'Sector , Akuril Road, Kandivali(East), Mumbai');
			$rowNumber++;
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'From : '.$from_l.' To '.$to_l.'');
			$rowNumber++;
			$rowNumber++;

			$styleArray4 = array(
				'font'  => array(						
					'size'  => 10,						
				),
				'borders' => array(
				'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('argb' => '#000000'),
				),
				),
			);

			$rowNumber3 = $rowNumber + 2;
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber3.'')->applyFromArray($styleArray4);
			//text wrap
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber3.'')->getAlignment()->setWrapText(true);
			$styleArray3 = array(
				'font'  => array(						
					'size'  => 10,						
				),
				'borders' => array(
				'bottom' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,
				'color' => array('argb' => '#000000'),
				),
				),
			);
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber.'')->applyFromArray($styleArray3);
			//text wrap
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber.'')->getAlignment()->setWrapText(true);
			//set aligment to center for that merged cell
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(35);

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'Sr.No.');						

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('C'.$rowNumber.'', 'Customer name');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('D'.$rowNumber.'', 'Invoice No.');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('E'.$rowNumber.'', 'Material Type');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('F'.$rowNumber.'', 'LR No.');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('G'.$rowNumber.'', 'LR Date');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('H'.$rowNumber.'', 'Delivery Date');

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('I'.$rowNumber.'', 'POD Recp.No');

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('J'.$rowNumber.'', 'Qty');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('K'.$rowNumber.'', 'Type Of Transportation');		
			$this->excel->getActiveSheet()->setCellValue('L'.$rowNumber.'', 'Destination');	
			$this->excel->getActiveSheet()->mergeCells('L'.$rowNumber.':M'.$rowNumber.'');	
			$this->excel->getActiveSheet()->setCellValue('N'.$rowNumber.'', 'Vehicle Type');	
			$this->excel->getActiveSheet()->setCellValue('O'.$rowNumber.'', 'Primary Freight Rate');	
			$this->excel->getActiveSheet()->setCellValue('P'.$rowNumber.'', 'Loading & Unloading Rate');	
			$this->excel->getActiveSheet()->setCellValue('Q'.$rowNumber.'', 'GDS & Detention');	
			$this->excel->getActiveSheet()->setCellValue('R'.$rowNumber.'', 'Total Amount(D+E+F)');	
			$this->excel->getActiveSheet()->setCellValue('S'.$rowNumber.'', 'Remarks');	
			$rowNumber++;
			//values from database
			//$this->excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(24);
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.':S'.$rowNumber3.'')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', '1');						

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('C'.$rowNumber.'', ''.$consignee_name.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('D'.$rowNumber.'', ''.$invoice_no.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('E'.$rowNumber.'', ''.$material_type.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('F'.$rowNumber.'', ''.$lrno.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('G'.$rowNumber.'', ''.$Lr_Date.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('H'.$rowNumber.'', ''.$delivery_date.'');

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('I'.$rowNumber.'', ''.$POD_receiptno.'');

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('J'.$rowNumber.'', ''.$num_packages.'');			

			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('K'.$rowNumber.'', ''.$type_transportation.'');		
			$this->excel->getActiveSheet()->setCellValue('L'.$rowNumber.'', ''.$from_l.'');	
			$this->excel->getActiveSheet()->setCellValue('M'.$rowNumber.'', ''.$to_l.'');	
			$this->excel->getActiveSheet()->setCellValue('N'.$rowNumber.'', ''.$vehicle_type.'');	
			$this->excel->getActiveSheet()->setCellValue('O'.$rowNumber.'', ''.$frieght_rate.'');	
			$this->excel->getActiveSheet()->setCellValue('P'.$rowNumber.'', ''.$loading_unloading.'');	
			$this->excel->getActiveSheet()->setCellValue('Q'.$rowNumber.'', ''.$detaintion.'');	
			$this->excel->getActiveSheet()->setCellValue('R'.$rowNumber.'', ''.$total.'');	
			$this->excel->getActiveSheet()->setCellValue('S'.$rowNumber.'', '');	
			$rowNumber++;
			$this->excel->getActiveSheet()->mergeCells('B'.$rowNumber.':C'.$rowNumber.'');
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.'')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'Total');
			$this->excel->getActiveSheet()->mergeCells('D'.$rowNumber.':Q'.$rowNumber.'');
			$this->excel->getActiveSheet()->setCellValue('D'.$rowNumber.'', '(In words '.$bill_word.' Rupees Only)');			
			$this->excel->getActiveSheet()->getStyle('R'.$rowNumber.'')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('R'.$rowNumber.'', ''.$total.'');


			$rowNumber++;
			$rowNumber++;

						
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.'')->applyFromArray($text_style);
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'For');
			$rowNumber++;
			$this->excel->getActiveSheet()->getRowDimension(''.$rowNumber.'')->setRowHeight(15);

			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.'')->applyFromArray($text_style);			
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', 'PERFECT TRANSPORT SOLUTIONS');
			$this->excel->getActiveSheet()->getRowDimension(''.$rowNumber.'')->setRowHeight(15);

			$rowNumber = $rowNumber + 5;
			$this->excel->getActiveSheet()->getStyle('B'.$rowNumber.'')->applyFromArray($text_style);
			$this->excel->getActiveSheet()->setCellValue('B'.$rowNumber.'', '(Autorized Signature)');
			$this->excel->getActiveSheet()->getRowDimension(''.$rowNumber.'')->setRowHeight(15);


			//specify print area
			$this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:P'.$rowNumber.'');			
			$filename='Invoice- '.$id.' '.date('d-m-y').'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache			            
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		}else{}
		//redirect to page with data
		$query = $this->db->query("SELECT * FROM lr_tbl WHERE id = '".$id."' ");
		$data = $query->result();
		$data['result'] = $this->show_lr($id);
		//print_r($data);
		$this->load->view('lr_records_edit', $data); 
	}

	
}// main class ends
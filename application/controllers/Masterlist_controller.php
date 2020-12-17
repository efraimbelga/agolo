<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterlist_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

    public function masterlist()
	{
		if($this->session->userdata('userkey')){
			$APIResult = $this->base_model->GetSessionInfo();
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) {
				if($data['error'] != 'No active session!'){
					// die($data['error']);
					echo "<script type='text/javascript'>";
					echo "    alert('".$data['error']."');";
					echo "	window.location='".base_url('signout')."'";
					echo "</script>";
				}
			}


			$sql="EXEC USP_AGLDE_MASTERLIST";
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { 
				$returnData = array(
					'error' => true,
					'message' =>"Error: ".$data['error']
				);
				echo json_encode($returnData);
				die(); 
			}
			$data = array(
				'page' => 'pages/masterlist',
				'masterlistData' => $data[0],
				'css' => array(
					'<link rel="stylesheet" type="text/css" href="'.base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css').'">'
				),
			);
			$this->load->view('base', $data);
			
		}else{
			redirect();
		}
	}

	   
}




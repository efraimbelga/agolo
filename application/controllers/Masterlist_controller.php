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


			$data = array(
				'page' => 'pages/masterlist',
			);
			$this->load->view('base', $data);
			
		}else{
			redirect();
		}
	}

	public function loadMasterlist(){
		$page = $this->input->post('page');
		$fetch = $this->input->post('fetch');
		$offset = $page - 1;
		
		$sql="EXEC USP_AGLDE_MASTERLIST @offset = 0,  @fetch = 0";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$masterlistCount = json_decode($APIResult, true);
		if (array_key_exists('error', $masterlistCount)) { 
			$returnData = array(
				'error' => true,
				'message' =>"Error1: ".$masterlistCount['error']
			);
			echo json_encode($returnData);
			die(); 
		}
		
		$sql="EXEC USP_AGLDE_MASTERLIST @offset = ".$offset.",  @fetch = ".$fetch;
	 	// echo $sql;
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$masterlistData = json_decode($APIResult, true);
		if (array_key_exists('error', $masterlistData)) { 
			$returnData = array(
				'error' => true,
				'message' =>"Error2: ".$masterlistData['error']
			);
			echo json_encode($returnData);
			die(); 
		}
		
		$postData = array(
			'masterlistData' => $masterlistData[0],
			'Total' => $masterlistCount[0][0]['Total'],
			'page' => $page
		);
		$this->load->view('pages/masterlist_table', $postData);
	}  
}




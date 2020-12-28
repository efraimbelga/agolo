<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Published_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

    public function published(){
    	if($this->session->userdata('userkey')){
			$APIResult = $this->base_model->GetSessionInfo();
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) {
				if($data['error'] != 'No active session!'){
					echo "<script type='text/javascript'>";
					echo "    alert('".$data['error']."');";
					echo "	window.location='".base_url('signout')."'";
					echo "</script>";
				}
			}
			$homeData = array(
				'page' => 'pages/published'
			);
			$this->load->view('base', $homeData);
		}else{
			redirect();
		}
    }

    public function load_published_list(){
    	$sql="EXEC USP_AGLDE_AGENTPUBLISHED;";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
	    $data = json_decode($APIResult, true);
	    $postdata = array(
	    	'data' => $data[0]
	    );
	    $this->load->view('pages/published_table', $postdata);
    }

    public function insert_AgentStateHistory(){
    	$ParentID  = $this->input->post('ParentID');
    	$AgentID = $this->input->post('AgentID');
    	$state = $this->input->post('state');

    	$sql="EXEC USP_AGLDE_INSERT_AgentStateHistory @ParentID = ".$ParentID.",
			@AgentID = '".$AgentID."',
			@AgentState =  '".$state."',
			@AgentStateDate = '".date('Y-m-d H:i:s')."',
			@UserId = '".$this->session->userdata('userName')."' ";
		// die($sql);
		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("1 : ".$data['error']); }
		else{
			$status = ($state=='1' ? 'activate' : 'deactivate');
			$a3result = $this->base_model->A3_API($AgentID, $status);
			// die($a3result);
		}
		extract($data);
		echo $result;
    }
    
}



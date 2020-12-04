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
			}else{
				$APIResult =  $this->base_model->SessionLogout();
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) {
					if($data['error']=='Active TITO for the current session detected!'){
						$APIResult = $this->base_model->GetAllocationsDt();
					    $data = json_decode($APIResult, true);
					   	if (array_key_exists('error', $data)) { die($data['error']); }
					    if(sizeof($data) > 0){
					    	$pid = strval($data[0]['ProcessId']);
					    	redirect('tito_monitoring/'.$pid);
						}						
					}else{
						die($data['error']);
					}
				}
			}
		
			$homeData = array(
				'page' => 'pages/published',
				'js' => array(
					'<script type="text/javascript" src="'.base_url('assets/customised/js/published.js').'"></script>'
				)
			);
			$this->load->view('base', $homeData);
		}else{
			redirect();
		}
    }
}



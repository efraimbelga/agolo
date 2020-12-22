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
    	$sql="SELECT ps.*, u.UserId, u.LoginName as [UserName], bi.BatchName, ba.RefId, bi.JobId, bi.BatchId FROM wms_view_JobsBatchInfoProjectSpecificInfo ps 
			INNER JOIN wms_JobsBatchInfo bi ON ps.PS_BatchId = bi.BatchId 
			INNER JOIN wms_JobsBatchAllocation ba on bi.LastAllocationRefId = ba.RefId 
			INNER JOIN NM_Users u ON ba.UserId = u.UserId 
			WHERE bi.StatusId = 7 AND bi.ProcessId in (4,5,6)
			ORDER BY ba.RefId ASC;";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
	    $data = json_decode($APIResult, true);
	    $postdata = array(
	    	'data' => $data[0]
	    );
	    $this->load->view('pages/published_table', $postdata);
    }
    
}



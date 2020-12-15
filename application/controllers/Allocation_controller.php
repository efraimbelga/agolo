<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allocation_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

    public function allocation()
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
			}else{
				$APIResult =  $this->base_model->SessionLogout();
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) {
					if($data['error']=='Active TITO for the current session detected!'){
						// die($data['error'])
						$APIResult = $this->base_model->GetAllocationsDt();
					    $data = json_decode($APIResult, true);
					    // echo"<pre>";
					    // 	print_r($data);
					    // echo"</pre>";
	
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
			$data = array(
				'page' => 'pages/userallocation',
				'css' => array(
					'<link rel="stylesheet" type="text/css" href="'.base_url('assets/customised/css/tito_monitoring.css').'">'
				),
			);
			$this->load->view('base', $data);
			
		}else{
			redirect();
		}
	}

	public function view_allcationlist(){
		$ProcessId = $this->input->post('processId');
		if($ProcessId=='4' || $ProcessId=='6'){
			$ProcessId = 5;
		}
		
		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);		
		if (array_key_exists('error', $data)) {
			if($data['error'] == 'No active session!'){
				// die('here '. $processId);
				$APIResult = $this->base_model->SessionLogin(6);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die($data['error']); }
			}
		}
		
		$sql="SELECT ps.*, u.UserId, u.LoginName as [UserName], bi.BatchName, ba.RefId, bi.JobId, bi.BatchId FROM wms_view_JobsBatchInfoProjectSpecificInfo ps 
			INNER JOIN wms_JobsBatchInfo bi ON ps.PS_BatchId = bi.BatchId 
			INNER JOIN wms_JobsBatchAllocation ba on bi.LastAllocationRefId = ba.RefId 
			INNER JOIN NM_Users u ON ba.UserId = u.UserId 
			WHERE bi.StatusId = 7 AND bi.ProcessId = ".$ProcessId." and batchname not in(select batchname from wms_jobsbatchinfo where processid in(4,6) and statusid<>1)
			ORDER BY ba.RefId ASC;";
		// echo $sql;
		// die();
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
	    $data = json_decode($APIResult, true);
	    // echo"<pre>";
	    // 	print_r($data);
	    // echo"</pre>";
	    // die();
	    $this->base_model->SessionLogout();	
	    if (array_key_exists('error', $data)) { die($data['error']); }
	    $postdata = array(
	    	'data' => $data[0]
	    );
	    $this->load->view('pages/table', $postdata);
	}

	public function allocate_batch(){
		$returnData = array();
		  	
    	$batches = $this->input->post('batch');
    	$processId = $this->input->post('processId');

		$userName = $this->session->userdata('userName');
		$sql="SELECT TOP (1) [UserId] FROM [WMS_AGLDE].[dbo].[NM_Users] WHERE [LoginName] = '".$userName."'";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { 
			$returnData = array(
				'error' => true,
				'message' =>"AB1: ".$data['error']
			);
			echo json_encode($returnData);
			die(); 
		}
		$userid = $data[0][0]['UserId'];


		$BatchNames='';
		foreach ($batches as $batchid){
			$BatchNames .= "'".$batchid."',";
		}
		$BatchNames = rtrim($BatchNames, ',');
		$sql="SELECT BatchId FROM wms_jobsbatchinfo WHERE BatchName IN (".$BatchNames.") AND ProcessId='".$processId."' AND StatusId in(1,6);";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { 
			$returnData = array(
				'error' => true,
				'message' =>"AB1: Error on batchID ".$batchid.", ".$data['error']
			);
			echo json_encode($returnData);
			die();
		}
		$BatchIds = $data[0];
		foreach ($BatchIds as $row) {
			$sql="EXEC usp_wms_Allocate_BatchToUser @batchid =".$row['BatchId'].", @userid=".$userid;
			// echo $sql;
			$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { 
				$returnData = array(
					'error' => true,
					'message' =>"AB2: Error on batchID ".$row['BatchId'].", ".$data['error']
				);
				echo json_encode($returnData);
				die(); 
			}
		}		
		extract($data);
		echo $result;
    }    
}




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
		
		$sql="EXEC USP_AGLDE_MASTERLIST @offset = 0, @fetch = 0, @search=''";
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
		
		$sql="EXEC USP_AGLDE_MASTERLIST @offset = ".$offset.", @fetch = ".$fetch.", @search=''";
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

	public function masterlist_download(){
		$key = (isset($_GET['key']) && $_GET['key'] != '' ? $_GET['key'] : '');
		
		set_time_limit(0);

		$sql="EXEC USP_AGLDE_MASTERLIST @offset = 0, @fetch = 0, @search='Yes'";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$masterlistData = json_decode($APIResult, true);
		if (array_key_exists('error', $masterlistData)) { 
			$returnData = array(
				'error' => true,
				'message' =>"Error1: ".$masterlistData['error']
			);
			echo json_encode($returnData);
			die(); 
		}
		
		$masterlistData = $masterlistData[0];
		// echo"<pre>";
		// print_r($masterlistData);
		// echo"</pre>";
		// die();
		if(sizeof($masterlistData) > 0){
			
			$this->load->library('excel');
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			$row = 1;
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'S. No.');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'Received Date');
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Source Name');
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'URL');
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Parent/Child');
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $row, 'Agent Name');
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'Priority');
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'Current Process');
			$object->getActiveSheet()->setCellValueByColumnAndRow(8, $row, 'Status');
			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $row, 'Content Analysis Completion Date');
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $row, 'Agent Development Completion Date');
			$object->getActiveSheet()->setCellValueByColumnAndRow(11, $row, 'Agent Publication Completion Date');
			$object->getActiveSheet()->setCellValueByColumnAndRow(12, $row, 'Agent Refinement Completion Date');
			$object->getActiveSheet()->setCellValueByColumnAndRow(13, $row, 'Agent Rework Completion Date');
			foreach ($masterlistData as $ml) {
				$row++;
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $ml['PS_BatchId']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $ml['SourceRequestDate']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $ml['SourceName']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $ml['SourceUrl']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ($ml['IsParent']=='1' ? 'Parent' : 'Child'));
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $ml['AgentName']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $ml['Priority']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $row, str_replace("_", " ", $ml['ProcessCode']));
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $ml['StatusString']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $ml['CONTENT_ANALYSIS_DATE']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $ml['AGENT_DEVELOPMENT_DATE']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $ml['AGENT_PUBLICATION_DATE']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $ml['AGENT_REFINEMENT_DATE']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $ml['AGENT_REWORK_DATE']);
			}
			$object_writer =  PHPExcel_IOFactory::createWriter($object, 'Excel5');
			header('Content-Type: application/vmd.ms-excel');
			header('Content-Disposition: attachment;filename="masterlist.xls"');
			$object_writer->save('php://output');
		}
		exit();		
	}
}




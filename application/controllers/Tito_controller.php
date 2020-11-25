<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tito_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

	public function tito_monitoring($processId)
	{
		// die($this->session->userdata('AllocationRefId'));
		if($this->session->userdata('AllocationRefId')){
						
			$sessionData = ['AllocationRefId'];
			$this->session->unset_userdata($sessionData);	
		}
		
		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) {
			// die($data['error']); 
		}else{
			$APIResult =  $this->base_model->SessionLogout();
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { die($data['error']); }
		}


		if($this->session->userdata('userkey')){
			
			$sessionData = [
                'processId'=> $processId
            ];
            $this->session->set_userdata($sessionData);
			$data = array(
				'page' => 'pages/tito_monitoring',
				'css' => array(
					'<link rel="stylesheet" type="text/css" href="'.base_url('assets/customised/css/tito_monitoring.css').'">'
				),
				'js' => array(
					'<script type="text/javascript" src="'.base_url('assets/customised/js/tito_monitoring.js').'"></script>'
				)
			);
			$this->load->view('base', $data);
		}else{
			redirect();
		}
	}

	public function view_tito_monitoring(){
		
		$processId = $this->session->userdata('processId');
		if($processId== 0){
			$processId = 1;
		}

		// $APIResult = $this->base_model->SessionLogin($processId);
		// $data = json_decode($APIResult, true);
		// if (array_key_exists('error', $data)) { die($data['error']); }
       
  //       $APIResult = $this->base_model->GetAllocationsDt();
	 //    $data = json_decode($APIResult, true);
	 //    if (array_key_exists('error', $data)) { die($data['error']); }

		$sql="SELECT * FROM [WMS_AGLDE].[dbo].[VIEW_AGLDE_SOURCEMOREDETAILS] WHERE ";
		if($processId=='1'){
			$sql .= "([Status] IS NULL OR [Status] ='1') AND [IsParent] = 1 ";
		}else{
			$sql .= "([Status] = '".$processId."') ";
		}
		$sql .= "ORDER BY [ParentID] ASC";
		
		$result = $this->base_model->get_data_array($sql);
		if($result){
			foreach ($result as $row) {
				// data-AllocationRefId="'.$row['AllocationRefId'].'" 
				echo'<tr class="sourceTR" data-ParentID="'.$row['ParentID'].'" data-ReferenceID="'.$row['ReferenceID'].'">';
					echo'<td>'.$row['ReferenceID'].'</td>';
					echo'<td>'.$row['NSRSourceURL'].'</td>';
					echo'<td>'.$row['SourceUserName'].'</td>';
					echo'<td>'.$row['SourcePassword'].'</td>';
					echo'<td>'.$row['ClaimedBy'].'</td>';										
				echo'</tr>';
			}
		}

	 //    if(sizeof($data) > 0){
		// 	foreach ($data as $row) {
		// 		echo'<tr class="sourceTR" data-ParentID="'.$row['ParentID'].'" data-AllocationRefId="'.$row['AllocationRefId'].'" data-ReferenceID="'.$row['ReferenceID'].'">';
		// 			echo'<td>'.$row['ReferenceID'].'</td>';
		// 			echo'<td>'.$row['SourceUrl'].'</td>';
		// 			echo'<td>'.$row['SourceUserName'].'</td>';
		// 			echo'<td>'.$row['SourcePassword'].'</td>';
		// 			echo'<td>'.$row['ClaimedBy'].'</td>';										
		// 		echo'</tr>';
		// 	}
		// }
		else{
			echo'<tr>';
				echo'<td colspan="9"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}
	
	}

	public function view_tito_form()
	{
		$processId = $this->session->userdata('processId');
		$ReferenceID = $this->input->post('ReferenceID');
		$ParentID = $this->input->post('ParentID');

		$sql="SELECT * FROM [WMS_AGLDE].[dbo].[VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [ParentID] = ".$ParentID;
		$parentData = $this->base_model->get_data_row($sql);
		$sectionData = false;
		if($processId == '1'){
			$sql="SELECT * FROM [VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [SectionParentID] = ".$ParentID." ";
			$sectionData = $this->base_model->get_data_array($sql);
		}
		

		$data = array(
			'process' => $this->getprocessname($processId),
			'parentData'	=> $parentData,
			'sectionData' 	=> $sectionData,
			'processId' 	=> $processId,
			'ReferenceID' => $ReferenceID
		);	

		if($processId == '1'){	
			$this->load->view('pages/titoformModal', $data);
		}else{
			$this->load->view('pages/titoformModal2', $data);
		}
	}

	public function subsectionform(){
		$this->load->view('pages/subsectionform');
	}

	public function getprocessname($id){
		switch ($id) {
		  	case 1:
		  	 	return 'CONTENT_ANALYSIS';
		  	break;
		  	case 2:
		  		return 'AGENT_DEVELOPMENT';
		  	break;
		  	case 3:
		  	  	return 'AGENT_DEV_REVIEW';
		  	break;
		  	case 4:
		  	  	return 'AGENT_REFINEMENT';
		  	break;
		  	case 5:
		  	  	return 'AGENT_PUBLICATION';
		  	break;
		  	case 6:
		  	  	return 'AGENT_REWORK';
		  	break;
		  	default:
		     return 'CONTENT_ANALYSIS';
		}
	}

	public function save_content_analysis(){
		$SourceID = '';
		$sourceType = $this->input->post('sourceType');
		$ParentID = $this->input->post('ParentID');
		if($sourceType=='Parent'){
			$sql = "EXEC USP_AGLDE_SOURCEDETAILS_CA_UPDATE 
			@SourceURL = '".$this->input->post('SourceURL')."',
			@SourceName = '".$this->input->post('SourceName')."',
			@Type = '".$this->input->post('Type')."',
			@Region = '".$this->input->post('Region')."',
			@Country = '".$this->input->post('Country')."',
			@Client = '".$this->input->post('Client')."',
			@Access = '".$this->input->post('Access')."',
			@Priority ='".$this->input->post('Priority')."',
			@Status = '',
			@SourceID = '".$SourceID."',
			@ParentID = ".$ParentID;

      		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { die("4. ".$data['error']); }
			extract($data);
			echo $result;
		}elseif($sourceType=='Section'){
			if($ParentID=='0'){
				$sql = "EXEC USP_AGLDE_SOURCEDETAILS_INSERT_SUBSECTION 
				@SourceURL = '".$this->input->post('SourceURL')."',
				@SourceName = '".$this->input->post('SourceName')."',
				@Type = '".$_POST['Type']."',
				@Region = '".$_POST['Region']."',
				@Country = '".$_POST['Country']."',
				@Client = '".$_POST['Client']."',
				@Access = '".$_POST['Access']."',
				@Priority = '".$_POST['Priority']."',
				@Status = '',
				@SectionParentID = ".$this->input->post('SectionParentID').",
				@NewSourceID = ".$this->input->post('NewSourceID').",
				@SourceID = '".$SourceID."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("1. ".$data['error']); }
				
				$sql="SELECT TOP(1) [ParentID] FROM [AGLDE_SourceDetails] WHERE 
				[SourceURL] = '".$_POST['SourceURL']."' AND
				[SourceName] = '".$_POST['SourceName']."' AND
				[Type] = '".$_POST['Type']."' AND
				[Region] = '".$_POST['Region']."' AND
				[Country] = '".$_POST['Country']."' AND
				[Client] = '".$_POST['Client']."' AND
				[Access] = '".$_POST['Access']."' AND
				[Priority] = '".$_POST['Priority']."' AND
				[SectionParentID] = ".$this->input->post('SectionParentID')." AND
				[NewSourceID] = ".$this->input->post('NewSourceID')." AND
				[SourceID] = '".$SourceID."'";			
				
				$APIResult = $this->base_model->GetDatabaseDataset($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("2. ".$data['error']); }
				$fdata = $data[0][0];
				echo $ParentID = $fdata['ParentID'];

			}else{
				$sql = "EXEC USP_AGLDE_SOURCEDETAILS_CA_UPDATE 
				@SourceURL = '".$this->input->post('SourceURL')."',
				@SourceName = '".$this->input->post('SourceName')."',
				@Type = '".$this->input->post('Type')."',
				@Region = '".$this->input->post('Region')."',
				@Country = '".$this->input->post('Country')."',
				@Client = '".$this->input->post('Client')."',
				@Access = '".$this->input->post('Access')."',
				@Priority ='".$this->input->post('Priority')."',
				@Status = '',
				@SourceID = '".$SourceID."',
				@ParentID = ".$ParentID;
								
	      		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("3. ".$data['error']); }
				extract($data);
				echo $result;
			}
		}
	}



	public function task_out_source(){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$processId = $this->session->userdata('processId');
		// die($processId);
		$ParentID 			= $this->input->post('ParentID');
		$AllocationRefId 	= $this->input->post('AllocationRefId');
		$status 			= $this->input->post('status');
		$ReferenceID 		= $this->input->post('ReferenceID');
		$NewSourceID 		= $this->input->post('NewSourceID');
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceName 		= $this->input->post('SourceName');
		$SourceID = $SubSourceID = '';

		if($status=='Done'){
			if($processId=='1'){
				$json = '{ "referenceId": "'.$ReferenceID.'", "sources": [{ "url": "'.$SourceURL.'", "name": "'.$SourceName.'" ';
			
				$sql="SELECT [ParentID], [SourceName], [SourceURL] FROM [WMS_AGLDE].[dbo].[AGLDE_SourceDetails] WHERE 
				[SectionParentID] = ".$ParentID." AND [IsParent] IS NULL ORDER BY [ParentID] ASC";
				$result = $this->base_model->get_data_array($sql);
				if($result){
					$json .= ',"sections": [ ';
					$sections='';
					foreach ($result as $row) {
						$sections .= '{ "url": "'.$row['SourceURL'].'", "name": "'.$row['SourceName'].'" },';
					}
					$sections = rtrim($sections, ',');
					$json .= $sections.']';
				}
				$json .= '}] }';
				$APIResult = $this->base_model->sourcesmanagementcrawlers($json);
			    $data = json_decode($APIResult, true);

			    if (array_key_exists('sources', $data)){
			    	$sources = $data['sources'];
			    	$x = $e = 0;
			        foreach ($sources as $row) {
			    	    $SourceID = $row['id'];
			    	    $sql="UPDATE [dbo].[AGLDE_SourceDetails] SET [SourceID] = '".$SourceID."', [Status]='2' WHERE [SourceName] = '".$row['name']."' AND [SourceURL] = '".$row['url']."' ";
			    	   	$this->base_model->executequery($sql);
						$x++;
			        }
			    }
			}
			else if($processId=='2'){
				$sql="UPDATE [dbo].[AGLDE_SourceDetails] SET [DateFormat]= '".$this->input->post('DateFormat')."',
    			[StoryFrequency] = '".$this->input->post('StoryFrequency')."',
    			[CrawlPatterns] = '".$this->input->post('CrawlPatterns')."',
    			[Difficulty] = '".$this->input->post('Difficulty')."',
    			[ConfigNotes] = '".$this->input->post('ConfigNotes')."',
    			[ExclusionNotes] = '".$this->input->post('ExclusionNotes')."',
    			[Status]='3' WHERE [ParentID] = ".$ParentID;
    			// die($sql);
    			$this->base_model->executequery($sql);
			}
			else if($processId=='3'){
				$sql="UPDATE [dbo].[AGLDE_SourceDetails] SET [PublicationNotes]= '".$this->input->post('PublicationNotes')."', [Status]='4' WHERE [ParentID] = ".$ParentID;
    			// die($sql);
    			$this->base_model->executequery($sql);
			}
			else if($processId=='4'){
				$sql="UPDATE [dbo].[AGLDE_SourceDetails] SET [ReConfigNotes]= '".$this->input->post('ReConfigNotes')."', [Status]='5' WHERE [ParentID] = ".$ParentID;
    			// die($sql);
    			$this->base_model->executequery($sql);
			}
			
		}		
	}
}



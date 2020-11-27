<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tito_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
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

	public function tito_monitoring($processId)
	{
	
		if($this->session->userdata('userkey')){
			$sessionData = [
                'processId'=> $processId
            ];
            $this->session->set_userdata($sessionData);
			$data = array(
				'process' => $this->getprocessname($processId),
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
		$processId = $_POST['processId'];
		if($processId== 0){
			$processId = 1;
		}

		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) {
			if($data['error'] == 'No active session!'){
				$APIResult = $this->base_model->SessionLogin($processId);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die($data['error']); }
			}
		}
		
		
		$APIResult = $this->base_model->GetAllocationsDt();
	    $data = json_decode($APIResult, true);
	    echo"<pre>";
	    	print_r($data);
	    echo"</pre>";
	    if (array_key_exists('error', $data)) { die($data['error']); }
	    if(sizeof($data) > 0){
			foreach ($data as $row) {
				echo'<tr class="sourceTR '.$row['StatusString'].'" data-ParentID="'.$row['ParentID'].'" data-AllocationRefId="'.$row['AllocationRefId'].'" data-ReferenceID="'.$row['ReferenceID'].'" data-status="'.$row['StatusString'].'">';
				if($processId==1){
					echo'<td>'.$row['ReferenceID'].'</td>';
				}else{
					echo'<td>xx'.$row['ReferenceID'].'</td>';
				}
					
					echo'<td>'.$row['SourceUrl'].'</td>';
					echo'<td>'.$row['SourceUserName'].'</td>';
					echo'<td>'.$row['SourcePassword'].'</td>';
					echo'<td>'.$row['ClaimedBy'].'</td>';
					echo'<td>'.$row['StatusString'].'</td>';	
														
				echo'</tr>';
			}
		}
		else{
			echo'<tr>';
				echo'<td colspan="6"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}

		$this->base_model->SessionLogout();	
	}

	public function delete_section(){
		$ParentID = $this->input->post('ParentID');
		$sql="DELETE FROM [WMS_AGLDE].[dbo].[AGLDE_SourceDetails] WHERE [ParentID] = ".$ParentID;
		echo $result = $this->base_model->executequery($sql);
	}

	public function view_tito_form()
	{
		// print_r($_POST);
		// die();

		$processId = $this->session->userdata('processId');
		$ReferenceID = $this->input->post('ReferenceID');
		$ParentID = $this->input->post('ParentID');
		
		$AllocationRefId = $this->input->post('AllocationRefId');
		$error = false;
		$errorMsg = '';
		if($_POST['status'] != 'Ongoing'){
			$APIResult = $this->base_model->SessionLogin($processId);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { 
				$error = true;
				$errorMsg  = "VTF1. ".$data['error'];
			}

			$APIResult=$this->base_model->TaskStart($AllocationRefId);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { 
				$error = true;
				$errorMsg  = "VTF2. ".$data['error'];
			}
		}

		if($error){
			$result = array('errorMsg' => $errorMsg);
			$this->load->view('errorModalcontent', $result);
		}else{
			$sql="SELECT * FROM [VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [ParentID] = ".$ParentID;
			$parentData = $this->base_model->get_data_row($sql);
			$data = array(
				'AllocationRefId' => $AllocationRefId,
				'process' => $this->getprocessname($processId),
				'parentData'	=> $parentData,			
				'processId' 	=> $processId,
				'ReferenceID' => $ReferenceID
			);	

			if($processId == '1'){	
				$sql="SELECT * FROM [AGLDE_SourceDetails] WHERE [SectionParentID] = ".$ParentID." ";
				$sectionData = $this->base_model->get_data_array($sql);
						
				$data['sectionData'] = $sectionData;
				$this->load->view('pages/titoformModal', $data);
			}else{
				$this->load->view('pages/titoformModal2', $data);
			}
		}

		
	}

	public function subsectionform(){
		$this->load->view('pages/subsectionform');
	}

	

	public function save_content_analysis(){
		$SourceID = '';
		$sourceType = $this->input->post('sourceType');
		$ParentID = $this->input->post('ParentID');
		if($sourceType=='Parent'){
			$sql = "EXEC USP_AGLDE_SOURCEDETAILS_UPDATE 
			@SourceURL = '".$this->input->post('SourceURL')."',
			@SourceName = '".$this->input->post('SourceName')."',
			@Type = '".$this->input->post('Type')."',
			@Region = '".$this->input->post('Region')."',
			@Country = '".$this->input->post('Country')."',
			@Client = '".$this->input->post('Client')."',
			@Access = '".$this->input->post('Access')."',
			@Priority ='".$this->input->post('Priority')."',
			@Status = '0',
			@SourceID = '".$SourceID."',
			@ParentID = ".$ParentID.",
			@DateFormat ='',
			@StoryFrequency ='',
			@CrawlPatterns ='',
			@Difficulty ='',
			@ConfigNotes ='',
			@ExclusionNotes ='',							
			@PublicationNotes ='',						
			@ReConfigNotes =''";
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
				$sql = "EXEC USP_AGLDE_SOURCEDETAILS_UPDATE 
				@SourceURL = '".$this->input->post('SourceURL')."',
				@SourceName = '".$this->input->post('SourceName')."',
				@Type = '".$this->input->post('Type')."',
				@Region = '".$this->input->post('Region')."',
				@Country = '".$this->input->post('Country')."',
				@Client = '".$this->input->post('Client')."',
				@Access = '".$this->input->post('Access')."',
				@Priority ='".$this->input->post('Priority')."',
				@Status = '0',
				@SourceID = '".$SourceID."',
				@ParentID = ".$ParentID.",						
				@DateFormat ='',
				@StoryFrequency ='',
				@CrawlPatterns ='',
				@Difficulty ='',
				@ConfigNotes ='',
				@ExclusionNotes ='',							
				@PublicationNotes ='',						
				@ReConfigNotes =''";

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

		// die();
		
		$processId = $this->session->userdata('processId');
		// die($processId);
		$ParentID 			= $this->input->post('ParentID');
		$AllocationRefId 	= $this->input->post('AllocationRefId');
		$status 			= $this->input->post('status');
		$ReferenceID 		= $this->input->post('ReferenceID');
		$NewSourceID 		= $this->input->post('NewSourceID');
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceName 		= $this->input->post('SourceName');

		$SourceID = $SubSourceID = '';

		// die($AllocationRefId." - ".$status);		
		$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("E. :".$data['error']); }

		// die();
		// $APIResult =  $this->base_model->SessionLogout();
		// $data = json_decode($APIResult, true);
		// if (array_key_exists('error', $data)) { die("D. :".$data['error']); }	

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
			        foreach ($sources as $row) {
			    	    $SourceID = $row['id'];
			    	    $sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
			    	    	@Type ='',
							@Region ='',
							@Country ='',
    						@Client ='',
    						@Access='',
    						@Priority='',
			    	   		@Status = '2',
							@ParentID = 0,						
							@SourceID ='".$SourceID."',
							@SourceName ='".$row['name']."',
							@SourceURL ='".$row['url']."',						
							@DateFormat ='',
							@StoryFrequency ='',
							@CrawlPatterns ='',
							@Difficulty ='',
							@ConfigNotes ='',
							@ExclusionNotes ='',							
							@PublicationNotes ='',						
							@ReConfigNotes =''";
						// die($sql);
						$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
					    $data = json_decode($APIResult, true);
					   	if (array_key_exists('error', $data)) { die("3 : ".$data['error']); }
			        }
			    }
			    $sql="EXEC USP_AGLDE_GENERATEBATCHES @ParentId=".$ParentID.", @userName = '".$this->session->userdata('userName')."' ";
			    $APIResult = $this->base_model->ExecuteDatabaseScript($sql);
			    $data = json_decode($APIResult, true);
			   	if (array_key_exists('error', $data)) { die("3 : ".$data['error']); }
			}
			else if($processId=='2'){
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@Status = '3',
					@ParentID = ".$ParentID.",						
					@SourceID ='',
					@SourceName ='',
					@SourceURL ='',						
					@DateFormat ='".$this->input->post('DateFormat')."',
					@StoryFrequency ='".$this->input->post('StoryFrequency')."',
					@CrawlPatterns ='".$this->input->post('CrawlPatterns')."',
					@Difficulty ='".$this->input->post('Difficulty')."',
					@ConfigNotes ='".$this->input->post('ConfigNotes')."',
					@ExclusionNotes ='".$this->input->post('ExclusionNotes')."',							
					@PublicationNotes ='',						
					@ReConfigNotes =''";
				// die($sql);
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("3 : ".$data['error']); }

			}
			else if($processId=='3'){
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@Status = '4',
					@ParentID = ".$ParentID.",						
					@SourceID ='',
					@SourceName ='',
					@SourceURL ='',						
					@DateFormat ='',
					@StoryFrequency ='',
					@CrawlPatterns ='',
					@Difficulty ='',
					@ConfigNotes ='',
					@ExclusionNotes ='',							
					@PublicationNotes ='".$this->input->post('PublicationNotes')."',						
					@ReConfigNotes =''";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("3 : ".$data['error']); }
			}
			else if($processId=='4'){
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@Status = '5',
					@ParentID = ".$ParentID.",						
					@SourceID ='',
					@SourceName ='',
					@SourceURL ='',						
					@DateFormat ='',
					@StoryFrequency ='',
					@CrawlPatterns ='',
					@Difficulty ='',
					@ConfigNotes ='',
					@ExclusionNotes ='',							
					@PublicationNotes ='',						
					@ReConfigNotes ='".$this->input->post('ReConfigNotes')."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("3 : ".$data['error']); }
			}
		}		
	}
}



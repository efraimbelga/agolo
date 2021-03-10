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

	public function allocate_source(){
		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);		
		if (array_key_exists('error', $data)) {
			if($data['error'] == 'No active session!'){
				// die('here '. $processId);
				$APIResult = $this->base_model->SessionLogin(3);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die($data['error']); }
			}
		}

		$APIResult = $this->base_model->AutoAllocate(0, '', '');
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die($data['error']); }

		$this->base_model->SessionLogout();	
	}

	public function tito_monitoring($processId)
	{
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

		if($this->session->userdata('userkey')){
			// if($processId=='4'){
			// 	redirect('tito_monitoring/4/tito');
			// }elseif($processId=='6'){
			// 	redirect('tito_monitoring/6/tito');
			// }
			// else{
				

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
			// }
			
		}else{
			redirect();
		}
	}

	public function view_tito_monitoring(){
		$processId = $_POST['processId'];
		if($processId== 0){
			$processId = 1;
		}

		// die($processId);

		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) {
			if($data['error'] == 'No active session!'){
				// die('here '. $processId);
				$APIResult = $this->base_model->SessionLogin($processId);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die($data['error']); }
			}
		}
		// else{
		// 	$APIResult = $this->base_model->SessionLogin($processId);
		// 	$data = json_decode($APIResult, true);
		// 	if (array_key_exists('error', $data)) { die($data['error']); }
		// }

		
		$APIResult = $this->base_model->GetAllocationsDt();
	    $data = json_decode($APIResult, true);
	    // echo"<pre>";
	    // 	print_r($data);
	    // echo"</pre>";
	    if (array_key_exists('error', $data)) { die($data['error']); }
	    if(sizeof($data) > 0){
			foreach ($data as $row) {
				if($processId==$row['ProcessId']){
					// data-status="'.$row['StatusString'].'"
					echo'<tr class="sourceTR '.$row['StatusString'].'" data-ParentID="'.$row['ParentID'].'" data-AllocationRefId="'.$row['AllocationRefId'].'" data-ReferenceID="'.$row['ReferenceID'].'" data-status="'.$row['StatusString'].'">';
						echo'<td>';
							if($row['StatusString']=='Ongoing'){
								echo'<button class="btn btn-xs btn-warning tito-btn">Task-In</button> ';
							}
							elseif($row['StatusString']=='Pending'){
								echo'<button class="btn btn-xs btn-success tito-btn">Task-In</button> ';
							}else{
								echo'<button class="btn btn-xs btn-success tito-btn">Task-In</button> ';
								if($processId == 1){
									echo'<button class="btn btn-xs btn-info addparent-btn">Add Parent</button> ';
								}								
							}							
						echo'</td>';
						echo'<td>'.$row['SourceUrl'].'</td>';
						if($processId==1){
							echo'<td>'.$row['ReferenceID'].'</td>';
						}else{
							echo'<td>'.$row['SourceName'].'</td>';
							echo'<td>'.($row['IsParent']=='1' ? 'Parent': 'Section').'</td>';
						}
						echo'<td>'.$row['SourceUserName'].'</td>';
						echo'<td>'.$row['SourcePassword'].'</td>';
						echo'<td>'.$row['ClaimedBy'].'</td>';
						echo'<td>'.$row['StatusString'].'</td>';						
					echo'</tr>';
				}
			}
		}
		else{
			echo'<tr>';
				echo'<td colspan="'.($processId>=2 ? '6' : '5').'"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}

		$this->base_model->SessionLogout();	
	}

	public function addparent_modal()
	{
		$data = array(
			'ParentID' => $this->input->post('ParentID'),
			'ReferenceID' => $this->input->post('ReferenceID'),
			'sourceURL' => $this->input->post('sourceURL')
		);
		$this->load->view('pages/addparent_modal', $data);
	}

	public function save_parent(){
		$ParentID = $this->input->post('ParentID');
		$ReferenceID = $this->input->post('referenceID');
		$SourceURL = $this->input->post('NEWsourceURL');
		$SourceURLP = $this->input->post('sourceURL');
		$ClaimedDate = date('Y-m-d H:i:s').".000";

		$sql="EXEC USP_AGLDE_REGISTER_MANUAL
		@ReferenceID = '".$ReferenceID."',
		@SourceURL = '".$SourceURL."',
		@ClaimedDate = '".$ClaimedDate."' ";

		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$data = json_decode($APIResult, true);
		$source = $data[0][0]['ID'];

		
		$ClaimedBy = $this->session->userdata('userName');
		$ProcessCode = 'CONTENT_ANALYSIS';

		$sql="EXEC USP_AGLDE_NEWSOURCEREQUEST_UPDATE @ClaimedBy='".$ClaimedBy."', @ClaimedDate='".$ClaimedDate."', @Id='".$source."'";

		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("1 : ".$data['error']); }

		extract($data);
        if($result == '' || $result == 'success'){
			$sql="EXEC USP_AGLDE_SOURCEDETAILS_INSERT @ClaimedBy='".$ClaimedBy."', @ClaimedDate='".$ClaimedDate."', @Id='".$source."'";
			$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { die("1 : ".$data['error']); }

			extract($data);
			if($result == '' || $result == 'success'){				
				$sql = "SELECT A.*, B.SourceURL as SourceURLP FROM dbo.AGLDE_SourceDetails 
				AS A INNER JOIN dbo.AGLDE_NewSourceRequest AS B 
				ON A.NewSourceID = B.ID WHERE B.IsClaimed IS NOT NULL 
				AND B.ClaimedBy='".$ClaimedBy."' AND B.ID IN (".$source.") ";	
				// die($sql);		
				$APIResult = $this->base_model->GetDatabaseDataset($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("2 : ".$data['error']); }
				$data = $data[0];
				if(sizeof($data) > 0){
					foreach ($data as $row) {						
						$sql="EXEC USP_AGLDE_PARENT_TO_SECTION 
						@SectionParentID = ".$row['ParentID']." ,
						@ParentID = ".$ParentID.",
						@SourceURL = '".$SourceURL."',
						@ReferenceID ='".$ReferenceID."',
						@SourceURLP = '".$SourceURLP."';";
						
						// die($sql);
						$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
						$data2 = json_decode($APIResult, true);

						if (array_key_exists('error', $data2)) { die("4 : ".$data2['error']); }
						else{
							echo 'saved';
						}				
					}
				}
			}
		}	
	}

	public function delete_section(){
		$ParentID = $this->input->post('ParentID');
		$sql="EXEC USP_AGLDE_SOURCEDETAILS_DELETE @ParentID = ".$ParentID;
		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("4. ".$data['error']); }
		extract($data);
		echo $result;
		
	}

	public function view_tito_form()
	{
		$processId = $this->session->userdata('processId');
		// die($processId);
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
			$sql="SELECT TOP(1) * FROM [VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [ParentID] = ".$ParentID;
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$parentData = json_decode($APIResult, true);			

			$sql="select TOP(1) wp.RefId from wms_Processes p inner join wms_WorkFlowProcesses wp on p.processid=wp.ProcessId where wp.workflowid=1 AND p.ProcessId=".$processId;
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$RefIdData = json_decode($APIResult, true);

			$data = array(
				'AllocationRefId'	=> $AllocationRefId,
				'process' 			=> $this->getprocessname($processId),
				'parentData'		=> $parentData[0][0],			
				'processId' 		=> $processId,
				'ReferenceID' 		=> $ReferenceID,
				'RefId'				=> $RefIdData[0][0]['RefId'],
				// 'remarkData'		=> $remarkData[0],
			);	

			$this->load->view('pages/titoformModal2', $data);
		}
	}

	public function subsectionform(){
		$data = array(
			'regions' => REGIONS,
			'formID' => 'FORM'.date('YmdHis')
		);
		$this->load->view('pages/subsectionform', $data);
	}

	public function content_analysis(){	
		if(isset($_GET['ParentID']) && $_GET['ParentID'] !='' && isset($_GET['AllocationRefId']) && $_GET['AllocationRefId'] != ''){			
			$ParentID = $_GET['ParentID'];
			$AllocationRefId = $_GET['AllocationRefId'];
			$error = false;
			$errorMsg = '';
			if($_GET['status'] != 'Ongoing'){
				$APIResult = $this->base_model->SessionLogin(1);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$error = true;
					$errorMsg  = "CA1: ".$data['error'];
				}else{
					$APIResult=$this->base_model->TaskStart($AllocationRefId);
					$data = json_decode($APIResult, true);
					if (array_key_exists('error', $data)) { 
						$error = true;
						$errorMsg  = "CA2: ".$data['error'];
					}
				}						
			}

			$sql="SELECT TOP(1) * FROM [dbo].[VIEW_AGLDE_SOURCEMOREDETAILS]  WHERE [ParentID] = ".$ParentID;
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$parentData = json_decode($APIResult, true);
			if (array_key_exists('error', $parentData)) { die("CA3: ".$parentData['error']); }
			// echo"<pre>";
			// print_r($parentData[0][0]);
			// echo"</pre>";
			// exit();

			$sql="SELECT * FROM [AGLDE_SourceDetails] WHERE [SectionParentID] = ".$ParentID." ";
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$sectionData = json_decode($APIResult, true);
			if (array_key_exists('error', $sectionData)) { die("CA4: ".$sectionData['error']); }
			$fdata = array(
				'error'			=> $error,
				'errorMsg'		=> $errorMsg,
				'parentData'	=> $parentData[0][0],
				'sectionData' 	=> $sectionData[0],
				'process' 		=> 'CONTENT_ANALYSIS',
				'processId' 	=> '1',
				'regions' 		=> REGIONS,
				'AllocationRefId' => $_GET['AllocationRefId'],
				'css' 			=> array(
					'<link rel="stylesheet" type="text/css" href="'.base_url('assets/customised/css/tito_monitoring.css').'">'
				),
				
			);
			$this->load->view('pages/content_analysis', $fdata);
		}		
	}
	

	public function save_content_analysis(){
		// print_r($_POST);
		// die();
		$SourceID = '';
		$sourceType = $this->input->post('sourceType');
		$ParentID = $this->input->post('ParentID');
		$newparent = $this->input->post('newparent');
		if($sourceType=='Parent'){
			if($newparent=='1'){
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_INSERT_NEWPARENT
				
				@SourceName = '".$this->input->post('SourceName')."',
				@SourceURL = '".$this->input->post('SourceURL')."',
				@Type = '".$this->input->post('Type')."',
				@Region = '".$this->input->post('Region')."',
				@Country = '".$this->input->post('Country')."',
				@Client = '".$this->input->post('Client')."',
				@Access = '".$this->input->post('Access')."',
				@Priority = '".$this->input->post('Priority')."'";

				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("1 : ".$data['error']); }
				extract($data);

				if($result == '' || $result == 'success'){
					$sql="SELECT TOP (1) [ProcessId] FROM [WMS_AGLDE].[dbo].[wms_Processes] WHERE [ProcessCode] = '".$ProcessCode."' ";
					$APIResult = $this->base_model->GetDatabaseDataset($sql);
					$data = json_decode($APIResult, true);
					$res = $data[0][0];
					$processid = $res['ProcessId'];

					$sql = "SELECT A.ParentID FROM dbo.AGLDE_SourceDetails 
					AS A INNER JOIN dbo.AGLDE_NewSourceRequest AS B 
					ON A.NewSourceID = B.ID WHERE B.IsClaimed IS NOT NULL 
					AND B.ClaimedDate = '".$ClaimedDate."' AND B.ClaimedBy='".$ClaimedBy."' AND B.ID IN (".$source.") ";
					$APIResult = $this->base_model->GetDatabaseDataset($sql);
					$data = json_decode($APIResult, true);
					if (array_key_exists('error', $data)) { die("2 : ".$data['error']); }

					$data = $data[0];
					if(sizeof($data) > 0){
						foreach ($data as $row) {
							$sql= "EXEC USP_AGLDE_REGISTERJOB @ParentId=".$row['ParentID'].", @processid=".$processid.", @userName=".$this->session->userdata('userName');
							$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
							$data1 = json_decode($APIResult, true);
							if (array_key_exists('error', $data1)) { die("3 : ".$data1['error']); }						
						}
					}
				}
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
				@ProcessID = 0,
				@SourceID = '".$SourceID."',
				@ParentID = ".$ParentID.",
				@DateFormat ='',
				@StoryFrequency ='',
				@CrawlPatterns ='',
				@Difficulty ='',
				@ConfigNotes ='',
				@ExclusionNotes ='',							
				@PublicationNotes ='',		
				@AgentID ='', @AgentName = '',			
				@ReConfigNotes =''";
	      		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) {
					$returnData = array(
						'error' => true,
						'message' =>"SCA1: ".$data['error']
					);
				    echo json_encode($returnData);
					die(); 
				}

				extract($data);
				$returnData = array(
					'error' => false,
					'message' => $result
				);
				echo json_encode($returnData);
			}
			
		}elseif($sourceType=='Section'){
			if($ParentID=='0'){
				// print_r($_POST);
				$sql = "EXEC USP_AGLDE_SOURCEDETAILS_INSERT_SUBSECTION 
				@SourceURL = '".$this->input->post('SourceURL')."',
				@SourceName = '".$this->input->post('SourceName')."',
				@Type = '".$this->input->post('Type')."',
				@Region = '".$this->input->post('Region')."',
				@Country = '".$this->input->post('Country')."',
				@Client = '".$this->input->post('Client')."',
				@Access = '".$this->input->post('Access')."',
				@Priority = '".$this->input->post('Priority')."',
				@Status = '',
				@SectionParentID = ".$this->input->post('SectionParentID').",
				@NewSourceID = ".$this->input->post('NewSourceID').",
				@SourceID = '".$SourceID."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) {  
					$returnData = array(
						'error' => true,
						'message' => "SCA2: ".$data['error']
					);
				    echo json_encode($returnData);
					die();
				}
				
				$sql="SELECT TOP(1) [ParentID] FROM [AGLDE_SourceDetails] WHERE 
				[SourceURL] = '".$_POST['SourceURL']."' AND
				[SourceName] = '".$_POST['SourceName']."' AND
				[Type] = '".$this->input->post('Type')."' AND
				[Region] = '".$this->input->post('Region')."' AND
				[Country] = '".$this->input->post('Country')."' AND
				[Client] = '".$this->input->post('Client')."' AND
				[Access] = '".$this->input->post('Access')."' AND
				[Priority] = '".$this->input->post('Priority')."' AND
				[SectionParentID] = ".$this->input->post('SectionParentID')." AND
				[NewSourceID] = ".$this->input->post('NewSourceID')." AND
				[SourceID] = '".$SourceID."'";			
				
				$APIResult = $this->base_model->GetDatabaseDataset($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "SCA3: ".$data['error']
					);
				    echo json_encode($returnData);
					die(); 
				}
				$fdata = $data[0][0];
				$returnData = array(
					'error' => false,
					'message' => $fdata['ParentID']
				);
				echo json_encode($returnData);
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
				@ProcessID = 0,
				@SourceID = '".$SourceID."',
				@ParentID = ".$ParentID.",						
				@DateFormat ='',
				@StoryFrequency ='',
				@CrawlPatterns ='',
				@Difficulty ='',
				@ConfigNotes ='',
				@ExclusionNotes ='',							
				@PublicationNotes ='',	
				@AgentID ='', @AgentName = '',					
				@ReConfigNotes =''";

	      		$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) {
					$returnData = array(
						'error' => true,
						'message' => "SCA4: ".$data['error']
					);
				    echo json_encode($returnData);
					die(); 
				}
				extract($data);
				$returnData = array(
					'error' => false,
					'message' => $result
				);
				echo json_encode($returnData);
			}
		}
	}

	public function task_out_source(){
		// echo"<pre>";
		// print_r($_POST);
		// echo"</pre>";
		// die();
		$returnData = array(
			'error' => false,
			'message' => ''
		);
		
		$ParentID 			= $this->input->post('ParentID');
		$processId 			= $this->input->post('processId');
		$ReferenceID 		= $this->input->post('ReferenceID');
		$NewSourceID 		= $this->input->post('NewSourceID');
		$AllocationRefId 	= $this->input->post('AllocationRefId');			
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceName 		= $this->input->post('SourceName');
		$status 			= $this->input->post('Status');	

		$SkipParent = ($this->input->post('gotodev')=='1' ? '0' : '1');

		$SourceID = $SubSourceID = '';
		if($status=='Done'){
			if($processId=='1'){
				$json = '{ "referenceId": "'.$ReferenceID.'", "sources": [{ "url": "'.$SourceURL.'", "name": "'.$SourceName.'" ';
			
				$sql="SELECT [ParentID], [SourceName], [SourceURL] FROM [dbo].[AGLDE_SourceDetails] WHERE 
				[SectionParentID] = ".$ParentID." AND [IsParent] IS NULL ORDER BY [ParentID] ASC";

				$APIResult = $this->base_model->GetDatabaseDataset($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("2. ".$data['error']); }
				$result = $data[0];

				if(sizeof($result)>0){
					$json .= ',"sections": [ ';
					$sections='';
					foreach ($result as $row) {
						$sections .= '{ "url": "'.$row['SourceURL'].'", "name": "'.$row['SourceName'].'" },';
					}
					$sections = rtrim($sections, ',');
					$json .= $sections.']';
				}
				$json .= '}] }';			
				// die($json);
				$APIResult = $this->base_model->A1_API($json);
				$data = json_decode($APIResult, true);
				// print_r($data);
				// die();
				if($APIResult === FALSE) {
					$returnData = array(
						'error' => true,
						'message' => 'Could not get response. Please try again later'
					);
      				echo json_encode($returnData);
      				die();
				}
				elseif(array_key_exists('timestamp', $data)) {
					$returnData = array(
						'error' 	=> true,
						// 'message' => '500 internal server error'
						'message' 	=> 'API Error 1: '.$data['message']
					);
      				echo json_encode($returnData);
      				die();
				}
				elseif(array_key_exists('sources', $data)){
				    $sources = $data['sources'];
				    foreach ($sources as $row) {
				    	$SourceID = $row['id'];
				    	if($SourceID != ''){
				    		$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					        	@Type ='',
								@Region ='',
								@Country ='',
		    					@Client ='',
		    					@Access='',
		    					@Priority='',
					       		@ProcessID = 1,
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
								@AgentID ='', @AgentName = '',
								@ReConfigNotes =''";
							// echo $sql;
							$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
						    $data = json_decode($APIResult, true);
				    	}
				   	}
				   	// die();
					$sql="EXEC USP_AGLDE_SOURCECONFIGURATION @SourceParentID = ".$ParentID.",
						@NewSourceID = ".$NewSourceID.",
						@FinishDate = '".date('Y-m-d H:i:s')."',
						@Remark = '".$this->input->post('Remark')."',
						@ProcessID = 1,
						@ADRemark = '',
						@APRemark = ''";
					$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
					if (array_key_exists('error', $data)) { 
						$returnData = array(
							'error' => true,
							'message' => "TO1A :".$data['error']
						);
			      		echo json_encode($returnData);
						die(); 
					}

					if($proceed){
						$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status,  $this->input->post('Remark'));
						$data = json_decode($APIResult, true);
						if (array_key_exists('error', $data)) { 
							$returnData = array(
								'error' => true,
								'message' => "TO1B :".$data['error']
							);
				      		echo json_encode($returnData);
							die(); 
						}

					    $sql="EXEC USP_AGLDE_GENERATEBATCHES @ParentId=".$ParentID.", @userName = '".$this->session->userdata('userName')."', @$SkipParent=".$SkipParent." ";
					    $APIResult = $this->base_model->ExecuteDatabaseScript($sql);
					    $data = json_decode($APIResult, true);
					   	if (array_key_exists('error', $data)) { 
					   		$returnData = array(
								'error' => true,
								'message' => "TO3 : ".$data['error']
							);
				      		echo json_encode($returnData);
					   	}else{
					   		$returnData = array(
								'error' => false,
								'message' => "Saved"
							);
				      		echo json_encode($returnData);
					   	}
					}else{

					}
				}
			}
			else if($processId=='2'){
				$AgentID = $this->input->post('AgentID');
				$json = '{ "agentId": "'.$AgentID.'" }';
				$CAPIResult = $this->base_model->A2_API($json, $this->input->post('SourceID'));
				if($CAPIResult === FALSE) { 
					$error = error_get_last();
					$returnData = array(
						'error' => true,
						'message' => 'A2: HTTP request failed'
					);
      				echo json_encode($returnData);
      				die();
				}
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
	    			@Client ='',
	    			@Access='',
	    			@Priority='',
					@ProcessID = 2,
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
					@AgentID = '".$AgentID."',
					@AgentName = '".$this->input->post('AgentName')."',				
					@ReConfigNotes =''";
				// die($sql);
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO4 : ".$data['error']
					);
      				echo json_encode($returnData);
      				die(); 
				}

				$sql="EXEC USP_AGLDE_SOURCECONFIGURATION 
					@SourceParentID = ".$ParentID.",
					@NewSourceID = ".$NewSourceID.",
					@FinishDate = '".date('Y-m-d H:i:s')."',
					@Remark = '".$this->input->post('Remark')."',
					@ProcessID = 2,
					@ADRemark = '',
					@APRemark = ''";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1A :".$data['error']
					);
			    	echo json_encode($returnData);
					die(); 
				}

				$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark'));
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1B :".$data['error']
					);
      				echo json_encode($returnData);
      			}
      			else{
      				$returnData = array(
						'error' => false,
						'message' => 'Saved'
					);
      				echo json_encode($returnData);
      			}
			}
			else if($processId=='6'){ //AGENT REWORK				
				// print_r($_POST);
				// die();
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@ProcessID = 6,
					@ParentID = ".$ParentID.",						
					@SourceID = '',
					@SourceName = '',
					@SourceURL = '',						
					@DateFormat = '".$this->input->post('DateFormat')."',
					@StoryFrequency = '".$this->input->post('StoryFrequency')."',
					@CrawlPatterns = '".$this->input->post('CrawlPatterns')."',
					@Difficulty = '".$this->input->post('Difficulty')."',
					@ConfigNotes = '".$this->input->post('ConfigNotes')."',
					@ExclusionNotes = '".$this->input->post('ExclusionNotes')."',							
					@PublicationNotes = '".$this->input->post('PublicationNotes')."',	
					@AgentID ='', @AgentName = '".$this->input->post('AgentName')."',	
					@ReConfigNotes = ''";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO6 : ".$data['error']
					);
      				echo json_encode($returnData);
      				die();
      			}

				$sql="EXEC USP_AGLDE_SOURCECONFIGURATION @SourceParentID = ".$ParentID.",
					@NewSourceID = ".$NewSourceID.",
					@FinishDate = '".date('Y-m-d H:i:s')."',
					@Remark = '".$this->input->post('Remark')[2]."',
					@ProcessID = 6,
					@ADRemark = '".$this->input->post('Remark')[0]."',
					@APRemark = '".$this->input->post('Remark')[1]."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				if (array_key_exists('error', $APIResult)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1A :".$APIResult['error']
					);
			    	echo json_encode($returnData);
					die(); 
				}

				$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark')[2]);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1C :".$data['error']
					);
      				echo json_encode($returnData);
      			}
      			else{
      				$returnData = array(
						'error' => false,
						'message' => 'Saved'
					);
      				echo json_encode($returnData);
      			}
			}
			else if($processId=='4'){ //AGENT REFINEMENT
				// print_r($_POST);
				// echo $this->input->post('Remark')[2];
				// die();
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@ProcessID = 4,
					@ParentID = ".$ParentID.",						
					@SourceID = '',
					@SourceName = '',
					@SourceURL = '',						
					@DateFormat = '".$this->input->post('DateFormat')."',
					@StoryFrequency = '".$this->input->post('StoryFrequency')."',
					@CrawlPatterns = '".$this->input->post('CrawlPatterns')."',
					@Difficulty = '".$this->input->post('Difficulty')."',
					@ConfigNotes = '".$this->input->post('ConfigNotes')."',
					@ExclusionNotes = '".$this->input->post('ExclusionNotes')."',							
					@PublicationNotes = '".$this->input->post('PublicationNotes')."',	
					@AgentID ='', @AgentName = '".$this->input->post('AgentName')."',	
					@ReConfigNotes = '".$this->input->post('ReConfigNotes')."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO6 : ".$data['error']
					);
      				echo json_encode($returnData);
      				die();
      			}

				$sql="EXEC USP_AGLDE_SOURCECONFIGURATION @SourceParentID = ".$ParentID.",
					@NewSourceID = ".$NewSourceID.",
					@FinishDate = '".date('Y-m-d H:i:s')."',
					@Remark = '".$this->input->post('Remark')[2]."',
					@ProcessID = 4,
					@ADRemark = '".$this->input->post('Remark')[0]."',
					@APRemark = '".$this->input->post('Remark')[1]."'";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1A :".$data['error']
					);
			    	echo json_encode($returnData);
					die(); 
				}

				$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark')[2]);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' =>"TO1D :".$data['error']
					);
      				echo json_encode($returnData);
      			}
      			else{
      				$returnData = array(
						'error' => false,
						'message' => 'Saved'
					);
      				echo json_encode($returnData);
      			}
			}
			else if($processId=='5'){ //AGENT PUBLICATION
				$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE
					@Type ='',
					@Region ='',
					@Country ='',
    				@Client ='',
    				@Access='',
    				@Priority='',
			    	@ProcessID = 5,
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
					@AgentID ='', @AgentName = '',					
					@ReConfigNotes =''";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);

				$sql="EXEC USP_AGLDE_SOURCECONFIGURATION @SourceParentID = ".$ParentID.",
					@NewSourceID = ".$NewSourceID.",
					@FinishDate = '".date('Y-m-d H:i:s')."',
					@Remark = '".$this->input->post('Remark')."',
					@ProcessID = 5,
					@ADRemark = '',
					@APRemark = ''";
				$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' => "TO1A :".$data['error']
					);
			    	echo json_encode($returnData);
					die(); 
				}

				$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark'));
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' =>"TO1D :".$data['error']
					);
      				echo json_encode($returnData);
      			}
      			else{
      				$returnData = array(
						'error' => false,
						'message' => 'Saved'
					);
      				echo json_encode($returnData);
      			}
			}
			else{
				$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark'));
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { 
					$returnData = array(
						'error' => true,
						'message' =>"TO1E :".$data['error']
					);
      				echo json_encode($returnData);
      			}
      			else{
      				$returnData = array(
						'error' => false,
						'message' => 'Saved'
					);
      				echo json_encode($returnData);
      			}
			}
		}else{
			$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status, $this->input->post('Remark'));
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { 
				$returnData = array(
					'error' => true,
					'message' => "TO1 : ".$data['error']
				);
      			echo json_encode($returnData);
			}else{
				$returnData = array(
					'error' => false,
					'message' => ''
				);
      			echo json_encode($returnData);
			}
		}		
	}


	public function get_url(){
		$APIResult = $this->base_model->GetSessionInfo();
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) {
			
		}else{
			$APIResult = $this->base_model->SessionLogout();
		}

		$ParentID = $this->input->post('ParentID');
		$sql="SELECT TOP (1) [NSRSourceURL] FROM [dbo].[VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [ParentID] = ".$ParentID;
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("2. ".$data['error']); }
		$rawdata = $data[0][0];
		echo $rawdata['NSRSourceURL'];
	}

	// public function agent_refinement($page){
	// 	if($page=='tito'){
	// 		if($this->session->userdata('userkey')){
	// 			$processId = $this->uri->segment(2);
			
	// 			$APIResult = $this->base_model->GetSessionInfo();
	// 			$data = json_decode($APIResult, true);
	// 			if (array_key_exists('error', $data)) {
	// 				if($data['error'] != 'No active session!'){
	// 					// die($data['error']);
	// 					echo "<script type='text/javascript'>";
	// 					echo "    alert('".$data['error']."');";
	// 					echo "	window.location='".base_url('signout')."'";
	// 					echo "</script>";
	// 				}
	// 			}

	// 			$sessionData = [
	//                 'processId'=> $processId
	//             ];
	//             $this->session->set_userdata($sessionData);
	// 			$data = array(
	// 				'process' => $this->getprocessname($processId),
	// 				'page' => 'pages/tito_monitoring',
	// 				'css' => array(
	// 					'<link rel="stylesheet" type="text/css" href="'.base_url('assets/customised/css/tito_monitoring.css').'">'
	// 				),
	// 				'js' => array(
	// 					'<script type="text/javascript" src="'.base_url('assets/customised/js/tito_monitoring.js').'"></script>'
	// 				)
	// 			);
	// 			$this->load->view('base', $data);
	// 		}else{
	// 			redirect();
	// 		}
	// 	}elseif($page=='allocate'){
	// 		if($this->session->userdata('userkey')){
	// 			$APIResult = $this->base_model->GetSessionInfo();
	// 			$data = json_decode($APIResult, true);
	// 			if (array_key_exists('error', $data)) {
	// 				if($data['error'] != 'No active session!'){
	// 					echo "<script type='text/javascript'>";
	// 					echo "    alert('".$data['error']."');";
	// 					echo "	window.location='".base_url('signout')."'";
	// 					echo "</script>";
	// 				}
	// 			}else{
	// 				$APIResult =  $this->base_model->SessionLogout();
	// 				$data = json_decode($APIResult, true);
	// 				if (array_key_exists('error', $data)) {
	// 					if($data['error']=='Active TITO for the current session detected!'){
	// 						$APIResult = $this->base_model->GetAllocationsDt();
	// 					    $data = json_decode($APIResult, true);
	// 					   	if (array_key_exists('error', $data)) { die($data['error']); }
	// 					    if(sizeof($data) > 0){
	// 					    	$pid = strval($data[0]['ProcessId']);
	// 					    	redirect('tito_monitoring/'.$pid);
	// 						}						
	// 					}else{
	// 						die($data['error']);
	// 					}
	// 				}
	// 			}
			
	// 			$homeData = array(
	// 				'page' => 'pages/agent_refinement_allocate',
	// 				'js' => array(
	// 					'<script type="text/javascript" src="'.base_url('assets/customised/js/agent_refinement.js').'"></script>'
	// 				)
	// 			);
	// 			$this->load->view('base', $homeData);
	// 		}else{
	// 			redirect();
	// 		}
	// 	}else{
	// 		redirect('tito_monitoring/4/tito');
	// 	}
	// }

	public function view_published_list()
    {
    	$ProcessId = 5; //AGENT_PUBLICATION ProcessId
    	$sql="SELECT ps.*, u.UserId, u.LoginName as [UserName], bi.BatchName FROM wms_view_JobsBatchInfoProjectSpecificInfo ps
			INNER JOIN wms_JobsBatchInfo bi ON ps.PS_BatchId = bi.BatchId
			INNER JOIN wms_JobsBatchAllocation ba on bi.LastAllocationRefId = ba.RefId
			INNER JOIN NM_Users u ON ba.UserId = u.UserId
			WHERE bi.StatusId = 7 AND  bi.ProcessId = ".$ProcessId.";";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$data = json_decode($APIResult, true);
		// echo"<pre>";
		// print_r($data);
		// echo"</pre>";
		// die();
		if (array_key_exists('error', $data)) { die("2. ".$data['error']); }
		$result = $data[0];
		if(sizeof($result)>0){
			foreach ($result as $row) {
				echo'<tr class="sourceTR">';
					echo'<td><button class="btn btn-xs btn-primary allocate-btn btn-flat" data-BatchName="'.$row['BatchName'].'"> Allocate</button></td>';
					echo'<td>'.$row['SourceName'].'</td>';
                    echo'<td>'.$row['SourceURL'].'</td>';
                    echo'<td>'.$row['UserName'].'</td>';
                    echo'<td>'.($row['IsParent'] =='1' ? 'Parent' : 'Section').'</td>';
                    // echo'<td>'.$row['Status'].'</td>';
                    echo'<td>'.$row['ParentID'].'</td>';
                    echo'<td>'.$row['BatchName'].'</td>';
                    echo'<td>'.$row['ReferenceID'].'</td>';

				echo'</tr>';
			}
		}
    }

    
}



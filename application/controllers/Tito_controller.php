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

		$APIResult = $this->base_model->SessionLogin($processId);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die($data['error']); }
        
  //       $APIResult = $this->base_model->AutoAllocate(0, '', '');
		// $data = json_decode($APIResult, true);
		// if (array_key_exists('error', $data)) { die($data['error']); }

        $APIResult = $this->base_model->GetAllocationsDt();
	    $data = json_decode($APIResult, true);
	    if (array_key_exists('error', $data)) { die($data['error']); }
	   	// echo "<pre>";
	   	// print_r($data);
	   	// echo "</pre>";
	    if(sizeof($data) > 0){
			foreach ($data as $row) {
				echo'<tr class="sourceTR" data-ParentID="'.$row['ParentID'].'" data-AllocationRefId="'.$row['AllocationRefId'].'" data-ReferenceID="'.$row['ReferenceID'].'">';
					echo'<td>'.$row['ReferenceID'].'</td>';
					echo'<td>'.$row['SourceUrl'].'</td>';
					echo'<td>'.$row['SourceUserName'].'</td>';
					echo'<td>'.$row['SourcePassword'].'</td>';
					echo'<td>'.$row['ClaimedBy'].'</td>';										
				echo'</tr>';
			}
		}
		else{
			echo'<tr>';
				echo'<td colspan="9"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}
	
	}

	public function view_tito_form()
	{
		if($this->session->userdata('AllocationRefId')){
			
			$sessionData = ['AllocationRefId'];
			$this->session->unset_userdata($sessionData);	
		}

		$processId = $this->session->userdata('processId');
		$AllocationRefId = $this->input->post('AllocationRefId');
		$ReferenceID = $this->input->post('ReferenceID');
		$ParentID = $this->input->post('ParentID');

		$sessionData = [
            'AllocationRefId'=> $AllocationRefId
        ];
        $this->session->set_userdata($sessionData);

		$sql="SELECT * FROM [VIEW_AGLDE_SOURCEMOREDETAILS] WHERE [ParentID] = ".$ParentID;
	
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$arrayRes = json_decode($APIResult, true);
		$fdata = $arrayRes[0][0];
		$ParentID = $fdata['ParentID'];
		$parentData = $fdata;
		// print_r($SourceDetails);
		// die();
		
		$sql="SELECT * FROM [AGLDE_SourceDetails] WHERE [SectionParentID] = ".$ParentID." ";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
		$arrayRes = json_decode($APIResult, true);
		$fdata = $arrayRes[0];
		$sectionData = $fdata;
		$data = array(
			'process' => $this->getprocessname($processId),
			'parentData'	=> $parentData,
			'sectionData' 	=> $sectionData,
			'processId' 	=> $processId,
			'AllocationRefId' => $AllocationRefId,
			'ReferenceID' => $ReferenceID
		);

		$AllocationRefId = $this->input->post('AllocationRefId');
		$APIResult = $this->base_model->TaskStart($AllocationRefId);
        $data2 = json_decode($APIResult, true);
        if (array_key_exists('error', $data2)) { die($data2['error']); }
      
		$this->load->view('pages/titoformModal', $data);
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
		// echo"<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// die();

		$ParentID 			= $this->input->post('ParentID');
		$AllocationRefId 	= $this->input->post('AllocationRefId');
		$status 			= $this->input->post('status');
		$ReferenceID 		= $this->input->post('ReferenceID');
		$NewSourceID 		= $this->input->post('NewSourceID');
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceURL 			= $this->input->post('SourceURL');
		$SourceName 		= $this->input->post('SourceName');
		$SourceID = $SubSourceID = '';
		
		$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status);
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("E. :".$data['error']); }
		
		$APIResult =  $this->base_model->SessionLogout();
		$data = json_decode($APIResult, true);
		if (array_key_exists('error', $data)) { die("D. :".$data['error']); }	

		$sessionData = ['AllocationRefId'];
		$this->session->unset_userdata($sessionData);

		if($status=='Done'){
			
			$json = '{ "referenceId": "'.$ReferenceID.'", "sources": [{ "url": "'.$SourceURL.'", "name": "'.$SourceName.'" ';
			
			$sql="SELECT [ParentID], [SourceName], [SourceURL] FROM [WMS_AGLDE].[dbo].[AGLDE_SourceDetails] WHERE 
			[SectionParentID] = ".$ParentID." AND [IsParent] IS NULL ORDER BY [ParentID] ASC";
			$APIResult = $this->base_model->GetDatabaseDataset($sql);
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) { die("T4. ".$data['error']); }
			$SectionData = $data[0];
			
			if(sizeof($SectionData) > 0){
				$json .= ',"sections": [ ';
				$sections='';
				foreach ($SectionData as $row) { $sections .= '{ "url": "'.$row['SourceURL'].'", "name": "'.$row['SourceName'].'" },'; }
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
		    	    

		    	    $APIResult = $this->base_model->SessionLogin('2');
					$data = json_decode($APIResult, true);
					if (array_key_exists('error', $data)) { die("T1. ".$data['error']); }

					if($x > 0){
		    	    	$ParentID = $SectionData[$e]['ParentID'];
		    	    	$sql="EXEC USP_AGLDE_SOURCEDETAILS_UPDATE_SourceID @SourceID='".$SourceID."', @ParentID =".$ParentID;
			    	    $APIResult = $this->base_model->ExecuteDatabaseScript($sql);
			    	    $data = json_decode($APIResult, true);
						if (array_key_exists('error', $data)) { die("T6. ".$data['error']); }

			    	    $sql= "EXEC USP_AGLDE_REGISTERJOB @ParentId=".$ParentID;
			    	    echo $sql."<br>";
						$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
						$data1 = json_decode($APIResult, true);
						extract($data1);
						if (array_key_exists('error', $data1)) { die("T5. ".$data1['error']); }

						$e++;
		    	    }


					$APIResult = $this->base_model->AutoAllocate(0, '', '');
					$data = json_decode($APIResult, true);
					if (array_key_exists('error', $data)) { die("T2. ".$data['error']); }

					if($x > 0){
						$APIResult = $this->base_model->GetAllocationsDt();
					    $data = json_decode($APIResult, true);
					    if (array_key_exists('error', $data)) { die("T8. ".$data['error']); }
					    if(sizeof($data) > 0){
							foreach ($data as $row) {
								$AllocationRefId = $row['AllocationRefId'];
							}
						}

						echo $AllocationRefId."<br>";
						$APIResult = $this->base_model->TaskEnd($AllocationRefId, $status);
						$data = json_decode($APIResult, true);
						if (array_key_exists('error', $data)) { die("E2. :".$data['error']); }
					}
					

					$APIResult =  $this->base_model->SessionLogout();
					$data = json_decode($APIResult, true);
					if (array_key_exists('error', $data)) { die("T3. ".$data['error']); }
					$x++;
		        }
		    }
		}
			
		
	}
}



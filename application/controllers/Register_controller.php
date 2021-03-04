<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

    public function register($regtype){
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
		
			$page = ($regtype=='pre_published' ? 'reg_prebulished' : 'reg_manual');
			// $page = 'reg_prebulished';
			$homeData = array(
				'page' => 'pages/'.$page
			);
			$this->load->view('base', $homeData);
		}else{
			redirect();
		}
    } 

    public function upload_prepublished(){
    	// print_r($_FILES);
    	if($_FILES["file"]['error'] <= 0){
			$sourcelist = basename($_FILES["file"]["name"]);
			$fileExt = strtolower(pathinfo($sourcelist, PATHINFO_EXTENSION));
		
			if($fileExt != "xlsx"){
				echo "Please use excel with 'xlsx' extenion only";
			}
			else{
				if ($_FILES["file"]["error"] == UPLOAD_ERR_OK)
				{	
					$this->load->library('excel');
					$path = $_FILES["file"]["tmp_name"];
				    $object = PHPExcel_IOFactory::load($path);
				    $percent=0;

		   			foreach($object->getWorksheetIterator() as $worksheet) {
						$highestRow = $worksheet->getHighestRow();
					    $highestColumn = $worksheet->getHighestColumn();

					    $donerow = 1;
					    for($row=2; $row <= $highestRow; $row++)
					    {					
					    	$AgentID = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					    	$sql = "SELECT TOP (1) [AgentID] FROM [WMS_AGLDE].[dbo].[AGLDE_SourceDetails] WHERE [AgentID] = '".$AgentID."' ";

					    	$APIResult = $this->base_model->GetDatabaseDataset($sql);
					    	$data = json_decode($APIResult, true);
					    	if($data[0]){
					    		//agent id found; do not insert
					    	}else{
					    		$SourceURL = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						    	$sql="EXEC USP_AGLDE_REGISTER_PREPUBLISHED @SourceURL='".$SourceURL."', @ClaimedDate='".date('Y-m-d H:i:s')."'";
						    	$APIResult = $this->base_model->GetDatabaseDataset($sql);
						    	$data = json_decode($APIResult, true);
						    	$id = $data[0][0]['ID'];

								$sql="EXEC USP_AGLDE_REGISTER_SourceDetails 
									@NewSourceID = ".$id.", 
									@SourceID = '".$worksheet->getCellByColumnAndRow(0, $row)->getValue()."', 
									@SourceName = '".$worksheet->getCellByColumnAndRow(1, $row)->getValue()."', 
									@SourceURL = '".$SourceURL."', 
									@AgentID = '".$AgentID."'";
								$APIResult = $this->base_model->GetDatabaseDataset($sql);
								$data = json_decode($APIResult, true);
								$ParentID = $data[0][0]['ParentID'];

								$sql="EXEC USP_AGLDE_REGISTER_SourceConfiguration @SourceParentID = ".$ParentID.", @Remark = 'PRE-PUBLISHED'";
								$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
								
								$sql="EXEC USP_AGLDE_REGISTERJOB_MANUAL @ParentId = ".$ParentID.", @userName = '".$this->session->userdata('userName')."', @processid = 5";
								// die($sql);
								$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
								if (array_key_exists('error', $data)) { die("Er1: ".$data['error']); }
					    	}
					    	$donerow++;
					    }
				
					    if($donerow == $highestRow){
					    	echo "All sources saved successfully";
					    }else{
					    	// $diff = $highestRow - $donerow;
					    	echo "Done but incomplete.";
					    }
					}
				}
			}
		}
    }  

    public function downloadtemplate($type){
    	$filename = ($type=='manual' ? 'REGISTRION MANUAL.xlsx' : 'REGISTER PRE PUBLISHED.xlsx');
    	$path = 'assets/files/'.$filename;
    	if(is_file($path))
      	{
	        // required for IE
	        if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }
	        $mime = get_mime_by_extension($path);
	        // Build the headers to push out the file properly.
	        header('Pragma: public');     // required
	        header('Expires: 0');         // no cache
	        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	        header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
	        header('Cache-Control: private',false);
	        header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
	        header('Content-Disposition: attachment; filename="'.basename($filename).'"');  // Add the file name
	        header('Content-Transfer-Encoding: binary');
	        header('Content-Length: '.filesize($path)); // provide file size
	        header('Connection: close');
	        readfile($path); // push it out
    	}
    	exit();
    }

    public function upload_manualregform(){
    	// print_r($_FILES);
    	if($_FILES["file"]['error'] <= 0){
			$sourcelist = basename($_FILES["file"]["name"]);
			$fileExt = strtolower(pathinfo($sourcelist, PATHINFO_EXTENSION));
		
			if($fileExt != "xlsx"){
				echo "Please use excel with 'xlsx' extenion only";
			}
			else{
				if ($_FILES["file"]["error"] == UPLOAD_ERR_OK)
				{	
					$this->load->library('excel');
					$path = $_FILES["file"]["tmp_name"];
				    $object = PHPExcel_IOFactory::load($path);
				    $percent=0;

		   			foreach($object->getWorksheetIterator() as $worksheet) {
						$highestRow = $worksheet->getHighestRow();
					    $highestColumn = $worksheet->getHighestColumn();
					    $donerow = 1;
					    for($row=2; $row <= $highestRow; $row++)
					    {		
					    	$tempReference = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					    	$ReferenceID = ($tempReference =='' ? '5ff32fb6c358c97197e54431' : $tempReference);
					    	$SourceName = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					    	$SourceURL = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					    	$AgentID = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

					    	$sql = "SELECT TOP (1) [AgentID] FROM [WMS_AGLDE].[dbo].[AGLDE_SourceDetails] WHERE [AgentID] = '".$AgentID."' ";
					    	$APIResult = $this->base_model->GetDatabaseDataset($sql);
					    	$data = json_decode($APIResult, true);
					    	if($data[0]){
					    		//agent id found; do not insert
					    	}else{
					    		$SourceURL = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						    	$sql="EXEC USP_AGLDE_REGISTER_MANUAL 
						    		@ReferenceID='".$ReferenceID."', 
						    		@SourceURL='".$SourceURL."', 
						    		@ClaimedDate='".date('Y-m-d H:i:s')."' ";
						    	$APIResult = $this->base_model->GetDatabaseDataset($sql);
						    	$data = json_decode($APIResult, true);
						    	$NewSourceID = $data[0][0]['ID'];

						    	$json = '{ "referenceId": "'.$ReferenceID.'", "sources": [{ "url": "'.$SourceURL.'", "name": "'.$SourceName.'"}] }';		
								$APIResult = $this->base_model->A1_API($json);
								$data = json_decode($APIResult, true);
								if($APIResult === FALSE) {
									$returnData = array(
										'error' => true,
										'message' => 'Could not get response. Please try again later'
									);
				      				echo json_encode($returnData);
				      				// die();
								}
								elseif(array_key_exists('timestamp', $data)) {
									$returnData = array(
										'error' => true,
										'message' => $data['message']
									);
				      				echo json_encode($returnData);
				      				die();
								}
								elseif(array_key_exists('sources', $data)){
								    $SourceID = $data['sources'];
									$sql="EXEC USP_AGLDE_SOURCEDETAILS_INSERT_MANUAL 
										@SourceID = '".$SourceID."' ,
										@AgentID = '".$AgentID."',
										@SourceName = '".$SourceName."',
										@SourceURL = '".$SourceURL."'";
									$APIResult = $this->base_model->GetDatabaseDataset($sql);
									$data = json_decode($APIResult, true);
									$ParentID = $data[0][0]['ParentID'];

									$sql="EXEC USP_AGLDE_REGISTER_SourceConfiguration @SourceParentID = ".$ParentID.", @Remark = 'MANUAL REGISTRATION'";
									$APIResult = $this->base_model->ExecuteDatabaseScript($sql);

									
									$sql="EXEC USP_AGLDE_REGISTERJOB_MANUAL @ParentId = ".$ParentID.", @userName = '".$this->session->userdata('userName')."', @processid = 2";
									$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
									
									$APIResult = $this->base_model->TaskEnd($AllocationRefId, 'Done', $this->input->post('Remark'));
									$data = json_decode($APIResult, true);
									// if (array_key_exists('error', $data)) { 
									// 	$returnData = array(
									// 		'error' => true,
									// 		'message' => "TO1B :".$data['error']
									// 	);
									// 	echo json_encode($returnData);
									// }
									// else{
									// 	$returnData = array(
									// 		'error' => false,
									// 		'message' => 'Saved'
									// 	);
									// 	echo json_encode($returnData);
									// }
								}					    		
					    	}
					    	$donerow++;
					    }
				
					    if($donerow == $highestRow){
					    	echo "All sources saved successfully";
					    }else{
					    	// $diff = $highestRow - $donerow;
					    	echo "Done but incomplete.";
					    }
					}
				}
			}
		}
    }
}





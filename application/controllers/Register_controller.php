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
		
			// $page = ($regtype=='pre_published' ? 'reg_prebulished' : 'reg_newsource');
			$page = 'reg_prebulished';
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
					    $userinfo =array();
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

								$sql="EXEC USP_AGLDE_REGISTER_SourceConfiguration @SourceParentID = ".$ParentID;
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
}





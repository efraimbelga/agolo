<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basecontroller extends CI_Controller {
	public function __construct(){
        parent::__construct();   
        $this->load->model('base_model');
    }

    public function index()
	{
		if($this->session->userdata('userkey')){
			redirect('home');
		}else{
			$data = array(
				'js' => array(
					'<script type="text/javascript" src="'.base_url('assets/customised/js/login.js').'"></script>'
				)
			);
			$this->load->view('login', $data);
		}		
	}

	public function loginuser()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$APIResult = $this->base_model->GenerateAccessKey2($username, $password);
        $data = json_decode($APIResult, true);
        if (array_key_exists('error', $data)) { die($data['error']); }
        if (array_key_exists('userkey', $data)) { 
            $userkey = $data['userkey'];

			$APIResult = $this->base_model->GetUserInfo($userkey);
            $data = json_decode($APIResult, true);
            if (array_key_exists('error', $data)) { die($data['error']); }
            // print_r($data);
            // die();
            $sessionData = [
                'userkey'       => $userkey,
                // 'UserId'      	=> $data['UserId'],
                'userName'      => $data['userName'],
                'fullName'      => $data['fullName'],
                'emailAddress'  => $data['emailAddress'],
                'role'          => $data['role'],
                'userLevel'     => $data['userLevel'],
                'passwordExpiry' => $data['passwordExpiry'],
                'sessionExpiry' => $data['sessionExpiry'],
                'projects'		=> $data['projects'],
                'workflows'		=> $data['workflows'],
                'processId'		=> 'CONTENT_ANALYSIS'
            ];
            

            $this->session->set_userdata($sessionData);
            echo 'ok';
        }
	}

	public function signout(){
		$APIResult = $this->base_model->SessionLogout();
		
		$sessionData = [
                'userkey',
                // 'UserId',
                'userName',
                'fullName',
                'emailAddress',
                'role',
                'userLevel',
                'passwordExpiry',
                'sessionExpiry',
                'projects',
                'workflows',
                'task'
            ];
		$this->session->unset_userdata($sessionData);
		redirect();
	}


	public function home()
	{
		if($this->session->userdata('userkey')){
			$APIResult = $this->base_model->GetSessionInfo();
			$data = json_decode($APIResult, true);
			if (array_key_exists('error', $data)) {
				// die($data['error']); 
			}else{
				$APIResult =  $this->base_model->SessionLogout();
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die($data['error']); }
			}
		
			$data = array(
				'page' => 'pages/home',
				'js' => array(
					'<script type="text/javascript" src="'.base_url('assets/customised/js/home.js').'"></script>'
				)
			);
			$this->load->view('base', $data);
		}else{
			redirect();
		}
	}

	public function view_source_request(){
		$sql="SELECT * FROM [AGLDE_NewSourceRequest] WHERE [IsClaimed] IS NULL ORDER BY [ID] ASC";
		$APIResult = $this->base_model->GetDatabaseDataset($sql);
        $data = json_decode($APIResult, true);
        $data = $data[0];
        if(sizeof($data) > 0){
			foreach ($data as $row) {
				$date = date_create($row['SourceRequestDate']);
				echo'<tr class="sourceTR" data-id="'.$row['ID'].'" data-ref="'.$row['ReferenceID'].'">';
					echo'<td>'.$row['ReferenceID'].'</td>';
					echo'<td>'.$row['SourceURL'].'</td>';
					echo'<td>'.date_format($date, "Y-m-d").'</td>';
					echo'<td>'.$row['SourceUserName'].'</td>';
					echo'<td>'.$row['SourcePassword'].'</td>';
				echo'</tr>';
			}
		}
		else{
			echo'<tr>';
				echo'<td colspan="5"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}
	}


	public function claim_request()
	{
		$this->base_model->SessionLogout();
		$source = '';
		foreach ($_POST['source'] as $value) {
			$source .= $value.",";
		}
		$source = rtrim($source, ',');
		$ClaimedDate = date('Y-m-d H:i:s');
		$ClaimedBy = $this->session->userdata('userName');

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
				$sql = "SELECT A.ParentID FROM dbo.AGLDE_SourceDetails AS A INNER JOIN dbo.AGLDE_NewSourceRequest AS B ON A.NewSourceID = B.ID WHERE B.IsClaimed IS NOT NULL AND B.ClaimedDate = '".$ClaimedDate."' AND B.ClaimedBy='".$ClaimedBy."' AND B.ID IN (".$source.") ";
				$APIResult = $this->base_model->GetDatabaseDataset($sql);
				$data = json_decode($APIResult, true);
				if (array_key_exists('error', $data)) { die("2 : ".$data['error']); }

				$data = $data[0];
				
				// $sql="SELECT TOP (1) [ProcessId] FROM [WMS_AGLDE].[dbo].[wms_Processes] WHERE [ProcessCode] = 'CONTENT_ANALYSIS'"
				// $APIResult = $this->base_model->GetDatabaseDataset($sql);
				// $data = json_decode($APIResult, true);
				// if (array_key_exists('error', $data)) { die("2 : ".$data['error']); }
				// $data = $data[0];


				if(sizeof($data) > 0){
					foreach ($data as $row) {
						$sql= "EXEC USP_AGLDE_REGISTERJOB @ParentId=".$row['ParentID'].", @processid=1, @userName=".$this->session->userdata('userName');
						$APIResult = $this->base_model->ExecuteDatabaseScript($sql);
						$data1 = json_decode($APIResult, true);
						if (array_key_exists('error', $data1)) { die("3 : ".$data1['error']); }						
					}
				}
			}
		}
		// $APIResult = $this->base_model->SessionLogin('1');
		// $data = json_decode($APIResult, true);
		// if (array_key_exists('error', $data)) { die($data['error']); }
		echo $result;

	}

	public function get_content_analysis_list(){
		$ClaimedBy = $this->session->userdata('userName');
		$sql="SELECT A.ParentID, B.ReferenceID FROM dbo.AGLDE_SourceDetails AS A INNER JOIN dbo.AGLDE_NewSourceRequest AS B ON A.NewSourceID = B.ID WHERE A.IsParent = 1 and A.Status IS NULL AND B.ClaimedBy = '".$ClaimedBy."'";
		$postdata = http_build_query(
		    array(
		        'apikey' 	=> APIKEY,
		        'userKey'	=> $this->session->userdata('userkey'),
		        'script'	=> urlencode($sql)
		    )
		);
		$opts = STREAM_CONTEXT;
		$opts['http']['content'] = $postdata;		    

		$result = file_get_contents(WMS_URL.'GetDatabaseDataset', false, stream_context_create($opts));
        $data = json_decode($result, true);
        $data = $data[0];
        if(sizeof($data) > 0){
			foreach ($data as $row) {
				echo '<li><a href="#" class="viewsource" data-id><i class="fa fa-circle-o"></i> Level Two</a></li>';
			}
		}
		else{
			echo'<tr>';
				echo'<td colspan="5"><p class="text-center">No data found</p></td>';
			echo'</tr>';
		}
	}

	public function dashboard(){

		$data = array(
			'page' => 'pages/dashboard',
			'js' => array(
				'<script type="text/javascript" src="'.base_url('assets/customised/js/dashboard.js').'"></script>'
			)
		);
		$this->load->view('base', $data);
	}

	public function analysisModal(){
		$sql="SELECT * FROM [AGLDE_NewSourceRequest] WHERE [ID] = ".$_POST['id'];
		$result = $this->base_model->get_data_row($sql);
		$date = date_create($result->ClaimedDate);
		$data = array(
			'ID' => $result->ID,
      		'ReferenceID' => $result->ReferenceID,
      		'SourceURL' => $result->SourceURL,
      		'SourceRequestDate' => $result->SourceRequestDate,
      		'SourceUserName' => $result->SourceUserName,
      		'SourcePassword' => $result->SourcePassword,
      		'IsClaimed' => $result->IsClaimed,
      		'ClaimedDate' => date_format($date, "Y-m-d"),
      		'ClaimedBy' => $result->ClaimedBy,
		);
		echo json_encode($data);
	}
}



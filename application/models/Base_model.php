<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }

    public function GenerateAccessKey2($username, $password){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'config'    => CONFIG,
                'userName'  => $username,
                'password'  => $password
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'GenerateAccessKey2', false, stream_context_create($opts));
        return $result;
    }

    public function TaskStart($AllocationRefId){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userKey'    => $this->session->userdata('userkey'),
                'allocationrefid'  => $AllocationRefId
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'TaskStart', false, stream_context_create($opts));
        return $result;
    }

    public function TaskEnd($AllocationRefId, $status, $titoRemarks){
        $postdata = http_build_query(
            array(
                'apiKey'        => APIKEY,
                'userKey'       => $this->session->userdata('userkey'),
                'allocationrefid'  => $AllocationRefId,
                'status'        => strtolower($status),
                'titoValue'     => '0',
                'titoRemarks'   => $titoRemarks,
                'isNfp'         => 'false',
                'nfpRemarks'    => ''
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'TaskEnd', false, stream_context_create($opts));
        return $result;
    }

    public function GetUserInfo($userkey){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userkey'   => $userkey
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'GetUserInfo', false, stream_context_create($opts));
        return $result;
    }

    public function SessionLogin($processId){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userkey'   => $this->session->userdata('userkey'),
                'refDate'   => date('Y-m-d'),
                'projectId' => 1,
                'processId' => $processId
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'SessionLogin', false, stream_context_create($opts));
        return $result;
    }

    public function SessionLogout(){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userkey'   => $this->session->userdata('userkey'),
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'SessionLogout', false, stream_context_create($opts));
        return $result;
    }

    public function GetDatabaseDataset($sql){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userKey'   => $this->session->userdata('userkey'),
                'script'    => urlencode($sql)
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'GetDatabaseDataset', false, stream_context_create($opts));
        return $result;
    }

    public function ExecuteDatabaseScript($sql){
        $postdata = http_build_query(
            array(
                'apiKey'    => APIKEY,
                'userKey'   => $this->session->userdata('userkey'),
                'script'    => urlencode($sql)
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'ExecuteDatabaseScript', false, stream_context_create($opts));
        return $result;
    }

    public function AutoAllocate($workflowId=null, $allocationCategory=null, $shipmentName=null){
         $postdata = http_build_query(
            array(
                'apiKey'                => APIKEY,
                'userKey'               => $this->session->userdata('userkey'),
                'workflowId'            => $workflowId,
                'allocationCategory'    => $allocationCategory,
                'shipmentName'          => $shipmentName
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'AutoAllocate', false, stream_context_create($opts));
        return $result;
    }

    public function GetAllocationsDt(){
        $postdata = http_build_query(
            array(
                'apiKey'        => APIKEY,
                'userKey'       => $this->session->userdata('userkey')
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'GetAllocationsDt', false, stream_context_create($opts));
        return $result;
    }

    public function GetSessionInfo(){
        $postdata = http_build_query(
            array(
                'apiKey'        => APIKEY,
                'userKey'       => $this->session->userdata('userkey')
            )
        );
        $opts = STREAM_CONTEXT;
        $opts['http']['content'] = $postdata;
        $result = file_get_contents(WMS_URL.'GetSessionInfo', false, stream_context_create($opts));
        return $result;
    }

    public function A2_API($json, $SourceID){        
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'PUT',
                'header' => "Content-Type: application/json",
                'content' => $json
            )
        ));

        // Send the request
        $response = @file_get_contents('https://sources-management.crawlers.agolo.com/api/v1/sources/'.$SourceID, FALSE, $context);
        return $response;
    }

    public function A1_API($json){
        
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => $json
            )
        ));
        // Send the request
        $response = @file_get_contents('https://sources-management.crawlers.agolo.com/api/v1/sources', FALSE, $context);
        return $response;
    }

    public function A3_API($agentID, $state){
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json"
            )
        ));
        // Send the request
        $response = @file_get_contents('https://sources-management.crawlers.agolo.com/api/v1/agents/'.$agentID.'/'.$state, FALSE, $context);
        return $response;
    }

    // public function subsectionSource($ReferenceID, $sourceURL, $SourceName, $SourceID){
    //     $context = stream_context_create(array(
    //         'http' => array(
    //             'method' => 'POST',
    //             'header' => "Content-Type: application/json",
    //             'content' => '{ "referenceId": "'.$ReferenceID.'", "sections":[{ "name": "'.$SourceName.'","url": "'.$sourceURL.'" }] }'
    //         )
    //     ));
    //     $response = file_get_contents('https://sources-management.crawlers.agolo.com/api/v1/sources/'.$SourceID.'/sections', FALSE, $context);
    //     return $response;
    // }

    public function get_data_array($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_data_row($sql){
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function executequery($sql){
        $this->db->query($sql);
        return $this->db->affected_rows(); 
    }
}



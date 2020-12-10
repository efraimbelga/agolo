<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AGOLO</title>
    <link rel="icon" href="<?= base_url('assets/images/favicon.png');?>" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css');?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css');?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/customised/css/style.css');?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/customised/css/home.css');?>">
    <?php
    if(isset($css)){
        foreach ($css as $cssfile) {
            echo $cssfile."\n";
        }
    }
?>
    <script type="text/javascript">
        var domain = "<?= base_url();?>";

    </script>
    <style type="text/css">
        .sidebar-mini.sidebar-collapse .content-wrapper,
        .sidebar-mini.sidebar-collapse .main-footer,
        .content-wrapper, .main-footer{
            margin-left: 0px !important;
        }
        
    </style>
</head>
<body class="hold-transition skin-blue" >
<!-- Site wrapper -->
<div class="wrapper" style="background: #ecf0f5;">
    <?php
        // $this->load->view('navbar-top');
    ?>
    <div class="content-wrapper" style="padding-top: 0px;">
        <br>

        <div class="col-lg-12">
            
            <h1>CONTENT ANALYSIS</h1>
            <?php
                if($error){
                    die('<h1 class="text-center">'.$errorMsg.'</h1>');
                }
            ?>
            <table style="width: 100%;">
                <?php
                    extract($parentData);
                    echo"<tr>";
                        echo "<td><p>Reference Id: <b> ".$ReferenceID."</b></p></td>";
                        echo "<td><p>Source Username: <b> ".($SourceUserName=='' ? 'None' : $SourceUserName)."</b></p></td>";
                        echo "<td><p>Claimed By: <b> ".$ClaimedBy."</b></p></td>";
                        echo "<td><p>Claimed Date: <b> ".$ClaimedDate."</b></p></td>";
                    echo"</tr>";
                ?>
            </table>
        </div>
        <div class="col-lg-12 CONTENT_ANALYSIS">
            <br>
            <table class="table table-condensed table-bordered contentanalysisTbl" id="psourceTbl">
                <thead>
                    <tr>
                        <th>Source URL</th>
                        <th>Source Name</th>
                        <th>Type</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Client</th>
                        <th>Access</th>
                        <th>Priority</th>
                        <th>Remark</th>
                        <?= ($process=='CONTENT_ANALYSIS' ? '<th></th>' : ''); ?>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>
                            <input type="hidden" id="ParentID" value="<?= $ParentID;?>">
                            <input type="hidden" id="processID" value="1">
                            <input type="hidden" id="ReferenceID" value="<?= $ReferenceID;?>">
                            <input type="hidden" id="AllocationRefId" value="<?= $AllocationRefId;?>">
                            <input type="hidden" id="NewSourceID" value="<?= $NewSourceID;?>">
                            <div class="form-control input-sm" id="SourceURL" data-key="SourceURL"><?= $NSRSourceURL;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm SourceName requiredDiv" id="SourceName" data-key="SourceName" contenteditable="true"><?= $SourceName;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Type " data-key="Type" contenteditable="true"><?= $Type;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Region" data-key="Region" contenteditable="true"><?= $Region;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Country" data-key="Country" contenteditable="true"><?= $Country;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Client" data-key="Client" contenteditable="true"><?= $Client;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Access" data-key="Access" contenteditable="true"><?= $Access;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Priority requiredDiv" data-key="Priority" contenteditable="true" id="Priority"><?= $Priority;?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Remark noedited" data-key="Remark" contenteditable="true"></div>
                        </td>
                        <td>
                            <a href="" class="btn btn-xs btn-success btn-flat savepsource-btn" ><i class="fa fa-check-square" aria-hidden="true"></i></a>
                            <a href="" class="btn btn-xs btn-danger btn-flat clearpsource-btn"><i class="fa fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                        
                    </tr>
                    <tr class="subsectiontr <?= (sizeof($sectionData) > 0 ? '' : 'displayNone');?>">
                        <th colspan="8">Sub-section:</th>
                    </tr>
                    <tr class="subsectiontr <?= (sizeof($sectionData) > 0 ? '' : 'displayNone');?>">
                        <th>Section Source URL</th>
                        <th>Source Name</th>
                        <th>Type</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Client</th>
                        <th>Access</th>
                        <th>Priority</th>
                        <!-- <th>Remark</th> -->
                        <th></th>
                    </tr>
                    <?php
                        foreach ($sectionData as $row) {
                    ?>
                        <tr class="subsection" data-id="<?= $row['ParentID'];?>">
                            <td>
                                <div class="form-control input-sm SourceURL requiredDiv" data-key="SourceURL" contenteditable="true" ><?= $row['SourceURL'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm SourceName requiredDiv" data-key="SourceName" contenteditable="true" ><?= $row['SourceName'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Type" data-key="Type" contenteditable="true" ><?= $row['Type'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Region" data-key="Region" contenteditable="true" ><?= $row['Region'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Country" data-key="Country" contenteditable="true" ><?= $row['Country'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Client" data-key="Client" contenteditable="true" ><?= $row['Client'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Access" data-key="Access" contenteditable="true" ><?= $row['Access'];?></div>
                            </td>
                            <td>
                                <div class="form-control input-sm Priority requiredDiv" data-key="Priority" contenteditable="true" ><?= $row['Priority'];?></div>
                            </td>
                            <!-- <td>
                                <div class="form-control input-sm Remark" data-key="Remark" contenteditable="true"></div>
                            </td> -->
                            <td class="text-left">
                                <a href="" class="savesection-btn btn btn-xs btn-flat btn-success"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                                <a href="" class="clearsection-btn btn btn-xs btn-flat btn-danger"><i class="fa fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>                            
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 CONTENT_ANALYSIS">
            <?= ($process=='CONTENT_ANALYSIS' ? '<button type="button" class="btn btn-xs btn-flat btn-info addsesction-btn" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Section</button>' : ''); ?>
            <button class="btn btn-flat btn-xs btn-danger taskout-btn" data-value="Pending" ><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Pending</button>
            <button class="btn btn-flat btn-xs btn-success taskout-btn" data-value="Done" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Done</button>
            <p class="errorMsg"></p> 
       </div>  
    </div>
    
    <div class="modal fade" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h1><i class="fa fa-spinner fa-spin"></i></h1>
                            <p>Please wait</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- SlimScroll -->
<script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->


<script type="text/javascript" src="<?= base_url('assets/customised/js/general.js');?>"></script>
<?php
    if(isset($js)){
        foreach ($js as $jsfile) {
            echo $jsfile."\n";
        }
    }
?>
<script type="text/javascript" src="<?= base_url('assets/customised/js/content_anaylsis.js');?>"></script>


</body>
</html>

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
<body class="hold-transition skin-blue sidebar-mini fixed" >
<!-- Site wrapper -->
<div class="wrapper" style="background: #ecf0f5;">
    <?php
        $this->load->view('navbar-top');
    ?>
    <div class="content-wrapper" >
        <br>
        <div class="col-lg-12 CONTENT_ANALYSIS">
            <?php
                if($error){
                    die('<h1 class="text-center">'.$errorMsg.'</h1>');
                }
            ?>
            <table style="width: 100%;">
                <?php
                // echo"<pre>";
                // print_r($parentData);
                // echo"</pre>";
                    foreach ($parentData as $row) {
                        echo "<input type='hidden' id='ParentID' value='".$row['ParentID']."'>";
                        echo "<input type='hidden' id='processId' value='1'>";
                        echo "<input type='hidden' id='ReferenceID' value='".$row['ReferenceID']."'>";
                        echo "<input type='hidden' id='AllocationRefId' value='".$AllocationRefId."'>";
                        echo "<input type='hidden' id='NewSourceID' value='".$row['NewSourceID']."'>";
                        echo"<tr>";
                        echo "<td><p>Reference Id: <b> ".$row['ReferenceID']."</b></p></td>";
                        echo "<td><p>Source Username: <b> ".$row['SourceUserName']."</b></p></td>";
                        echo "<td><p>Claimed By: <b> ".$row['ClaimedBy']."</b></p></td>";
                        echo "<td><p>Claimed Date: <b> ".$row['ClaimedDate']."</b></p></td>";
                        echo"</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="col-lg-12">
            <br>
            <table class="table table-condensed table-bordered contentanalysiTbl" id="psourceTbl">
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
                    <?php
                        foreach ($parentData as $row) { ?>
                    <tr>
                        <td>
                            <div class="form-control input-sm" id="SourceURL" data-key="SourceURL"><?= $row['NSRSourceURL'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm SourceName editablediv " id="SourceName" data-key="SourceName" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['SourceName'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Type editablediv " data-key="Type" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Type'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Region editablediv" data-key="Region" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Region'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Country editablediv" data-key="Country" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Country'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Client editablediv" data-key="Client" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Client'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Access editablediv" data-key="Access" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Access'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Priority editablediv" data-key="Priority" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $row['Priority'];?></div>
                        </td>
                        <td>
                            <div class="form-control input-sm Remark editablediv" data-key="Remark" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>></div>
                        </td>
                        <?= ($process=='CONTENT_ANALYSIS' ? '<td>
                            <a href="" class="savepsource-btn" ><i class="fa fa-check-square" aria-hidden="true"></i></a>
                            <a href="" class="clearpsource-btn"><i class="fa fa-window-close" aria-hidden="true"></i></a>
                        </td>' : ''); ?>
                        
                    </tr>
                <?php  } ?>
                    <tr class="subsectiontr displayNone">
                        <th>Section Source URL</th>
                        <th>Source Name</th>
                        <th>Type</th>
                        <th>Region</th>
                        <th>Country</th>
                        <th>Client</th>
                        <th>Access</th>
                        <th>Priority</th>
                        <th>Remark</th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
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


<!-- <script type="text/javascript" src="<?= base_url('assets/customised/js/general.js');?>"></script> -->
<?php
    if(isset($js)){
        foreach ($js as $jsfile) {
            echo $jsfile."\n";
        }
    }
?>


</body>
</html>

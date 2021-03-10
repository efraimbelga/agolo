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
        div.errorDiv {
            margin-bottom: 30px;
        }
    </style>
</head>
<body class="hold-transition skin-blue" >
<!-- Site wrapper -->
<div class="wrapper" style="background: #ecf0f5;">
    <div class="content-wrapper" style="padding-top: 0px;">
        <div class="row">
            <div class="col-lg-12">
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
                    <input type="hidden" name="processID" id="processID" value="1" required>
                    <input type="hidden" name="ReferenceID" id="ReferenceID" value="<?= $ReferenceID;?>" required>
                    <input type="hidden" name="AllocationRefId" id="AllocationRefId" value="<?= $AllocationRefId;?>" required>
                    <input type="hidden" name="NewSourceID" id="NewSourceID" value="<?= $NewSourceID;?>" required>
                    <input type="hidden" name="SectionParentID" id="SectionParentID" value="<?= $ParentID;?>" required >
                    <!-- <label class="checkbox-inline">
                        <input type="checkbox" value="1" id="subsectionOpt"> Sub-section
                    </label> -->
                    <!-- <input type="hidden" name="newparent" id="newparent" value="0" required > -->
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <tr>
                                <td style="display: none;"><form id="parentdataForm"></form></td>
                                    <td>
                                        <input form="parentdataForm" type="hidden" name="ParentID" class="ParentID" id="ParentID" value="<?= $ParentID;?>" required >
                                        <input form="parentdataForm" type="text" name="SourceURL" id="SourceURL" class="form-control input-sm noedited SourceURL" value="<?= $NSRSourceURL;?>" required readonly>
                                    </td>
                                    <td><input form="parentdataForm" type="text" name="SourceName" class="form-control input-sm SourceName" id="SourceName" value="<?= $SourceName;?>" required autocomplete="off">
                                    </td>
                                    <td>
                                        <input form="parentdataForm" type="text" name="Type" class="form-control input-sm Type" id="Type" value="<?= $Type;?>">
                                    </td>
                                    <td>
                                        <select form="parentdataForm" name="Region" class="form-control input-sm Region" id="Region">
                                            <option value=""></option>
                                            <?php
                                            foreach ($regions as $region) {
                                                echo'<option '.($Region==$region ? 'selected' : '').' value="'.$region.'">'.$region.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input form="parentdataForm" type="text" name="Country" id="Country" class="form-control input-sm Country" value="<?= $Country;?>">
                                    </td>
                                    <td>
                                        <input form="parentdataForm" type="text" name="Client" id="Client" class="form-control input-sm Client" value="<?= $Client;?>">
                                    </td>
                                    <td>
                                        <input form="parentdataForm" type="text" name="Access" id="Access" class="form-control input-sm Access" value="<?= $Access;?>">
                                    </td>
                                    <td>
                                        <select form="parentdataForm" name="Priority" id="Priority" class="form-control input-sm Priority" required>
                                            <option value=""> </option>
                                            <option <?= ($Priority=='High' ? 'selected' : ''); ?> value="High">High</option>
                                            <option <?= ($Priority=='Medium' ? 'selected' : ''); ?> value="Medium">Medium</option>
                                            <option <?= ($Priority=='Low' ? 'selected' : ''); ?> value="Low">Low</option>
                                        </select>
                                    </td>                               
                                    <td>
                                        <button form="parentdataForm" type="submit" class="btn btn-xs btn-success savepsource-btn" ><i class="fa fa-check-square" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger clearpsource-btn"><i class="fa fa fa-trash-o" aria-hidden="true"></i></button>
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
                                <th></th>
                            </tr>
                            <?php
                                foreach ($sectionData as $row) {
                            ?>
                                <tr class="subsection">
                                    <td style="display: none;"><form class="subsectionFrom" id="FORM<?= $row['ParentID'];?>"></form></td>                                    
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="hidden" class="ParentID" name="ParentID" value="<?= $row['ParentID'];?>" required >
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="SourceURL" class="form-control input-sm SourceURL" value="<?= $row['SourceURL'];?>" required >
                                    </td>
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="SourceName" class="form-control input-sm" value="<?= $row['SourceName'];?>" >
                                    </td>
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="Type" class="form-control input-sm" value="<?= $row['Type'];?>" >
                                    </td>
                                    <td>
                                        <select form="FORM<?= $row['ParentID'];?>" name="Region" class="form-control input-sm">
                                            <option value=""></option>
                                            <?php
                                            foreach ($regions as $region) {
                                                echo'<option '.($row['Region']==$region ? 'selected' : '').' value="'.$region.'">'.$region.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="Country" class="form-control input-sm" value="<?= $row['Country'];?>" >
                                    </td>
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="Client" class="form-control input-sm" value="<?= $row['Client'];?>" >
                                    </td>
                                    <td>
                                        <input form="FORM<?= $row['ParentID'];?>" type="text" name="Access" class="form-control input-sm" value="<?= $row['Access'];?>" >
                                    </td>
                                    <td>
                                        <select form="FORM<?= $row['ParentID'];?>" class="form-control input-sm" name="Priority" required>
                                            <option value=""> </option>
                                            <option <?= ($row['Priority']=='High' ? 'selected' : ''); ?> value="High">High</option>
                                            <option <?= ($row['Priority']=='Medium' ? 'selected' : ''); ?> value="Medium">Medium</option>
                                            <option <?= ($row['Priority']=='Low' ? 'selected' : ''); ?> value="Low">Low</option>
                                        </select>
                                    </td>
                                    <td class="text-left">
                                        <button type="submit" form="FORM<?= $row['ParentID'];?>" class="btn btn-xs btn-success"><i class="fa fa-check-square" aria-hidden="true"></i></button>
                                        <button type="button" class="clearsection-btn btn btn-xs btn-danger"><i class="fa fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>                                                         
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>

                    </table>
                    <div class="row">
                        <div class="col-lg-2">
                            Remarks:
                            <div class="form-control input-sm Remark noedited" data-key="Remark" id="Remark" contenteditable="true"></div>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="1" id="gotoAgentDevelopment" checked> Proceed parent to Agent Development
                            </label>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 CONTENT_ANALYSIS">
                    <button type="button" class="btn btn-xs btn-info addsesction-btn" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Section</button>
                    <button type="button" class="btn btn-xs btn-danger taskout-btn" data-value="Pending" ><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Pending</button>
                    <button type="button" class="btn btn-xs btn-success taskout-btn" data-value="Done" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Done</button>
                    <!-- <p class="errorMsg"></p> --> 
                </div> 
                <div class="col-lg-12 errorDiv">
                </div>
            </div>
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

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
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <?php
        $this->load->view('navbar-top');
        $this->load->view('navbar-left');
    ?>
    <div class="content-wrapper">
        <?php
            $this->load->view($page);
        ?>
    </div>
    <?php
        // $this->load->view('footer');
        $this->load->view('navbar-right');
    ?>
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
<script src="<?= base_url('assets/dist/js/demo.js');?>"></script>

<script type="text/javascript">
    $(function(){
        $('.sidebar-menu').tree()
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/customised/js/general.js');?>"></script>
<?php
    if(isset($js)){
        foreach ($js as $jsfile) {
            echo $jsfile."\n";
        }
    }
?>


</body>
</html>

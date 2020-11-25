<?php
    $segment1 = $this->uri->segment(1);
    $segment2 = $this->uri->segment(2);
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $this->session->userdata('fullName');?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?= ($segment1=='home' ? 'active' : '');?>"><a href="<?= base_url('home');?>"><i class="fa fa-circle-o"></i> <span>Home</span></a></li>
            <li class="treeview <?= ($segment1=='tito_monitoring' ? 'active' : '');?>">
                <a href="#">
                    <i class="fa fa-files-o"></i> <span>TITO Monitoring</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                        $this->load->model('base_model');
                        $sql="SELECT [ProcessId], [ProcessCode] FROM [WMS_AGLDE].[dbo].[wms_Processes] ORDER BY [ProcessId] ASC";
                        $APIResult = $this->base_model->GetDatabaseDataset($sql);
                        $data = json_decode($APIResult, true);
                        $data = $data[0];
                        if(sizeof($data) > 0){
                            foreach ($data as $row) {
                                echo '<li class="'.($segment2==$row['ProcessId'] ? 'active' : '').'"><a href="'.base_url('tito_monitoring/'.$row['ProcessId']).'"><i class="fa fa-circle-o"></i> ';
                                echo '    <span>'.$row['ProcessCode'].'</span>';
                                echo '</li>';
                            }
                        }
                    ?>     
                </ul>
            </li>
        </ul>
    </section>
</aside>
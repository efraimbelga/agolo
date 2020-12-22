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
            <li class="<?= ($segment1=='home' ? 'active' : '');?>"><a href="<?= base_url('home');?>"><i class="fa fa-circle-o"></i> <span>New Source Request</span></a></li>
            <li><a href="<?= base_url('allocation');?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>User Allocation</span></a></li>
            <li class="treeview <?= ($segment1=='tito_monitoring' ? 'active' : '');?>">
                <a href="#">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>User Task View</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php
                        $this->load->model('base_model');
                        $sql="select p.* from wms_Processes p inner join wms_WorkFlowProcesses wp on p.processid=wp.ProcessId where wp.workflowid=1 order by wp.RefId asc";
                        $APIResult = $this->base_model->GetDatabaseDataset($sql);
                        $data = json_decode($APIResult, true);
                        if (array_key_exists('error', $data)) {  }
                       
                        $data = $data[0];
                        if(sizeof($data) > 0){
                            $segment3 = $this->uri->segment(3);
                            foreach ($data as $row) {
                                echo '<li class="'.($segment2==$row['ProcessId'] ? 'active' : '').'"><a href="'.base_url('tito_monitoring/'.$row['ProcessId']).'"><i class="fa fa-circle-o"></i> ';
                                echo '    <span>'.str_replace("_", " ", $row['ProcessCode']).'</span>';
                                echo '</a></li>';
                            }
                        }
                    ?>     
                </ul>
            </li>
            <li class="<?= ($segment1=='masterlist' ? 'active' : '');?>"><a href="<?= base_url('masterlist');?>"><i class="fa fa-files-o"></i> <span>Master List</span></a></li>
            <li><a href="<?= base_url('published');?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Agent Published List</span></a></li>
        </ul>
    </section>
</aside>
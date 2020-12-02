<section class="content-header">
    <h1>User Task View <small><?= $process;?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <!-- <div class="box-header">
            <h3 class="box-title">TITO Monitoring</h3>
        </div> -->
        <input type="hidden" id="processidTxtx" value="<?= $process; ?>">
        <div class="box-body srboxbody table-responsive">
            <?php
                if($this->session->userdata('processId')=='3'){
                    echo '<button class="btn btn-info btn-sm allocate-btn" data-value="'.$this->session->userdata('processId').'">Allocated</button>';
                }
            ?>
            <table class="table table-condensed table-bordered" id="srTable">
                <thead>
                    <tr>
                        <th>Source URL</th>
                        <?php
                            if($process=='CONTENT_ANALYSIS'){
                                echo '<th>Reference ID</th>';
                            }else{
                                echo '<th>Source Name</th>';
                                echo '<th>Heirarchy</th>';
                            }
                        ?>                        
                        <th>Source Username</th>
                        <th>Source Password</th>
                        <th>Claimed By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>
<div id="titoModal" class="modal fade" role="dialog">
    <?php
        // $this->load->view('pages/titoformModal');
    ?>
</div>
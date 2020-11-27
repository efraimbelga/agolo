<section class="content-header">
    <h1>TITO Monitoring <small><?= $process;?></small></h1>
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
        <div class="box-body srboxbody table-responsive">
            <table class="table table-condensed table-bordered" id="srTable">
                <thead>
                    <tr>
                        <?php
                            if($process=='CONTENT_ANALYSIS'){
                                echo '<th>Reference ID</th>';
                            }else{
                                echo '<th>Source ID</th>';
                            }
                        ?>
                        <th>Source URL</th>
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
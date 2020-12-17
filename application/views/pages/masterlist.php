<style type="text/css">
    table.dataTable.table-condensed>thead>tr>th {
    padding-right: 34px;
}
</style>
<section class="content-header">
    <h1>
        Masterlist
    </h1>
</section>
<section class="content">
    <div class="box">
        <!-- <div class="box-header">
            <h3 class="box-title">Publisher Information</h3>
        </div> -->
        <div class="box-body srboxbody ">           
            <div class="col-lg-12">
                <table class="table table-condensed table-bordered" id="masterlistTbl">
                    <thead>
                        <tr>
                            <th >S. No.</th>
                            <th >Received Date</th>
                            <th >Source Name</th>
                            <th >URL</th>
                            <th >Parent/Child</th>
                            <th >Agent Name</th>
                            <th >Priority</th>
                            <th >Process</th>
                            <th >Status</th>
                            <th >Configuration Completion Date</th>
                            <th >Reconfiguration Completion Date</th>
                            <th >Publication Date</th>
                            <th >Remarks</th>
                            <th >Configuration Month</th>
                            <th >Reconfiguration Month</th>
                            <th >Publication Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // echo"<pre>";
                            // print_r($masterlistData);
                            // echo"</pre>";
                            foreach ($masterlistData as $mdata) {
                                echo'<tr>';
                                    echo'<td>'.$mdata['PS_BatchId'].'</td>';
                                    echo'<td>';
                                        $date = date_create($mdata['SourceRequestDate']);
                                        echo date_format($date,"Y-m-d");
                                    echo'</td>';                                    
                                    echo'<td>'.$mdata['SourceName'].'</td>';
                                    echo'<td>'.$mdata['SourceUrl'].'</td>';
                                    echo'<td>'.($mdata['IsParent']=='1' ? 'Parent' : 'Child').'</td>';
                                    echo'<td>'.$mdata['AgentName'].'</td>';
                                    echo'<td>'.$mdata['Priority'].'</td>';
                                    echo'<td>'.$mdata['ProcessCode'].'</td>';
                                    echo'<td>'.$mdata['StatusString'].'</td>';                                    
                                    echo'<td></td>';
                                    echo'<td></td>';
                                    echo'<td></td>';
                                    echo'<td></td>';
                                    echo'<td></td>';
                                    echo'<td></td>';
                                    
                                echo'</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
<script src="<?= base_url('assets/customised/js/masterlist.js');?>"></script>
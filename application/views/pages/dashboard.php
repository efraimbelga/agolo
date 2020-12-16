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
            <!-- <div class="row"> -->
                <!-- <div class="col-lg-12"> -->
                    <table>
                        <tr>
                            <td style="padding: 0px 5px;">Publisher Task:</td>
                            <td style="padding: 0px 5px;">Status:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <select>
                                    <option></option>
                                    <option>Option One</option>
                                    <option>Option Two</option>
                                </select>
                            </td>
                            <td style="padding: 5px;">                                
                                <select>
                                    <option></option>
                                    <option>Option One</option>
                                    <option>Option Two</option>
                                </select>
                            </td>
                            <td style="padding: 5px;"><button class="btn btn-xs btn-flat btn-info"><i class="fa fa-search" aria-hidden="true"></i> Search</button></td>
                        </tr>
                    </table>
                    <!-- <hr> -->
                <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="row"> -->
                <!-- <div class="col-lg-12"> -->
                    <table class="table table-condensed table-bordered" id="srTable">
                        <thead>
                            <tr>
                                <th>Source Name</th>
                                <th>Agent Name</th>                        
                                <th>Source URL</th>
                                <th>Reference ID</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Request Date</th>
                                <th>Claimed Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                <!-- </div> -->
            <!-- </div> -->
        </div>
        <!-- <div class="box-footer text-right">
            <button class="btn btn-info claim-btn btn-flat" disabled>Task IN</button>
            <button class="btn btn-warning clear-btn btn-flat" disabled>Clear</button>
        </div> -->
    </div>
</section>
<div id="analysisModal" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Content Analysis</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table style="width: 100%">
                            <tr>
                                <td><p>Source URL:<br><b><span class="sourceurlTxt"></span></p></td>
                                <td><p>Reference ID:<br><b><span class="referenceidTxt"></span></p></td>
                            </tr>
                            <tr>
                                <td><p>Claimed By:<br><b><span class="claimedbyTxt"></span></p></td>
                                <td><p>Claimed Date:<br><b><span class="claimeddateTxt"></span></p></td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3></h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info claim-btn btn-flat" >Task IN</button>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
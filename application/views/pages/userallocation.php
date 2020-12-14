<section class="content-header">
    <h1>User Allocation</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User Allocation</a></li>

    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body srboxbody">
            <div class="col-lg-10">
                <table>
                    <tr>
                        <td>Tasks (For):</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control">
                                <option value="">--Select--</option>
                                <option value="4">AGENT_REFINEMENT</option>
                                <option value="6">AGENT_REWORK</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-2 text-right">
                <button class="btn btn-info claim-btn btn-flat" disabled>Allocate</button>
                <button class="btn btn-warning clear-btn btn-flat" disabled>Clear</button>
            </div>
            <div class="col-lg-12 table-responsive">
                <br>
                <table class="table table-condensed table-bordered" id="allocationTable">
                    <thead>
                        <tr>
                            
                            <th>Source URL</th>
                            <th>Reference ID</th>
                            <th>Source Name</th>
                            <th>Heirarchy</th>                       
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
        
    </div>
</section>
<div id="titoModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript" src="<?= base_url('assets/customised/js/userallocation.js');?>"></script>
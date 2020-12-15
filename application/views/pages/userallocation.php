<section class="content-header">
    <h1>User Allocation</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User Allocation</a></li>

    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body srboxbody">
            <div class="col-lg-12">
                <table class="optionsTable">
                    <tr>
                        <td><b>Tasks (For):</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control taskSelect">
                                <option value="">--Select--</option>
                                <option value="4">AGENT_REFINEMENT</option>
                                <option value="6">AGENT_REWORK</option>
                            </select>
                        </td>
                        <td>

                            <button class="btn btn-info allocate-btn btn-flat btn-xs" disabled>Allocate</button>
                            <button class="btn btn-warning clear-btn btn-flat btn-xs" disabled>Clear</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12 table-responsive table-holder">               
            </div>
        </div>        
    </div>
</section>
<div id="titoModal" class="modal fade" role="dialog">
</div>
<script type="text/javascript" src="<?= base_url('assets/customised/js/userallocation.js');?>"></script>
<section class="content-header">
    <h1>
        Register <small>Manual Registration</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">

            <div class="col-lg-6">
                <form id="manualregform">
                    <div class="form-group">
                      <p><b>Instructions:</b></p>
                      <p>1. Use excel with .xlsx extension only.</p>
                      <p>2. Use the following template:</p>
                      <img src="<?= base_url('assets/images/manual reg header.png');?>">
                      <br>
                      <a href="<?= base_url('downloadtemplate/manual');?>" target="_blank">Download template</a>
                      <br><br>
                      <label for="usr">Upload file:</label>
                      <div class="input-group">
                        <input type="file" name="file" id="inputfile" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                        <div class="input-group-btn">
                          <button class="btn btn-default" type="submit">
                            <i class="fa fa-upload" aria-hidden="true"></i> Upload
                          </button>
                        </div>
                      </div>
                    </div>
                </form>
                <p class="errorMsg"></p>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?= base_url('assets/customised/js/register.js');?>"></script>
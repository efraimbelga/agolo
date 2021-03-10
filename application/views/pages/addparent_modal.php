<form id="addparentForm">
<div class="addparentModal modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Register Parent</h4>
        </div>
            <div class="modal-body">
              
              <!-- <div class="row"> -->
                <div class="form-group">
                  <input type="hidden" name="ReferenceID" value="<?= $ReferenceID;?>" required>
                  <input type="hidden" name="ParentID" value="<?= $ParentID;?>" required>
                  <input type="hidden" name="sourceURL" value="<?= $sourceURL;?>" required>
                  <label for="sourceURL">Source URL:</label>
                  <input type="text" class="form-control" id="NEWsourceURL" name="NEWsourceURL" value="<?= $sourceURL; ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="referenceID">Referece ID:</label>
                  <input type="text" class="form-control" id="referenceID" name="referenceID" value="<?= $ReferenceID; ?>" autocomplete="off" required>
                </div>
              <!-- </div>               -->
           
        </div>
        <div class="modal-footer">
            <!-- taskdone-btn -->
            <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check-square-o" aria-hidden="true"></i> Save Parent</button>
            <p class="errorMsg"></p>
        </div>
    </div>
</div>
 </form>
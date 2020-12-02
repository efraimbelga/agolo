<div class="titoformModal modal-dialog modal-lg <?= $process; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-btn" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?= $process;?></h4>
        </div>
        <div class="modal-body">
            <input type="hidden" id="ParentID" value="<?= $parentData->ParentID;?>">
            <input type="hidden" id="processId" value="<?= $processId;?>">
            <input type="hidden" id="ReferenceID" value="<?= $ReferenceID;?>">
            <input type="hidden" id="AllocationRefId" value="<?= $AllocationRefId;?>">
            <input type="hidden" id="NewSourceID" value="<?= $parentData->NewSourceID;?>">
            <p>Reference Id: <b><?= $ReferenceID;?></b></p>
            <div class="row">
                <div class="col-lg-12 modalcol1">
                    <table class="table table-condensed table-bordered contentanalysiTbl" id="psourceTbl">
                        <thead>
                            <tr>
                                <th>Source URL</th>
                                <th>Source Name</th>
                                <th>Type</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Client</th>
                                <th>Access</th>
                                <th>Priority</th>
                                <th>Remark</th>
                                <?= ($process=='CONTENT_ANALYSIS' ? '<th></th>' : ''); ?>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-control input-sm" id="SourceURL" data-key="SourceURL"><?= $parentData->NSRSourceURL;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm SourceName editablediv " id="SourceName" data-key="SourceName" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->SourceName;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Type editablediv " data-key="Type" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Type;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Region editablediv" data-key="Region" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Region;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Country editablediv" data-key="Country" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Country;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Client editablediv" data-key="Client" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Client;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Access editablediv" data-key="Access" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Access;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Priority editablediv" data-key="Priority" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>><?= $parentData->Priority;?></div>
                                </td>
                                <td>
                                    <div class="form-control input-sm Remark editablediv" data-key="Remark" <?= ($processId=='1' ? 'contenteditable="true"' : '');?>></div>
                                </td>
                                <?= ($process=='CONTENT_ANALYSIS' ? '<td>
                                    <a href="" class="savepsource-btn" ><i class="fa fa-check-square" aria-hidden="true"></i></a>
                                    <a href="" class="clearpsource-btn"><i class="fa fa-window-close" aria-hidden="true"></i></a>
                                </td>' : ''); ?>
                                
                            </tr>
                            <tr>
                                <td colspan="10" class="text-left">
                                    <b style="float: left; margin-left: 5px;">Sections</b>
                                </td>
                            </tr>
                            <tr>
                                <th>Source URL</th>
                                <th>Source Name</th>
                                <th>Type</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Client</th>
                                <th>Access</th>
                                <th>Priority</th>
                                <th>Remark</th>
                                <?= ($process=='CONTENT_ANALYSIS' ? '<th></th>' : ''); ?>
                            </tr>
                            <?php
                                // echo"<pre>";
                                // print_r($sectionData);
                                // echo"</pre>";
                                if($sectionData){
                                    foreach ($sectionData as $row) {
                                ?>
                                    <tr class="subsection" data-id="<?= $row['ParentID'];?>">
                                        <td>
                                            <div class="form-control input-sm SourceURL editablediv" data-key="SourceURL" contenteditable="true" ><?= $row['SourceURL'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm SourceName editablediv" data-key="SourceName" contenteditable="true" ><?= $row['SourceName'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Type editablediv" data-key="Type" contenteditable="true" ><?= $row['Type'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Region editablediv" data-key="Region" contenteditable="true" ><?= $row['Region'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Country editablediv" data-key="Country" contenteditable="true" ><?= $row['Country'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Client editablediv" data-key="Client" contenteditable="true" ><?= $row['Client'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Access editablediv" data-key="Access" contenteditable="true" ><?= $row['Access'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Priority editablediv" data-key="Priority" contenteditable="true" ><?= $row['Priority'];?></div>
                                        </td>
                                        <td>
                                            <div class="form-control input-sm Remark editablediv" data-key="Remark" contenteditable="true"></div>
                                        </td>
                                        <?= ($process=='CONTENT_ANALYSIS' ? '<td>
                                            <a href="" class="savesection-btn"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                                            <a href="" class="clearsection-btn"><i class="fa fa-window-close" aria-hidden="true"></i></a>
                                        </td>' : ''); ?>
                                        
                                    </tr>
                                <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
           
                <div class="col-lg-12">
                    <?= ($process=='CONTENT_ANALYSIS' ? '<button type="button" class="btn btn-xs btn-flat btn-info addsesction-btn" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Section</button>' : ''); ?>
                    <button class="btn btn-flat btn-xs btn-danger taskout-btn" data-value="Pending" ><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Pending</button>
                    <button class="btn btn-flat btn-xs btn-success taskout-btn" data-value="Done" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Done</button>
                    <p class="errorMsg"></p> 
                </div>                                       
                <?php
                    if($process=='CONTENT_ANALYSIS'){
                ?>
                    <div class="col-lg-12">
                        <!-- <iframe src="<?= $parentData->NSRSourceURL;?>" name="iframe_a" height="600px" width="100%" title="NSRSourceURL"></iframe> -->
                    </div>
                <?php
                    }
                ?>
                
            </div>
        </div>
    </div>
<div class="titoformModal modal-dialog modal-lg <?= $process; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <?= ($processId==2 ? '<button type="button" class="close" data-dismiss="modal">&times;</button>' : '');?>
            <h4 class="modal-title"><?= $process;?></h4>
        </div>
        <div class="modal-body">
            <input type="hidden" id="ParentID" value="<?= $parentData['ParentID'];?>">
            <input type="hidden" id="processId" value="<?= $processId;?>">
            <input type="hidden" id="ReferenceID" value="<?= $ReferenceID;?>">
            <input type="hidden" id="NewSourceID" value="<?= $parentData['NewSourceID'];?>">
            <input type="hidden" id="AllocationRefId" value="<?= $AllocationRefId;?>">

            <!-- <div class="row"> -->
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#content_analysis"><h4 class="panel-title">CONTENT_ANALYSIS</h4></a>
                        </div>
                        <div id="content_analysis" class="panel-collapse collapse in form-horizontal">
                            <div class="panel-body">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source URL:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm" id="SourceURL" data-key="SourceURL"><?= $parentData['NSRSourceURL'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source Name:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm SourceName editablediv " id="SourceName" data-key="SourceName" ><?= $parentData['SourceName'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source ID:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm SourceID editablediv " id="SourceID" data-key="SourceID" ><?= $parentData['SourceID'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Type:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Type editablediv " data-key="Type" ><?= $parentData['Type'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Region:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Region editablediv" data-key="Region" ><?= $parentData['Region'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Country:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Country editablediv" data-key="Country" ><?= $parentData['Country'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Client:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Client editablediv" data-key="Client" ><?= $parentData['Client'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Access:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Access editablediv" data-key="Access" ><?= $parentData['Access'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Priority:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Priority editablediv" data-key="Priority" ><?= $parentData['Priority'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" ></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <?php
                if($RefId >=8){
            ?>
            <!-- <div class="row"> -->
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#agent_development"><h4 class="panel-title">AGENT_DEVELOPMENT</h4></a>
                        </div>
                        <div id="agent_development" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($RefId==8 ? 'myForm': '');?>" >
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Date Format:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm DateFormat editablediv" id="DateFormat" data-key="DateFormat" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['DateFormat'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Story Frequency :</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm StoryFrequency editablediv " id="StoryFrequency " data-key="StoryFrequency" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['StoryFrequency'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Crawl Patterns:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm CrawlPatterns editablediv " data-key="CrawlPatterns" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['CrawlPatterns'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Difficulty:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Difficulty editablediv" data-key="Difficulty" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['Difficulty'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Configuration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ConfigNotes editablediv" data-key="ConfigNotes" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['ConfigNotes'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Exclusion Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ExclusionNotes editablediv" data-key="ExclusionNotes" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['ExclusionNotes'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group ">
                                                <label class="control-label col-sm-3 col-lg-4 col-xs-12">Agent ID:</label>
                                                <div class="col-sm-9 col-lg-8 col-xs-12">
                                                    <div class="form-control input-sm AgentID" id="AgentID" data-key="AgentID" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>><?= $parentData['AgentID'];?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                                <div class="col-sm-9 col-lg-8 col-xs-12">
                                                    <div class="form-control input-sm Remarks" data-key="Remarks" <?= ($RefId == 8 ? 'contenteditable="true"' : '');?>></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <?php
            }
            if($RefId >=9){
            ?>
            <!-- <div class="row"> -->
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT_PUBLICATION</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($RefId==9 ? 'myForm': '');?>" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" <?= ($RefId ==9 ? 'contenteditable="true"' : '');?>></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <?php
                }
            if($RefId >=0){
            ?>
            <!-- <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse3"><h4 class="panel-title">AGENT_DEV_REVIEW</h4></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($processId=='3' ? 'myForm': '');?>" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Publication Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm PublicationNotes editablediv" id="PublicationNotes" data-key="PublicationNotes" <?= ($processId=='3' ? 'contenteditable="true"' : '');?>><?= $parentData['PublicationNotes'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" ></div>
                                        </div>
                                    </div>
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php }
                if($RefId >=10){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse4"><h4 class="panel-title">AGENT_REFINEMENT</h4></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($RefId==10 ? 'myForm': '');?>" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Reconfiguration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ReConfigNotes editablediv" id="ReConfigNotes" data-key="ReConfigNotes" <?= ($RefId ==10 ? 'contenteditable="true"' : '');?>><?= $parentData['ReConfigNotes'];?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" <?= ($RefId ==10 ? 'contenteditable="true"' : '');?>></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                if($RefId >=11){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT_REWORK</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($RefId==11 ? 'myForm': '');?>">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" <?= ($RefId == 11 ? 'contenteditable="true"' : '');?>></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>      
        </div>
        <div class="modal-footer">
            <p class="errorMsg"></p>
            <?php
            // if($processId==2){
                echo '<button class="btn btn-flat btn-xs btn-success taskdone-btn" data-value="Done"><i class="fa fa-check-square-o" aria-hidden="true"></i> Save</button>';
            // }else{
            //     echo '<button class="btn btn-flat btn-xs btn-danger taskdone-btn" data-value="Pending"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Pending</button>';
            //     echo '<button class="btn btn-flat btn-xs btn-success taskdone-btn" data-value="Done"><i class="fa fa-check-square-o" aria-hidden="true"></i> Save</button>';
            // }
               
            ?>  
             
        </div>
    </div>
</div>
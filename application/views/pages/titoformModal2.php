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
            <input type="hidden" id="NewSourceID" value="<?= $parentData->NewSourceID;?>">

            <div class="row">
                <div class="col-lg-12 form-horizontal">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group ">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source URL:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm" id="SourceURL" data-key="SourceURL"><?= $parentData->NSRSourceURL;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source Name:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm SourceName editablediv " id="SourceName" data-key="SourceName" ><?= $parentData->SourceName;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Type:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Type editablediv " data-key="Type" ><?= $parentData->Type;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Region:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Region editablediv" data-key="Region" ><?= $parentData->Region;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Country:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Country editablediv" data-key="Country" ><?= $parentData->Country;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Client:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Client editablediv" data-key="Client" ><?= $parentData->Client;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Access:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Access editablediv" data-key="Access" ><?= $parentData->Access;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Priority:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Priority editablediv" data-key="Priority" ><?= $parentData->Priority;?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                <div class="form-control input-sm Remarks editablediv" data-key="Remarks" >Remarks here</div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <br> 
            <?php
                if($processId >=2){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse2"><h4 class="panel-title">AGENT_DEVELOPMENT</h4></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($processId=='2' ? 'myForm': '');?>" style="border-top: none; padding: 0px">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Agent ID:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm AgentID editablediv" id="AgentID" data-key="AgentID" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Date Format:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm DateFormat editablediv" id="DateFormat" data-key="DateFormat" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->DateFormat;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Story Frequency :</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm StoryFrequency editablediv " id="StoryFrequency " data-key="StoryFrequency" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->StoryFrequency;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Crawl Patterns:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm CrawlPatterns editablediv " data-key="CrawlPatterns" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->CrawlPatterns;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Difficulty:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Difficulty editablediv" data-key="Difficulty" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->Difficulty;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Configuration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ConfigNotes editablediv" data-key="ConfigNotes" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->ConfigNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Exclusion Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ExclusionNotes editablediv" data-key="ExclusionNotes" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->ExclusionNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Remarks editablediv" data-key="Remarks" >Remarks here</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            if($processId >=3){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse3"><h4 class="panel-title">AGENT_DEV_REVIEW</h4></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($processId=='3' ? 'myForm': '');?>" style="border-top: none; padding: 0px">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Publication Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm PublicationNotes editablediv" id="PublicationNotes" data-key="PublicationNotes" <?= ($processId=='3' ? 'contenteditable="true"' : '');?>><?= $parentData->PublicationNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                if($processId >=4){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse4"><h4 class="panel-title">AGENT_REFINEMENT</h4></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal <?= ($processId=='4' ? 'myForm': '');?>" style="border-top: none; padding: 0px">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Reconfiguration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ReConfigNotes editablediv" id="ReConfigNotes" data-key="ReConfigNotes" <?= ($processId=='4' ? 'contenteditable="true"' : '');?>><?= $parentData->ReConfigNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                if($processId >=5){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT_PUBLICATION</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal" style="border-top: none; padding: 0px">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Agent Remarks:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm DateFormat" id="DateFormat" data-key="DateFormat" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->DateFormat;?></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
                if($processId >=6){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT_REWORK</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal" style="border-top: none; padding: 0px">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Date Format:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm DateFormat" id="DateFormat" data-key="DateFormat" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->DateFormat;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Story Frequency :</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm StoryFrequency editablediv " id="StoryFrequency " data-key="StoryFrequency" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->StoryFrequency;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Crawl Patterns:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm CrawlPatterns editablediv " data-key="CrawlPatterns" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->CrawlPatterns;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Difficulty:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm Difficulty editablediv" data-key="Difficulty" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->Difficulty;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Configuration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ConfigNotes editablediv" data-key="ConfigNotes" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->ConfigNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Exclusion Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <div class="form-control input-sm ExclusionNotes editablediv" data-key="ExclusionNotes" <?= ($processId=='2' ? 'contenteditable="true"' : '');?>><?= $parentData->ExclusionNotes;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">

                <div class="col-lg-12">
                    <button class="btn btn-flat btn-xs btn-danger taskdone-btn" data-value="Pending"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Pending</button>
                    <button class="btn btn-flat btn-xs btn-success taskdone-btn" data-value="Done"><i class="fa fa-check-square-o" aria-hidden="true"></i> Done</button>
                    <p class="errorMsg"></p> 
                </div>
            </div>
      
        </div>
    </div>
<div class="titoformModal modal-dialog modal-lg <?= $process; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <?= ($processId==2 ? '<button type="button" class="close" data-dismiss="modal">&times;</button>' : '');?>
            <h4 class="modal-title"><?= str_replace("_", " ", $process); ?></h4>
        </div>
        <form id="titoForm">
            <div class="modal-body">
                <input type="hidden" name="ParentID" value="<?= $parentData['ParentID'];?>">
                <input type="hidden" name="processId" value="<?= $processId;?>">
                <input type="hidden" name="ReferenceID" value="<?= $ReferenceID;?>">
                <input type="hidden" name="NewSourceID" value="<?= $parentData['NewSourceID'];?>">
                <input type="hidden" name="SourceID" value="<?= $parentData['SourceID'];?>">
                <input type="hidden" name="AllocationRefId" value="<?= $AllocationRefId;?>">
                <input type="hidden" name="SourceURL" value="<?= $parentData['SourceURL'];?>">
                <input type="hidden" name="SourceName" value="<?= $parentData['SourceName'];?>">            
                <input type="hidden" name="Status" value="Done">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#content_analysis"><h4 class="panel-title">CONTENT ANALYSIS</h4></a>
                        </div>
                        <div id="content_analysis" class="panel-collapse collapse in form-horizontal">
                            <div class="panel-body">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group ">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source URL:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['SourceURL'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source ID:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['SourceID'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Region:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Region'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Client:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Client'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Priority:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Priority'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Source Name:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['SourceName'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Type:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Type'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Country:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Country'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Access:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['Access'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remark:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <div class="form-control input-sm"><?= $parentData['CONTENT_ANALYSIS_Remark'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <?php
                if($RefId >=8){
            ?>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#agent_development"><h4 class="panel-title">AGENT DEVELOPMENT</h4></a>
                        </div>
                        <div id="agent_development" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group ">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Date Format:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="DateFormat" class="form-control input-sm" required value="'.$parentData['DateFormat'].'">' : '<div class="form-control input-sm">'.$parentData['DateFormat'].'</div>' );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Crawl Patterns:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="CrawlPatterns" class="form-control input-sm" required value="'.$parentData['CrawlPatterns'].'">' : '<div class="form-control input-sm">'.$parentData['CrawlPatterns'].'</div>' );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Configuration Notes:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="ConfigNotes" class="form-control input-sm" value="'.$parentData['ConfigNotes'].'">' : '<div class="form-control input-sm">'.$parentData['ConfigNotes'].'</div>' );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group ">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Agent Name:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" class="form-control input-sm" name="AgentName" id="AgentName" required value="'.$parentData['AgentName'].'">' : '<div class="form-control input-sm">'.$parentData['AgentName'].'</div>' );?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group ">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Agent ID:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 ? '<input type="text" autocomplete="off" name="AgentID" id="AgentID" class="form-control input-sm" required>' : '<div class="form-control input-sm">'.$parentData['AgentID'].'</div>' );?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Story Frequency :</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="StoryFrequency" class="form-control input-sm" required value="'.$parentData['StoryFrequency'].'">' : '<div class="form-control input-sm">'.$parentData['StoryFrequency'].'</div>' );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Difficulty:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?php
                                                    if($RefId==8 || $RefId==10 || $RefId==11){
                                                        echo '<select name="Difficulty" class="form-control input-sm" required>';
                                                        echo '    <option value=""></option>';
                                                        echo '    <option '.($parentData['Difficulty']=='Average' ? 'selected' : '').' value="Average">Average</option>';
                                                        echo '    <option '.($parentData['Difficulty']=='Difficult' ? 'selected' : '').' value="Difficult">Difficult</option>';
                                                        echo '</select>';
                                                    }else{
                                                        echo '<div class="form-control input-sm">'.$parentData['Difficulty'].'</div>';
                                                    }
                                                ?>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Exclusion Notes:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="ExclusionNotes" class="form-control input-sm" value="'.$parentData['ExclusionNotes'].'">' : '<div class="form-control input-sm">'.$parentData['ExclusionNotes'].'</div>' );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding: 0px;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remark:</label>
                                            <div class="col-sm-9 col-lg-8 col-xs-12">
                                                <?= ($RefId==8 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="'.($RefId==8 ? 'Remark' : 'Remark[]').'" class="form-control input-sm" required value="'.$parentData['AGENT_DEVELOPMENT_Remark'].'">' : '<div class="form-control input-sm">'.$parentData['AGENT_DEVELOPMENT_Remark'].'</div>' );?>
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
            if($RefId >=9){
            ?>
            <!-- <div class="row"> -->
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT PUBLICATION</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Publication Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <?= ($RefId==9 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="PublicationNotes" class="form-control input-sm" value="'.$parentData['PublicationNotes'].'">' : '<div class="form-control input-sm">'.$parentData['PublicationNotes'].'</div>' );?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remark:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <?= ($RefId==9 || $RefId==10 || $RefId==11 ? '<input type="text" autocomplete="off" name="'.($RefId==9 ? 'Remark' : 'Remark[]').'" class="form-control input-sm" required value="'.$parentData['AGENT_PUBLICATION_Remark'].'">' : '<div class="form-control input-sm">'.$parentData['AGENT_PUBLICATION_Remark'].'</div>' );?>
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
   
                if($RefId ==10){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse4"><h4 class="panel-title">AGENT REFINEMENT</h4></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal" >
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group ">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Reconfiguration Notes:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <?= ($RefId==10 ? '<input type="text" autocomplete="off" name="ReConfigNotes" class="form-control input-sm">' : '<div class="form-control input-sm" value="'.$parentData['ReConfigNotes'].'">'.$parentData['ReConfigNotes'].'</div>' );?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remark:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <?= ($RefId==10 ? '<input type="text" autocomplete="off" name="Remark[]" class="form-control input-sm" required value="'.$parentData['AGENT_REFINEMENT_Remark'].'">' : '<div class="form-control input-sm">'.$parentData['AGENT_REFINEMENT_Remark'].'</div>' );?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                if($RefId ==11){
            ?>
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#collapse1"><h4 class="panel-title">AGENT REWORK</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body form-horizontal">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-lg-4 col-xs-12">Remark:</label>
                                        <div class="col-sm-9 col-lg-8 col-xs-12">
                                            <?= ($RefId==11 ? '<input type="text" autocomplete="off" name="Remark[]" class="form-control input-sm" required value="'.$parentData['AGENT_REWORK_Remark'].'">' : '<div class="form-control input-sm">'.$parentData['AGENT_REWORK_Remark'].'</div>' );?>
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
            <!-- taskdone-btn -->
            <button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check-square-o" aria-hidden="true"></i> Save</button>
            <p class="errorMsg"></p>
        </div>
        </form>
    </div>
</div>

<style type="text/css">
    div.form-control.input-sm {
        height: auto;
        min-height: 25px;
        padding: 3px 4px;
        font-size: 13px;
    }
</style>

<?php
    function searchForRemark($ProcessCode, $array) {
        $array = array_reverse($array);
        foreach ($array as $key => $val) {
            if ($val['ProcessCode'] === $ProcessCode) {
                return $array[$key]['Remarks'];
            }
        }
        return null;
    }

?>

<style type="text/css">
    .input-group .input-group-addon {
        border-radius: 0;
        border-right:none; 
        background-color: #fff;
        height: 25px;
        padding: 3px 4px;
        font-size: 13px;
    }
</style>
<div class="col-lg-12 table-responsive">    
    <table id="masterlistTbl" class="table table-bordered table-condensed table-hovered">
        <thead>
            <tr>
                <th style="white-space: nowrap;">S. No.</th>
                <th style="white-space: nowrap;">Received Date</th>
                <th style="white-space: nowrap;">Source Name</th>
                <th style="white-space: nowrap;">URL</th>
                <th style="white-space: nowrap;">Parent/Child</th>
                <th style="white-space: nowrap;">Agent Name</th>
                <th style="white-space: nowrap;">Priority</th>
                <th style="white-space: nowrap;">Current Process</th>
                <th style="white-space: nowrap;">Status</th>
                <th style="white-space: nowrap;">Configured By</th>                
                <th style="white-space: nowrap;">Content Analysis Completion Date</th>
                <th style="white-space: nowrap;">Agent Development Completion Date</th>
                <th style="white-space: nowrap;">Agent Publication Completion Date</th>
                <th style="white-space: nowrap;">Agent Refinement Completion Date</th>
                <th style="white-space: nowrap;">Agent Rework Completion Date</th>
                <th style="white-space: nowrap;">Remarks</th>
                <!-- <th style="white-space: nowrap;">Configuration Month</th> -->
                <!-- <th style="white-space: nowrap;">Reconfiguration Month</th> -->
                <!-- <th style="white-space: nowrap;">Publication Month</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                // echo"<pre>";
                // print_r($masterlistData);
                // echo"</pre>";
                // die();
                if(sizeof($masterlistData) > 0){
                    foreach ($masterlistData as $ml) {
                        echo'<tr>';
                            echo '<td>'.$ml['PS_BatchId'].'</td>';
                            echo '<td>'.$ml['SourceRequestDate'].'</td>';
                            echo '<td>'.$ml['SourceName'].'</td>';
                            echo '<td>'.$ml['SourceUrl'].'</td>';
                            echo '<td>'.($ml['IsParent']=='1' ? 'Parent' : 'Child').'</td>';
                            echo '<td>'.$ml['AgentName'].'</td>';
                            echo '<td>'.$ml['Priority'].'</td>';
                            echo '<td>'.str_replace("_", " ", $ml['ProcessCode']).'</td>';
                             echo '<td>'.$ml['StatusString'].'</td>';
                            echo '<td>'.strtoupper($ml['ClaimedBy']).'</td>';                           
                            echo '<td>'.$ml['CONTENT_ANALYSIS_DATE'].'</td>';
                            echo '<td>'.$ml['AGENT_DEVELOPMENT_DATE'].'</td>';
                            echo '<td>'.$ml['AGENT_PUBLICATION_DATE'].'</td>';
                            echo '<td>'.$ml['AGENT_REFINEMENT_DATE'].'</td>';
                            echo '<td>'.$ml['AGENT_REWORK_DATE'].'</td>';
                            echo '<td>---</td>'; //REMARK
                        echo'</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<div class="col-lg-12 text-center"> 
    <ul class="pagination">
        <?php
            $per_page_record = 10;

            $total_pages = ceil($Total / $per_page_record);     
            $pagLink = "";       
          
            if($page>=2){   
                
                echo '<li><a href="#" class="gotopage" data-value="'.($page-1).'">  Prev </a></li>';
            }       
                       
            for ($i=1; $i<=$total_pages; $i++) {   
                if ($i == $page) {   
                    $pagLink .= '<li class="active"><a href="#">'.$i.'</a></li>';   
                }               
                else  {   
                    $pagLink .= '<li><a href="#" class="gotopage" data-value="'.$i.'">'.$i.'</a></li>';     
                }   
            };     
            echo $pagLink;   
      
            if($page<$total_pages){   
                echo '<li><a href="#" class="gotopage" data-value="'.($page+1).'">  Next </a></li>';
            } 
        ?>
        
      </ul>
</div>
<table class="table table-condensed table-bordered" id="allocationTable">
    <thead>
        <tr>
            <th>BatchName</th>
            <th>Source URL</th>
            <th>Source Name</th>
            <th>Heirarchy</th>                       
            <th>Source Username</th>
            <th>Source Password</th>
            <th>Claimed Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // echo"<pre>";
            // print_r($data);
            // echo"</pre>";
            if(sizeof($data) > 0){
                foreach ($data as $row) {
                    echo'<tr class="sourceTR '.($row['AgentState']=='1' : 'active' : 'inactive').'">';
                        echo'<td>'.$row['BatchName'].'</td>';
                        echo'<td>'.$row['SourceUrl'].'</td>';
                        echo'<td>'.$row['SourceName'].'</td>';
                        
                        echo'<td>'.($row['IsParent']=='1' ? 'Parent': 'Section').'</td>';
                        echo'<td>'.$row['SourceUserName'].'</td>';
                        echo'<td>'.$row['SourcePassword'].'</td>';
                        echo'<td>'.$row['SourceRequestDate'].'</td>';                     
                    echo'</tr>';
                }
            }
            else{
                echo'<tr>';
                    echo'<td colspan="9"><p class="text-center">No data found</p></td>';
                echo'</tr>';
            }
        ?>
    </tbody>
</table>
<table class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th>Agent Status</th>       
            <th>Source Name</th>
            <th>Source URL</th>            
            <th>Current Process</th>
            <th>Agent ID</th>
            <th>Agent Name</th>
            <th>User Name</th>
            <th>Agent State Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(sizeof($data) > 0){
                foreach ($data as $row) {
                    echo'<tr data-pid="'.$row['pID'].'" data-aid="'.$row['aID'].'" class="'.($row['AgentState']=='1' ? 'active' : ($row['AgentState']=='0' ? 'inactive' : 'new')).'">';
                        echo'<td style="padding:0px;">';
                            echo '<select class="form-control input-sm agentState-opt">';
                                echo'<option value=""></option>';
                                echo'<option '.($row['AgentState']== '1' ? 'selected' : '').' value="1">Active</option>';
                                echo'<option '.($row['AgentState']== '0' ? 'selected' : '').' value="0">Inactive</option>';
                            echo'</select>';
                        echo'</td>';
                        echo'<td>'.$row['SourceName'].'</td>';
                        echo'<td>'.$row['SourceUrl'].'</td>';                        
                        echo'<td>'.$row['ProcessCode'].'</td>';
                        echo'<td>'.$row['aID'].'</td>';
                        echo'<td>'.$row['AgentName'].'</td>';
                        echo'<td><span class="UserId">'.$row['UserId'].'</span></td>';
                        echo'<td>'.$row['AgentStateDate'].'</td>';
                    echo'</tr>';
                }
            }else{
                echo'<tr><td colspan="7">No data found</td></tr>';
            }
        ?>
    </tbody>
</table>

<style type="text/css">
    tr.inactive {
        color: red;
        font-weight: bold;
    }
    tr.active {
        color: green;
        font-weight: bold;
    }
</style>
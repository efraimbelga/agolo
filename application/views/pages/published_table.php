<table class="table table-condensed table-bordered">
    <thead>
        <tr>           
            <th>Source Name</th>
            <th>Source URL</th>
            <th>Status</th>
            <th>Current Process</th>
            <th>Agent Name</th>
            <th>User Name</th>
            <th>Agent State Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(sizeof($data) > 0){
                foreach ($data as $row) {
                    echo'<tr>';
                        
                        echo'<td>'.$row['SourceName'].'</td>';
                        echo'<td>'.$row['SourceUrl'].'</td>';
                        echo'<td>';
                            echo '<select class="form-controll input-sm agentState-opt">';
                                echo'<option value=""></option>';
                                echo'<option '.($row['Status']== '1' ? 'selected' : '').' value="1">Active</option>';
                                echo'<option '.($row['Status']== '0' ? 'selected' : '').' value="0">Inactive</option>';
                            echo'</select>';
                        echo'</td>';
                        echo'<td>'.$row['ProcessCode'].'</td>';
                        echo'<td>'.$row['AgentName'].'</td>';
                        echo'<td><span class="username">'.$row['UserName'].'</span></td>';
                        echo'<td>'.$row['AgentStatedate'].'</td>';
                    echo'</tr>';
                }
            }else{
                echo'<tr><td colspan="7">No data found</td></tr>';
            }
        ?>
    </tbody>
</table>
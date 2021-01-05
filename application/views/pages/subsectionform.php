<tr class="subsection">
    
        <td style="display: none;"><form class="subsectionFrom" id="<?= $formID;?>"></form></td>
        <td>
            <input form="<?= $formID;?>" type="hidden" class="ParentID" name="ParentID" value="0" required >
            <input form="<?= $formID;?>" type="text" name="SourceURL" class="form-control input-sm SourceURL" required>
        </td>
        <td>
            <input form="<?= $formID;?>" type="text" name="SourceName" class="form-control input-sm SourceName" required>
        </td>
        <td>
            <input form="<?= $formID;?>" type="text" name="Type" class="form-control input-sm Type">
        </td>
        <td>
            <select form="<?= $formID;?>" name="Region" class="form-control input-sm Region">
                <option value=""></option>
                <?php
                foreach ($regions as $region) {
                    echo'<option value="'.$region.'">'.$region.'</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <input form="<?= $formID;?>" type="text" name="Country" class="form-control input-sm Country" >
        </td>
        <td>
            <input form="<?= $formID;?>" type="text" name="Client" class="form-control input-sm Client" >
        </td>
        <td>
            <input form="<?= $formID;?>" type="text" name="Access" class="form-control input-sm Access" >
        </td>
        <td>
            <select form="<?= $formID;?>" class="form-control input-sm Priority" name="Priority" id="Priority" required>
                <option value=""> </option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </td>
        <td class="text-left">
            <button form="<?= $formID;?>" ype="submit" class="btn btn-xs btn-success"><i class="fa fa-check-square" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger clearsection-btn"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </td>
    
</tr>
    <?php
        $hasData = !empty($organization);
    ?>
    <div class="box">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="org-name" <?php if ($hasData) echo 'value="'.$organization[0]->name.'"'; ?> disabled>
            </div>
        </div>

        <div class="field">
            <label class="label">Type</label>
            <div class="control">
                <input class="input" type="text" name="org-name" <?php if ($hasData) echo 'value="'.$organization[0]->type.'"'; ?> disabled>
            </div>
        </div>

        <br>

        <div class="field">
            <label class="label">Address</label>
            <div class="control">
                <textarea class="textarea" type="text" name="address" disabled><?php if ($hasData) echo $organization[0]->address; ?></textarea>
            </div>
        </div>

        <br>

        <h5 class="subtitle is-5">Responding Areas</h5>

        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
            <thead>
                <tr>
                    <th>Province</th>
                    <th>District</th>
                    <th>Town</th>
                    <?php
                        if (!empty($isOrgAdmin) && $isOrgAdmin)
                            echo '<th></th>';
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($respondingAreas as $row) {
                        echo '<tr>';
                        echo '<td>' . ucfirst($row->province) . '</td>';
                        echo '<td>' . ucfirst($row->district) . '</td>';
                        echo '<td>' . ucfirst($row->town) . '</td>';
                        if (!empty($isOrgAdmin) && $isOrgAdmin) {
                            echo '<td>';
                            echo '<button class="delete location-delete" aria-label="remove" title="remove" type="button" style="float:right;" data-target="loc-' . $row->id . '">';
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>

        <br>

        <div class="field">
            <label class="label">Contact Number</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="org-contact" <?php if ($hasData) echo 'value="'.$organization[0]->contact.'"'; ?> disabled>
                <span class="icon is-small is-left">
                    <i class="fas fa-phone"></i>
                </span>
            </div>
        </div>
            
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="email" name="org-email" <?php if ($hasData) echo 'value="'.$organization[0]->email.'"'; ?> disabled>
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>
        <br>
    </div>
    
    <br>
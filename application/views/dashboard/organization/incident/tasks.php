<div class="section">
    <?php if (!empty($tasks)) : ?>
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Date Time</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($tasks as $row) {
                        echo '<tr>';
                        echo '<td style="max-width: 400px;">' . ucfirst($row->content) . '</td>';
                        echo '<td>' . ucfirst($row->assigned_at) . '</td>';
                        echo '<td>' . form_open('organization/mark-task-complete/'.$row->id) . '<button class="button is-link" type="submit">Mark Completed</button>'.form_close().'</td>';
                        if ($row->assigned_to !== NULL) {
                            echo '<td>'.$row->responder_name.'</td>';
                        } else {
                            echo '<td><button class="button is-link task-assign-btn" data-task-id="'.$row->id.'">Assign Task</button>';
                        }
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No tasks yet...</p>
    <?php endif; ?>
</div>

<div class="modal" id="responders-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
  <div class="result">
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;" id="org-responders-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            <?php
                if (!empty($responders)) {        
                    foreach ($responders as $row) {
                        echo '<tr>';
                        echo '<td>';
                        echo $row->first_name;
                        echo '</td>';
                        echo '<td>';
                        echo $row->last_name;
                        echo '</td>';
                        echo '<td>';
                        echo $row->position;
                        echo '</td>';
                        echo '<td>';
                        echo $row->contact;
                        echo '</td>';
                        echo '<td>';
                        echo $row->email;
                        echo '</td>';
                        echo '<td>';
                        echo form_open('organization/assign-task/', 'id="assign-task-form"');
                        echo '<input type="hidden" name="incident-id" value="'.$id.'">';
                        echo '<input type="hidden" name="responder-id" value="'.$row->id.'">';
                        echo '<input type="hidden" name="task-id" class="task-id" value="-1">';
                        echo '<button class="button is-link" type="submit">Assign</button>';
                        echo form_close();
                        echo '</td>';
                        echo '</tr>';    
                    }
                }    
            ?>
            </tbody>
        </table>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
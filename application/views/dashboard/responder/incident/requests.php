<div class="section">
    <?php echo form_open('responder/add-request'); ?>
    <input type="hidden" name="inc-id" value="<?php echo $id; ?>">
    <input type="hidden" name="res-id" value="<?php echo $resId; ?>">
    <textarea class="textarea" name="request-content" placeholder="Request"></textarea>
    <br>
    <div class="control">
        <label class="label">Request Priority</label>
        <div class="select is-fullwidth">
            <select name="priority">
                <option value="3">Urgent</option>
                <option value="2">High</option>
                <option value="1">Medium</option>
                <option value="0">Low</option>
            </select>
        </div>
    </div>
    <br>
    <button class="button is-link" type="submit">Add Request</button>
    <?php echo form_close(); ?>

    <hr>

    <?php if (!empty($requests)) : ?>
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;">
            <thead>
                <tr>
                    <th>Request</th>
                    <th>Date Time</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($requests as $row) {
                        switch ($row->priority) {
                            case '0':
                                $priority = 'Low';
                                break;
                            
                            case '1':
                                $priority = 'Medium';
                                break;
                            
                            case '2':
                                $priority = 'High';
                                break;
                            
                            case '3':
                                $priority = 'Urgent';
                                break;

                            default:
                                $priority = 'Undefined';
                                break;
                        }
                        echo '<tr>';
                        echo '<td style="max-width: 400px;">' . ucfirst($row->content) . '</td>';
                        echo '<td>' . ucfirst($row->added_at) . '</td>';
                        echo '<td>' . ucfirst($priority) . '</td>';
                        echo '<td>' . ucfirst($row->status) . '</td>';
                        if ($row->status !== 'completed') {
                            echo '<td>' . form_open('responder/mark-request-complete/'.$row->id .'/' . $id) . '<button class="button is-link" type="submit">Mark Completed</button>'.form_close().'</td>';
                        } else {
                            echo '<td></td>';
                        }
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No request yet...</p>
    <?php endif; ?>
</div>
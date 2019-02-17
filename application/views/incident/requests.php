<div class="section">
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
                        if ($row->status === 'unseen') {
                            echo '<td>' . form_open('incident/update-request-status/'.$row->id .'/' . $id) . '<input type="hidden" name="status" value="seen"> <button class="button is-link" type="submit">Mark Seen</button>'.form_close().'</td>';
                        } else if ($row->status === 'seen'){
                            echo '<td>' . form_open('incident/update-request-status/'.$row->id .'/' . $id) . '<input type="hidden" name="status" value="handling"> <button class="button is-link" type="submit">Mark Handling</button>'.form_close().'</td>';
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
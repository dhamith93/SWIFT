<div class="section">
    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
        <thead>
            <tr>
                <th>Incident</th>
                <th>Task</th>
                <th>Date Time</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($tasks as $row) {
                    echo '<tr>';
                    echo '<td><a href="../../incident/' . $row->inc_id . '" target="_blank">' . ucfirst($row->name) . '</a></td>';
                    echo '<td style="max-width: 600px;">' . ucfirst($row->content) . '</td>';
                    echo '<td>' . ucfirst($row->assigned_at) . '</td>';
                    echo '<td>' . form_open('organization/mark-task-complete/'.$row->id) . '<button class="button is-link" type="submit">Mark Completed</button>'.form_close();
                }
            ?>
        </tbody>
    </table>
</div>
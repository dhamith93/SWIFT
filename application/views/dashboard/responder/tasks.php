<div class="section">
    <?php if (!empty($tasks)) : ?>
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;">
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
                        echo '<td><a href="../../responder/incident/' . $row->inc_id . '/tasks" target="_blank">' . ucfirst($row->name) . '</a></td>';
                        echo '<td style="max-width: 600px;">' . ucfirst($row->content) . '</td>';
                        echo '<td>' . ucfirst($row->assigned_at) . '</td>';
                        echo '<td>' . form_open('responder/mark-task-complete/'.$row->id) . '<button class="button is-link" type="submit">Mark Completed</button>'.form_close();
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No uncompleted tasks yet...</p>
    <?php endif; ?>
</div>
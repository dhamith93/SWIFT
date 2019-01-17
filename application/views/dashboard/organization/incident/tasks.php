<div class="section">
    <?php if (!empty($tasks)) : ?>
        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Date Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($tasks as $row) {
                        echo '<tr>';
                        echo '<td style="max-width: 600px;">' . ucfirst($row->content) . '</td>';
                        echo '<td>' . ucfirst($row->assigned_at) . '</td>';
                        echo '<td>' . form_open('organization/mark-task-complete/'.$row->id) . '<button class="button is-link" type="submit">Mark Completed</button>'.form_close();
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No tasks yet...</p>
    <?php endif; ?>
</div>
<textarea class="textarea" id="task-content" placeholder="Task"></textarea>
<br>
<div class="control">
    <label class="label">Responding Organization</label>
    <div class="select is-fullwidth">
        <select id="responder-org">
            <?php
                foreach ($responders as $row)
                    echo '<option value="' . $row->id . '">' . $row->name . '</option>';
            ?>
        </select>
    </div>
</div>
<br>
<button class="button is-link" id="add-task-btn">Add Task</button>

<hr>

<div class="box">
    <table class="table is-bordered is-striped is-narrow is-hoverable" id="tasks" style="margin: auto;">
        <thead>
            <tr>
                <th>Date Assigned</th>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Is Completed</th>
                <th>Completed At</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($tasks as $task) {
                    echo '<tr>';
                    echo '<td>' . $task['assigned_at'] . '</td>';
                    echo '<td>' . $task['content'] . '</td>';
                    echo '<td>' . $task['org'] . '</td>';
                    echo '<td>' . $task['is_completed'] . '</td>';
                    echo '<td>' . $task['completed_at'] . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>

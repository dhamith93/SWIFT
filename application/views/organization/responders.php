<div class="box">
    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($responders as $row) {
                    echo '<tr>';
                    echo '<td>' . ucfirst($row->first_name) . '</td>';
                    echo '<td>' . ucfirst($row->last_name) . '</td>';
                    echo '<td>' . $row->contact . '</td>';
                    echo '<td>' . $row->email . '</td>';
                    echo '<td>';
                    if ($row->is_admin === '1') {
                        echo 'YES';
                    } else {
                        echo 'NO';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
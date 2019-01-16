<div class="section">
    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
        <thead>
            <tr>
                <th>Incident</th>
                <th>Alert</th>
                <th>Date Time</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($alerts as $row) {
                    echo '<tr>';
                    echo '<td><a href="../../incident/' . $row->inc_id . '" target="_blank">' . ucfirst($row->name) . '</a></td>';
                    echo '<td>' . ucfirst($row->content) . '</td>';
                    echo '<td>' . ucfirst($row->published_date) . '</td>';
                }
            ?>
        </tbody>
    </table>
</div>
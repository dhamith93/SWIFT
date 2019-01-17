<div class="section">
    <?php if (!empty($alerts)) : ?>
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;">
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
                        echo '<td><a href="../../organization/incident/' . $row->inc_id . '" target="_blank">' . ucfirst($row->name) . '</a></td>';
                        echo '<td style="max-width: 600px;">' . ucfirst($row->content) . '</td>';
                        echo '<td>' . ucfirst($row->published_date) . '</td>';
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No alerts yet...</p>
    <?php endif; ?>
</div>
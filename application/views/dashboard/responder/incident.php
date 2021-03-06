<div class="section">
    <?php if (!empty($incidents)) : ?>
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Affected Areas</th>
                    <th>Longtitude</th>
                    <th>Latitude</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($incidents as $row) {
                        echo '<tr>';
                        echo '<td>' . ucfirst($row['name']) . '</td>';
                        echo '<td>' . ucfirst($row['type']) . '</td>';
                        echo '<td>';
                            foreach ($row['locations'] as $location) {
                                echo ucfirst($location) . '<br>';
                            }
                        echo '</td>';
                        echo '<td>' . ucfirst($row['lng']) . '</td>';
                        echo '<td>' . ucfirst($row['lat']) . '</td>';
                        echo '<td>';
                        echo '<a class="button is-danger" href="../../responder/incident/' . $row['id'] . '" target="_blank" aria-haspopup="true">More</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="text-align:center;">No incident assigned yet...</p>
    <?php endif; ?>
</div>
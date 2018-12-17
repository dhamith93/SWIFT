<table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
    <thead>
        <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Province</th>
        <th>District</th>
        <th>Location</th>
        <th>Longtitude</th>
        <th>Latitude</th>
        <th>On going</th>
        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($incidentResult as $row) {
                echo '<tr>';
                echo '<td>' . ucfirst($row->name) . '</td>';
                echo '<td>' . ucfirst($row->type) . '</td>';
                echo '<td>' . ucfirst($row->province) . '</td>';
                echo '<td>' . ucfirst($row->district) . '</td>';
                echo '<td>' . ucfirst($row->location) . '</td>';
                echo '<td>' . ucfirst($row->lng) . '</td>';
                echo '<td>' . ucfirst($row->lat) . '</td>';
                echo '<td>';
                if ($row->on_going === '1') {
                    echo 'YES';
                } else {
                    echo 'NO';
                }
                echo '</td>';
                echo '<td>';
                echo '<button class="button is-danger more-btn" id="' . $row->id . '">More</button>';
                echo '</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>
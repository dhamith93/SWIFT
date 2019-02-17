<div class="section">
    <table class="table" style="width: 800px; margin: auto;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Date & time occured</th>
                <th>On going</th>
            </tr>
        </thead>
        <tbody>
            <tr class=>
                <td><?php echo ucfirst($incident[$id]['name']); ?></td>
                <td><?php echo ucfirst($incident[$id]['type']); ?></td>
                <td>
                    <?php
                        echo ucfirst($incident[$id]['date']);
                        echo ' -- '; 
                        echo ucfirst($incident[$id]['time']);
                    ?>
                </td>
                <?php 
                    if ($incident[$id]['on_going'] === '1')  {
                        echo '<td>YES</td>';
                    } else {
                        echo '<td>NO</td>';
                    }
                ?>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <br>

    <h4 class="subtitle is-5">Affected Areas</h4>
    <div class="columns">
        <div class="column">
            <hr>
            <?php 
                $locationCount = 0;
                foreach ($incident[$id]['locations'] as $location):
            ?>
                <div id="loc-<?php echo $locationCount;?>">
                    <p> <?php echo $location;?></p>
                    <hr>
                </div>

                <?php $locationCount += 1;?>

            <?php endforeach; ?>
            
        </div>
        <div class="column">
            <div id="map" style="width:100%;height:400px;"></div>
            <?php 
                if (!empty($incident[$id]['lat']) && !empty($incident[$id]['lng'])) {
                    echo '<p><strong>Lat:</strong> ' . $incident[$id]['lat'] . ' | <strong>Lng:</strong> ' . $incident[$id]['lng'] . '</p>';
                    echo '<button class="button is-warning" id="locate-btn">Load exact location</button>';
                }
            ?>
        </div>
        </div>

        <hr>

        <br> <br>

        <div class="columns">
        <div class="column">
            <h4 class="subtitle is-5">Casualties</h4>
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                <thead>
                    <tr>
                        <th>Deaths</th>
                        <th>Wounded</th>
                        <th>Missing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php if (isset($casualties[0])) echo $casualties[0]->deaths; else echo '0'; ?>
                        </td>
                        <td>
                            <?php if (isset($casualties[0])) echo $casualties[0]->wounded; else echo '0'; ?>
                        </td>
                        <td>
                            <?php if (isset($casualties[0])) echo $casualties[0]->missing; else echo '0'; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <h4 class="subtitle is-5">Hospitalizations</h4>
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                <thead>
                    <tr>
                        <th>Hospital</th>
                        <th>No. of patients</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        <?php if (isset($hospitalizations[0])) echo $hospitalizations[0]->hospital_id; ?>
                        </td>
                        <td>
                        <?php if (isset($hospitalizations[0])) echo $hospitalizations[0]->count; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>

        <br>

        <hr>

        <br>

        <div class="columns">
        <div class="column">
            <h4 class="subtitle is-5">Evacuations</h4>
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                <thead>
                    <tr>
                        <th>Address</th>
                        <th>No. of evacuees</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php if (!empty($evacuations)) foreach ($evacuations as $evac): ?>
                        <td>
                            <?php echo $evac->address; ?>
                        </td>
                        <td>
                            <?php echo $evac->count; ?>
                        </td>
                        <td>
                            <?php echo $evac->contact; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <br>
    </div>
</div>

<script>

    <?php 
        if ($incident[$id]['geocodes']) {
            if (!empty($incident[$id]['lat']) && !empty($incident[$id]['lng'])) {
                echo 'var lat = ' . $incident[$id]['lat'] . ';';
                echo 'var lng = ' . $incident[$id]['lng'] . ';';
            } else {
                echo 'var lat = 7.8731;';
                echo 'var lng = 80.7718;';
            }
            
            echo 'var locations = {';
            foreach ($incident[$id]['geocodes'] as $geocode) {
                echo $geocode['name'] . ': {';
                echo '\'lat\':' . $geocode['lat'] . ',';
                echo '\'lng\':' . $geocode['lng'];
                echo '},';
            }
            echo '};';
        }
    ?>

function initMap() {
    let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {lat: lat, lng: lng}
    });

    if (locations) {
        Object.keys(locations).map((k, i) => {
            let marker = new google.maps.Marker({
                map: map,
                position: locations[k],
                title: k,
                label: {
                    color: 'black',
                    fontWeight: 'bold',
                    text: k
                }
            });
            let center = locations[k];
            map.panTo(center);
        });
    }
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('geocode_api'); ?>&callback=initMap"></script>
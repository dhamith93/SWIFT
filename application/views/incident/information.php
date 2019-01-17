<div class="section">
    <table class="table" style="width: 800px; margin: auto;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Date & time occured</th>
                <th>On going</th>
                <?php 
                    if ($incident[$id]['on_going'] === '1')
                        echo '<th></th>';
                ?>
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
                        echo '<td>';
                        echo form_open('incident/mark-complete/' . $id);
                        echo '<button type="submit" class="button">Mark complete</button>';
                        echo form_close();
                        echo '</td>';
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
    <div class="columns" style="background-color: #fff;">
        <div class="column">
            <hr>
            <?php 
                $locationCount = 0;
                foreach ($incident[$id]['locations'] as $location):
            ?>
                <div id="loc-<?php echo $locationCount;?>">
                    <p> <?php echo $location;?> </p>
                    <hr>
                </div>

                <?php $locationCount += 1;?>

            <?php endforeach; ?>
            
            <a class="button is-success" id="add-area-btn">
                <span class="icon is-small">
                    <i class="fas fa-chevron-down animated flipInX btn-icon" id="btn-icon"></i>
                </span>
                <span>Add More</span>
            </a>

            <br> <br>

            <div class="box is-hidden" id="location-box">
                <?php echo form_open('incident/add-location/' . $id, 'id="add-location-form"') ?>
                    <div class="control">
                        <label class="label">Province</label>
                        <div class="select is-fullwidth">
                            <select id="area-province">
                                <option value="central">Central</option>
                                <option value="eastern">Eastern</option>
                                <option value="north-central">North Central</option>
                                <option value="north-western">North Western</option>
                                <option value="northern">Northern</option>
                                <option value="sabaragamuwa">Sabaragamuwa</option>
                                <option value="southern">Southern</option>
                                <option value="uva">Uva</option>
                                <option value="western">Western</option>
                            </select>
                        </div>
                    </div>
                    
                    <br>

                    <div class="control">
                        <label class="label">District</label>
                        <div class="select is-fullwidth">
                            <select id="area-district">
                                <option value="ampara">Ampara</option>
                                <option value="anuradhapura">Anuradhapura</option>
                                <option value="badulla">Badulla</option>
                                <option value="batticaloa">Batticaloa</option>
                                <option value="colombo">Colombo</option>
                                <option value="galle">Galle</option>
                                <option value="gampaha">Gampaha</option>
                                <option value="hambantota">Hambantota</option>
                                <option value="jaffna">Jaffna</option>
                                <option value="kalutara">Kalutara</option>
                                <option value="kandy">Kandy</option>
                                <option value="kegalle">Kegalle</option>
                                <option value="kilinochchi">Kilinochchi</option>
                                <option value="kurunegala">Kurunegala</option>
                                <option value="mannar">Mannar</option>
                                <option value="matale">Matale</option>
                                <option value="matara">Matara</option>
                                <option value="monaragala">Monaragala</option>
                                <option value="mullaitivu">Mullaitivu</option>
                                <option value="nuwara-eliya">Nuwara Eliya</option>
                                <option value="polonnaruwa">Polonnaruwa</option>
                                <option value="puttalam">Puttalam</option>
                                <option value="ratnapura">Ratnapura</option>
                                <option value="trincomalee">Trincomalee</option>
                                <option value="vavuniya">Vavuniya</option>
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="field">
                        <label class="label">Town</label>
                        <div class="control">
                            <input class="input" type="text" id="area-town">
                        </div>
                    </div>

                    <input type="hidden" name="location-string" id="location-string" value="">
                    <input type="hidden" name="alert-orgs" id="alert-orgs" value="FALSE">

                    <div class="field">
                        <button class="button is-link" id="add-location-btn">Add Area</button>
                    </div>
                <?php echo form_close(); ?>
            </div>
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
            <?php echo form_open('incident/update-casualties/' . $id, 'id="update-casualties-form"') ?>
                <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                    <thead>
                        <tr>
                            <th>Deaths</th>
                            <th>Wounded</th>
                            <th>Missing</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="control">
                                    <input class="input" type="number" name="deaths" value="<?php if (isset($casualties[0])) echo $casualties[0]->deaths; else echo '0'; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="control">
                                    <input class="input" type="number" name="wounded" value="<?php if (isset($casualties[0])) echo $casualties[0]->wounded; else echo '0'; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="control">
                                    <input class="input" type="number" name="missing" value="<?php if (isset($casualties[0])) echo $casualties[0]->missing; else echo '0'; ?>">
                                </div>
                            </td>
                            <td>
                                <button class="button is-link" type="submit">Update</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php echo form_close(); ?>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php if (!empty($evacuations)) foreach ($evacuations as $evac): ?>
                    <?php echo form_open('incident/update-evacuations/' . $id, 'id="update-evacuation-form"') ?>
                        <td>
                            <div class="control">
                                <textarea class="textarea" name="address" cols="30" rows="4"><?php echo $evac->address; ?></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="control">
                                <input class="input" type="number" name="evacuees" value="<?php echo $evac->count; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="control">
                                <input class="input" type="text" name="contact" value="<?php echo $evac->contact; ?>">
                            </div>
                        </td>
                        <input type="hidden" name="id" value="<?php echo $evac->id; ?>">
                        <td>
                            <button class="button is-link" type="submit">Update</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php echo form_close(); ?>
                    <?php echo form_open('incident/add-evacuations/' . $id, 'id="add-evacuation-form"') ?>
                    <tr>
                        <td>
                            <div class="control">
                                <textarea class="textarea" name="address" cols="30" rows="3"></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="control">
                                <input class="input" type="number" name="evacuees">
                            </div>
                        </td>
                        <td>
                            <div class="control">
                                <input class="input" type="text" name="contact">
                            </div>
                        </td>
                        <td>
                            <button class="button is-link" type="submit" style="width: 100%;">Add</button>
                        </td>
                    </tr>
                    <?php echo form_close(); ?>
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
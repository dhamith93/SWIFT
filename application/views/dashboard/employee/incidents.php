    <div class="tabs is-centered">
        <ul>
            <li class="tab-header is-active" data-tab="0"><a>On going</a></li>
            <li class="tab-header" data-tab="1"><a>Search</a></li>
            <li class="tab-header" data-tab="2"><a>Add</a></li>
        </ul>
    </div>
    <div id="tab-content" class="tab-content">
        <div class="tab is-active" data-content="0">
            <?php
                if (!empty($incidents)) {
                    $data['incidentResult'] = $incidents;
                    $this->load->view('dashboard/employee/incident_table', $data);
                }
            ?>
        </div>
        <div class="tab" data-content="1">
            <div class="search-input-area is-centered" >
                <?php
                    $name = '';
                    $type = ''; 
                    $town = '';
                    $province = '';
                    $district = '';
                    $isOngoing = 'indeterminate';

                    if (!empty($ongoing) && $ongoing === 'unchecked')
                        $isOngoing = '';
                    
                    if (!empty($ongoing) && $ongoing === 'checked')
                        $isOngoing = 'checked';

                    if (!empty($searchType)) {
                        if ($searchType === 'name')
                            $name = 'selected';
                        if ($searchType === 'type')
                            $type = 'selected';
                        if ($searchType === 'town')
                            $town = 'selected';
                        if ($searchType === 'province')
                            $province = 'selected';
                        if ($searchType === 'district')
                            $district = 'selected';
                    }

                ?>
                <?php echo form_open('incident/search', 'id="search-form"'); ?>
                    <div class="field has-addons is-centered">
                        <p class="control">
                            <span class="select is-rounded is-primary">
                                <select name="search-type">
                                    <option value="name" <?php echo $name; ?>>Name</option>
                                    <option value="type" <?php echo $type; ?>>Type</option>
                                    <option value="town" <?php echo $town; ?>>Town</option>
                                    <option value="district" <?php echo $district; ?>>District</option>
                                    <option value="province" <?php echo $province; ?>>Province</option>
                                </select>
                            </span>
                        </p>
                        <p class="control">
                            <input class="input is-rounded is-primary" type="text" name="search-value" <?php if (!empty($searchValue)) echo 'value="'.$searchValue.'"'; ?>>
                        </p>
                        <p class="control">
                            <button class="button is-rounded is-primary" type="submit">
                                Search
                            </button>
                        </p>
                    </div> 
                    <label class="checkbox">
                        <input type="checkbox" id="checkbox" <?php if ($isOngoing === 'checked') echo 'checked'; ?>>
                        On going
                    </label>

                    <input type='hidden' id='is-ongoing' name='is-ongoing' value='-1'>


                <?php echo form_close(); ?>
                <script>
                    let checkbox = document.getElementById('checkbox');

                    if ('<?php echo $isOngoing; ?>' === 'indeterminate') {
                        checkbox.indeterminate = true;
                    } else if (checkbox.checked) {
                        document.getElementById('is-ongoing').value = '1';
                    } else {
                        document.getElementById('is-ongoing').value = '0';
                    }

                    checkbox.addEventListener('click', (e) => {
                        if (checkbox.checked) {
                            document.getElementById('is-ongoing').value = '1';
                        } else {
                            document.getElementById('is-ongoing').value = '0';
                        }
                    });
                </script>
            </div>
            <hr>
            <div class="columns search-result">
                <div class="notification is-danger" id="no-record-notification">
                    No records found!
                </div>
                <?php 
                    if (!empty($incidentResults)) {
                        $data['incidentResult'] = $incidentResults;
                        $this->load->view('dashboard/employee/incident_table', $data);
                    }
                ?>
            </div>
        </div>
        <div class="tab" data-content="2">
            <?php 
                if (!empty($errors)) {
                    echo '<div class="notification is-danger" id="empty-error-notification">';
                    foreach ($errors as $error)
                        echo $error . '<br>';
                    echo '</div>';
                }
            ?>
            <div class="notification is-success" id="success-notification">
                Incident added successfully!
            </div>
            <div class="notification is-danger" id="employee-error-notification">
                An error occured when adding incident! <br>
                Try again.
            </div>
            <?php echo form_open('incident/add', 'id="add-incident-form"'); ?>
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input" type="text" name="name">
                    </div>
                </div>

                <div class="control">
                    <label class="label">Type</label>
                    <div class="select is-fullwidth">
                        <select name="type">
                            <option value="flood">Flood</option>
                            <option value="fire">Fire</option>
                            <option value="land-slide">Land Slides</option>
                            <option value="storm">Storm</option>
                            <option value="shooting">Shooting</option>
                            <option value="explosion">Explosion</option>
                            <option value="tsunami">Tsunami</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <br>

                <div class="box" id="location-box">
                    <label class="label">Affected Areas</label> <br>
                    <div class="control">
                        <label class="label">Province</label>
                        <div class="select is-fullwidth">
                            <select id="province">
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
                            <select id="district">
                                <option value="Ampara">Ampara</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Galle">Galle</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Kegalle">Kegalle</option>
                                <option value="Kilinochchi">Kilinochchi</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Matale">Matale</option>
                                <option value="Matara">Matara</option>
                                <option value="Monaragala">Monaragala</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Nuwara-eliya">Nuwara Eliya</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="field">
                        <label class="label">Town</label>
                        <div class="control">
                            <input class="input" type="text" id="town">
                        </div>
                    </div>

                    <hr>
                    
                    <div class="field">
                        <div class="control" id="locations"> </div>
                    </div>

                    <input type="hidden" name="location-list" id="location-list" value="">

                    <div class="field">
                        <button class="button is-link is-rounded" id="add-location-btn" type="button">Add Area</button>
                    </div>
                </div>

                <div class="field">
                    <label class="label">GPS Location</label>
                    <div class="control">
                        <input class="input" type="text" name="lat" placeholder="Latitude">
                    </div>
                    <br>
                    <div class="control">
                        <input class="input" type="text" name="long" placeholder="Longtitude">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Date and Time</label>
                    <div class="control">
                        <input class="input" type="date" name="date">
                    </div>
                    <br>
                    <div class="control">
                        <input class="input" type="time" name="time">
                    </div>
                </div>

                <br>

                <div class="control">
                    <label class="label">Send Alerts</label> <small>CTRL + CLICK to chose multiple items.</small>
                    <div class="select is-fullwidth is-multiple">
                        <select multiple size="10" name="alerts-receivers[]">
                            <option value="public">Public</option>
                            <option value="1">Hospitals</option>
                            <option value="2">Fire Brigade</option>
                            <option value="3">Ambulance Services</option>
                            <option value="4">Police</option>
                            <option value="5">Search and Rescue</option>
                            <option value="6">Military</option>
                            <option value="7">Provincial Council</option>
                            <option value="8">Urban Council</option>
                            <option value="9">Pradheshiya Sabha</option>
                        </select>
                    </div>
                </div>

                <br>

                <div class="field">
                    <label class="label">Alert content</label>
                    <div class="control">
                        <textarea class="textarea" name="alert"></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Hazard warning to responders</label>
                    <div class="control">
                        <textarea class="textarea" name="warning"></textarea>
                    </div>
                </div>
                
                <br>

                <div class="field submit-btns">
                    <button class="button is-link is-rounded" type="submit">Add Incident</button>
                    <button class="button is-danger is-rounded" type="reset">Reset</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
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
                    $location = '';
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
                        if ($searchType === 'location')
                            $location = 'selected';
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
                                    <option value="location" <?php echo $location; ?>>Location</option>
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
            <div class="notification is-success" id="success-notification">
                Incident added successfully!
            </div>
            <div class="notification is-danger" id="employee-error-notification">
                An error occured when adding incident! <br>
                Try again.
            </div>
            <?php echo form_open('incident/add'); ?>
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

                <div class="control">
                    <label class="label">Province</label>
                    <div class="select is-fullwidth">
                        <select name="province">
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
                        <select name="district">
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
                    <label class="label">Location</label>
                    <div class="control">
                        <input class="input" type="text" name="location">
                    </div>
                </div>

                <div class="field">
                    <label class="label">GPS Location</label>
                    <div class="control">
                        <input class="input" type="text" name="long" placeholder="Longtitude">
                    </div>
                    <br>
                    <div class="control">
                        <input class="input" type="text" name="lat" placeholder="Latitude">
                    </div>
                </div>

                <div class="control">
                    <label class="label">Send Alerts</label> <small>CTRL + CLICK to chose multiple items.</small>
                    <div class="select is-fullwidth is-multiple">
                        <select multiple size="10" name="alerts-receivers[]">
                            <option value="public">Public</option>
                            <option value="hospitals">Hospitals</option>
                            <option value="fire-brigades">Fire Brigade</option>
                            <option value="ambulance-services">Ambulance Services</option>
                            <option value="police">Police</option>
                            <option value="s&r">Search and Rescue</option>
                            <option value="military">Military</option>
                            <option value="pc">Provincial Council</option>
                            <option value="uc">Urban Council</option>
                            <option value="ps">Pradheshiya Sabha</option>
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
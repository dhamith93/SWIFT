<div id="resp-search-area">
    <br>
    <div class="search">
        <?php echo form_open('organization/search', 'id="search-organization-form"'); ?>

            <?php
                $hospital = '';
                $fireBrigade = '';
                $ambulance = '';
                $police = '';
                $sNr = '';
                $military = '';
                $pc = '';
                $uc = '';
                $ps = '';
                $town = '';
                $province = '';
                $district = '';

                if (!empty($orgType) && !empty($locationType)) {
                    switch ($orgType) {
                        case 'hospital':
                            $hospital = 'selected';
                            break;
                        case 'fire-brigade':
                            $fireBrigade = 'selected';
                            break;
                        case 'ambulance-service':
                            $ambulance = 'selected';
                            break;
                        case 'police':
                            $police = 'selected';
                            break;
                        case 's&r':
                            $sNr = 'selected';
                            break;
                        case 'military':
                            $military = 'selected';
                            break;
                        case 'pc':
                            $pc = 'selected';
                            break;
                        case 'uc':
                            $uc = 'selected';
                            break;
                        case 'ps':
                            $ps = 'selected';
                            break;
                    }

                    switch ($locationType) {
                        case 'town':
                            $town = 'selected';
                            break;
                        case 'province':
                            $province = 'selected';
                            break;
                        case 'district':
                            $district = 'selected';
                            break;
                    }
                }
            ?>

            <p class="control">
                <span class="select is-primary">
                    <select name="org-type">
                        <option value="hospital" <?php echo $hospital; ?>>Hospital</option>
                        <option value="fire-brigade" <?php echo $fireBrigade; ?>>Fire Brigade</option>
                        <option value="ambulance-service" <?php echo $ambulance; ?>>Ambulance Service</option>
                        <option value="police" <?php echo $police; ?>>Police</option>
                        <option value="s&r" <?php echo $sNr; ?>>Search and Rescue</option>
                        <option value="military" <?php echo $military; ?>>Military</option>
                        <option value="pc" <?php echo $pc; ?>>Provincial Council</option>
                        <option value="uc" <?php echo $uc; ?>>Urban Council</option>
                        <option value="ps" <?php echo $ps; ?>>Pradheshiya Sabha</option>
                    </select>
                </span>

                <span style="line-height: 2rem;">in</span>

                <span>
                    <input class="input is-primary" type="text" name="search-value" <?php if(!empty($orgSearchValue)) echo 'value="' . $orgSearchValue . '"'; ?>>
                </span>

                <span class="select is-primary">
                    <select name="location-type">
                        <option value="province" <?php echo $province; ?>>Province</option>
                        <option value="district" <?php echo $district; ?>>District</option>
                        <option value="town" <?php echo $town; ?>>Town</option>
                    </select>
                </span>

                <span>
                    <button class="button is-primary" id="search-btn">
                        Search
                    </button>
                </span>

            </p>
        <?php echo form_close(); ?>
    </div>

    <br>

    <?php 
        if (!empty($organizationResult)) {
            echo '<div class="result">';
            echo '    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="search-result-table">';
            echo '        <thead>';
            echo '            <tr>';
            echo '                <th>Name</th>';
            echo '                <th>Type</th>';
            echo '                <th>Address</th>';
            echo '                <th>Contact</th>';
            echo '                <th>Email</th>';
            echo '                <th></th>';
            echo '            </tr>';
            echo '        </thead>';
            echo '        <tbody>';
            foreach ($organizationResult as $row) {
                echo '<tr>';
                echo '<td>';
                echo $row['name'];
                echo '</td>';
                echo '<td>';
                echo $row['type'];
                echo '</td>';
                echo '<td>';
                echo $row['address'];
                echo '</td>';
                echo '<td>';
                echo $row['contact'];
                echo '</td>';
                echo '<td>';
                echo $row['email'];
                echo '</td>';
                echo '<td>';
                echo '<a class="button is-danger" href="../../organization/' . $row['id'] . '" target="_blank" aria-haspopup="true">More</a>';
                echo '</td>';
                echo '</tr>';    
            }
            echo '        </tbody>';
            echo '    </table>';
            echo '</div>';
        }    
    ?>
    
</div>
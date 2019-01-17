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
                        case '1':
                            $hospital = 'selected';
                            break;
                        case '2':
                            $fireBrigade = 'selected';
                            break;
                        case '3':
                            $ambulance = 'selected';
                            break;
                        case '4':
                            $police = 'selected';
                            break;
                        case '5':
                            $sNr = 'selected';
                            break;
                        case '6':
                            $military = 'selected';
                            break;
                        case '7':
                            $pc = 'selected';
                            break;
                        case '8':
                            $uc = 'selected';
                            break;
                        case '9':
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
                        <option value="1" <?php echo $hospital; ?>>Hospital</option>
                        <option value="2" <?php echo $fireBrigade; ?>>Fire Brigade</option>
                        <option value="3" <?php echo $ambulance; ?>>Ambulance Service</option>
                        <option value="4" <?php echo $police; ?>>Police</option>
                        <option value="5" <?php echo $sNr; ?>>Search and Rescue</option>
                        <option value="6" <?php echo $military; ?>>Military</option>
                        <option value="7" <?php echo $pc; ?>>Provincial Council</option>
                        <option value="8" <?php echo $uc; ?>>Urban Council</option>
                        <option value="9" <?php echo $ps; ?>>Pradheshiya Sabha</option>
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
            echo '    <table class="table is-bordered is-striped is-hoverable" style="margin: auto;" id="search-result-table">';
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
                echo '<a class="button is-danger" href="../../org/' . $row['id'] . '" target="_blank" aria-haspopup="true">More</a>';
                echo '</td>';
                echo '</tr>';    
            }
            echo '        </tbody>';
            echo '    </table>';
            echo '</div>';
        }    
    ?>
    
</div>

<div class="notification is-success" id="success-notification">
    Organization added successfully!
</div>
<div class="notification is-danger" id="error-notification">
    An error occured when adding the organization! <br>
    Try again.
</div>
<?php echo form_open('organization/add', 'id="add-organization-form"'); ?>
    <?php
        $hasErrors = !empty($errors);
        $hasFormData = !empty($formData);
    ?>
    <div class="box">
        <h4 class="subtitle is-4">Organization Info</h4>
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="org-name">
            </div>
            <?php
                if ($hasErrors && isset($errors['org-name'])) {
                    echo '<p class="help is-danger">A name is required!</p>';
                }
            ?>
        </div>

        <div class="control">
            <label class="label">Type</label>
            <div class="select is-fullwidth">
                <select name="type">
                    <option value="hospital">Hospital</option>
                    <option value="fire-brigade">Fire Brigade</option>
                    <option value="ambulance-service">Ambulance Service</option>
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
            <label class="label">Address</label>
            <div class="control">
                <textarea class="textarea" type="text" name="address"> </textarea>
            </div>
            <?php
                if ($hasErrors && isset($errors['address'])) {
                    echo '<p class="help is-danger">Valid address is required!</p>';
                }
            ?>
        </div>

        <div class="box" id="location-box">
            <h5 class="subtitle is-5">Responding Areas</h5>
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
                        <option value="empty"></option>
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
                    <input class="input" type="text" id="town">
                </div>
            </div>

            <div class="field">
                <div class="control" id="locations"> </div>
            </div>

            <?php
                if ($hasErrors && isset($errors['location-list'])) {
                    echo '<p class="help is-danger">Atleast one responding area is required!</p> <br>';
                }
            ?>


            <input type="hidden" name="location-list" id="location-list" value="">

            <div class="field">
                <button class="button is-link is-rounded" id="add-location-btn" type="button">Add Area</button>
            </div>
        </div>

        <div class="field">
            <label class="label">Contact Number</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="org-contact" <?php if ($hasFormData) echo 'value="'.$formData['org_contact'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-phone"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['org-contact'])) {
                    echo '<p class="help is-danger">Contact number is required!</p>';
                }
            ?>
        </div>
            
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="email" name="org-email" <?php if ($hasFormData) echo 'value="'.$formData['org_email'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['org-email'])) {
                    echo '<p class="help is-danger">A valid email is required!</p>';
                }
            ?>
        </div>
        <br>
    </div>

    <div class="box">
        <h4 class="subtitle is-4">Admin Account Info</h4>
        <div class="field">
            <label class="label">First Name</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="first-name" <?php if ($hasFormData) echo 'value="'.$formData['first_name'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-address-card"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['first-name'])) {
                    echo '<p class="help is-danger">First name is required!</p>';
                }
            ?>
        </div>
        <div class="field">
            <label class="label">Last Name</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="last-name" <?php if ($hasFormData) echo 'value="'.$formData['last_name'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-address-card"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['last-name'])) {
                    echo '<p class="help is-danger">Last name is required!</p>';
                }
            ?>
        </div>
        <div class="field">
            <label class="label">Password</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="password" name="password">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['password'])) {
                    echo '<p class="help is-danger">Password is required!</p>';
                }
            ?>
        </div>
        <div class="field">
            <label class="label">Password confirmation</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="password" name="password2">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['password2'])) {
                    echo '<p class="help is-danger">Matching password is required!</p>';
                }
            ?>
        </div>
            
        <div class="field">
            <label class="label">Contact Number</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="contact" <?php if ($hasFormData) echo 'value="'.$formData['contact'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-phone"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['contact'])) {
                    echo '<p class="help is-danger">Contact number is required!</p>';
                }
            ?>
        </div>
            
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="email" name="email" <?php if ($hasFormData) echo 'value="'.$formData['email'].'"'; ?>>
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
            <?php
                if ($hasErrors && isset($errors['email'])) {
                    echo '<p class="help is-danger">A valid email is required!</p>';
                }
            ?>
        </div>
    </div>
    
    <br>

    <div class="field submit-btns">
        <button class="button is-link" type="submit">Add Organization</button>
        <button class="button is-danger" type="reset">Reset</button>
    </div>
<?php echo form_close(); ?>
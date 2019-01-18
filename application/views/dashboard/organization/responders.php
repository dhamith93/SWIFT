<div class="tabs is-centered">
    <ul>
        <li class="tab-header is-active" data-tab="0"><a>Search</a></li>
        <li class="tab-header" data-tab="1"><a>Add</a></li>
    </ul>
</div>
<div id="tab-content" class="tab-content">
    <div class="tab is-active" data-content="0">
        <div class="search-input-area is-centered">
            <?php echo form_open('organization/get-responders'); ?>
                <input type="hidden" name="org-id" value="<?php echo $orgId; ?>">
                <?php
                    $email = ''; 
                    $firstName = '';
                    $lastName = '';
                    $position = '';

                    if (!empty($searchType)) {
                        if ($searchType === 'first-name')
                        $firstName = 'selected';
                        if ($searchType === 'last-name')
                        $lastName = 'selected';
                        if ($searchType === 'email')
                            $email = 'selected';
                        if ($searchType === 'position')
                            $position = 'selected';
                    }
                ?>
                <div class="field has-addons is-centered">
                    <p class="control">
                        <span class="select is-rounded is-primary">
                            <select name="search-type">
                                <option value="first-name" <?php echo $firstName; ?>>First Name</option>
                                <option value="last-name" <?php echo $lastName; ?>>Last Name</option>
                                <option value="email" <?php echo $email; ?>>Email</option>
                                <option value="position" <?php echo $position; ?>>Position</option>
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
            <?php echo form_close(); ?>
        </div>
        <hr>
        <div class="columns search-result">
            <?php 
                $hasResponderResult = !empty($responderResult);
                $displayOpt = ($hasResponderResult) ? 'block' : 'none';
            ?>
            <div class="notification is-danger" id="no-record-notification">
                No records found!
            </div>
            <div class="notification is-success" id="delete-success-notification">
                Responder record deleted successfully!
            </div>
            <div class="notification is-danger" id="delete-error-notification">
                An error occured while updating responder records! <br>
                Try again.
            </div>

            <table class="table is-bordered is-striped is-hoverable" style="display:<?php echo $displayOpt; ?>;">
                <thead>
                    <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                            if ($hasResponderResult) {
                                foreach ($responderResult as $row) {
                                    echo '<tr>';
                                    echo '<td>' . ucfirst($row->first_name) . '</td>';
                                    echo '<td>' . ucfirst($row->last_name) . '</td>';
                                    echo '<td>' . ucfirst($row->contact) . '</td>';
                                    echo '<td>' . $row->email . '</td>';
                                    echo '<td>' . ucfirst($row->position) . '</td>';
                                    if ($row->is_admin !== '1') {
                                        echo '<td>';
                                        echo form_open('organization/make-admin', 'class="make-responder-admin-form"');
                                        echo '<input type="hidden" name="responder-id" value="' . $row->id . '"/>';
                                        echo '<input type="hidden" name="org-id" value="' . $orgId . '"/>';
                                        echo '<button class="button is-danger" type="submit">Make Admin</button>';
                                        echo form_close();
                                        echo '</td>';
                                        echo '<td>';
                                        echo form_open('organization/delete-responder', 'class="delete-responder-form"');
                                        echo '<input type="hidden" name="responder-id" value="' . $row->id . '"/>';
                                        echo '<button class="button is-danger" type="submit">Delete</button>';
                                        echo form_close();
                                        echo '</td>';
                                    } else {
                                        echo '<td> -- </td>';
                                        echo '<td> -- </td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab" data-content="1">
        <div class="notification is-success" id="success-notification">
            Responder added successfully!
        </div>
        <?php
            $hasErrors = !empty($errors);
            $hasFormData = !empty($formData);
        ?>
        <?php echo form_open('organization/add-responder'); ?>
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
                <label class="label">Position</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" name="position" <?php if ($hasFormData) echo 'value="'.$formData['position'].'"'; ?>>
                    <span class="icon is-small is-left">
                    <i class="fas fa-address-card"></i>
                    </span>
                </div>
                <?php
                    if ($hasErrors && isset($errors['position'])) {
                        echo '<p class="help is-danger">Position of the employee in the organization is required!</p>';
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
            <input type="hidden" name="org-id" value="<?php echo $orgId; ?>">
            <br>
            <div class="field is-grouped submit-btns">
                <div class="control">
                    <button class="button is-link is-rounded">Add Responder</button>
                </div>
                <div class="control">
                    <button class="button is-danger is-rounded" type="reset">Cancel</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
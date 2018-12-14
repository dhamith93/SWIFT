            <div class="tabs is-centered">
                <ul>
                    <li class="tab-header is-active" data-tab="0"><a>Search</a></li>
                    <li class="tab-header" data-tab="1"><a>Add</a></li>
                </ul>
            </div>
            <div id="tab-content" class="tab-content">
                <div class="tab is-active" data-content="0">
                    <div class="search-input-area is-centered">
                        <?php echo form_open('admin/get-employee'); ?>
                            <div class="field has-addons is-centered">
                                <p class="control">
                                    <input class="input" type="text" name="emp-id" placeholder="Employee ID">
                                </p>
                                <p class="control">
                                    <button class="button" type="submit">
                                        Search
                                    </button>
                                </p>
                            </div> 
                        </form>
                    </div>
                    <div class="columns search-result">
                        <?php 
                            $hasEmployeeResult = !empty($employeeResult);
                            $displayOpt = ($hasEmployeeResult) ? 'block' : 'none';
                        ?>
                        <div class="notification is-danger" id="no-record-notification">
                            No records found!
                        </div>
                        <div class="notification is-success" id="employee-delete-success-notification">
                            Employee record deleted successfully!
                        </div>
                        <div class="notification is-danger" id="employee-delete-error-notification">
                            An error occured when deleting employee! <br>
                            Try again.
                        </div>

                        <div class="card" id="employee-result" style="display:<?php echo $displayOpt; ?>;">
                            <header class="card-header">
                                <p class="card-header-title">
                                    <?php 
                                        if ($hasEmployeeResult)
                                            echo $employeeResult['first_name'] . ' ' . $employeeResult['last_name'];
                                    ?>
                                </p>                                
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <?php 
                                        if ($hasEmployeeResult) {
                                            echo '<strong>Employee ID:</strong> ' . $employeeResult['emp_id'] .'<br>';
                                            echo '<strong>Contact Number:</strong> ' . $employeeResult['contact'] .'<br>';
                                            echo '<strong>Email:</strong> ' . $employeeResult['email'] .'<br>';
                                            // echo '<strong>Last logged in:</strong>' . $employeeResult['last_logged_in'] .'<br>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <?php echo form_open('admin/delete-employee'); ?>
                                    <button class="button is-danger" name="emp-id" <?php if ($hasEmployeeResult) echo 'value="'.$employeeResult['emp_id'].'"'; ?> type="submit">Delete</button>
                                </form>
                            </footer>
                        </div>

                    </div>
                </div>
                <div class="tab" data-content="1">
                    <div class="notification is-success" id="success-notification">
                        Employee added successfully!
                    </div>
                    <div class="notification is-danger" id="employee-error-notification">
                        An error occured when adding employee! <br>
                        Try again.
                    </div>
                    <?php
                        $hasErrors = !empty($errors);
                        $hasFormData = !empty($formData);
                    ?>
                    <?php echo form_open('admin/add-employee'); ?>
                        <div class="field">
                            <label class="label">Employee ID</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="emp-id" <?php if ($hasFormData) echo 'value="'.$formData['emp_id'].'"'; ?>>
                              <span class="icon is-small is-left">
                                <i class="fas fa-address-card"></i>
                              </span>
                            </div>
                            <?php
                                if ($hasErrors && isset($errors['emp-id'])) {
                                    echo '<p class="help is-danger">Employee ID is required!</p>';
                                }
                            ?>
                        </div>
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
                              <input class="input" type="password" name="password" <?php if ($hasFormData) echo 'value="'.$formData['password'].'"'; ?>>
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
                                    echo '<p class="help is-danger">Email is required!</p>';
                                }
                            ?>
                        </div>
                          
                        <div class="field is-grouped">
                            <div class="control">
                              <button class="button is-link">Add Employee</button>
                            </div>
                            <div class="control">
                              <button class="button is-text" type="reset">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
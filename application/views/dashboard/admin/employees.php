            <div class="tabs is-centered">
                <ul>
                    <li class="tab-header is-active" data-tab="0"><a>Search</a></li>
                    <li class="tab-header" data-tab="1"><a>Add</a></li>
                </ul>
            </div>
            <div id="tab-content" class="tab-content">
                <div class="tab is-active" data-content="0">
                    <div class="search-input-area is-centered">
                        <div class="field has-addons is-centered">
                            <p class="control">
                                <input class="input" type="text" placeholder="Employee name">
                            </p>
                            <p class="control">
                                <button class="button">
                                    Search
                                </button>
                            </p>
                        </div> 
                    </div>
                    <div class="columns search-result">
                        
                    </div>
                </div>
                <div class="tab" data-content="1">
                    <?php echo form_open('admin/add-employee'); ?>
                        <div class="field">
                            <label class="label">Employee ID</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="emp-id">
                              <span class="icon is-small is-left">
                                <i class="fas fa-address-card"></i>
                              </span>
                            </div>
                          </div>
                        <div class="field">
                            <label class="label">First Name</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="first-name">
                              <span class="icon is-small is-left">
                                <i class="fas fa-address-card"></i>
                              </span>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Last Name</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="last-name">
                              <span class="icon is-small is-left">
                                <i class="fas fa-address-card"></i>
                              </span>
                            </div>
                          </div>
                          
                          <div class="field">
                            <label class="label">Username</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="username">
                              <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                              </span>
                            </div>
                          </div>
                          
                          <div class="field">
                            <label class="label">Password</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="password" name="password">
                              <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                              </span>
                            </div>
                          </div>
                          
                          <div class="field">
                            <label class="label">Contact Number</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="text" name="contact">
                              <span class="icon is-small is-left">
                                <i class="fas fa-phone"></i>
                              </span>
                            </div>
                          </div>
                          
                          <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left has-icons-right">
                              <input class="input" type="email" name="email">
                              <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                              </span>
                            </div>
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
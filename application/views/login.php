    <?php
        $hasErrors = !empty($errors);
        $hasFormData = !empty($formData);
        $displayOpt = ($hasErrors && !empty($errors['loginError'])) ? 'block' : 'none';
    ?>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <div class="box" id="login-box">
                        <figure class="avatar">
                            <img src="<?php echo base_url(); ?>assets/images/swift_logo_128.png">
                        </figure>
                        <h3 class="title has-text-grey">SWIFT</h3>
                        <p class="subtitle has-text-grey">Please login to proceed.</p>
                        <div class="notification is-warning" style="display:<?php echo $displayOpt;?>;">
                            Password/username incorrect or account does not exists!<br>
                            Please contact admin for more information.
                        </div>
                        <?php echo form_open('login/go', 'id="login-form"'); ?>
                            <input type="hidden" name="date-time" id="date-time">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-rounded" name="username" type="text" <?php if ($hasFormData) echo 'value="'.$formData['username'].'"'; ?> placeholder="Username" autofocus="">
                                </div>
                                <?php
                                    if ($hasErrors && isset($errors['username'])) {
                                        echo '<p class="help is-danger">Username is required!</p>';
                                    }
                                ?>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-rounded" name="password" type="password" placeholder="Password">
                                </div>
                                <?php
                                    if ($hasErrors && isset($errors['password'])) {
                                        echo '<p class="help is-danger">Password is required!</p>';
                                    }
                                ?>
                            </div>
                            <div class="select is-rounded is-fullwidth">
                                <select name="acct-type">
                                    <option>Employee</option>
                                    <option>Organization</option>
                                    <option>Responder</option>
                                </select>
                            </div>       
                            <br><br>                
                            <button class="button is-info is-rounded">Login</button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var loginForm = document.getElementById('login-form');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                let dateTime = new Date();
                document.getElementById('date-time').value = new Date(dateTime.getTime() - (dateTime.getTimezoneOffset() * 60000)).toISOString().slice(0, 19).replace('T', ' ');
                loginForm.submit();
            });
        }
    
    </script>
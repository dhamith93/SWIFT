<div class="section" style="width:600px; margin:auto;">
    <h3 class="subtitle is-4">Change Password</h3>

    <div class="box">
        <?php echo form_open_multipart('organization/change-password'); ?>
        <input type="hidden" name="username" <?php echo 'value="'.$this->session->userdata('username').'"'; ?>>
        <div class="field">
            <label class="label">Current Password</label>
            <div class="control">
                <input class="input" type="password" name="current" required>
            </div>
        </div>
        <div class="field">
            <label class="label">New Password</label>
            <div class="control">
                <input class="input" type="password" name="new" required>
            </div>
        </div>
        <div class="field">
            <label class="label">New Password Confim</label>
            <div class="control">
                <input class="input" type="password" name="new-confirm" required>
            </div>
        </div>
        <button class="button is-danger" type="submit">Change</button>
        <?php echo form_close(); ?>
    </div>
</div>
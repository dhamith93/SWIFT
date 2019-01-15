<?php
    $hasErrors = !empty($errors);
?>

<div class="section" style="width:600px; margin:auto;">
    <div class="box">
        <?php echo form_open('employee/settings/change_pw'); ?>
        <div class="field">
            <label class="label">Current Password</label>
            <div class="control">
                <input class="input" type="password" name="current">
            </div>
            <?php
                if ($hasErrors && isset($errors['current'])) {
                    echo '<p class="help is-danger">Current password is invalid!</p>';
                }
            ?>
        </div>
        <div class="field">
            <label class="label">New password</label>
            <div class="control">
                <input class="input" type="password" name="new">
            </div>
            <?php
                if ($hasErrors && isset($errors['new'])) {
                    echo '<p class="help is-danger">Password cannot be empty!</p>';
                }
            ?>
        </div>
        <div class="field">
            <label class="label">Confirm new password</label>
            <div class="control">
                <input class="input" type="password" name="new-confirm">
            </div>
            <?php
                if ($hasErrors && isset($errors['new-confirm'])) {
                    echo '<p class="help is-danger">Password cannot be empty!</p>';
                }
            ?>
        </div>

        <button class="button is-danger" type="submit">Change</button>

        <?php echo form_close(); ?>
    </div>
</div>
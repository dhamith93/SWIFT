<style>
.file-name {
    display: none;
}
</style>

<?php 
    $hasOrgInfo = !empty($org);
    if ($hasOrgInfo)
        $org = $org[0];
?>

<div class="section" style="width:600px; margin:auto;">
    <h3 class="subtitle is-4">Organization Info</h3>

    <p>Change the feild(s) you want to update.

    <br>

    <div class="box">
        <?php echo form_open_multipart('organization/change-info'); ?>
        <input type="hidden" name="org-id" <?php if ($hasOrgInfo) echo 'value="'.$org->id.'"'; ?>>
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" required <?php if ($hasOrgInfo) echo 'value="'.$org->name.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Address</label>
            <div class="control">
                <textarea class="textarea is-info" name="address" required><?php if ($hasOrgInfo) echo $org->address; ?></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" required <?php if ($hasOrgInfo) echo 'value="'.$org->email.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Contact number</label>
            <div class="control">
                <input class="input" type="tel" name="contact" required <?php if ($hasOrgInfo) echo 'value="'.$org->contact.'"'; ?>>
            </div>
        </div>
        <button class="button is-danger" type="submit">Update</button>
        <?php echo form_close(); ?>
    </div>
</div>
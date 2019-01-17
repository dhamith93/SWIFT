<style>
.file-name {
    display: none;
}
</style>

<?php 
    $hasCompanyInfo = !empty($companyInfo);
?>

<div class="section" style="width:600px; margin:auto;">
    <h3 class="subtitle is-4">Company Info</h3>

    <p>Change the feild(s) you want to update.<br>Clear the feilds that you want to remove from system.</p>

    <br>

    <div class="box">
        <?php echo form_open_multipart('admin/change-info'); ?>
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" required <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->name.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Slogan</label>
            <div class="control">
                <input class="input" type="text" name="slogan" <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->slogan.'"'; ?>>
            </div>
        </div>

        <div style="display:flex">            
                <div class="field" style="margin-right:15px;">
                    <div class="file is-info">
                        <label class="file-label">
                            <input class="file-input" type="file" name="logo" id="logo">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Select Logo
                                </span>
                            </span>
                            <span class="file-name" id="logo-name"></span>
                        </label>
                    </div>
                </div>
        
                <div class="field">
                    <div class="file is-info">
                        <label class="file-label">
                            <input class="file-input" type="file" name="cover" id="cover">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Select Cover Image
                                </span>
                            </span>
                            <span class="file-name" id="cover-name"></span>
                        </label>
                    </div>
                </div>
        </div>

        <div class="field">
            <label class="label">Address</label>
            <div class="control">
                <textarea class="textarea is-info" name="address" required><?php if ($hasCompanyInfo) echo $companyInfo->address; ?></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" required <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->email.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Contact number 1</label>
            <div class="control">
                <input class="input" type="tel" name="contact_1" required <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->contact_1.'"'; ?>>
            </div>
        </div>

        <div class="field">
            <label class="label">Contact number 2</label>
            <div class="control">
                <input class="input" type="tel" name="contact_2" <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->contact_2.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Contact number 3</label>
            <div class="control">
                <input class="input" type="tel" name="contact_3" <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->contact_3.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Contact number 4</label>
            <div class="control">
                <input class="input" type="tel" name="contact_4" <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->contact_4.'"'; ?>>
            </div>
        </div>
        <div class="field">
            <label class="label">Contact number 5</label>
            <div class="control">
                <input class="input" type="tel" name="contact_5" <?php if ($hasCompanyInfo) echo 'value="'.$companyInfo->contact_5.'"'; ?>>
            </div>
        </div>

        <button class="button is-danger" type="submit">Update</button>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
var logo = document.getElementById('logo');
var cover = document.getElementById('cover');

logo.addEventListener('change', () => {
    if(logo.files.length > 0) {
        document.getElementById('logo-name').innerHTML = logo.files[0].name;
        document.getElementById('logo-name').style.display = 'block';
    }
});

cover.addEventListener('change', () => {
    if(cover.files.length > 0) {
        document.getElementById('cover-name').innerHTML = cover.files[0].name;
        document.getElementById('cover-name').style.display = 'block';
    }
});

</script>
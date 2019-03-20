<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/organization.css">

<div class="container">
    <div class="columns">
        <div class="column">
            <h2 class="subtitle is-4">Organization Information</h2>
            <?php
                $this->view('organization/information');
            ?>
        </div>

        <div class="column">
            <h2 class="subtitle is-4">Responders</h2>
            <?php
                $this->view('organization/responders');
            ?>
        </div>
    </div>

</div>
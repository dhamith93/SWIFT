<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/incident.css">

<script>
    var incidentId = <?php echo $id;?>

    <?php 
        if (!empty($incident[$id]['lat']) && !empty($incident[$id]['lng'])) {
            echo 'var lat = ' . $incident[$id]['lat'] . ';';
            echo 'var lng = ' . $incident[$id]['lng'] . ';';
        } else {
            echo 'var lat = 7.8731;';
            echo 'var lng = 80.7718;';
        }

        if (!empty($incident[$id]['geocodes'])) {
            echo 'var locations = {';
            foreach ($incident[$id]['geocodes'] as $geocode) {
                echo $geocode['name'] . ': {';
                echo '\'lat\':' . $geocode['lat'] . ',';
                echo '\'lng\':' . $geocode['lng'];
                echo '},';

            }
            echo '};';
        }
    ?>
</script>

<div class="background"></div>

<div class="container">
    <h1 class="title">
        Incident: <?php echo ucfirst($incident[$id]['name']); ?>
        <span class="subtitle is-6">
            <?php 
                echo '';
                echo ucfirst($incident[$id]['date']);
                echo ' - '; 
                echo ucfirst($incident[$id]['time']);
            ?>
        </span>
    </h1>
    <h2 class="subtitle is-4">Type: <?php echo ucfirst($incident[$id]['type']); ?></h2>

    <div class="tabs is-centered">
        <ul>
            <li class="tab-header is-active" data-tab="0"><a>Information</a></li>
            <li class="tab-header" data-tab="1"><a>Alerts & Warnings</a></li>
            <li class="tab-header" data-tab="2"><a>Gallery</a></li>
            <li class="tab-header" data-tab="3"><a>Responders</a></li>
            <li class="tab-header" data-tab="4"><a>Requests</a></li>
            <li class="tab-header" data-tab="5"><a>Tasks</a></li>
            <li class="tab-header" data-tab="6"><a>Message Board</a></li>
            <?php 
                if ($this->session->userdata('user_type') === 'Employee')
                    echo '<li class="tab-header" data-tab="7"><a>Press Releases</a></li>';
            ?>
        </ul>
    </div>
    <div id="tab-content" class="tab-content">
        <div class="tab is-active" data-content="0">

            <?php
                $this->view('incident/information');
            ?>

        </div>
        <div class="tab" data-content="1">

            <?php
                $this->view('incident/alerts_warnings');
            ?>
                            
        </div>
        <div class="tab" data-content="2">

            <?php
                $this->view('incident/media');
            ?>

        </div>
        <div class="tab" data-content="3">

            <?php
                $this->view('incident/responders');
            ?>

        </div>
        <div class="tab" data-content="4">
        </div>
        <div class="tab" data-content="5">
            <?php
                $this->view('incident/tasks');
            ?>
        </div>
        <div class="tab" data-content="6">
        </div>
        <?php 
            if ($this->session->userdata('user_type') === 'Employee') {
                echo '<div class="tab" data-content="7">';
                $this->view('incident/press_releases');
                echo '</div>';
            }
        ?>
        
    </div>

</div>

<script src="<?php echo base_url(); ?>assets/scripts/incident.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('geocode_api'); ?>&callback=initMap"></script>
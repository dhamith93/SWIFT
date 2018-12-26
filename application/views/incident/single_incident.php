<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/incident.css">

<script>
    var incidentId = <?php echo $id;?>
</script>

<div class="background"></div>

<div class="container">
    <h1 class="title">Incident: <?php echo ucfirst($incident[$id]['name']); ?></h1>
    <h2 class="subtitle is-4">Type: <?php echo ucfirst($incident[$id]['type']); ?></h2>

    <div class="tabs is-centered">
        <ul>
            <li class="tab-header is-active" data-tab="0"><a>Information</a></li>
            <li class="tab-header" data-tab="1"><a>Alerts & Warnings</a></li>
            <li class="tab-header" data-tab="2"><a>Gallary</a></li>
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
        </div>
        <div class="tab" data-content="6">
        </div>
        <?php 
            if ($this->session->userdata('user_type') === 'Employee') {
                echo '<div class="tab" data-content="7">';
                echo '</div>';
            }
        ?>
        
    </div>

</div>

<script src="<?php echo base_url(); ?>assets/scripts/incident.js"></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=[API_KEY]&callback=initMap"></script> -->
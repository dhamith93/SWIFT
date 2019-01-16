<link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/incident.css">

<div class="columns dashboard-columns">
        <div class="column vert-nav-column is-one-fifth">
            <nav class="navbar is-link" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item dashboard-title" href="#">
                        <img src="<?php echo base_url(); ?>assets/images/swift_logo_128.png">
                        <span class="title is-5">SWIFT</span>
                    </a>

                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="main-navbar">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
            </nav>
            <?php 
                $this->view('templates/incident-nav');
            ?>
        </div>
        <div class="column is-four-fifths dashboard-selected-column">
                <!-- <nav class="navbar is-warning" role="navigation" aria-label="main navigation">
                    <div class="navbar-brand">
                        <h1 class="navbar-item title is-5">
                            <?php //echo $title; ?>
                        </h1>
                    </div>
                </nav> -->
        <?php
            switch (lcfirst($title)) {
                case 'information':
                    $view = 'incident/information';
                    break;
                case 'alerts-warnings':
                    $view = 'incident/alerts_warnings';
                    break;
                case 'media':
                    $view = 'incident/media';
                    break;
                case 'responders':
                    $view = 'incident/responders';
                    break;
                case 'requests':
                    $view = 'incident/requests';
                    break;
                case 'tasks':
                    $view = 'incident/tasks';
                    break;
                case 'messageboard':
                    $view = 'incident/messageboard';
                    break;
                case 'press-releases':
                    $view = 'incident/press_releases';
                    break;
                default:
                    $view = 'incident/information';
                    break;
            }

            $this->view($view);
        ?>
    </div>
</div>
<script>
    var incidentId = <?php echo $id; ?>;

    <?php 
        if ($incident[$id]['geocodes']) {
            if (!empty($incident[$id]['lat']) && !empty($incident[$id]['lng'])) {
                echo 'var lat = ' . $incident[$id]['lat'] . ';';
                echo 'var lng = ' . $incident[$id]['lng'] . ';';
            } else {
                echo 'var lat = 7.8731;';
                echo 'var lng = 80.7718;';
            }
            
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
<script src="<?php echo base_url(); ?>assets/scripts/incident.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo getenv('geocode_api'); ?>&callback=initMap"></script>
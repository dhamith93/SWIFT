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
                $this->view('templates/incident-res-nav');
            ?>
        </div>
        <div class="column is-four-fifths dashboard-selected-column">
        <?php
            switch (lcfirst($title)) {
                case 'information':
                    $view = 'dashboard/responder/incident/information';
                    break;
                case 'alerts-warnings':
                    $view = 'dashboard/responder/incident/alerts_warnings';
                    break;
                case 'media':
                    $view = 'incident/media';
                    break;
                case 'requests':
                    $view = 'dashboard/responder/incident/requests';
                    break;
                case 'tasks':
                    $view = 'dashboard/responder/incident/tasks';
                    break;
                case 'messageboard':
                    $view = 'dashboard/responder/incident/messageboard';
                    break;
                default:
                    $view = 'dashboard/responder/incident/information';
                    break;
            }

            $this->view($view);
        ?>
    </div>
</div>
<script>
    const incidentId = <?php echo $id; ?>;
    const orgId = <?php echo $orgId; ?>;
</script>
<script src="<?php echo base_url(); ?>assets/scripts/incident.js"></script>
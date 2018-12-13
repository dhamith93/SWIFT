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
            <?php $this->view('templates/admin-nav'); ?>
        </div>
        <div class="column is-four-fifths dashboard-selected-column">
                <nav class="navbar is-warning" role="navigation" aria-label="main navigation">
                    <div class="navbar-brand">
                        <h1 class="navbar-item title is-5">
                            <?php echo $title; ?>
                        </h1>
                    </div>
                </nav>
        <?php
            switch (lcfirst($title)) {
                case 'employees':
                    $view = 'employees';
                    break;
                case 'organizations':
                    $view = 'organizations';
                    break;
                case 'company':
                    $view = 'company';
                    break;
                case 'settings':
                    $view = 'settings';
                    break;
                default:
                    $view = 'employees';
                    break;
            }

            $this->view('dashboard/admin/'.$view);
        ?>
    </div>
    <script src="<?php echo base_url(); ?>assets/scripts/dashboard.js"></script>
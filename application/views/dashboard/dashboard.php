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
                if ($section === 'admin')
                    $this->view('templates/admin-nav');

                if ($section === 'employee')
                    $this->view('templates/employee-nav');

                if ($section === 'organization')
                    $this->view('templates/organization-nav');
            ?>
        </div>
        <div class="column is-four-fifths dashboard-selected-column">
        <?php
            if ($section === 'admin' || $section === 'employee') {
                switch (lcfirst($title)) {
                    case 'employees':
                        $view = 'dashboard/admin/employees';
                        break;
                    case 'company':
                        $view = 'dashboard/admin/company';
                        break;
                    case 'settings':
                        $view = 'dashboard/employee/settings';
                        break;
                    case 'incidents':
                        $view = 'dashboard/employee/incidents';
                        break;
                    case 'organizations':
                        $view = 'dashboard/employee/organizations';
                        break;
                    default:
                        $view = ($section === 'admin') ? 'dashboard/admin/employees' : 'dashboard/employee/incidents';
                        break;
                }
            }

            if ($section === 'organization') {
                switch (lcfirst($title)) {
                    case 'incidents':
                        $view = 'dashboard/organization/incidents';
                        break;
                    case 'alerts':
                        $view = 'dashboard/organization/alerts';
                        break;
                    case 'tasks':
                        $view = 'dashboard/organization/tasks';
                        break;
                    case 'responders':
                        $view = 'dashboard/organization/responders';
                        break;
                    case 'settings':
                        $view = 'dashboard/organization/settings';
                        break;
                    default:
                        $view = ($section === 'admin') ? 'dashboard/admin/employees' : 'dashboard/employee/incidents';
                        break;
                }

            }

            if (!empty($view))
                $this->view($view);
        ?>
    </div>
    </div>
    <script>
        var section = '<?php echo $section; ?>';
        var view = '<?php echo lcfirst($title); ?>';
    </script>
    <script src="<?php echo base_url(); ?>assets/scripts/dashboard.js"></script>
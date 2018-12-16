<nav class="dashboard-nav" id="dashboard-nav">
    <ul>
        <li class="vert-nav-item" id="incidents"><a href="<?php echo base_url(); ?>employee/incidents/">Incidents</a></li>
        <li class="vert-nav-item" id="organizations"><a href="<?php echo base_url(); ?>employee/organizations/">Organizations</a></li>
        <li class="vert-nav-item" id="settings"><a href="<?php echo base_url(); ?>employee/settings/">Settings</a></li>
        <li class="vert-nav-item" id="logout"><a href="<?php echo base_url(); ?>logout">Log out</a></li>
    </ul>
</nav>

<script>
    let element = document.getElementById('<?php echo lcfirst($title); ?>');
    element.classList.add('nav-item-active');
</script>
<nav class="dashboard-nav" id="dashboard-nav">
    <ul>
        <li class="vert-nav-item" id="incidents"><a href="<?php echo base_url(); ?>organization/incidents/">On Going Incidents</a></li>
        <li class="vert-nav-item" id="alerts"><a href="<?php echo base_url(); ?>organization/alerts/">Alerts</a></li>
        <li class="vert-nav-item" id="tasks"><a href="<?php echo base_url(); ?>organization/tasks/">Tasks</a></li>
        <li class="vert-nav-item" id="responders"><a href="<?php echo base_url(); ?>organization/responders/">Responders</a></li>
        <li class="vert-nav-item" id="settings"><a href="<?php echo base_url(); ?>organization/settings/">Settings</a></li>
        <li class="vert-nav-item" id="logout"><a href="<?php echo base_url(); ?>logout">Log out</a></li>
    </ul>
</nav>

<script>
    let element = document.getElementById('<?php echo lcfirst($title); ?>');
    element.classList.add('nav-item-active');
</script>
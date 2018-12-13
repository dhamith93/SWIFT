<nav class="dashboard-nav" id="dashboard-nav">
    <ul>
        <li class="vert-nav-item" id="employees"><a href="<?php echo base_url(); ?>admin/employees/">Employees</a></li>
        <li class="vert-nav-item" id="organizations"><a href="<?php echo base_url(); ?>admin/organizations/">Organizations</a></li>
        <li class="vert-nav-item" id="company"><a href="<?php echo base_url(); ?>admin/company/">Company Info</a></li>
        <li class="vert-nav-item" id="settings"><a href="<?php echo base_url(); ?>admin/settings/">Admin Settings</a></li>
    </ul>
</nav>

<script>
    let element = document.getElementById('<?php echo lcfirst($title); ?>');
    element.classList.add('nav-item-active');
</script>
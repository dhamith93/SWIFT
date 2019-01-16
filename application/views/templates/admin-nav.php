<nav class="dashboard-nav" id="dashboard-nav">
    <ul>
        <li class="vert-nav-item" id="employees"><a href="<?php echo base_url(); ?>admin/employees/">Employees</a></li>
        <li class="vert-nav-item" id="company"><a href="<?php echo base_url(); ?>admin/company/">Company Info</a></li>
        <li class="vert-nav-item" id="emp-dash"><a href="<?php echo base_url(); ?>employee">Emp. Dashboard</a></li>
        <li class="vert-nav-item" id="logout"><a href="<?php echo base_url(); ?>logout">Log out</a></li>
    </ul>
</nav>

<script>
    let element = document.getElementById('<?php echo lcfirst($title); ?>');
    element.classList.add('nav-item-active');
</script>
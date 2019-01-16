<nav class="dashboard-nav" id="dashboard-nav">
    <ul>
        <li class="vert-nav-item" id="information"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>information">Information</a></li>
        <li class="vert-nav-item" id="alerts-warnings"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>alerts-warnings">Alerts & Warnings</a></li>
        <li class="vert-nav-item" id="media"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>media">Media</a></li>
        <li class="vert-nav-item" id="responders"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>responders">Responders</a></li>
        <li class="vert-nav-item" id="requests"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>requests">Requests</a></li>
        <li class="vert-nav-item" id="tasks"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>tasks">Tasks</a></li>
        <li class="vert-nav-item" id="messageboard"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>messageboard">Messageboard</a></li>
        <li class="vert-nav-item" id="press-releases"><a href="<?php echo base_url(); ?>incident/<?php echo $id.'/'; ?>press-releases">Press Releases</a></li>
    </ul>
</nav>

<script>
    let element = document.getElementById('<?php echo lcfirst($title); ?>');
    element.classList.add('nav-item-active');
</script>
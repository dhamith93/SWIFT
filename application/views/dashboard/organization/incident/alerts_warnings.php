<div class="section">
    <div class="columns">
        <div class="column">
            <h4 class="subtitle is-4">Alerts</h4>
            <div id="alerts" class="box">
                <?php foreach ($alerts as $alert): ?>
                <div class="alert notification is-danger" id="alert-<?php echo $alert->id; ?>">
                    <p><?php echo $alert->content; ?></p>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="column">
            <h4 class="subtitle is-4">Hazard warnings</h4>
                <textarea class="textarea" id="warning" disabled><?php echo $incident[$id]['warning']; ?></textarea>
        </div>
    </div>
</div>
<div class="columns">
    <div class="column">
        <h4 class="subtitle is-4">Alerts</h4>
        <div id="alerts">

            <?php
                foreach ($alerts as $alert):
            ?>

            <div class="alert notification is-danger" id="alert-<?php echo $alert->id; ?>">
                <button class="delete alert-delete-btn" data-alert-id="<?php echo $alert->id; ?>"></button>
                <?php echo $alert->content; ?>
            </div>

            <?php endforeach;?>
        </div>
        <br>
        <textarea id="add-alert" class="textarea"></textarea>
        <br>
        <button class="button is-link" id="add-alert-btn">Add</button>
    </div>
    <div class="column">
        <h4 class="subtitle is-4">Hazard warnings</h4>
            <textarea class="textarea"><?php echo $incident[$id]['warning']; ?></textarea>
            <br>
            <button class="button is-link" id="update-evac-btn">Update</button>
    </div>
</div>
<div id="gallery">

<?php
    if (!empty($images)) {
        echo '<h3 class="subtitle is-4">Images</h3>';
        
        foreach ($images as $image) {
            $src = base_url() . 'assets/media/' . $id . '/images/' . $image;

            echo '<figure class="image incident-media" data-src="' . $src . '" data-media-type="image">';
            echo '<img src="' . $src . '" title="' . $image . '">';
            echo '</figure> ';
        }
    }
?>

<hr>

<?php
    if (!empty($videos)) {
        echo '<h3 class="subtitle is-4">Videos</h3>';

        foreach ($videos as $video) {
            $src = base_url() . 'assets/media/' . $id . '/videos/' . $video;

            echo '<figure class="image incident-media" data-src="' . $src . '" data-media-type="video">';
            echo '<video src="' . $src . '" title="' . $video . '">';
            echo '</figure> ';
        }

        echo '<hr>';
    }
?>

</div>

<!-- <section class="section"> -->
<div id="upload">
    <h3 class="subtitle is-4">Add new media</h3>

    <?php echo form_open_multipart('incident/upload-image/' . $id);?>    
    <div class="field">
    <div class="file is-danger has-name is-boxed">
        <label class="file-label">
            <input class="file-input" type="file" name="user-image" id="user-image" accept="image/*" onChange="fillFileName('image')">
            <span class="file-cta">
                <span class="file-icon">
                <i class="fas fa-cloud-upload-alt"></i>
                </span>
                <span class="file-label">
                Select Image File
                </span>
            </span>
            <span class="file-name" id="image-file-name" style="text-align:center;">Please select a file</span>
        </label>
        </div>
    </div>
    
    <button class="button is-primary" type="submit">Upload Image</button>
    <?php echo form_close(); ?>

    <?php echo form_open_multipart('incident/upload-video/' . $id);?>
    <div class="field">
    <div class="file is-danger has-name is-boxed">
        <label class="file-label">
            <input class="file-input" type="file" name="user-video" id="user-video" accept=".mp4" onChange="fillFileName('video')">
            <span class="file-cta">
                <span class="file-icon">
                <i class="fas fa-cloud-upload-alt"></i>
                </span>
                <span class="file-label">
                Select Video File
                </span>
            </span>
            <span class="file-name" id="video-file-name" style="text-align:center;">Please select a file</span>
        </label>
        </div>
    </div>

    <input type="hidden" name="test" value="test">
    
    <button class="button is-primary" type="submit">Upload Video</button>
    <?php echo form_close(); ?>
<!-- </section> -->
</div>

<div class="modal" id="media-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
    <video id="modal-video" src="" autoplay controls></video>
    <p class="image">
      <a id="modal-link" href="" target="_blank" rel="noopener noreferrer">
        <img id="modal-img" src="">
      </a>
    </p>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
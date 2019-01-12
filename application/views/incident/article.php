<style>
figure {
    cursor: pointer;
    display: inline-block !important;
    margin: 20px;
    width: 128px;
}

figure img:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
}

#img-url {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    direction: rtl;
    text-align: left;
}
</style>


<div class="container"> 
    <br><br>
    <input class="input" type="text" id="title" placeholder="Title" value="<?php if (!empty($article)) echo $article->title; ?>">
    <br><br>
    <textarea name="content" id="editor"><?php if (!empty($article)) echo $article->content; ?></textarea>
    <br><br>
    <button class="button is-primary" id="img-btn">Insert Image</button>
    <button class="button is-danger" id="save-btn">Save</button>
    <button class="button is-link" id="publish-btn">Publish</button>

    <script src="/assets/ckeditor/ckeditor.js"></script>
</div>

<div class="modal" id="modal">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">
        <?php
            if (!empty($images)) {
                echo '<div class="field has-addons is-centered">';
                echo '    <p class="control" style="width:100%;">';
                echo '        <input class="input is-primary" type="text" id="img-url" >';
                echo '    </p>';
                echo '    <p class="control">';
                echo '        <button class="button is-primary" id="copy-btn" type="submit">';
                echo '            Copy';
                echo '        </button>';
                echo '    </p>';
                echo '</div> ';
                
                foreach ($images as $image) {
                    $src = base_url() . 'assets/media/' . $id . '/images/' . $image;

                    echo '<figure class="image incident-media" data-src="' . $src . '" data-media-type="image">';
                    echo '<img src="' . $src . '" title="' . $image . '">';
                    echo '</figure> ';
                }
            } else {
                echo '<p>No images found. Please upload images to gallary before adding them.</p>';
            }
        ?>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>

<script>
    var id = <?php echo $id; ?>;
    <?php 
        if (!empty($article)) {
            echo 'var articleId = '.$article->id.';';
        } else {
            echo 'var articleId = -1;';
        }
    ?>
</script>

<script defer src="<?php echo base_url(); ?>assets/scripts/article.js"></script>
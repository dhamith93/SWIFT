<div id="press-releases">
    <a href="../article/add/<?php echo $id; ?>" target="_blank" class="button is-danger">Add new article</a>
    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="responders-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date Time</th>
                <th>Is Published</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if (!empty($pressReleases)) {        
                foreach ($pressReleases as $row) {
                    echo '<tr>';
                    echo '<td>';
                    echo $row->title;
                    echo '</td>';
                    echo '<td>';
                    echo $row->published_date;
                    echo '</td>';
                    echo '<td>';
                    if ($row->is_published === '0') {
                        echo '<button class="button is-warning publishBtn" data-article-id="' . $row->id  . '">Publish</button>';
                    } else {
                        echo '<button class="button is-danger unPublishBtn" data-article-id="' . $row->id  . '">Unpublish</button>';
                    }
                    echo '</td>';
                    echo '<td>';
                    echo '<button class="button is-link editArticleBtn" data-article-id="' . $row->id  . '">Edit</button>';
                    echo '</td>';
                    echo '<td>';
                    echo '<button class="button is-danger deleteArticleBtn" data-article-id="' . $row->id  . '">Delete</button>';
                    echo '</td>';
                    echo '</tr>';    
                }
            }    
        ?>
        </tbody>
</div>
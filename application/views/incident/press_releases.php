<div class="section">
    <div id="press-releases">
        <a href="../../article/add/<?php echo $id; ?>" target="_blank" class="button is-danger">Add new article</a>

        <?php 
            if (!empty($pressReleases)) {
                echo '<table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="responders-table">';
                echo '<thead>';
                echo '    <tr>';
                echo '        <th>Title</th>';
                echo '        <th>Date Time</th>';
                echo '        <th></th>';
                echo '        <th></th>';
                echo '        <th></th>';
                echo '    </tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($pressReleases as $row) {
                    $publishBtnDisplay = ($row->is_published === '0') ? 'block' : 'none';
                    $unpublishBtnDisplay = ($row->is_published === '1') ? 'block' : 'none';
                    echo '<tr id="article-'.$row->id.'">';
                    echo '<td>';
                    echo $row->title;
                    echo '</td>';
                    echo '<td>';
                    echo $row->published_date;
                    echo '</td>';
                    echo '<td>';
                    echo '<button class="button is-warning publish-btn" id="pub-'.$row->id.'" data-article-id="'.$row->id.'" style="display: '.$publishBtnDisplay.';">Publish</button>';
                    echo '<button class="button is-danger unpublish-btn" id="unpub-'.$row->id.'" data-article-id="'.$row->id.'" style="display: '.$unpublishBtnDisplay.';">Unpublish</button>';
                    echo '</td>';
                    echo '<td>';
                    echo '<a class="button is-link" href="../../article/edit/'.$row->id.'?incId='.$id.'" target="_blank">Edit</a>';
                    echo '</td>';
                    echo '<td>';
                    echo '<button class="button is-danger delete-btn" data-article-id="'.$row->id.'">Delete</button>';
                    echo '</td>';
                    echo '</tr>';    
                }
            echo '     </tbody>';
            echo ' </table>';
            } else {
                echo '<p style="text-align: center;">No press releases for this incident yet...</p>';
            }
        ?>
            
    </div>
</div>
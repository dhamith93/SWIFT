<div class="section">
    <a class="button is-success" id="add-responders-btn">
        <span class="icon is-small">
            <i class="fas fa-chevron-down animated flipInX btn-icon" id="btn-icon"></i>
        </span>
        <span>Add More</span>
    </a>

    <div class="is-hidden" id="search-area">
        <div class="search-input-area is-centered">
            <div class="field has-addons is-centered">
                <p class="control">
                    <span class="select is-rounded is-primary">
                        <select id="resp-search-type">
                            <option value="all">All Available</option>
                            <option value="first-name">First Name</option>
                            <option value="last-name">Last Name</option>
                            <option value="email">Email</option>
                            <option value="position" >Position</option>
                        </select>
                    </span>
                </p>
                <p class="control">
                    <input class="input is-rounded is-primary" type="text" id="resp-search-value">
                </p>
                <p class="control">
                    <button class="button is-rounded is-primary" id="search-responders-btn">
                        Search
                    </button>
                </p>
            </div>
        </div>

        <br>

        <div class="result">
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="search-result-table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Position</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <br>
    <div class="result">
        <table class="table is-bordered is-striped is-hoverable" style="margin: auto;" id="org-responders-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>

            <?php
                if (!empty($responders)) {        
                    foreach ($responders as $row) {
                        echo '<tr>';
                        echo '<td>';
                        echo $row->first_name;
                        echo '</td>';
                        echo '<td>';
                        echo $row->last_name;
                        echo '</td>';
                        echo '<td>';
                        echo $row->position;
                        echo '</td>';
                        echo '<td>';
                        echo $row->contact;
                        echo '</td>';
                        echo '<td>';
                        echo $row->email;
                        echo '</td>';
                        echo '</tr>';    
                    }
                }    
            ?>
            </tbody>
        </table>
    </div>
    <br>
</div>
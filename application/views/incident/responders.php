<div class="result">
    <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="responders-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        <?php 
            if (!empty($responders)) {        
                foreach ($responders as $row) {
                    echo '<tr>';
                    echo '<td>';
                    echo $row->name;
                    echo '</td>';
                    echo '<td>';
                    echo $row->type;
                    echo '</td>';
                    echo '<td>';
                    echo $row->address;
                    echo '</td>';
                    echo '<td>';
                    echo $row->contact;
                    echo '</td>';
                    echo '<td>';
                    echo $row->email;
                    echo '</td>';
                    echo '<td>';
                    echo '<a class="button is-danger" href="../organization/' . $row->id . '" target="_blank" aria-haspopup="true">More</a>';
                    echo '</td>';
                    echo '</tr>';    
                }
            }    
        ?>
        </tbody>
    </table>
</div>

<a class="button is-success" id="add-responders-btn">
    <span class="icon is-small">
        <i class="fas fa-chevron-down animated flipInX btn-icon" id="btn-icon"></i>
    </span>
    <span>Add More</span>
</a>

<div class="is-hidden" id="search-area">
    <br>
    <div class="search">
        <p class="control">
            <span class="select is-primary">
                <select id="org-type">
                    <option value="1">Hospital</option>
                    <option value="2">Fire Brigade</option>
                    <option value="3">Ambulance Service</option>
                    <option value="4">Police</option>
                    <option value="5">Search and Rescue</option>
                    <option value="6">Military</option>
                    <option value="7">Provincial Council</option>
                    <option value="8">Urban Council</option>
                    <option value="9">Pradheshiya Sabha</option>
                </select>
            </span>

            <span style="line-height: 2rem;">in</span>

            <span>
                <input class="input is-primary" type="text" id="search-value">
            </span>

            <span class="select is-primary">
                <select id="search-type">
                    <option value="province">Province</option>
                    <option value="district">District</option>
                    <option value="town">Town</option>
                </select>
            </span>

            <span>
                <button class="button is-primary" id="search-btn">
                    Search
                </button>
            </span>

        </p>                
    </div>

    <br>

    <div class="result">
        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;" id="search-result-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
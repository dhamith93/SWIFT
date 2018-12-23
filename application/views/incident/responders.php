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
                    <option value="fireBrigrade">Fire Brigades</option>
                    <option value="hospital">Hospitals</option>
                    <option value="policeStation">Police Stations</option>
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
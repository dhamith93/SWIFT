<div class="tabs is-centered">
        <ul>
            <li class="tab-header is-active" data-tab="0"><a>Search</a></li>
            <li class="tab-header" data-tab="1"><a>Add</a></li>
        </ul>
    </div>
    <div id="tab-content" class="tab-content">
        <div class="tab is-active" data-content="0">

            <?php
                $this->view('dashboard/employee/organizations_search');
            ?>

        </div>
        <div class="tab" data-content="1">

            <?php
                $this->view('dashboard/employee/organization_add');
            ?>

        </div>
    </div>
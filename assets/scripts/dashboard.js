document.addEventListener('DOMContentLoaded', () => {
    var tabHeaders = document.getElementsByClassName('tab-header');
    var tabs = document.getElementsByClassName('tab');

    // if path/to/here#add || path/to/gere#add-success is loaded after adding a new user, display Add tab
    var urlAnchor = window.location.hash.substr(1);
    if (urlAnchor && (urlAnchor === 'add' || urlAnchor === 'add-success')) {
        unsetTabHeaderIsActive();

        let selectedTabContents;

        if (section === 'admin') {
            tabHeaders[1].classList.add('is-active'); // add tabHeader
            selectedTabContents = document.querySelectorAll('[data-content="1"]'); // add tab
        } 

        if (section === 'employee') {
            tabHeaders[2].classList.add('is-active'); // add tabHeader
            selectedTabContents = document.querySelectorAll('[data-content="2"]'); // add tab
        }
        
        activateTab(selectedTabContents);

        if (urlAnchor === 'add-success') {
            document.getElementById('success-notification').style.display = 'block';
            window.history.replaceState('', 'Employees', '#add'); // replaces the #add-success with #add
        }
    }

    if (urlAnchor && urlAnchor === 'no-record') {
        document.getElementById('no-record-notification').style.display = 'block';
        window.history.replaceState('', 'Employees', '#');

        if (section === 'employee') {
            unsetTabHeaderIsActive();
            tabHeaders[1].classList.add('is-active');
            selectedTabContents = document.querySelectorAll('[data-content="1"]');
            activateTab(selectedTabContents);
        }
    }

    if (urlAnchor && urlAnchor === 'search') {
        unsetTabHeaderIsActive();
        tabHeaders[1].classList.add('is-active');
        selectedTabContents = document.querySelectorAll('[data-content="1"]');
        activateTab(selectedTabContents);
    }

    if (urlAnchor && urlAnchor === 'delete-success') {
        document.getElementById('employee-delete-success-notification').style.display = 'block';
        window.history.replaceState('', 'Employees', '#');
    }

    if (urlAnchor && urlAnchor === 'delete-error') {
        document.getElementById('employee-delete-error-notification').style.display = 'block';
        window.history.replaceState('', 'Employees', '#');
    }


    for (let i = 0; i < tabHeaders.length; i++) {
        tabHeaders[i].addEventListener('click', function() {
            unsetTabHeaderIsActive();     
            this.classList.add('is-active');
            let selectedTabContents = document.querySelectorAll('[data-content="' + this.dataset.tab + '"]');
            activateTab(selectedTabContents);
        });
    }

    const navbarBurgers = getAll('.navbar-burger');
    if (navbarBurgers.length > 0) {
        navbarBurgers.forEach( el => {
            el.addEventListener('click', () => {
                let dashboardNav = document.getElementById('dashboard-nav');
                dashboardNav.classList.toggle('dashboard-nav-active');
                el.classList.toggle('is-active');
            });
        });
    }

    function unsetTabHeaderIsActive() {
        for (let j = 0; j < tabHeaders.length; j++) {
            tabHeaders[j].classList.remove('is-active');
            tabs[j].classList.remove('is-active');
        }
    }

    function activateTab(selectedTabContents) {
        selectedTabContents.forEach(function(selectedTabContent) {
            selectedTabContent.classList.add('is-active');
        });
    }

    var deleteEmpForms = getAll('.delete-emp-form');

    if (deleteEmpForms.length > 0) {
        deleteEmpForms.forEach(el => {
            el.addEventListener('submit', (e) => {
                e.preventDefault();
                if (confirm("Do you want to delete the employee record? This can't be undone!")) {
                   el.submit();
                }
            });
        });
    }

    var addLocationBtn = document.getElementById('add-location-btn');
    var locationCount = 0;
    var locationList = new Array();

    addLocationBtn.addEventListener('click', (e) => {
        let province = document.getElementById('province').value;
        let district = document.getElementById('district').value;
        let town = document.getElementById('town').value;
        let locations = document.getElementById('locations');

        if (!town) {
            document.getElementById('town').classList.add('is-danger');
            return
        }

        document.getElementById('town').classList.remove('is-danger');
        document.getElementById('location-box').classList.remove('box-is-danger');

        let locationString = province + '>' + district + '>' + town;

        locationList[locationCount] = locationString;
        
        locations.innerHTML += '<div id="loc-'+ locationCount +'"><p>' + locationString 
            + '<button class="delete location-delete" aria-label="close" type="button" style="float:right;" data-target="loc-' 
            + locationCount +'"></button></p><hr></div>';

        locationCount += 1;

        let locationDelBtns = getAll('.location-delete');

        if (locationDelBtns.length > 0) {
            locationDelBtns.forEach(el => {
                el.addEventListener('click', (e) => {
                    let locationElement = document.getElementById(el.dataset.target);
                    let arrPos = parseInt(el.dataset.target.substr(4));
                    delete locationList[arrPos];
                    locationElement.parentNode.removeChild(locationElement);
                });
            });
        }
    });

    var addIncidentForm = document.getElementById('add-incident-form');

    addIncidentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        let locationVals = document.getElementById('location-list');

        locationVals.value = '';

        for (let i = 0; i < locationList.length; i++) {
            if (locationList[i] !== undefined) {
                if (locationVals.value.length > 0)
                    locationVals.value += '|';
                
                locationVals.value += locationList[i];
            }
        }

        if (locationVals.value.length == 0) {
            document.getElementById('location-box').classList.add('box-is-danger');
            return;
        }

        document.getElementById('location-box').classList.remove('box-is-danger');

        addIncidentForm.submit();
    });


    // Modal | chose to load a different page instead of a modal. Keep commented codes as reference.

    var moreBtns = getAll('.more-btn');
    // var rootEl = document.documentElement;
    // var $modals = getAll('.modal');
    // var $modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');

    if (moreBtns.length > 0) {
        moreBtns.forEach(el => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                window.open("http://localhost:8888/SWIFT/incident/" + el.id, '_blank').focus();
            });
        });
    }


    // if ($modalCloses.length > 0) {
    //     $modalCloses.forEach(function ($el) {
    //         $el.addEventListener('click', function () {
    //             closeModals();
    //         });
    //     });
    // }

    // function openModal(target) {
    //     var $target = document.getElementById(target);
    //     rootEl.classList.add('is-clipped');
    //     $target.classList.add('is-active');
    // }

    // function closeModals() {
    //     rootEl.classList.remove('is-clipped');
    //         $modals.forEach(function ($el) {
    //         $el.classList.remove('is-active');
    //     });
    // }

    // document.addEventListener('keydown', function (event) {
    //         var e = event || window.event;
    //         if (e.keyCode === 27) {
    //         closeModals();
    //         closeDropdowns();
    //     }
    // });

    function getAll(selector) {
        return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
    }

});
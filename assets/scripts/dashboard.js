document.addEventListener('DOMContentLoaded', () => {
    const tabHeaders = document.getElementsByClassName('tab-header');
    const tabs = document.getElementsByClassName('tab');
    let locationList = new Array();

    // if path/to/here#add || path/to/gere#add-success is loaded after adding a new user, display Add tab
    const urlAnchor = window.location.hash.substr(1);
    if (urlAnchor && (urlAnchor === 'add' || urlAnchor === 'add-success' || urlAnchor === 'add-error')) {
        unsetTabHeaderIsActive();

        let selectedTabContents;

        if (section === 'admin') {
            tabHeaders[1].classList.add('is-active'); // add tabHeader
            selectedTabContents = document.querySelectorAll('[data-content="1"]'); // add tab
        } 

        if (section === 'employee') {
            let n = (view === 'incidents') ? 2 : 1;
            tabHeaders[n].classList.add('is-active'); // add tabHeader
            selectedTabContents = document.querySelectorAll('[data-content="' + n + '"]'); // add tab
        }

        if (section === 'organization') {
            let n = 1;
            tabHeaders[n].classList.add('is-active'); // add tabHeader
            selectedTabContents = document.querySelectorAll('[data-content="' + n + '"]'); // add tab
        }
        
        activateTab(selectedTabContents);

        if (urlAnchor === 'add-success') {
            document.getElementById('success-notification').style.display = 'block';
            window.history.replaceState('', 'Employees', '#add'); // replaces the #add-success with #add
        }

        if (urlAnchor === 'add-error') {
            document.getElementById('error-notification').style.display = 'block';
            window.history.replaceState('', 'Employees', '#add'); // replaces the #add-error with #add
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
        document.getElementById('delete-success-notification').style.display = 'block';
        window.history.replaceState('', 'Employees', '#');
    }

    if (urlAnchor && urlAnchor === 'delete-error') {
        document.getElementById('delete-error-notification').style.display = 'block';
        window.history.replaceState('', 'Employees', '#');
    }

    if (urlAnchor && urlAnchor === 'password-changed') {
        alert('Password updated successfully!');
        window.history.replaceState('', 'Employees', '#');
    }

    if (urlAnchor && urlAnchor === 'password-change-error') {
        alert('Your password did not updated!\nPlease use your old password and try again.');
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

    const deleteEmpForms = getAll('.delete-emp-form');

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

    const makeResponderAdminForms = getAll('.make-responder-admin-form');

    if (makeResponderAdminForms.length > 0) {
        makeResponderAdminForms.forEach(el => {
            el.addEventListener('submit', (e) => {
                e.preventDefault();
                if (confirm("Do you want to make this responder admin?\nYou will lose admin privileges! And you will be logged out!")) {
                   el.submit();
                }
            });
        });
    }

    const deleteResponderForms = getAll('.delete-responder-form');

    if (deleteResponderForms.length > 0) {
        deleteResponderForms.forEach(el => {
            el.addEventListener('submit', (e) => {
                e.preventDefault();
                if (confirm("Do you want to delete the responder record? This can't be undone!")) {
                   el.submit();
                }
            });
        });
    }

    const addLocationBtn = document.getElementById('add-location-btn');

    if (addLocationBtn) {
        let locationCount = 0;
        locationList = new Array();
    
        addLocationBtn.addEventListener('click', (e) => {
            let province = document.getElementById('province').value;
            let district = document.getElementById('district').value;
            let town = document.getElementById('town').value;
            let locations = document.getElementById('locations');
    
            if (!town && view === 'incidents') {
                document.getElementById('town').classList.add('is-danger');
                return
            }
    
            document.getElementById('town').classList.remove('is-danger');
            document.getElementById('location-box').classList.remove('box-is-danger');

            let locationString;
            
            if (district === 'empty') {
                locationString = province;    
            } else if (!town) {
                locationString = province + '>' + district;    
            } else {
                locationString = province + '>' + district + '>' + town;
            }
    
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
    }


    const addIncidentForm = document.getElementById('add-incident-form');
    const addOrganizationForm = document.getElementById('add-organization-form');

    if (addIncidentForm) {
        addIncidentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            checkLocationsAndSubmit(addIncidentForm);
        });
    }

    if (addOrganizationForm) {
        addOrganizationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            checkLocationsAndSubmit(addOrganizationForm);
        });
    }

    function checkLocationsAndSubmit(form) {
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

        form.submit();
    }

    function getAll(selector) {
        return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
    }

});
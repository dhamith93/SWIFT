var tabHeaders = document.getElementsByClassName('tab-header');
var tabs = document.getElementsByClassName('tab');
var addLocationBtn = document.getElementById('add-area-btn');
var addRespondersBtn = document.getElementById('add-responders-btn');
var searchBtn = document.getElementById('search-btn');
var resultTable = document.getElementById('search-result-table');
var responderTable = document.getElementById('responders-table');
var addAlertBtn = document.getElementById('add-alert-btn');
var alertDeleteBtns = getAll('.alert-delete-btn');
var setAlertPublic = document.getElementById('alert-public');
var addTaskBtn = document.getElementById('add-task-btn');

for (let i = 0; i < tabHeaders.length; i++) {
    tabHeaders[i].addEventListener('click', function() {
        unsetTabHeaderIsActive();     
        this.classList.add('is-active');
        let selectedTabContents = document.querySelectorAll('[data-content="' + this.dataset.tab + '"]');
        activateTab(selectedTabContents);
    });
}

addAlertBtn.addEventListener('click', (e) => {
    let content = document.getElementById('add-alert').value;
    let isPublic = (setAlertPublic.checked) ? '1' : '0';

    if (content !== '') {
        let params = 'incidentId=' + incidentId + '&content=' + content + '&isPublic=' + isPublic;
    
        if (confirm('Do you want to add this alert?')) {
            sendXhr(
                'http://localhost:8888/SWIFT/api/alert/', 
                'POST', 
                (r) => {
                    reloadAlerts();
                }, 
                (r) => {
                    alert('Error adding alert! Please try again');
                },
                params
            );
        }
    }
});

alertDeleteBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        deleteAlert(el.dataset.alertId);
    });
});

addLocationBtn.addEventListener('click', (e) => {
    document.getElementById('location-box').classList.toggle('is-hidden');
    document.getElementById('btn-icon').classList.toggle('fa-chevron-down');
    document.getElementById('btn-icon').classList.toggle('fa-chevron-up');
});

addRespondersBtn.addEventListener('click', (e) => {
    document.getElementById('search-area').classList.toggle('is-hidden');
});

searchBtn.addEventListener('click', (e) => {
    let orgType = document.getElementById('org-type').value;
    let searchValue = document.getElementById('search-value').value;
    let searchType = document.getElementById('search-type').value;

    if (orgType !== '' && searchValue !== '' && searchType !== '') {
        let url = 'http://localhost:8888/SWIFT/api/organizations/?orgType='+ orgType +
            '&searchValue=' + searchValue + '&searchType=' + searchType;
        sendXhr(url, 'GET', fillResultTable, xhrFailure);
    }
});

addTaskBtn.addEventListener('click', (e) => {
    if (confirm('Do you want to add this task?')) {
        let taskContent = document.getElementById('task-content').value;
        let respondingOrgId = document.getElementById('responder-org').value;
    
        if (taskContent) {
            let params = 'incidentId= ' + incidentId + '&taskContent=' + taskContent + '&respongingOrg=' + respondingOrgId;
            sendXhr(
                'http://localhost:8888/SWIFT/api/task/',
                'POST',
                (r) => {
                    sendXhr(
                        'http://localhost:8888/SWIFT/api/task/?incidentId=' + incidentId,
                        'GET',
                        (r) => {
                            reloadTasksTable(r);
                        },
                        (r) => { 
                            alert('Task Added!');
                        }
                    );
                },
                (r) => { 
                    xhrFailure(r);
                },
                params
            );
        }
    }
});

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

function sendXhr(url, method, successCallback, failureCallback, params) {
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);

    xhr.onload = () => {
        let response = JSON.parse(xhr.responseText);
        if (response['status'] === 'OK') {
            successCallback(response);
        } else {
            failureCallback(response);
        }
    };

    xhr.onerror = () => {
        alert('Error sending request! Please try again.');
    };   

    if (params)
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.send(params); 
}

function xhrFailure(response) {
    if (response['msg']) {
        if (response['msg'] === 'DB_FAILURE') {
            alert('Error adding record! Please try again.');
        } else if (response['msg'] === 'RECORD_EXISTS') {
            alert('Record already exists!')
        }
    } else {
        alert('No records found!');
    }
}

function xhrSuccess() {
    sendXhr(
        'http://localhost:8888/SWIFT/api/responding_orgs/?incidentId=' + incidentId, 
        'GET',
        (r) => {
            reloadReponderTable(r);
        },
        () => { }
    );
}

function deleteAlert(alertId) {
    params = 'alertId=' + alertId;
    if (confirm('Do you want to delete this alert?\nYou cannot undo this!')) {
        sendXhr(
            'http://localhost:8888/SWIFT/api/alert/', 
            'DELETE', 
            (r) => {
                alert('Alert deleted!');
                hideAlert(alertId);
            }, 
            (r) => {
                alert('Error deleting alert! Please try again');
            },
            params
        );
    }
}

function hideAlert(alertId) {
    document.getElementById('alert-' + alertId).style.display = 'none';
}

function reloadAlerts() {
    sendXhr(
        'http://localhost:8888/SWIFT/api/alert/?incidentId=' + incidentId, 
        'GET',
        (r) => { 
            let mainAlertDiv = document.getElementById('alerts');

            while (mainAlertDiv.firstChild)
                mainAlertDiv.removeChild(mainAlertDiv.firstChild);

            let keys = Object.keys(r).reverse();

            for(let i = 0; i< keys.length; i++) {
                if (keys[i] !== 'status') {
                    let content = r[keys[i]]['content'];
    
                    let alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'notification', 'is-danger');
                    alertDiv.id = 'alert-' + keys[i];
        
                    let button = document.createElement('button');
    
                    button.innerHTML = 'Add';
                    button.classList.add('delete', 'alert-delete-btn');
                    button.dataset.alertId = keys[i];

                    button.addEventListener('click', (e) => {
                        deleteAlert(button.dataset.alertId);
                    });
    
                    let p = document.createElement('p');
                    p.innerHTML = content;
    
                    alertDiv.appendChild(button);
                    alertDiv.appendChild(p);
    
                    mainAlertDiv.appendChild(alertDiv);
                    mainAlertDiv.appendChild(document.createElement('br'));
                }
            }
        },
        (r) => {
            alert('Alert added!');
            location.reload();
        },
    );
}

function reloadReponderTable(data) {
    resetTable(responderTable);
    
    Object.keys(data).forEach(key => {
        if (key !== 'status') {
            let name = data[key]['name'];
            let type = data[key]['type'];
            let contact = data[key]['contact'];
            let address = data[key]['address'];
            let email = data[key]['email'];
    
            let tableRef = responderTable.getElementsByTagName('tbody')[0];

            let link = document.createElement('a');
            link.classList.add('button', 'is-danger');
            link.innerHTML = 'More';
            link.href = '../organization/' + key;
            link.target = '_blank';
        
            let tr = document.createElement('tr');
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
            let cell6 = document.createElement('td');
        
            cell1.appendChild(document.createTextNode(name));
            cell2.appendChild(document.createTextNode(type));
            cell3.appendChild(document.createTextNode(contact));
            cell4.appendChild(document.createTextNode(address));
            cell5.appendChild(document.createTextNode(email));
            cell6.appendChild(link);
        
            tr.appendChild(cell1);
            tr.appendChild(cell2);
            tr.appendChild(cell3);
            tr.appendChild(cell4);
            tr.appendChild(cell5);
            tr.appendChild(cell6);
        
            tableRef.appendChild(tr);
        }
    });
}

function reloadTasksTable(data) {
    let tasksDiv = document.getElementById('tasks');
    resetTable(tasksDiv);

    let keys = Object.keys(data).reverse();

    for(let i = 0; i< keys.length; i++) {
        if (keys[i] !== 'status') {
            let assignedAt = data[keys[i]]['assigned_at'];
            let content = data[keys[i]]['content'];
            let org = data[keys[i]]['org'];
            let isCompleted = data[keys[i]]['is_completed'];
            let completedAt = data[keys[i]]['completed_at'];

            let tableRef = tasksDiv.getElementsByTagName('tbody')[0];

            let tr = document.createElement('tr');
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
        
            cell1.appendChild(document.createTextNode(assignedAt));
            cell2.appendChild(document.createTextNode(content));
            cell3.appendChild(document.createTextNode(org));
            cell4.appendChild(document.createTextNode(isCompleted));
            cell5.appendChild(document.createTextNode(completedAt));
        
            tr.appendChild(cell1);
            tr.appendChild(cell2);
            tr.appendChild(cell3);
            tr.appendChild(cell4);
            tr.appendChild(cell5);
        
            tableRef.appendChild(tr);
        }
    }
}

function fillResultTable(data) {
    resetTable(resultTable);

    Object.keys(data).forEach(key => {
        if (key !== 'status') {
            let name = data[key]['name'];
            let type = data[key]['type'];
            let contact = data[key]['contact'];
            let address = data[key]['address'];
    
            let tableRef = resultTable.getElementsByTagName('tbody')[0];
        
            let button = document.createElement('button');
        
            button.id = key;
            button.innerHTML = 'Add';
            button.classList.add('button', 'is-link', 'add-responder-btn');
        
            let tr = document.createElement('tr');
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
        
            cell1.appendChild(document.createTextNode(name));
            cell2.appendChild(document.createTextNode(type));
            cell3.appendChild(document.createTextNode(contact));
            cell4.appendChild(document.createTextNode(address));
            cell5.appendChild(button);
        
            tr.appendChild(cell1);
            tr.appendChild(cell2);
            tr.appendChild(cell3);
            tr.appendChild(cell4);
            tr.appendChild(cell5);
        
            tableRef.appendChild(tr);

            document.getElementById(key).addEventListener('click', (e) => {
                let params = 'orgId=' + key +'&incidentId=' + incidentId;
                sendXhr(
                    'http://localhost:8888/SWIFT/api/responding_orgs/', 
                    'POST',
                    (r) => {
                        alert('Organization added to responders list!');
                        xhrSuccess();
                    },
                    xhrFailure,
                    params
                );
            });
        }
    });
}

function resetTable(e) {
    let elements = e.getElementsByTagName('tbody');
    let length = elements[0].childNodes.length - 1;
    for (let i = length; i > 0; i--)
        elements[0].removeChild(elements[0].childNodes[i]);
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: -1.397, lng: 100.644}
    });
    var geocoder = new google.maps.Geocoder();

    // geocodeAddress('Kolonnawa, sri lanka', geocoder, map);
    // geocodeAddress('Wellampitiya, sri lanka', geocoder, map);
    // geocodeAddress('Kotikawattha, sri lanka', geocoder, map);
    // geocodeAddress('Angoda, sri lanka', geocoder, map);
    // document.getElementById('submit').addEventListener('click', function() {
    //   geocodeAddress(geocoder, map);
    // });
    }

    function geocodeAddress(address, geocoder, resultsMap) {
    // var address = document.getElementById('address').value;
    // var address = 'colombo, sri lanka';
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
        resultsMap.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: resultsMap,
            position: results[0].geometry.location
        });
        } else {
        alert('Geocode was not successful for the following reason: ' + status);
        }
    });
    }

function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}
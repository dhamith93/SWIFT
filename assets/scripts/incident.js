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

const addLocationBtn = document.getElementById('add-area-btn');
const addLocationForm = document.getElementById('add-location-form');
const addRespondersBtn = document.getElementById('add-responders-btn');
const searchBtn = document.getElementById('search-btn');
const resultTable = document.getElementById('search-result-table');
const responderTable = document.getElementById('responders-table');
const addAlertBtn = document.getElementById('add-alert-btn');
const alertDeleteBtns = getAll('.alert-delete-btn');
const setAlertPublic = document.getElementById('alert-public');
const updateWarningBtn = document.getElementById('update-warning-btn');
const addTaskBtn = document.getElementById('add-task-btn');
const locateBtn = document.getElementById('locate-btn');
const incidentMedia = getAll('.incident-media');
const modals = getAll('.modal');
const publishBtns = getAll('.publish-btn');
const unPublishBtns = getAll('.unpublish-btn');
const editBtns = getAll('.edit-btn');
const deleteBtns = getAll('.delete-btn');
const searchRespondersBtn = document.getElementById('search-responders-btn');
const assignedTaskBtns = getAll('.task-assign-btn');
const modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');
const urlAnchor = window.location.hash.substr(1);
const refreshMillSecs = 60000;
const requestCountInterval = window.setInterval(refreshRequestCount, refreshMillSecs);

if (urlAnchor && urlAnchor === 'gallery-error') {
    window.history.replaceState('', 'Incident', '#');
    alert('Error adding new media. Please try again.');
}

if (urlAnchor && urlAnchor === 'location-error') {
    window.history.replaceState('', 'Incident', '#');
    alert('Error adding new location...\nPlease try again.');
}

if (urlAnchor && urlAnchor === 'update-error') {
    window.history.replaceState('', 'Incident', '#');
    alert('Error updating the incident...\nPlease try again.');
}

if (addLocationForm) {
    addLocationForm.addEventListener('submit', (e) => {
        let province = document.getElementById('area-province').value;
        let district = document.getElementById('area-district').value;
        let town = document.getElementById('area-town').value;
        let locationString = document.getElementById('location-string');
    
        if (province && district && town) {
            locationString.value = province + '>' + district + '>' + town;
            
            if (confirm('Do you want to add: ' + locationString.value + ' as an affected area?')) {
                if (confirm('Do you want to alert selected organizations of this new area?'))
                    document.getElementById('alert-orgs').value = 'TRUE';
    
                e.submit();
            }
    
            e.preventDefault();
        }
    });
}

if (addAlertBtn) {
    addAlertBtn.addEventListener('click', (e) => {
        let content = document.getElementById('add-alert').value;
        let isPublic = (setAlertPublic.checked) ? '1' : '0';
    
        if (content !== '') {
            let params = 'incidentId=' + incidentId + '&content=' + content + '&isPublic=' + isPublic;
        
            if (confirm('Do you want to add this alert?')) {
                sendXhr(
                    'http://localhost/SWIFT/api/alert/', 
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
}

alertDeleteBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        deleteAlert(el.dataset.alertId);
    });
});

if (updateWarningBtn) {
    updateWarningBtn.addEventListener('click', (e) => {
        if (confirm('Do you want to update the warning?')) {
            let warning = document.getElementById('warning').value;
            let params = 'incidentId= ' + incidentId + '&warning=' + warning;

            sendXhr(
                'http://localhost/SWIFT/api/warning/',
                'POST',
                (r) => {},
                (r) => { 
                    alert('Error updating the warning. Please try again.');
                },
                params
            );
        }
    });
}

if (addLocationBtn) {
    addLocationBtn.addEventListener('click', (e) => {
        document.getElementById('location-box').classList.toggle('is-hidden');
        document.getElementById('btn-icon').classList.toggle('fa-chevron-down');
        document.getElementById('btn-icon').classList.toggle('fa-chevron-up');
    });
}

if (addRespondersBtn) {
    addRespondersBtn.addEventListener('click', (e) => {
        document.getElementById('search-area').classList.toggle('is-hidden');
    });
}

if (searchBtn) {
    searchBtn.addEventListener('click', (e) => {
        let orgType = document.getElementById('org-type').value;
        let searchValue = document.getElementById('search-value').value;
        let searchType = document.getElementById('search-type').value;
    
        if (orgType !== '' && searchValue !== '' && searchType !== '') {
            let url = 'http://localhost/SWIFT/api/organizations/?orgType='+ orgType +
                '&searchValue=' + searchValue + '&searchType=' + searchType;
            sendXhr(url, 'GET', fillResultTable, xhrFailure);
        }
    });
}

if (addTaskBtn) {
    addTaskBtn.addEventListener('click', (e) => {
        let taskContent = document.getElementById('task-content').value;
        let respondingOrgId = document.getElementById('responder-org').value;
        
        if (taskContent) {
            if (confirm('Do you want to add this task?')) {
                let params = 'incidentId= ' + incidentId + '&taskContent=' + taskContent + '&respongingOrg=' + respondingOrgId;
                sendXhr(
                    'http://localhost/SWIFT/api/task/',
                    'POST',
                    (r) => {
                        sendXhr(
                            'http://localhost/SWIFT/api/task/?incidentId=' + incidentId,
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
}

incidentMedia.forEach(el => {
    el.addEventListener('click', (e) => {
        openModal('media-modal', el.dataset.src, el.dataset.mediaType);
    });
});

publishBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        let articleId = el.dataset.articleId;
        
        if (confirm('Do you want to publish this article?')) {
            let params = 'articleId= ' + articleId;
            sendXhr(
                'http://localhost/SWIFT/api/article_publish/',
                'POST',
                (r) => {
                    document.getElementById('pub-' + articleId).style.display = 'none';
                    document.getElementById('unpub-' + articleId).style.display = 'block';
                },
                (r) => { 
                    alert('Error publishing the article. Please try again.');
                },
                params
            );
        }
    });
});

unPublishBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        let articleId = el.dataset.articleId;

        if (confirm('Do you want to unpublish this article?')) {
            let params = 'articleId= ' + articleId;
            sendXhr(
                'http://localhost/SWIFT/api/article_unpublish/',
                'POST',
                (r) => {
                    document.getElementById('pub-' + articleId).style.display = 'block';
                    document.getElementById('unpub-' + articleId).style.display = 'none';
                },
                (r) => { 
                    alert('Error unpublishing the article. Please try again.');
                },
                params
            );
        }
    });
});

editBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        let articleId = el.dataset.articleId;
        console.log(articleId);
    });
});

deleteBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        let articleId = el.dataset.articleId;
        
        if (confirm('Do you want to delete this article?')) {
            let params = 'articleId= ' + articleId;
            sendXhr(
                'http://localhost/SWIFT/api/article/',
                'DELETE',
                (r) => {
                    document.getElementById('article-' + articleId).remove();
                },
                (r) => { 
                    alert('Error deleting the article. Please try again.');
                },
                params
            );
        }        
    });
});

if (searchRespondersBtn) {
    searchRespondersBtn.addEventListener('click', (e) => {
        let searchType = document.getElementById('resp-search-type').value;
        let searchValue = document.getElementById('resp-search-value').value;

        if (searchType === 'all' || (searchType && searchValue)) {
            if (searchType === 'all')
                searchValue = 'all';

            sendXhr(
                'http://localhost/SWIFT/api/org_responders/?orgId=' + orgId + '&searchType=' + searchType + '&searchValue=' + searchValue,
                'GET',
                (r) => {                 
                    fillOrgResultTable(r);
                 },
                (r) => {
                    response['status'] !== 'NO_RECORDS'
                        alert('Cannot retrieve search result...');
                },
            )
        }
    });
}

assignedTaskBtns.forEach(el => {
    el.addEventListener('click', (e) => {
        openModal('responders-modal');
        let elements = getAll('.task-id');

        elements.forEach(el1 => {
            el1.value = el.dataset.taskId;
        });
    });
});

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
        'http://localhost/SWIFT/api/responding_orgs/?incidentId=' + incidentId, 
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
            'http://localhost/SWIFT/api/alert/', 
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
        'http://localhost/SWIFT/api/alert/?incidentId=' + incidentId, 
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
            link.href = '../../org/' + key;
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

function fillOrgResultTable(data) {
    resetTable(resultTable);
    
    Object.keys(data).forEach(key => {
        if (key !== 'status') {
            let firstName = data[key]['first_name'];
            let lastName = data[key]['last_name'];
            let position = data[key]['position'];
            let contact = data[key]['contact'];
            let email = data[key]['email'];
    
            let tableRef = resultTable.getElementsByTagName('tbody')[0];
    
            let button = document.createElement('button');
        
            button.id = key;
            button.innerHTML = 'Add';
            button.classList.add('button', 'is-link', 'add-org-responder-btn');
    
            button.addEventListener('click', (e) => {
                if (confirm('Do you want to add this responder to the incident?')) {
                    let params = 'incidentId= ' + incidentId + '&responderId=' + key;
                    sendXhr(
                        'http://localhost/SWIFT/api/add_responder/',
                        'POST',
                        (r) => {
                            sendXhr(
                                'http://localhost/SWIFT/api/org_responder/?orgId=' + orgId + '&searchType=id&searchValue=' + key,
                                'GET',
                                (r) => { addToOrgResponderTable(r); },
                                (r) => {},
                            )
                        },
                        (r) => { alert('Error unpublishing the article. Please try again.'); },
                        params
                    );
                }
            });
        
            let tr = document.createElement('tr');
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
            let cell6 = document.createElement('td');
        
            cell1.appendChild(document.createTextNode(firstName));
            cell2.appendChild(document.createTextNode(lastName));
            cell3.appendChild(document.createTextNode(position));
            cell4.appendChild(document.createTextNode(contact));
            cell5.appendChild(document.createTextNode(email));
            cell6.appendChild(button);
        
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

function addToOrgResponderTable(data) {
    Object.keys(data).forEach(key => {
        if (key !== 'status') {
            let firstName = data[key]['first_name'];
            let lastName = data[key]['last_name'];
            let position = data[key]['position'];
            let contact = data[key]['contact'];
            let email = data[key]['email'];
    
            let tableRef = document.getElementById('org-responders-table').getElementsByTagName('tbody')[0];
    
            let tr = document.createElement('tr');
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
        
            cell1.appendChild(document.createTextNode(firstName));
            cell2.appendChild(document.createTextNode(lastName));
            cell3.appendChild(document.createTextNode(position));
            cell4.appendChild(document.createTextNode(contact));
            cell5.appendChild(document.createTextNode(email));
        
            tr.appendChild(cell1);
            tr.appendChild(cell2);
            tr.appendChild(cell3);
            tr.appendChild(cell4);
            tr.appendChild(cell5);
        
            tableRef.appendChild(tr);
        }
    });
}

function reloadTasksTable(data) {
    let tasksDiv = document.getElementById('tasks-table');
    tasksDiv.style.display = '';
    resetTable(tasksDiv);

    let keys = Object.keys(data).reverse();

    for(let i = 0; i< keys.length; i++) {
        if (keys[i] !== 'status') {
            let assignedAt = data[keys[i]]['assigned_at'];
            let content = data[keys[i]]['content'];
            let org = data[keys[i]]['org'];
            let isCompleted = data[keys[i]]['is_completed'];
            let completedAt = (data[keys[i]]['completed_at'] === null) ? '' : data[keys[i]]['completed_at'];

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

    document.getElementById('task-content').value = '';
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
                    'http://localhost/SWIFT/api/responding_orgs/', 
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

function fillFileName(type) {
    let userMedia;
    let fileName; 

    if (type === 'image') {
        userMedia = document.getElementById('user-image');
        fileName = document.getElementById('image-file-name');
    } else {
        userMedia = document.getElementById('user-video');
        fileName = document.getElementById('video-file-name');
    }

    fileName.innerHTML = userMedia.value.substr(userMedia.value.lastIndexOf('\\') + 1);
}

if (modalCloses.length > 0) {
    modalCloses.forEach(function (el) {
        el.addEventListener('click', function () {
            closeModals();
        });
    });
}

function openModal(t, src = null, type = null) {
    let target = document.getElementById(t);
    let rootEl = document.documentElement;

    if (src && type) {
        let modalVideo = document.getElementById('modal-video');
        let modalImg = document.getElementById('modal-img');
        let modalLink = document.getElementById('modal-link');
    
        if (type === 'image') {
            modalVideo.classList.add('is-hidden');
            modalImg.src = src;
            modalLink.href = src;
            modalImg.classList.remove('is-hidden');
        } else {
            modalImg.classList.add('is-hidden');
            modalVideo.src = src;
            modalVideo.classList.remove('is-hidden');
        }
    }

    rootEl.classList.add('is-clipped');
    target.classList.add('is-active');
}

function closeModals() {
    let rootEl = document.documentElement;
    rootEl.classList.remove('is-clipped');
    modals.forEach(function (el) {
        el.classList.remove('is-active');
    });
    document.getElementById('modal-video').pause();
}

document.addEventListener('keydown', function (event) {
        let e = event || window.event;
        if (e.keyCode === 27) {
        closeModals();
        closeDropdowns();
    }
});

if (locateBtn) {
    locateBtn.addEventListener('click', (e) => {
        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: {lat: lat, lng: lng}
        });

        let marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(lat, lng),
            label: {
                color: 'black',
                fontWeight: 'bold',
                text: lat + ', ' + lng
            }
        });
    });
}

function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}

function refreshRequestCount() {
    let params = 'incidentId= ' + incidentId;
    sendXhr(
        'http://localhost/SWIFT/api/unseen_request_count/?' + params,
        'GET',
        (r) => {
            if (r['count'] > 0) {
                let requestLink = document.getElementById('request-link');
                let requestLinkText = 'Requests &nbsp; <sup>' + r['count'] + '</sup>';
                requestLink.innerHTML = requestLinkText;
            }
        },
        (r) => { }
    );
}

// set request count for the first time
refreshRequestCount();
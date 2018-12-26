var tabHeaders = document.getElementsByClassName('tab-header');
var tabs = document.getElementsByClassName('tab');

for (let i = 0; i < tabHeaders.length; i++) {
    tabHeaders[i].addEventListener('click', function() {
        unsetTabHeaderIsActive();     
        this.classList.add('is-active');
        let selectedTabContents = document.querySelectorAll('[data-content="' + this.dataset.tab + '"]');
        activateTab(selectedTabContents);
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

var addLocationBtn = document.getElementById('add-area-btn');
var addRespondersBtn = document.getElementById('add-responders-btn');
var searchBtn = document.getElementById('search-btn');
var resultTable = document.getElementById('search-result-table');
var responderTable = document.getElementById('responders-table');

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
        () => { },
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
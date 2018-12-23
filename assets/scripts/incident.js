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
        sendXhr(url);
    }
});

function sendXhr(url) {
    let xhr = new XMLHttpRequest();    
    let method = 'GET';
    if ("withCredentials" in xhr) {
        xhr.open(method, url, true);
    } else if (typeof XDomainRequest != "undefined") {
        xhr = new XDomainRequest();
        xhr.open(method, url);
    } else {
        xhr = null;
    }
    if (xhr != null) {
        xhr.onload = function() {
            let response = xhr.responseText;
            response = JSON.parse(response);
            fillResultTable(response);
        };
    
        xhr.onerror = function() {
            alert('error');
        };   

        xhr.send();
    }
}

function fillResultTable(data) {
    resetTable(resultTable);

    Object.keys(data).forEach(key => {
        let name = data[key]['name'];
        let type = data[key]['type'];
        let contact = data[key]['contact'];
        let address = data[key]['address'];

        let tableRef = resultTable.getElementsByTagName('tbody')[0];
        let newRow = document.createElement('tr');
    
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
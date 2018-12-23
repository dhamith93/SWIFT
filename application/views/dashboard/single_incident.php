<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

<style>
.background {
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 400px;
    background-color: #5ab4ff;
    box-shadow: 0px 0px 10px #000000;
}
section {
    box-shadow: 0px 0px 25px #2d2d2d;
    width: 95vw;
    margin: auto;
    margin-top: 5vh;
    margin-bottom: 5vh;
    background-color: #fff;
}

h4 {
    text-align: center;
    text-decoration: underline;
}

hr {
    background-color: #c7c7c7;
}

#location-box {
    width: 300px;
    margin: auto;
}

#search-area {
    width: 580px;
    margin: auto;
}

#search-area span input {
    width: 200px;
}

#alerts {
    /* display: none; */
    overflow: scroll;
    height: 400px;
}
</style>

<div class="background"></div>

<section class="section">
    <div class="container">
        <h1 class="title">Incident: <?php echo ucfirst($incident[$id]['name']); ?></h1>
        <h2 class="subtitle is-4">Type: <?php echo ucfirst($incident[$id]['type']); ?></h2>

        <div class="tabs is-centered">
            <ul>
                <li class="tab-header is-active" data-tab="0"><a>Information</a></li>
                <li class="tab-header" data-tab="1"><a>Alerts & Warnings</a></li>
                <li class="tab-header" data-tab="2"><a>Gallary</a></li>
                <li class="tab-header" data-tab="3"><a>Responders</a></li>
                <li class="tab-header" data-tab="4"><a>Requests</a></li>
                <li class="tab-header" data-tab="5"><a>Tasks</a></li>
                <li class="tab-header" data-tab="6"><a>Message Board</a></li>
            </ul>
        </div>
        <div id="tab-content" class="tab-content">
            <div class="tab is-active" data-content="0">

                <div class="columns">
                    <div class="column">
                        <h4 class="subtitle is-4">Affected Areas</h4>
                        <?php 
                            $locationCount = 0;
                            foreach ($incident[$id]['locations'] as $location):
                        ?>
                            <div id="loc-<?php echo $locationCount;?>">
                                <p> <?php echo $location;?>
                                    <button class="delete location-delete" aria-label="close" type="button" style="float:right;" data-target="loc-<?php echo $locationCount;?>">
                                    </button>
                                </p>
                                <hr>
                            </div>

                            <?php $locationCount += 1;?>

                        <?php endforeach; ?>
                        
                        <a class="button is-success" id="add-area-btn">
                            <span class="icon is-small">
                                <i class="fas fa-chevron-down animated flipInX btn-icon" id="btn-icon"></i>
                            </span>
                            <span>Add More</span>
                        </a>

                        <br> <br>

                        <div class="box is-hidden" id="location-box">
                                <div class="control">
                                    <label class="label">Province</label>
                                    <div class="select is-fullwidth">
                                        <select id="area-province">
                                            <option value="central">Central</option>
                                            <option value="eastern">Eastern</option>
                                            <option value="north-central">North Central</option>
                                            <option value="north-western">North Western</option>
                                            <option value="northern">Northern</option>
                                            <option value="sabaragamuwa">Sabaragamuwa</option>
                                            <option value="southern">Southern</option>
                                            <option value="uva">Uva</option>
                                            <option value="western">Western</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <br>

                                <div class="control">
                                    <label class="label">District</label>
                                    <div class="select is-fullwidth">
                                        <select id="area-district">
                                            <option value="ampara">Ampara</option>
                                            <option value="anuradhapura">Anuradhapura</option>
                                            <option value="badulla">Badulla</option>
                                            <option value="batticaloa">Batticaloa</option>
                                            <option value="colombo">Colombo</option>
                                            <option value="galle">Galle</option>
                                            <option value="gampaha">Gampaha</option>
                                            <option value="hambantota">Hambantota</option>
                                            <option value="jaffna">Jaffna</option>
                                            <option value="kalutara">Kalutara</option>
                                            <option value="kandy">Kandy</option>
                                            <option value="kegalle">Kegalle</option>
                                            <option value="kilinochchi">Kilinochchi</option>
                                            <option value="kurunegala">Kurunegala</option>
                                            <option value="mannar">Mannar</option>
                                            <option value="matale">Matale</option>
                                            <option value="matara">Matara</option>
                                            <option value="monaragala">Monaragala</option>
                                            <option value="mullaitivu">Mullaitivu</option>
                                            <option value="nuwara-eliya">Nuwara Eliya</option>
                                            <option value="polonnaruwa">Polonnaruwa</option>
                                            <option value="puttalam">Puttalam</option>
                                            <option value="ratnapura">Ratnapura</option>
                                            <option value="trincomalee">Trincomalee</option>
                                            <option value="vavuniya">Vavuniya</option>
                                        </select>
                                    </div>
                                </div>

                                <br>

                                <div class="field">
                                    <label class="label">Town</label>
                                    <div class="control">
                                        <input class="input" type="text" id="area-town">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control" id="locations"> </div>
                                </div>

                                <div class="field">
                                    <button class="button is-link" id="add-location-btn">Add Area</button>
                                </div>
                        </div>
                    </div>
                    <div class="column">
                        <div id="map" style="width:100%;height:400px;"></div>
                    </div>
                </div>

                <hr>

                <div class="columns">
                    <div class="column">
                        <h4 class="subtitle is-4">Casualties</h4>
                        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                            <thead>
                                <tr>
                                    <th>Deaths</th>
                                    <th>Wounded</th>
                                    <th>Missing</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="deaths">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="wounded">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="missing">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="button is-link" id="update-casualties-btn">Update</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column">
                        <h4 class="subtitle is-4">Hospitalizations</h4>
                        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                            <thead>
                                <tr>
                                    <th>Hospital</th>
                                    <th>No. of patients</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        xyz
                                    </td>
                                    <td>
                                        88
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="columns">
                    <div class="column">
                        <h4 class="subtitle is-4">Evacuations</h4>
                        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                            <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>No. of evacuees</th>
                                    <th>Contact</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="update-evac-address">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="update-evac-evacuees">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="update-evac-contact">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="button is-link" id="update-evac-btn">Update</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="add-evac-address">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="add-evac-evacuees">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="add-evac-contact">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="button is-link" id="add-evac-btn" style="width: 100%;">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column">
                        <h4 class="subtitle is-4">Property Damages</h4>
                        <table class="table is-bordered is-striped is-narrow is-hoverable" style="margin: auto;">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Cost estimate</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="update-prop-type">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="update-prop-count">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="update-prop-cost">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="button is-link" id="update-property-btn">Update</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="text" id="add-prop-type">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="add-prop-count">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control">
                                            <input class="input" type="number" id="add-prop-cost">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="button is-link" id="add-property-btn" style="width: 100%;">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="tab" data-content="1">

                <div class="columns">
                        <div class="column">
                            <h4 class="subtitle is-4">Alerts</h4>
                            <div id="alerts">
                                <div class="notification is-danger">
                                    <button class="delete"></button>
                                    Primar lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
                                    consectetur adipiscing elit
                                </div>
                                <div class="notification is-danger">
                                    <button class="delete"></button>
                                    Primar lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
                                    consectetur adipiscing elit
                                </div>
                                <div class="notification is-danger">
                                    <button class="delete"></button>
                                    Primar lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Sit amet,
                                    consectetur adipiscing elit
                                </div>
                            </div>
                            <br>
                            <textarea id="add-alert" class="textarea"></textarea>
                            <br>
                            <button class="button is-link" id="add-alert-btn">Add</button>
                        </div>
                        <div class="column">
                            <h4 class="subtitle is-4">Hazard warnings</h4>
                                <textarea class="textarea"><?php echo $incident[$id]['warning']; ?></textarea>
                                <br>
                                <button class="button is-link" id="update-evac-btn">Update</button>
                        </div>
                    </div>

                                
            </div>
            <div class="tab" data-content="2">

                <h4 class="subtitle is-4 is-center">Media</h4>
                <div id="gallary">
                </div>
                <a class="button is-success" id="add-responders-btn">
                    <span class="icon is-small">
                        <i class="fas fa-plus animated flipInX btn-icon"></i>
                    </span>
                    <span>Add Media</span>                    
                </a>
                <input type="file" id="mypic" accept="image/*">

            </div>
            <div class="tab" data-content="3">

                <h4 class="subtitle is-4">Responders</h4>
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

            </div>
            <div class="tab" data-content="4">
            </div>
            <div class="tab" data-content="5">
            </div>
            <div class="tab" data-content="6">
            </div>
        </div>

    </div>
</section>

<script>
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

        // https://us1.locationiq.com/v1/search.php?key=08e1ae6caccbd4&q=colombo,sri%20lanka&format=json

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
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiQmUAapRHaBK7KVDwe1K0CvkvtWnaD2A&callback=initMap"></script>
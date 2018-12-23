<h4 class="subtitle is-4">Affected Areas</h4>
<div class="columns">
    <div class="column">
        <hr>
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
                
                <br>br

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

    <br> <br>

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

    <br>

    <hr>

    <br>

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

    <br>
</div>
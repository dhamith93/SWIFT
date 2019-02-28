<div class="section">
    <div class="report-search">
        <?php echo form_open(''); ?>
            <p class="control">
                <span style="line-height: 2rem;">From</span>

                <span>
                    <input class="input is-primary" type="date" name="start-date" style="width:200px;">
                </span>

                <span style="line-height: 2rem;">To</span>

                <span>
                    <input class="input is-primary" type="date" name="end-date" style="width:200px;">
                </span>

                <span style="line-height: 2rem;">In</span>

                <span>
                    <input class="input is-primary" type="text" name="location" style="width:200px;" value="Everywhere">
                </span>

                <span class="select is-primary">
                    <select name="location-type">
                        <option value="all">All</option>
                        <option value="province">Province</option>
                        <option value="district">District</option>
                    </select>
                </span>

                <span>
                    <button class="button is-primary" type="submit">
                        Get
                    </button>
                </span>

            </p>       
        <?php echo form_close(); ?>
    </div>

    <?php if (!empty($report)): ?>

    <div class="section">
    <style type="text/css">
        table {
            width: 100%;
        }

        table td {
            border: none !important;
        }

        .first-header {
            background-color: rgb(40, 48, 58);
            color: #fff;
        }

        .second-header {
            background-color: #4a4a4a;
            color: #fff;
        }

        .first-header tr th {
            color: #fff;
            border: 1px solid rgb(40, 48, 58);
        }

        .second-header tr th {
            color: #fff;
            border: 1px solid #4a4a4a;
        }

        .sum {
            background-color: #ffc0a2;
        }

        .end-sum {
            background-color: #ff7a47;
            color: #fff;
        }

        .end-sum td strong {
            color: #fff;
        }
    </style>
        <table cellpadding="0" cellspacing="0" class="table is-fullwidth">
            <thead class="first-header">
                <tr>
                    <th colspan="1">Date</th>
                    <th colspan="1">Type</th>
                    <th colspan="3">Location</th>
                    <th colspan="5">Casualties</th>
                </tr>
            </thead>
            <tbody class="second-header">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Town</th>
                    <th>Deaths</th>
                    <th>Missing</th>
                    <th>Wounded</th>
                    <th>Hospitalizations</th>
                    <th>Evacuated</th>
                </tr>
            </tbody>
            <tbody>
                <?php 
                    $prevDate = '';
                    $totalDeaths = 0;
                    $totalMissing = 0;
                    $totalWounded = 0;
                    $totalHospitalizations = 0;
                    $totalEvacuations = 0;
                    
                    $totalTimeFrameDeaths = 0;
                    $totalTimeFrameMissing = 0;
                    $totalTimeFrameWounded = 0;
                    $totalTimeFrameHospitalizations = 0;
                    $totalTimeFrameEvacuations = 0;

                    foreach ($report as $date => $row): 
                ?>
                    <tr>
                        <?php
                            foreach ($row as $incident): 
                            $prevProvince = '';
                            $prevDistrict = '';

                            if ($prevDate === $incident['date']) {
                                echo '<td rowspan="'.count($incident['locations']).'"></td>';
                            } else {
                                echo '<td rowspan="'.count($incident['locations']).'">'.$date.'</td>';
                                $prevDate = $incident['date'];
                            }
                        ?>
                        <td rowspan="<?php echo count($incident['locations']); ?>"><?php echo $incident['type']; ?></td>
                            <?php for ($i = 0; $i < count($incident['locations']); $i++): ?>
                                <?php 
                                    $province = '';
                                    $district = '';
                                    $town = $incident['locations'][$i]['town'];

                                    if ($prevProvince !== $incident['locations'][$i]['province']) {
                                        $province = $incident['locations'][$i]['province'];
                                        $prevProvince = $province;
                                    }

                                    if ($prevDistrict !== $incident['locations'][$i]['district']) {
                                        $district = $incident['locations'][$i]['district'];
                                        $prevDistrict = $district;
                                    }
                                ?>
                                <td><?php echo $province; ?></td>
                                <td><?php echo $district; ?></td>
                                <td><?php echo $town; ?></td>
                                <?php if ($i === 0): ?>
                                    <?php
                                        $totalDeaths += (!empty($incident['casualties'])) ? (int) $incident['casualties'][0]->deaths : 0;
                                        $totalMissing += (!empty($incident['casualties'])) ? (int) $incident['casualties'][0]->missing : 0;
                                        $totalWounded += (!empty($incident['casualties'])) ? (int) $incident['casualties'][0]->wounded : 0;
                                        $totalHospitalizations += (int) $incident['hospitalizations'];
                                        $totalEvacuations += (int) $incident['evacuations']; 
                                    ?>
                                    <td rowspan="<?php echo count($incident['locations']); ?>"><?php if (!empty($incident['casualties'])) echo $incident['casualties'][0]->deaths; else echo 0; ?></td>
                                    <td rowspan="<?php echo count($incident['locations']); ?>"><?php if (!empty($incident['casualties'])) echo $incident['casualties'][0]->missing; else echo 0; ?></td>
                                    <td rowspan="<?php echo count($incident['locations']); ?>"><?php if (!empty($incident['casualties'])) echo $incident['casualties'][0]->wounded; else echo 0; ?></td>
                                    <td rowspan="<?php echo count($incident['locations']); ?>"><?php echo $incident['hospitalizations']; ?></td>
                                    <td rowspan="<?php echo count($incident['locations']); ?>"><?php echo $incident['evacuations']; ?></td>
                                <?php endif; ?>
                                </tr>
                                <tr>                           
                            <?php endfor; ?>
                        <?php 
                            endforeach; 
                        ?>
                    </tr>
                    <?php
                        echo '<tr class="sum">';
                        echo '<td colspan="4"></td>';
                        echo '<td><strong>SUM</strong></td>';
                        echo '<td>'.$totalDeaths.'</td>';
                        echo '<td>'.$totalMissing.'</td>';
                        echo '<td>'.$totalWounded.'</td>';
                        echo '<td>'.$totalHospitalizations.'</td>';
                        echo '<td>'.$totalEvacuations.'</td>';
                        echo '</tr>';

                        $totalTimeFrameDeaths += $totalDeaths;
                        $totalTimeFrameMissing += $totalMissing;
                        $totalTimeFrameWounded += $totalWounded;
                        $totalTimeFrameHospitalizations += $totalHospitalizations;
                        $totalTimeFrameEvacuations += $totalEvacuations;

                        $totalDeaths = 0;
                        $totalMissing = 0;
                        $totalWounded = 0;
                        $totalHospitalizations = 0;
                        $totalEvacuations = 0;
                    ?>
                <?php endforeach; ?>
                <tr class="end-sum">
                <td colspan="4"></td>
                <td><strong>TOTAL</strong></td>
                <td><?php echo $totalTimeFrameDeaths; ?></td>
                <td><?php echo $totalTimeFrameMissing; ?></td>
                <td><?php echo $totalTimeFrameWounded; ?></td>
                <td><?php echo $totalTimeFrameHospitalizations; ?></td>
                <td><?php echo $totalTimeFrameEvacuations; ?></td>
                </tr>
            </tbody>
            <tbody class="second-header">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Town</th>
                    <th>Deaths</th>
                    <th>Missing</th>
                    <th>Wounded</th>
                    <th>Hospitalizations</th>
                    <th>Evacuated</th>
                </tr>
            </tbody>
            <tfoot class="first-header">
                <tr>
                    <th colspan="1">Date</th>
                    <th colspan="1">Type</th>
                    <th colspan="3">Location</th>
                    <th colspan="5">Casualties</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php endif; ?>
</div>
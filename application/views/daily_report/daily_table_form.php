<?php

            //   echo "<pre>";
            //   print_r($data);
            //   echo "</pre>";
?>
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Daily Reports - <?=$date_for_daily?></div>
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/daily-report-<?php echo date("Ymd");?>.csv"><span class="badge badge-warning">Download File</span></a></div>
    <!-- <div class="pull-right"><a href="<?= base_url() ?>pages/exportCSV"><span class="badge badge-warning">Download File</span></a></div> -->
</div>
<div class="block-content collapse in">
    <div class="scroll-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="3">MDSCSI Sales TC/AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">Voice Sales / TC /AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">Web Sales / TC /AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">GcashMiniProgram Sales / TC /AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">Mobile Apps Sales / TC /AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">CTC Sales / TC /AC</th>
                    <th colspan="1"></th>
                    <th colspan="3">fbchatbot Sales / TC /AC</th>
                    <th colspan="1"></th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                    <th colspan="1"></th>
                    <th>GC</th>
                    <th>Gross Actual</th>
                    <th>Gross AC</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for($x=0;$x<25;$x++){
                ?>
                    <tr>
                        <td><?php if($x!=24){echo $x;}?></td>
                        <td></td>
                        <td><?= $data[0][$x]['gc'];?></td>
                        <td><?= $data[0][$x]['ga'];?></td>
                        <td><?= $data[0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['voice'][$x]['gc'];?></td>
                        <td><?= $data['daily']['voice'][$x]['ga'];?></td>
                        <td><?= $data['daily']['voice'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['web'][$x]['gc'];?></td>
                        <td><?= $data['daily']['web'][$x]['ga'];?></td>
                        <td><?=  $data['daily']['web'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['gcashminiprogram'][$x]['gc'];?></td>
                        <td><?= $data['daily']['gcashminiprogram'][$x]['ga'];?></td>
                        <td><?= $data['daily']['gcashminiprogram'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['mobile_app'][$x]['gc'];?></td>
                        <td><?= $data['daily']['mobile_app'][$x]['ga'];?></td>
                        <td><?=  $data['daily']['mobile_app'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['ctc'][$x]['gc'];?></td>
                        <td><?= $data['daily']['ctc'][$x]['ga'];?></td>
                        <td><?= $data['daily']['ctc'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['daily']['fbchatbot'][$x]['gc'];?></td>
                        <td><?= $data['daily']['fbchatbot'][$x]['ga'];?></td>
                        <td><?= $data['daily']['fbchatbot'][$x]['ac'];?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

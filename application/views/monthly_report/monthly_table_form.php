
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Monthly Reports - <?=$month."-".$year?></div>
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/monthly_report_<?php echo date("Ymd");?>.csv"><span class="badge badge-warning">Download File</span></a></div>
</div>

<div class="block-content collapse in">
    <div class="scroll-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="3"></th>
                    <th colspan="3">MDSCSI Sales TC/AC</th>
                    <th></th>
                    <th colspan="3">Voice Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3">Web Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3">GcashMiniProgram Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3">Mobile Apps Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3">CTC Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3">fbchatbot Sales / TC /AC</th>
                    <th></th>
                    <th colspan="3"></th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Dayname</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>Gross Actual</th>
                    <th>GC</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>GC Below Promised Time</th>
                    <th>% CRT Below Promised Time</th>
                </tr>
            </thead>
            <tbody>


            <?php
                    for($x=0;$x<32;$x++){
                ?>
                    <tr>
                        
                        <td><?=$data['monthly']['mdscsi'][$x]['date'];?></td>
                        <td><?=$data['monthly']['voice'][$x]['day'];?></td>
                        <td></td>
                        <td><?=$data['monthly']['mdscsi'][$x]['ga'];?></td>
                        <td><?=$data['monthly']['mdscsi'][$x]['gc'];?></td>
                        <td><?=$data['monthly']['mdscsi'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['voice'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['voice'][$x]['ga'];?></td>
                        <td><?= $data['monthly']['voice'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['web'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['web'][$x]['ga'];?></td>
                        <td><?= $data['monthly']['web'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['gcashminiprogram'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][$x]['ga'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['mobile_app'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['mobile_app'][$x]['ga'];?></td>
                        <td><?=  $data['monthly']['mobile_app'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['ctc'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['ctc'][$x]['ga'];?></td>
                        <td><?= $data['monthly']['ctc'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['fbchatbot'][$x]['gc'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][$x]['ga'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][$x]['ac'];?></td>
                        <td></td>
                        <td><?=$data['monthly']['mdscsi'][$x]['tc_below'];?></td>
                        <td><?=$data['monthly']['mdscsi'][$x]['crt'];?>%</td>
                        
                    </tr>
                <?php
                    }
                ?>
            </tbody>

            <tbody>
               
            </tbody>
        </table>
    </div>
</div>


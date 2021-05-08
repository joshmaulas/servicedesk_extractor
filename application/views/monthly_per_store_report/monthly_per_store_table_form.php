<?php

// echo "<pre>";
// print_r($data);
// echo "<pre>";


?>
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Monthly Reports per Store- <?=$month. "-".$year?></div>
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/Monthly_report_per_store_<?=$month."-".$year;?>.csv"><span class="badge badge-warning">Download File</span></a></div>
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
                    <th>Store Code</th>
                    <th>Store Name</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>TC</th>
                    <th>Gross Sales</th>
                    <th>Gross AC</th>
                    <th></th>
                    <th>GC Below Promised Time</th>
                    <th>% CRT Below Promised Time</th>
                </tr>
            </thead>
            <tbody>

            <?php
                   foreach($data['monthly']['mdscsi'][0] as $x => $arr){
                ?>
                    <tr>
                        
                        <td><?=$data['monthly']['mdscsi'][0][$x]['store_code'];?></td>
                        <td><?=$data['monthly']['mdscsi'][0][$x]['store_name'];?></td>
                        <td></td>
                        <td><?=$data['monthly']['mdscsi'][0][$x]['gc'];?></td>
                        <td><?=$data['monthly']['mdscsi'][0][$x]['ga'];?></td>
                        <td><?=$data['monthly']['mdscsi'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['voice'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['voice'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['voice'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['web'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['web'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['web'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['gcashminiprogram'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['mobile_app'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['mobile_app'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['mobile_app'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['ctc'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['ctc'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['ctc'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['fbchatbot'][0][$x]['gc'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][0][$x]['ga'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['mdscsi'][0][$x]['tc_below'];?></td>
                        <td><?= $data['monthly']['mdscsi'][0][$x]['crt'];?>%</td>

                    </tr>
                <?php
                    }

                ?>
                    <tr>
                        
                        <td><?=$data['monthly']['mdscsi'][1]['store_code'];?></td>
                        <td><?=$data['monthly']['mdscsi'][1]['store_name'];?></td>
                        <td></td>
                        <td><?=$data['monthly']['mdscsi'][1]['gc'];?></td>
                        <td><?=$data['monthly']['mdscsi'][1]['ga'];?></td>
                        <td><?=$data['monthly']['mdscsi'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['voice'][1]['gc'];?></td>
                        <td><?= $data['monthly']['voice'][1]['ga'];?></td>
                        <td><?= $data['monthly']['voice'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['web'][1]['gc'];?></td>
                        <td><?= $data['monthly']['web'][1]['ga'];?></td>
                        <td><?= $data['monthly']['web'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['gcashminiprogram'][1]['gc'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][1]['ga'];?></td>
                        <td><?= $data['monthly']['gcashminiprogram'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['mobile_app'][1]['gc'];?></td>
                        <td><?= $data['monthly']['mobile_app'][1]['ga'];?></td>
                        <td><?= $data['monthly']['mobile_app'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['ctc'][1]['gc'];?></td>
                        <td><?= $data['monthly']['ctc'][1]['ga'];?></td>
                        <td><?= $data['monthly']['ctc'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['fbchatbot'][1]['gc'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][1]['ga'];?></td>
                        <td><?= $data['monthly']['fbchatbot'][1]['ac'];?></td>
                        <td></td>
                        <td><?= $data['monthly']['mdscsi'][1]['tc_below'];?></td>
                        <td><?= $data['monthly']['mdscsi'][1]['crt'];?>%</td>

                    </tr>
            </tbody>

        </table>
    </div>
</div>


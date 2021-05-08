<?php

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";

?>
<div class="navbar navbar-inner block-header">
    <!-- <div class="muted pull-left">Monthly Reports - <?=$month."-".$year?></div> -->
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/breakfast_sales_report_<?=$month_breakfast."-".$year_breakfast;?>.csv"><span class="badge badge-warning">Download File</span></a></div>
</div>

<div class="block-content collapse in">
    <div class="scroll-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="3">Store Code</th>
                    <th colspan="3">Store Name</th>
                    <th colspan="3">TC </th>
                    <th colspan="3">Gross Sales</th>
                    <th colspan="3">Net Sales</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>

			<?php
			foreach($data as $x => $value){
			?>
                <tr>
                    <td colspan="3"><?=$data[$x]['store_code'] ?></td>
                    <td colspan="3"><?=$data[$x]['store_name'] ?></td>
                    <td colspan="3"><?=$data[$x]['tc'] ?></td>
                    <td colspan="3"><?=$data[$x]['sales'] ?></td>
                    <td colspan="3"><?=$data[$x]['net_sales'] ?></td>
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


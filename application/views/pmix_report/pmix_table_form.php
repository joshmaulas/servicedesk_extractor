<?php 
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";



?>


<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Product Mix Reports - <?=$month."-".$year?></div>
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/PMIX_report_<?= $month."-".$year;?>.csv"><span class="badge badge-warning">Download File</span></a></div>
</div>

<div class="block-content collapse in">
    <div class="scroll-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Poscode</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>UPT</th>
                    <th>Net Sales</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            <?php
                   foreach($data[0] as $x => $arr){
                ?>
                    <tr>
                        
                        <td><?=$data[0][$x]['child_item_poscode'];?></td>
                        <td><?=$data[0][$x]['name'];?></td>
                        <td><?=$data[0][$x]['category'];?></td>
                        <td><?=$data[0][$x]['quantity'];?></td>
                        <td><?=$data[0][$x]['upt'];?></td>
                        <td><?=$data[0][$x]['net_sales'];?></td>

                    </tr>
                <?php
                    }

                ?>
                    <tr>
                        
                        <td><?=$data[1]['child_item_poscode'];?></td>
                        <td><?=$data[1]['name'];?></td>
                        <td><?=$data[1]['category'];?></td>
                        <td><?=$data[1]['quantity'];?></td>
                        <td><?=$data[1]['upt'];?></td>
                        <td><?=$data[1]['net_sales'];?></td>

                    </tr>

            </tbody>

            <tbody>
               
            </tbody>
        </table>
    </div>
</div>


<?php
// echo "<pre>";
// print_r($store);
// echo "<pre>";
?>

 <div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Calls Plot Detailed </div>
    <div class="pull-right"><a href="<?php echo base_url();?>pages/download/calls_plot_<?=$storeID."_".$calls_plot_date_from."_".$calls_plot_date_to;?>.csv"><span class="badge badge-warning">Download File</span></a></div>
    </div>
<div class="block-content collapse in">
	<div class="scroll-table">
		<table class="table table-bordered">
		<thead>
		<tr>
			<td style="text-align:center; font-weight:bold" colspan="7"><?=$storeID."-".$store[0]['store_name']?> Calls Plot	</td>
		</tr>
		<tr>
			<th>City</th>
			<th>Barangay</th>
			<th>Street</th>
			<th>Landmark</th>
			<th>Total Orders</th>
			<th>Total Gross</th>
			<th>Promised Time</th>
		</tr>
			

			<?php
			foreach($data as $x => $value){
			?>
		<tr>
			<td><?=$data[$x]['city_name'] ?></td>
			<td><?=$data[$x]['brgy'] ?></td>
			<td><?=$data[$x]['Location'] ?></td>
			<td><?=$data[$x]['landmark'] ?></td>
			<td><?=$data[$x]['total_order'] ?></td>
			<td><?=$data[$x]['total_gross'] ?></td>
			<td><?=$data[$x]['promised_time'] ?></td>
		</tr>
				


			<?php
			}

			?>

		
		<?php
            // $output = '';

			// while ($hubs = $result->fetch_array()) {
               
			// 	// echo "<pre>";
			// 	// print_r($result_arr);
			// 	// echo "</pre>";
            //     $output .=
			// 	"<tr>
            //     <td >".$hubs['city_name']."</td>
			// 	<td >".$hubs['brgy']."</td>
			// 	<td >".$hubs['Location']."</td>
			// 	<td >".$hubs['landmark']."</td>
			// 	<td >1</td>
			// 	<td >".$hubs['total_gross']."</td>
			// 	<td >".$hubs['promised_time']."</td>";
                

			// 	// for csv content

			// 	$csv_string .= $hubs['city_name'].",";
			// 	$csv_string .= $hubs['brgy'].",";
			// 	$csv_string .= $hubs['Location'].",";
			// 	$csv_string .= $hubs['landmark'].",";
			// 	$csv_string .= "1,";
			// 	$csv_string .= $hubs['total_gross'].",";
			// 	$csv_string .= $hubs['promised_time'].",";
			// 	$csv_string .= "\n";

			// }
            // echo $output; 
			// $csv_string .= "\n";
			
		?>
        </tr>

	</thead>
</table>


   </div>

</div>

<style>

	.muted{
		color: red !important;
		font-weight: bold;
	}

</style>


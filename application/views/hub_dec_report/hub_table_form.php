<?php
// database connections
// include("../../config/db_connect.php");
include("../../config/functions.php");

$param = array();
$param['date_from'] = $_POST['date_from'];
$param['date_to'] = $_POST['date_to'];



function hub_dec_report($param){
	include("../../config/db_connect.php");
	$array_result = array();

		$sql = "SELECT
                    ofs_stores.`code`,
                    ofs_stores.store_name,
                    ofs_profit_center_type.type AS profit_center,
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'As Advised') THEN 1 END) AS 'as advised',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Others') THEN 1 END) AS 'others',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Scheduled - Under Renovation') THEN 1 END) AS 'under renovation',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Scheduled - Rest Day') THEN 1 END) AS 'rest day',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Store Capacity - Many Pending Orders') THEN 1 END) AS 'many pending orders',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Store Capacity - Preparing for LFO') THEN 1 END) AS 'preparing for lfo',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Rider Capacity - No Rider') THEN 1 END) AS 'no rider',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Rider Capacity - 1 Rider Available') THEN 1 END) AS '1 rider available',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Rider Capacity - 2 Riders Available') THEN 1 END) AS '2 riders available',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Rider Capacity - Limited Rider') THEN 1 END) AS 'limited rider',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Technical - Connectivity Issues') THEN 1 END) AS 'connectivity issues',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Technical - Computer Hardware Issues') THEN 1 END) AS 'computer hardware issues',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Technical - Computer Software Issues') THEN 1 END) AS 'computer software issues',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Technical - Electric Supply Issues') THEN 1 END) AS 'electric supply issues',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Technical - Equipment Issues') THEN 1 END) AS 'equipment issues',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Weather Condition - Heavy Rain') THEN 1 END) AS 'heavy rain',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Weather Condition - Unpassable Area') THEN 1 END) AS 'unpassable area',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Weather Condition - Flooded') THEN 1 END) AS 'Flooded',
                    COUNT(CASE WHEN (ofs_store_updates.subcategory = 'Weather Condition - Flooded Delivery Area') THEN 1 END) AS 'flooded delivery area'
            FROM
                    ofs_stores
                        LEFT JOIN ofs_store_updates ON (ofs_stores.`code` = ofs_store_updates.store_code AND ofs_store_updates.timestamp BETWEEN '".$param['date_from']." 00:00:00' AND '". $param['date_to'] ." 23:59:59' AND ofs_store_updates.category != '30min Delivery Time')
                        INNER JOIN ofs_profit_center_type ON ofs_stores.profit_center_type = ofs_profit_center_type.id
            WHERE
                ofs_stores.is_active = 1
            GROUP BY
                ofs_stores.`code`,
                ofs_store_updates.store_name
            ORDER BY
                ofs_stores.store_name,
                ofs_profit_center_type.type ASC";

		$result = $query_hub->query($sql);

		return $result;

		
}

 ?>
 <div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Hub Declaration Detailed </div>
    <div class="pull-right"><a href="download.php?download=hubdec-report-<?php echo $param['date_from']."to".$param['date_to'].".csv"?>"><span class="badge badge-warning">Download File</span></a></div>
</div>
<div class="block-content collapse in">
	<div class="scroll-table">
		<table class="table table-bordered">
		<thead>
		<tr>
			<th colspan="3">Store Code</th>
			<th colspan="3">Profit Center</th>
			<th colspan="3">Store Name</th>
			<th colspan="3">As Advised</th>
			<th colspan="3">Others</th>
			<th colspan="3">Under Renovation</th>
			<th colspan="3">Rest Day</th>
			<th colspan="3">Many Pending Orders</th>
			<th colspan="3">Preparing For LFO</th>
			<th colspan="3">No Rider</th>
			<th colspan="3">Limited Rider</th>
			<th colspan="3">Connectivity Issues</th>
			<th colspan="3">Computer Hardware Issues</th>
			<th colspan="3">Computer Software Issues</th>
			<th colspan="3">Electric Supply Issues</th>
			<th colspan="3">Equipment Issues</th>
			<th colspan="3">Heavy Rain</th>
			<th colspan="3">Unpassable Area</th>
			<th colspan="3">Flooded</th>
			<th colspan="3">Flooded Delivery Area</th>

			<!-- For csv header -->

			<?php

				$csv_string = "Store Code,";
			 	$csv_string .= "Profit Center,";
			 	$csv_string .= "Store Name,";
			 	$csv_string .= "As Advised,";
			 	$csv_string .= "Others,";
			 	$csv_string .= "Under Renovation,";
			 	$csv_string .= "Rest Day,";
			 	$csv_string .= "Many Pending Orders,";
			 	$csv_string .= "Preparing for LFO,";
			 	$csv_string .= "No rider,";
			 	$csv_string .= "Limited rider,";
			 	$csv_string .= "Connectivity Issues,";
			 	$csv_string .= "Computer hardware issues,";
			 	$csv_string .= "Computer software issues,";
			 	$csv_string .= "Electric supply issues,";
			 	$csv_string .= "Equipment issues,";
			 	$csv_string .= "Heavy rain,";
			 	$csv_string .= "Unpassable area,";
			 	$csv_string .= "Flooded,";
			 	$csv_string .= "Flooded delivery area";

			    $csv_string .= "\n";

			?>

		</tr>
		<?php
			$hub_details = hub_dec_report($param);

			$result_arr = array();

			while ($hubs = $hub_details->fetch_array()) {
				$result_arr = $hubs;

				// echo "<pre>";
				// print_r($result_arr);
				// echo "</pre>";
				echo "<tr><td colspan='3'>".$hubs['code']."</td>";
				echo "<td colspan='3'>".$hubs['profit_center']."</td>";
				echo "<td colspan='3'>".$hubs['store_name']."</td>";
				echo "<td colspan='3'>".$hubs['as advised']."</td>";
				echo "<td colspan='3'>".$hubs['others']."</td>";
				echo "<td colspan='3'>".$hubs['under renovation']."</td>";
				echo "<td colspan='3'>".$hubs['rest day']."</td>";
				echo "<td colspan='3'>".$hubs['many pending orders']."</td>";
				echo "<td colspan='3'>".$hubs['preparing for lfo']."</td>";
				echo "<td colspan='3'>".$hubs['no rider']."</td>";
				echo "<td colspan='3'>".$hubs['limited rider']."</td>";
				echo "<td colspan='3'>".$hubs['connectivity issues']."</td>";
				echo "<td colspan='3'>".$hubs['computer hardware issues']."</td>";
				echo "<td colspan='3'>".$hubs['computer software issues']."</td>";
				echo "<td colspan='3'>".$hubs['electric supply issues']."</td>";
				echo "<td colspan='3'>".$hubs['equipment issues']."</td>";
				echo "<td colspan='3'>".$hubs['heavy rain']."</td>";
				echo "<td colspan='3'>".$hubs['unpassable area']."</td>";
				echo "<td colspan='3'>".$hubs['Flooded']."</td>";
				echo "<td colspan='3'>".$hubs['flooded delivery area']."</td>";

				// for csv content

				$csv_string .= $hubs['code'].",";
				$csv_string .= $hubs['profit_center'].",";
				$csv_string .= $hubs['store_name'].",";
				$csv_string .= $hubs['as advised'].",";
				$csv_string .= $hubs['others'].",";
				$csv_string .= $hubs['under renovation'].",";
				$csv_string .= $hubs['rest day'].",";
				$csv_string .= $hubs['many pending orders'].",";
				$csv_string .= $hubs['preparing for lfo'].",";
				$csv_string .= $hubs['no rider'].",";
				$csv_string .= $hubs['limited rider'].",";
				$csv_string .= $hubs['connectivity issues'].",";
				$csv_string .= $hubs['computer hardware issues'].",";
				$csv_string .= $hubs['computer software issues'].",";
				$csv_string .= $hubs['electric supply issues'].",";
				$csv_string .= $hubs['equipment issues'].",";
				$csv_string .= $hubs['heavy rain'].",";
				$csv_string .= $hubs['unpassable area'].",";
				$csv_string .= $hubs['Flooded'].",";
				$csv_string .= $hubs['flooded delivery area'].",";

				$csv_string .= "\n";

			}
			// $csv_string .= "\n";
			echo "</tr>";
		?>

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

 <?php

 	/**
 	 * Create File for hub dec reason report
 	 */




    $file_name_monthly = "hubdec-report-".$param['date_from']."to".$param['date_to'];
    $file_location_hubdec = "csv_reports/hubdec_reason_report/";
 	create_report_file($csv_string,$file_location_hubdec,$file_name_monthly,"w");
 ?>

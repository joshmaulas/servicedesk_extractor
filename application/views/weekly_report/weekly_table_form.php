
<?php
// databse connections
include("../../config/db_connect.php");
include("../../config/functions.php");

$datepick = $_POST['date_for_weekly'];
$d_rang = $_POST['d_range'];


$year = intval(date("Y", strtotime($datepick)));
$month = intval(date("n", strtotime($datepick)));
$day = intval(date("d", strtotime($datepick)));


$arr = processArray($year, $month, $day, $d_rang);
$arr_ft = getDayBetween($year, $month, $day, $d_rang);

function processArray($year, $month, $day, $r){
	$days = getDayBetween($year, $month, $day, $r);
	$arr = array('weekly' => detailSql($year, $month, $days['from'], $days['to']));

	$arrs= detailSqlP2($year, $month, $days['from'], $days['to'], $arr);
	return $arrs;
}

function detailSqlP2($year, $month, $from, $to, $arr){
	//pr($arr);
	$from_date = $year."-".$month."-".$from;
	$to_date = $year."-".$month."-".$to;

	include("../../config/db_connect.php");
	$sql = "SELECT
                ofs_stores.code as code,
                ofs_stores.store_name,
                ofs_profit_center_type.type AS profit_center,
                COUNT(CASE WHEN (ofs_store_updates.category = '45min Delivery Time') THEN 1 END) AS '45min',
                COUNT(CASE WHEN (ofs_store_updates.category = '60min (1hr) Delivery Time') THEN 1 END) AS '60min',
                COUNT(CASE WHEN (ofs_store_updates.category = '90min (1hr 30mins) Delivery Time') THEN 1 END) AS '90min',
                COUNT(CASE WHEN (ofs_store_updates.category = '120min (2hr) Delivery Time') THEN 1 END) AS '120min',
                COUNT(CASE WHEN (INSTR(ofs_store_updates.category,'Relay') > 0) THEN 1 END) AS 'Relay',
                COUNT(CASE WHEN (ofs_store_updates.category = 'On-Hold Delivery') THEN 1 END) AS 'hold',
                COUNT(CASE WHEN (ofs_store_updates.category = 'Close Store') THEN 1 END) AS 'closed'
            FROM
                ofs_stores
                    LEFT JOIN ofs_store_updates ON (ofs_stores.code = ofs_store_updates.store_code AND ofs_store_updates.timestamp BETWEEN '". $from_date ." 00:00:00' AND '". $to_date ." 23:59:59')
                    INNER JOIN ofs_profit_center_type ON ofs_stores.profit_center_type = ofs_profit_center_type.id
            WHERE
                ofs_stores.is_active = 1
            GROUP BY
                ofs_stores.`code`,
                ofs_store_updates.store_name
            ORDER BY
                ofs_stores.store_name,
                ofs_profit_center_type.type ASC";
		$ress = $query_hub->query($sql);
		$arr_hub = array();
		while($res = $ress->fetch_array()){
			$data = array(
				'sc' => $res['code'],
				'min45' => $res['45min'],
				'min60' => $res['60min'],
				'min90' => $res['90min'],
				'min120' => $res['120min'],
				'relay' => $res['Relay'],
				'hold' => $res['hold'],
				'closed' => $res['closed']
			);

			array_push($arr_hub, $data);

		}
		foreach ($arr['weekly'] as $key => $value) {
			//pr($key);

			$arr['weekly'][$key]['hub_dec'] = array(
				'min45' => 0,
				'min60' => 0,
				'min90' => 0,
				'min120' => 0,
				'relay' => 0,
				'hold' => 0,
				'closed' => 0
			);
			foreach ($arr_hub as $x => $val) {
				//pr($arr_hub[$x]['sid'] .' = '. $arr['weekly'][$key]['sid'] );
				if($arr_hub[$x]['sc'] == $arr['weekly'][$key]['sc']){
					$arr['weekly'][$key]['hub_dec']['min45'] = $arr_hub[$x]['min45'];
					$arr['weekly'][$key]['hub_dec']['min60'] = $arr_hub[$x]['min60'];
					$arr['weekly'][$key]['hub_dec']['min90'] = $arr_hub[$x]['min90'];
					$arr['weekly'][$key]['hub_dec']['min120'] = $arr_hub[$x]['min120'];
					$arr['weekly'][$key]['hub_dec']['relay'] = $arr_hub[$x]['relay'];
					$arr['weekly'][$key]['hub_dec']['hold'] = $arr_hub[$x]['hold'];
					$arr['weekly'][$key]['hub_dec']['closed'] = $arr_hub[$x]['closed'];

				}

			}
		}
		return $arr;
}

function detailSql($year, $month, $from, $to){

	include("../../config/db_connect.php");
	error_reporting(E_ALL & ~E_NOTICE);
	$arr_result = array();
	        $sql = "SELECT
	            	os.`id` as sid,
	                os.`code` AS st_code,
	                pc.`type` AS profit_center,
	                os.`store_name` AS store,
	                COUNT(oo.`id`) AS total_calls,
	                COUNT(IF(30 > TIMESTAMPDIFF(MINUTE, oo.`order_date`, oo.`customer_receive_datetime`), 30, NULL)) AS tc_below,
	                IFNULL(SUM(oo.`total_gross`), 0) AS tg_below
	                FROM `ofs_stores` as os
	                LEFT JOIN `ofs_orders` as oo ON  oo.`store_id` = os.`id`
	                LEFT JOIN `ofs_profit_center_type` as pc ON  pc.`id` = os.`profit_center_type`
	    		    WHERE
	                oo.`status` = 5 AND os.`is_active` = 1
	                AND oo.`year` = $year and oo.`month` = $month and oo.`day` BETWEEN $from and $to
	                GROUP BY os.`id`
	                ORDER BY pc.`type`, os.`code` ASC";

	        $ress = $query->query($sql);
	        while($res = $ress->fetch_array()){
				$crt = 0;
				$crt = noerror_divide($res['tc_below'], $res['total_calls']) * 100;
	            $data = array(
	                'sid' => $res['sid'],
	                'pc' => $res['profit_center'],
	                'sc' => $res['st_code'],
	                'sn' => $res['store'],
	                'details' => array(
	                    'tc' => $res['total_calls'],
	                    'tcb' => $res['tc_below'],
	                    'tgb' => $res['tg_below'],
						'crt' => $crt
	                	)
	                );
	            array_push($arr_result, $data);
	        }

	return $arr_result;

}


function getDayBetween($year, $month, $day,$range){
	$bet = array('from' => 1, 'to' => 7);
	$num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	$bet['from'] = $day;
	$bet['to'] = $day + 6;

	if($bet['to'] > $num_of_days && $range == 'weekly'){
		$bet['to'] = $num_of_days;
	}
	else if($range == 'daily'){
		$bet['to'] = $day;
	}

	return $bet;
}

$csv_weekly = "\n\nStore Code,Profit Center,Store Name,Total TC,TC Below Prosime Time,Sale Below Promise Time,% CRT Below Promise Time,,\n";
?>
<div class="navbar navbar-inner block-header">
	<div class="muted pull-left">Hub Declaration Summary - <?=$year."-".$month."-".$arr_ft['from']." to ".$year."-".$month."-".$arr_ft['to']?></div>
	<div class="pull-right"><a href="download.php?download=weekly-report-<?php echo $year."-".$month."-".$arr_ft['from']."to".$year."-".$month."-".$arr_ft['to'];?>.csv"><span class="badge badge-warning">Download File</span></a></div>
</div>
<div class="block-content collapse in">
	<div class="scroll-table">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th style="width:30px;" rowspan="2">Store&nbspCode</th>
					<th class="span2"rowspan="2">Profit&nbspCenter</th>
					<th class="span2"rowspan="2">Store&nbspName</th>
					<th class="span2" colspan="4">Extended&nbspPromise&nbspTime</th>
					<th class="span2"rowspan="2">Relay</th>
					<th class="span2"rowspan="2">Hold</th>
					<th class="span2"rowspan="2">Closed</th>
					<th class="span2"rowspan="2">Total&nbspTC</th>
					<th class="span2"rowspan="2">TC&nbspBelow&nbspPromise&nbspTime</th>
					<th class="span2"rowspan="2">Sales&nbspBelow&nbspPromise&nbspTime</th>
					<th class="span2"rowspan="2">%&nbspCRT&nbspBelow&nbspPromise&nbspTime</th>

				</tr>
				<tr>
					<th class="span2">45min</th>
					<th class="span2">60min</th>
					<th class="span2">90min</th>
					<th class="span2">120min</th>

			</thead>
			<tbody>
				<?php
				foreach ($arr['weekly'] as $key => $value) {
				?>
					<tr>
						<td><?=$arr['weekly'][$key]['sc'];?></td>
						<td><?=$arr['weekly'][$key]['pc'];?></td>
						<td><?=$arr['weekly'][$key]['sn'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['min45'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['min60'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['min90'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['min120'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['relay'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['hold'];?></td>
						<td><?=$arr['weekly'][$key]['hub_dec']['closed'];?></td>
						<td><?=num_format($arr['weekly'][$key]['details']['tc']);?></td>
						<td><?=num_format($arr['weekly'][$key]['details']['tcb']);?></td>
						<td><?=num_format($arr['weekly'][$key]['details']['tgb']);?></td>
						<td><?=num_format($arr['weekly'][$key]['details']['crt']);?>%</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
$csv_weekly = "\n\nStore Code,Profit Center,Store Name,45min,60min,90min,120min,Relay,Hold,Closed,Total TC,TC Below Promise Time,Sales Below Promise Time,% CRT Below Promise Time,,\n";

foreach ($arr['weekly'] as $key => $value) {
	$csv_weekly .= $arr['weekly'][$key]['sc'].",";
	$csv_weekly .= $arr['weekly'][$key]['pc'].",";
	$csv_weekly .= $arr['weekly'][$key]['sn'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['min45'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['min60'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['min90'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['min120'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['relay'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['hold'].",";
	$csv_weekly .= $arr['weekly'][$key]['hub_dec']['closed'].",";
	$csv_weekly .= $arr['weekly'][$key]['details']['tc'].",";
	$csv_weekly .= $arr['weekly'][$key]['details']['tcb'].",";
	$csv_weekly .= preg_replace('/\.(\d{2}).*/', '.$1',$arr['weekly'][$key]['details']['tgb']).",";
	$csv_weekly .= preg_replace('/\.(\d{2}).*/', '.$1',$arr['weekly'][$key]['details']['crt'])."%,,\n";
}
$file_location_hourly = "";
$file_name_hourly = $year."-".$month."-".$arr_ft['from']."to".$year."-".$month."-".$arr_ft['to'];
//run to create hourly report script:
$file_location_hourly = "csv_reports/weekly_report/";
//run to create hourly report script:
create_report_file($csv_weekly,$file_location_hourly,"weekly-report-".$file_name_hourly,"w");
?>

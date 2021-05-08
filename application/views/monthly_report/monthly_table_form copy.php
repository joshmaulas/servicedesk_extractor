
<?php



    include("../../config/functions.php");


    $param['year'] = $_POST['year'];
    $param['month'] = $_POST['month'];
    $monthName = date('F', strtotime($param['year']."-".$param['month']));

    $date = getDateNeed($param['year'], $param['month']);

    $arr = array('monthly' => array());
    $arr['monthly'] = array(
        'mdscsi' => array(),
        'voice' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'voice'),
        'web' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'web'),
        'gcashminiprogram' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'gcashminiprogram'),
        'mobile_app' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'mobile_app'),
        'ctc' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'ctc'),
        'fbchatbot' => queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'fbchatbot')
    );
    $arr['monthly']['mdscsi'] = getOverAll($arr);

    function queryForMonth($year, $month, $from, $to, $source){
        include("../../config/db_connect.php");

    	switch ($source) {
    		case 'voice':
    			$src = 1;
    			break;
    		case 'web':
    			$src = 2;
    			break;
    		case 'gcashminiprogram':
    			$src = 11;
    			break;
    		case 'mobile_app':
    			$src = 6;
    			break;
    		case 'ctc':
    			$src = 4;
    			break;
            case 'fbchatbot':
                $src = 10;
                break;
    		default:
    			# code...
    			$src = 1;
    			break;
    	}

        $select_query = "SELECT 1 as days ";
    	$temp_arr = array();
    	for($x=$from;$x<=$to;$x++){
            $select_query .= "UNION SELECT $x ";
        }
    	$ac = 0;
    	$daily_sql =   "SELECT IFNULL(SUM(total_gross),0) as total_gross,
                        COUNT(id) as total_calls, days,
                        IFNULL(SUM(total_gross)/COUNT(id),0) as ac,
                        COUNT(IF(30 > TIMESTAMPDIFF(MINUTE, order_date, customer_receive_datetime), 30, NULL)) AS tc_below
                        FROM($select_query) AS Alldays
                        LEFT JOIN `ofs_orders` ON day = days
                                AND source_id = $src
                                AND status = 5
                                AND year = $year
                                AND month = $month
                        GROUP BY days
                        ORDER BY days";
    	$res_daily_sql = $query->query($daily_sql);
    	while($result = $res_daily_sql->fetch_array()){
    		$res_arr = array(
                                'date' => $year."-".$month."-".$result['days'],
                                'day' => date('l',strtotime($year."-".$month."-".$result['days'])),
                                'ga' => $result['total_gross'], 'gc' => $result['total_calls'],
                                'ac' => $result['ac'],
                                'tc_below' => $result['tc_below']
                            );
    		array_push($temp_arr , $res_arr);
    	}

        $mtd = array();
        $mtd = getTotalUpdate($temp_arr);
    	array_push($temp_arr, getTotalUpdate($temp_arr));
        array_push($temp_arr, getTrend($mtd, $year, $month));

    	return $temp_arr;

    }
    function getTotalUpdate($arr = array()){
        $totalGross = 0;
        $totalCall = 0;
        $totalAc = 0;
        $totalTcBelow = 0;
        foreach ($arr as $key => $value) {
            # code...
            $totalGross += $arr[$key]['ga'];
            $totalCall += $arr[$key]['gc'];
            $totalTcBelow += $arr[$key]['tc_below'];

        }
        $totalAc = noerror_divide($totalGross, $totalCall);
        $newArr = array(
                        'date' => 'MTD Sales',
                        'day' => '',
                        'ga' => $totalGross,
                        'gc' => $totalCall,
                        'ac' => $totalAc,
                        'tc_below' => $totalTcBelow
                    );

        return $newArr;
    }

    /**
     * [getTrend description]
     * @param  [type] $arr   [description]
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    function getTrend($arr,$year,$month){
        $d = getDateNeed($year, $month);
        $provi = $d['to'];
        $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $temp = array();
        $trend = noerror_divide($arr['ga'] , $provi) * $last;

        $temp = array(
                        'date' => 'TREND Sales',
                        'day' => '',
                        'ga' => $trend,
                        'gc' => ' ',
                        'ac' => ' ',
                        'tc_below' => ' '
                    );

        return $temp;
    }


    /**
     * [getOverAll description]
     * @param  [type] $arr [description]
     * @return [type]      [description]
     */
    function getOverAll($arr){
    	$temp_arr = array();
    	foreach ($arr['monthly']['voice'] as $x => $value) {
            if(count($arr['monthly']['voice']) - 1 != $x){
        		$temp_gc = 0;
        		$temp_ac = 0;
        		$temp_tc = 0;
                $temp_tcbelow = 0;

                $temp_tcbelow = $arr['monthly']['voice'][$x]['tc_below'] +
                                $arr['monthly']['web'][$x]['tc_below'] +
                                $arr['monthly']['gcashminiprogram'][$x]['tc_below'] +
                                $arr['monthly']['mobile_app'][$x]['tc_below'] + 
                                $arr['monthly']['ctc'][$x]['tc_below'] + 
                                $arr['monthly']['fbchatbot'][$x]['tc_below'];

        		$temp_gc      = $arr['monthly']['voice'][$x]['ga'] +
                                $arr['monthly']['web'][$x]['ga'] +
                                $arr['monthly']['gcashminiprogram'][$x]['ga'] +
                                $arr['monthly']['mobile_app'][$x]['ga'] +
                                $arr['monthly']['ctc'][$x]['ga'] +
                                $arr['monthly']['fbchatbot'][$x]['ga'];

        		$temp_tc      = $arr['monthly']['voice'][$x]['gc'] +
                                $arr['monthly']['web'][$x]['gc'] +
                                $arr['monthly']['gcashminiprogram'][$x]['gc'] +
                                $arr['monthly']['mobile_app'][$x]['gc'] +
                                $arr['monthly']['ctc'][$x]['gc'] +
                                $arr['monthly']['fbchatbot'][$x]['gc'];

        		$temp_ac = noerror_divide($temp_gc , $temp_tc);
        		$res_arr = array(
                                'date' => $arr['monthly']['voice'][$x]['date'],
                                'day' => date('l',strtotime($arr['monthly']['voice'][$x]['date'])),
                                'ga' => $temp_gc, 'gc' => $temp_tc, 'ac' => $temp_ac,
                                'tc_below' => $temp_tcbelow
                            );
        		array_push($temp_arr, $res_arr);
        	}else{
                $date = explode('-', $arr['monthly']['voice'][$x-2]['date']);
                $tr = getTrend($temp_arr[$x-1], $date[0], $date[1]);
                array_push($temp_arr, $tr);
            }
        }
    	return $temp_arr;
    }

    /**
     * [getDateNeed description]
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    // function getDateNeed($year, $month){
    //     $now_year = intval(date("Y"));
    //     $now_month = intval(date("m"));

    //     $from = 1;
    //     $to = 1;

    //     if($now_year == $year && $now_month == $month){
    //         $to = intval(date("d")) - 1;
    //         if($to == 0){
    //             $to = 1;
    //         }
    //     }
    //     else {
    //         $to = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    //     }
    //     $date = array('year' => $year,
    //         'month' => $month,
    //         'from' => $from,
    //         'to' => $to
    //     );

    //     return $date;
    // }
?>

<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Monthly Reports - <?=$monthName. " ".$param['year']?></div>
    <div class="pull-right"><a href="download.php?download=monthly_report_<?php echo $monthName."-".$param['year'].".csv"?>"><span class="badge badge-warning">Download File</span></a></div>
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
                    foreach ($arr['monthly']['mdscsi'] as $key => $value) {
                ?>
                    <tr>
                        <td><?=$arr['monthly']['mdscsi'][$key]['date'];?></td>
                        <td><?=$arr['monthly']['voice'][$key]['day'];?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['mdscsi'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['mdscsi'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['mdscsi'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['voice'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['voice'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['voice'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['web'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['web'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['web'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['gcashminiprogram'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['gcashminiprogram'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['gcashminiprogram'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['mobile_app'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['mobile_app'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['mobile_app'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['ctc'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['ctc'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['ctc'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['fbchatbot'][$key]['ga']);?></td>
                        <td><?=num_format($arr['monthly']['fbchatbot'][$key]['gc']);?></td>
                        <td><?=num_format($arr['monthly']['fbchatbot'][$key]['ac']);?></td>
                        <td></td>
                        <td><?=num_format($arr['monthly']['mdscsi'][$key]['tc_below']);?></td>
                        <td><?=num_format(noerror_divide($arr['monthly']['mdscsi'][$key]['tc_below'], $arr['monthly']['mdscsi'][$key]['gc']) * 100);?></td>
                    </tr>
                <?php

                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php

    $csv_string = ",,,MDSCSI Sales TC/AC,";
    $csv_string .= ",,,Voice Sales TC/AC,";
    $csv_string .= ",,,Web Sales TC/AC,";
    $csv_string .= ",,,GcashMiniProgram Sales TC/AC,";
    $csv_string .= ",,,Mobile Apps Sales TC/AC,";
    $csv_string .= ",,,CTC Sales TC/AC,";
    $csv_string .= ",,,fbchatbot Sales TC/AC,";
    $csv_string .= "\n";
    $csv_string .= ",,,";
    for ($i=1; $i<=6; $i++) {
        $csv_string .= "Gross Actual,GC,Gross AC,,";
    }
    $csv_string .= "\n";


    foreach ($arr['monthly']['mdscsi'] as $key => $value) {
        $csv_string .= $arr['monthly']['mdscsi'][$key]['date'].",";
        $csv_string .= $arr['monthly']['voice'][$key]['day'].",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc'][$key]['ac']).",,";

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot'][$key]['ga']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot'][$key]['gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot'][$key]['ac']).",,";

        $csv_string .= "\n";
    }
    $file_location_monthly = "";
    $file_name_monthly = "monthly_report_".$monthName."-".$param['year'];
    //run to create hourly report script:
    $file_location_hourly = "csv_reports/monthly_report/";
    //run to create hourly report script:
    create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");
?>


<?php
// database connections

include("../../config/db_connect.php");
include("../../config/functions.php");

$datepick_temp = $_POST['date_for_daily'];
$datepick = date("Y-m-d", strtotime($datepick_temp));
$date_part = explode("-", $datepick_temp);
$year = intval($date_part[0]);
$month = intval($date_part[1]);
$day = intval($date_part[2]);

$arr = array('daily' => array());
$arr['daily']= array(
    'voice' => dailySqlQuery($year, $month, $day, 'voice'),
    'web' => dailySqlQuery($year, $month, $day, 'web'),
    'gcashminiprogram' => dailySqlQuery($year, $month, $day, 'gcashminiprogram'),
    'mobile_app' => dailySqlQuery($year, $month, $day, 'mobile_app'),
    'ctc' => dailySqlQuery($year, $month, $day, 'ctc'),
    'fbchatbot' => dailySqlQuery($year, $month, $day, 'fbchatbot')
);
array_push($arr, getOverAll($arr));

function dailySqlQuery($year, $month, $day, $source){
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


    $temp_arr = array();
    for($x=0;$x<24;$x++){
        $ac = 0;
        $daily_sql = "SELECT IFNULL(SUM(total_gross),0) as total_gross_per_hour, COUNT(id) as total_calls
                    FROM ofs_orders
                    WHERE year = $year AND month = $month AND day = $day AND HOUR = $x AND status = 5 AND source_id = $src";
        $res_daily_sql = $query->query($daily_sql);
        while($result = $res_daily_sql->fetch_array()){
            $ac = noerror_divide($result['total_gross_per_hour'] , $result['total_calls']);
            $res_arr = array('time' => $x, 'ga' => $result['total_gross_per_hour'], 'gc' => $result['total_calls'], 'ac' => $ac);
            array_push($temp_arr , $res_arr);
        }
    }
    array_push($temp_arr, getTotalUpdate($temp_arr));

    return $temp_arr;

}

function getTotalUpdate($arr = array()){
    $totalGross = 0;
    $totalCall = 0;
    $totalAc = 0;
    for($x = 0; $x < 24; $x++){
        $totalGross += $arr[$x]['ga'];
        $totalCall += $arr[$x]['gc'];

    }
    $totalAc = noerror_divide($totalGross, $totalCall);
    $newArr = array('time' => '', 'ga' => $totalGross, 'gc' => $totalCall, 'ac' => $totalAc);
    return $newArr;
}

function getOverAll($arr = array()){
    $temp_arr = array();
    for($x = 0; $x < 24; $x++){
        $temp_gc = 0;
        $temp_ac = 0;
        $temp_tc = 0;
        $temp_gc = $arr['daily']['voice'][$x]['ga'] + $arr['daily']['web'][$x]['ga'] + $arr['daily']['gcashminiprogram'][$x]['ga'] + $arr['daily']['mobile_app'][$x]['ga'] + $arr['daily']['ctc'][$x]['ga'] + $arr['daily']['fbchatbot'][$x]['ga'];
        $temp_tc = $arr['daily']['voice'][$x]['gc'] + $arr['daily']['web'][$x]['gc'] + $arr['daily']['gcashminiprogram'][$x]['gc'] + $arr['daily']['mobile_app'][$x]['gc'] + $arr['daily']['ctc'][$x]['gc'] + $arr['daily']['fbchatbot'][$x]['gc'];
        $temp_ac = noerror_divide($temp_gc, $temp_tc);
        $res_arr = array('time' => $x, 'ga' => $temp_gc, 'gc' => $temp_tc, 'ac' => $temp_ac);
        array_push($temp_arr, $res_arr);
    }
    array_push($temp_arr, getTotalUpdate($temp_arr));

    return $temp_arr;
}

?>
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Daily Reports - <?=$datepick_temp?></div>
    <!-- <div class="pull-right"><a href="download.php?download=daily-report-<?php echo $datepick;?>.csv"><span class="badge badge-warning">Download File</span></a></div> -->
    <div class="pull-right"><a href="<?php echo base_url(); ?>pages/download?download=daily-report-<?php echo $datepick;?>.csv"><span class="badge badge-warning">Download File</span></a></div>
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
                        <td><?= $arr[0][$x]['gc'];?></td>
                        <td><?= $arr[0][$x]['ga'];?></td>
                        <td><?= $arr[0][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['voice'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['voice'][$x]['ga'];?></td>
                        <td><?= $arr['daily']['voice'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['web'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['web'][$x]['ga'];?></td>
                        <td><?=  $arr['daily']['web'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['gcashminiprogram'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['gcashminiprogram'][$x]['ga'];?></td>
                        <td><?= $arr['daily']['gcashminiprogram'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['mobile_app'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['mobile_app'][$x]['ga'];?></td>
                        <td><?=  $arr['daily']['mobile_app'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['ctc'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['ctc'][$x]['ga'];?></td>
                        <td><?= $arr['daily']['ctc'][$x]['ac'];?></td>
                        <td></td>
                        <td><?= $arr['daily']['fbchatbot'][$x]['gc'];?></td>
                        <td><?= $arr['daily']['fbchatbot'][$x]['ga'];?></td>
                        <td><?= $arr['daily']['fbchatbot'][$x]['ac'];?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php

    $csv_string = ",,MDSCSI Sales TC/AC,,";
    $csv_string .= ",,Voice Sales TC/AC,,";
    $csv_string .= ",,Web Sales TC/AC,,";
    $csv_string .= ",,GcashMiniProgram Sales TC/AC,,";
    $csv_string .= ",,Mobile Apps Sales TC/AC,,";
    $csv_string .= ",,CTC Sales TC/AC,,";
    $csv_string .= ",,fbchatbot Sales TC/AC";
    $csv_string .= "\n";
    $csv_string .= ",,";
    for ($i=1; $i<=7; $i++) { 
        $csv_string .= "GC,Gross Actual,Gross AC,,";
    }
    $csv_string .= "\n";

    for($x=0;$x<25;$x++){
        $hour = "";
        if($x!=24){$hour .= $x;}
        $csv_string .= $hour.",,".preg_replace('/\.(\d{2}).*/', '.$1', $arr[0][$x]['gc']).",".$arr[0][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr[0][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['voice'][$x]['gc']).",".$arr['daily']['voice'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['voice'][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['web'][$x]['gc']).",".$arr['daily']['web'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['web'][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['gcashminiprogram'][$x]['gc']).",".$arr['daily']['gcashminiprogram'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['gcashminiprogram'][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['mobile_app'][$x]['gc']).",".$arr['daily']['mobile_app'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['mobile_app'][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['ctc'][$x]['gc']).",".$arr['daily']['ctc'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['ctc'][$x]['ac']).",,";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['fbchatbot'][$x]['gc']).",".$arr['daily']['fbchatbot'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $arr['daily']['fbchatbot'][$x]['ac']).",,\n";
    }
    $file_location_hourly = "";
    $file_name_hourly = $datepick;
    //run to create hourly report script:
    $file_location_hourly = "csv_reports/daily_report/";
    //run to create hourly report script:
    create_report_file($csv_string,$file_location_hourly,"daily-report-".$datepick,"w");
?>

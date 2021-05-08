<?php
    include("../../config/functions.php");

    $previous_date = $_POST['previous_date'];
    $present_date = $_POST['present_date'];
    $type = $_POST['type'];



    $comps_list = array();
    $growth_list = array();

    $title = "";
    $summary ="";
    $filename ="";


    switch ($type) {
        case 1:
            $title = "Daily Comps and Growth - Calendar Days";
            $d_prev = date("D, M j, y", strtotime($previous_date));
            $d_pres = date("D, M j, y", strtotime($present_date));

            $dprev = date("D-M-j-y", strtotime($previous_date));
            $dpres = date("D-M-j-y", strtotime($present_date));
            $d = date("y-m-d",strtotime($present_date));
            $filename = "DCG-$d-calendar";
            $summary = "Daily Calendar Days ($d_prev and $d_pres)";
            $arr = fetch_data_calendar($previous_date,$present_date);
            $comps_list = $arr['comps'];
            $growth_list = $arr['growth'];

            $total_list = array(
                'profit_center' => '',
                'store_code' => '',
                'store_name' => '',
                'prev_gc' => 0,
                'prev_sale' => 0,
                'pres_gc' => 0,
                'pres_sale' => 0,
                'comps_gc' => 0,
                'comps_sales' => 0
            );
            foreach ($comps_list as $key => $value) {
                $total_list['prev_gc'] = $total_list['prev_gc']+$comps_list[$key]['prev_gc'];
                $total_list['prev_sale'] = $total_list['prev_sale']+$comps_list[$key]['prev_sale'];
                $total_list['pres_gc'] = $total_list['pres_gc']+$comps_list[$key]['pres_gc'];
                $total_list['pres_sale'] = $total_list['pres_sale']+$comps_list[$key]['pres_sale'];
            }
            $total_list['comps_gc'] = noerror_divide(($total_list['pres_gc'] - $total_list['prev_gc']),$total_list['prev_gc']) * 100;
            $total_list['comps_sales'] = noerror_divide(($total_list['pres_sale'] - $total_list['prev_sale']),$total_list['prev_sale']) * 100;

            array_push($comps_list,$total_list);
            break;
        case 2:
            $title = "Daily Comps and Growth - Trading Days";
            $d_prev = date("D, M j, y", strtotime($previous_date));
            $d_pres = date("D, M j, y", strtotime($present_date));
            $d = date("y-m-d",strtotime($present_date));
            $filename = "DCG-$d-trading";
            $summary = "Daily Trading Days ($d_prev and $d_pres)";
            $arr = fetch_data_calendar($previous_date,$present_date);
            $comps_list = $arr['comps'];
            $growth_list = $arr['growth'];

            $total_list = array(
                'profit_center' => '',
                'store_code' => '',
                'store_name' => '',
                'prev_gc' => 0,
                'prev_sale' => 0,
                'pres_gc' => 0,
                'pres_sale' => 0,
                'comps_gc' => 0,
                'comps_sales' => 0
            );
            foreach ($comps_list as $key => $value) {
                $total_list['prev_gc'] = $total_list['prev_gc']+$comps_list[$key]['prev_gc'];
                $total_list['prev_sale'] = $total_list['prev_sale']+$comps_list[$key]['prev_sale'];
                $total_list['pres_gc'] = $total_list['pres_gc']+$comps_list[$key]['pres_gc'];
                $total_list['pres_sale'] = $total_list['pres_sale']+$comps_list[$key]['pres_sale'];
            }
            $total_list['comps_gc'] = noerror_divide(($total_list['pres_gc'] - $total_list['prev_gc']),$total_list['prev_gc']) * 100;
            $total_list['comps_sales'] = noerror_divide(($total_list['pres_sale'] - $total_list['prev_sale']),$total_list['prev_sale']) * 100;

            array_push($comps_list,$total_list);
            break;
        case 3:
                $arr = fetch_data_mtd($previous_date,$present_date);
                $title = "MTD Comps and Growth";

                $d = date("y-m-d",strtotime($present_date));
                $filename = "DCG-$d-mtd";
                $comps_list = $arr['comps'];
                $growth_list = $arr['growth'];
                $pres_date_part = explode("-", $present_date);
                $prev_date_part = explode("-", $previous_date);
                $mon = $pres_date_part[1];
                $da = intval($pres_date_part[2]);
                $y1 = $pres_date_part[0];
                $y2 = $prev_date_part[0];
                $monthn = date("F", strtotime($mon));
                $summary = "MTD (COMPS MTD - $monthn 1-$da, $y1 & $y2)";


            break;
        case 4:
            $comps_list = fetch_data_all($previous_date,$present_date);
            $d = date("y-m-d",strtotime($present_date));
            $filename = "DCG-$d-allstore";
            break;
        default:
            # code...
            break;
    }

    function fetch_data_calendar($previous_date,$present_date){
        include("../../config/db_connect.php");

        $store_list_all = array();
        $sql_store_all = "SELECT store_name, code, type FROM ofs_stores AS os LEFT JOIN ofs_profit_center_type AS op ON op.id = os.profit_center_type";
        $res = $query->query($sql_store_all);
        while($r = $res->fetch_array()){
            $data = array(
                'profit_center' => $r['type'],
                'store_code' => $r['code'],
                'store_name' => $r['store_name']
            );
            array_push($store_list_all, $data);
        }
        $store_list_active = array();
        $sql_store_active = "SELECT store_name, code, type FROM ofs_stores AS os LEFT JOIN ofs_profit_center_type AS op ON op.id = os.profit_center_type where os.is_active = 1";
        $res = $query->query($sql_store_active);
        while($r = $res->fetch_array()){
            $data = array(
                'store_code' => $r['code'],
                'store_name' => $r['store_name'],
                'pres_gc' => 0,
                'pres_sale' => 0
            );
            array_push($store_list_active, $data);
        }

        $prev_date_part = explode("-", $previous_date);
        $prev_year = intval($prev_date_part[0]);
        $prev_month = intval($prev_date_part[1]);
        $prev_day = intval($prev_date_part[2]);

        $pres_date_part = explode("-", $present_date);
        $pres_year = intval($pres_date_part[0]);
        $pres_month = intval($pres_date_part[1]);
        $pres_day = intval($pres_date_part[2]);

        $arr_for_past = array();
        $arr_for_present = array();
        $arr_for_growth = array();
        $monthName = date('F', mktime(0, 0, 0, $prev_month, 10));
        if(!file_exists("/var/www/mcd_reporting/csv_reports/comps_growth/$pres_year")){
            mkdir("/var/www/mcd_reporting/csv_reports/comps_growth/$pres_year");
        }
        if(!file_exists("/var/www/mcd_reporting/csv_reports/comps_growth/$pres_year/$monthName")){
            mkdir("/var/www/mcd_reporting/csv_reports/comps_growth/$pres_year/$monthName");
        }
        $file = fopen('/var/www/mcd_reporting/csv_reports/comps_growth/'.$prev_year.'/'.$monthName.'/'.$prev_date_part[1].''.$prev_date_part[2].''.$prev_date_part[0].'.csv', 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
          $gc = 0;
          $sale = 0;
          if($line[2] == NULL){
              $gc = 0;
          }
          else{
              $gc = $line[2];
          }

          if($line[3] == NULL){
              $sale = 0;
          }
          else{
              $sale = $line[3];
          }
          $data = array(
              'profit_center' => '',
              'store_code' => $line[0],
              'store_name' => $line[1],
              'prev_gc' => $gc,
              'prev_sale' => $sale,
              'pres_gc' => NULL,
              'pres_sale' => NULL,
              'comps_gc' => NULL,
              'comps_gc' => NULL,
              'comps_sales' => NULL
          );
          array_push($arr_for_past, $data);
        }
        $gc_prev = 0;
        $sale_prev = 0;
        foreach ($arr_for_past as $key => $value) {
            $gc_prev = $gc_prev + $arr_for_past[$key]['prev_gc'];
            $sale_prev = $sale_prev + $arr_for_past[$key]['prev_sale'];
        }
        $data_growth = array(
            'prev_date' => $previous_date,
            'pres_date' => $present_date,
            'prev_gc' => $gc_prev,
            'prev_sale' => $sale_prev,
            'pres_gc' => 0,
            'pres_sale' => 0,
            'comps_gc' => 0,
            'comps_sales' => 0
        );
        array_push($arr_for_growth,$data_growth);

        $query2 = mysqli_connect($servername, $username, $password, $dbname);
        $sql_2 = "SELECT
                os.`code` AS st_code,
                COUNT(oo.`id`) AS gc,
                IFNULL(SUM(oo.`total_gross`), 0) AS gs
                FROM `ofs_stores` as os
                LEFT JOIN `ofs_orders` as oo ON  oo.`store_id` = os.`id`
                WHERE
                oo.`status` = 5 and os.`is_active` = 1
                AND oo.`year` = $pres_year and oo.`month` = $pres_month and oo.`day` = $pres_day
                GROUP BY os.`id`";

        $ress2 = $query2->query($sql_2);

        while($res = $ress2->fetch_array()){
            $data = array(
                'store_code' => $res['st_code'],
                'pres_gc' => $res['gc'],
                'pres_sale' => $res['gs'],
                );
            array_push($arr_for_present, $data);
        }
        $gc_pres = 0;
        $sale_pres =0;

        foreach ($arr_for_present as $key => $value) {
            $gc_pres = $gc_pres + $arr_for_present[$key]['pres_gc'];
            $sale_pres = $sale_pres + $arr_for_present[$key]['pres_sale'];
        }
        $arr_for_growth[0]['pres_gc'] = $gc_pres;
        $arr_for_growth[0]['pres_sale'] = $sale_pres;
        foreach ($store_list_active as $key => $value) {
            foreach ($arr_for_present as $keys => $value) {
                if($store_list_active[$key]['store_code'] == $arr_for_present[$keys]['store_code']){
                    $store_list_active[$key]['pres_gc'] = $arr_for_present[$keys]['pres_gc'];
                    $store_list_active[$key]['pres_sale'] = $arr_for_present[$keys]['pres_sale'];
                }
            }
        }
        $arr_for_present = $store_list_active;

        $afp_str = "";
        foreach ($arr_for_present as $key => $value) {
            $afp_str .= $arr_for_present[$key]['store_code'].",";
            $afp_str .= $arr_for_present[$key]['store_name'].",";
            $afp_str .= $arr_for_present[$key]['pres_gc'].",";
            $afp_str .= $arr_for_present[$key]['pres_sale'].",";
            $afp_str .= "\n";
        }

        $myfile = fopen("/var/www/mcd_reporting/csv_reports/comps_growth/$pres_year/$monthName/".$pres_date_part[1]."".$pres_date_part[2]."".$pres_date_part[0].".csv", "w") or die("Unable to open file!");
        fwrite($myfile, $afp_str);
        fclose($myfile);


        $arr = $arr_for_past;
        foreach ($arr as $key => $value) {
            foreach ($arr_for_present as $keys => $value) {
                if($arr[$key]['store_code'] == $arr_for_present[$keys]['store_code']){
                    $arr[$key]['pres_gc'] = $arr_for_present[$keys]['pres_gc'];
                    $arr[$key]['pres_sale'] = $arr_for_present[$keys]['pres_sale'];
                }
            }
        }
                foreach ($arr as $key => $value) {
                    if($arr[$key]['prev_gc'] === NULL || $arr[$key]['prev_sale'] === NULL || $arr[$key]['pres_gc'] === NULL || $arr[$key]['pres_sale'] === NULL){
                        unset($arr[$key]);
                    }
                }

        $arr = array_values($arr);

        foreach ($arr as $key => $value) {
            foreach ($store_list_all as $keys => $value) {
                if($arr[$key]['store_code'] == $store_list_all[$keys]['store_code']){
                    $arr[$key]['profit_center'] = $store_list_all[$keys]['profit_center'];
                }
            }
        }
        $profit_centers = array();
        $store_codes = array();
        foreach ($arr as $key => $value) {
            $profit_centers[$key] = $value['profit_center'];
            $store_codes[$key] = $value['store_code'];
        }
        array_multisort($profit_centers, SORT_ASC | SORT_STRING, $store_codes, SORT_ASC, $arr);

        foreach ($arr as $key => $value) {
            $arr[$key]['comps_gc'] = noerror_divide(($arr[$key]['pres_gc'] - $arr[$key]['prev_gc']),$arr[$key]['prev_gc']) * 100;
            $arr[$key]['comps_sales'] = noerror_divide(($arr[$key]['pres_sale'] - $arr[$key]['prev_sale']),$arr[$key]['prev_sale']) * 100;
        }

        foreach ($arr_for_growth as $key => $value) {
            $arr_for_growth[$key]['comps_gc'] = noerror_divide(($arr_for_growth[$key]['pres_gc'] - $arr_for_growth[$key]['prev_gc']),$arr_for_growth[$key]['prev_gc']) * 100;
            $arr_for_growth[$key]['comps_sales'] = noerror_divide(($arr_for_growth[$key]['pres_sale'] - $arr_for_growth[$key]['prev_sale']),$arr_for_growth[$key]['prev_sale']) * 100;
        }

        $return_arr = array(
            'comps' => $arr,
            'growth' => $arr_for_growth
        );
        return $return_arr;

    }

    function fetch_data_mtd($previous_date, $present_date){
        include("../../config/db_connect.php");

        $prev_date_part = explode("-", $previous_date);
        $prev_year = intval($prev_date_part[0]);
        $prev_month = intval($prev_date_part[1]);
        $prev_day = intval($prev_date_part[2]);

        $pres_date_part = explode("-", $present_date);
        $pres_year = intval($pres_date_part[0]);
        $pres_month = intval($pres_date_part[1]);
        $pres_day = intval($pres_date_part[2]);

        $store_list = array();
        $growth_list = array();
        $sql_store = "SELECT store_name, code, type FROM ofs_stores AS os LEFT JOIN ofs_profit_center_type AS op ON op.id = os.profit_center_type";
        $res = $query->query($sql_store);
        while($r = $res->fetch_array()){
            $data = array(
                'profit_center' => $r['type'],
                'store_code' => $r['code'],
                'store_name' => $r['store_name'],
                'prev_gc' => NULL,
                'prev_sale' => NULL,
                'pres_gc' => NULL,
                'pres_sale' => NULL,
                'comps_gc' => NULL,
                'comps_sale' => NUll
            );
            array_push($store_list, $data);
        }

        for($x = 1; $x <= $prev_day; $x++){

            $d = sprintf("%02d", $x);
            $gc = 0;
            $sale = 0;
            $mon = date('F', mktime(0, 0, 0, $prev_month, 10));
            $file = fopen('/var/www/mcd_reporting/csv_reports/comps_growth/'.$prev_date_part[0].'/'.$mon.'/'.$prev_date_part[1].''.$d.''.$prev_date_part[0].'.csv', 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
              //$line is an array of the csv elements
              $gc = $gc + $line[2];
              $sale = $sale + $line[3];
              foreach ($store_list as $key => $value) {
                 if($store_list[$key]['store_code'] == $line[0]){
                     $store_list[$key]['prev_gc'] = $store_list[$key]['prev_gc'] + $line[2];
                     $store_list[$key]['prev_sale'] = $store_list[$key]['prev_sale'] + $line[3];
                 }
              }
            }
            fclose($file);

            $data = array(
                'prev_date' => $prev_date_part[0],
                'pres_date' => "",
                'prev_gc' => $gc,
                'prev_sale' => $sale,
                'pres_gc' => NULL,
                'pres_sale' => NULL,
                'comps_gc' => NULL,
                'comps_sale' => NULL,
            );
            array_push($growth_list, $data);
        }
        for($x = 1; $x <= $pres_day; $x++){
            $d = sprintf("%02d", $x);
            $gc = 0;
            $sale = 0;
			$mon = date('F', mktime(0, 0, 0, $prev_month, 10));
            $file = fopen('/var/www/mcd_reporting/csv_reports/comps_growth/'.$pres_date_part[0].'/'.$mon.'/'.$pres_date_part[1].''.$d.''.$pres_date_part[0].'.csv', 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
              //$line is an array of the csv elements
              $gc = $gc + $line[2];
              $sale = $sale + $line[3];
              foreach ($store_list as $key => $value) {
                 if($store_list[$key]['store_code'] == $line[0]){
                     $store_list[$key]['pres_gc'] = $store_list[$key]['pres_gc'] + $line[2];
                     $store_list[$key]['pres_sale'] = $store_list[$key]['pres_sale'] + $line[3];
                 }
              }
            }
            fclose($file);

            $growth_list[$x-1]['pres_date'] = $pres_date_part[0];
            $growth_list[$x-1]['pres_gc'] = $gc;
            $growth_list[$x-1]['pres_sale'] = $sale;
        }

        foreach ($store_list as $key => $value) {
            if($store_list[$key]['prev_gc'] === NULL || $store_list[$key]['prev_sale'] === NULL || $store_list[$key]['pres_gc'] === NULL || $store_list[$key]['pres_sale'] === NULL){
                unset($store_list[$key]);
            }
        }
        $store_list = array_values($store_list);

        $profit_centers = array();
        $store_codes = array();
        foreach ($store_list as $key => $value) {
            $profit_centers[$key] = $value['profit_center'];
            $store_codes[$key] = $value['store_code'];
        }
        array_multisort($profit_centers, SORT_ASC | SORT_STRING, $store_codes, SORT_ASC, $store_list);

        $total = array(
            'profit_center' => '',
            'store_code' => '',
            'store_name' => '',
            'prev_gc' => 0,
            'prev_sale' => 0,
            'pres_gc' => 0,
            'pres_sale' => 0,
            'comps_gc' => 0,
            'comps_sales' => 0
        );

        foreach ($store_list as $key => $value) {
            $total['prev_gc'] = $total['prev_gc'] + $store_list[$key]['prev_gc'];
            $total['prev_sale'] = $total['prev_sale'] + $store_list[$key]['prev_sale'];
            $total['pres_gc'] = $total['pres_gc'] + $store_list[$key]['pres_gc'];
            $total['pres_sale'] = $total['pres_sale'] + $store_list[$key]['pres_sale'];
            # code...
        }
        array_push($store_list , $total);

        foreach ($store_list as $key => $value) {
            $store_list[$key]['comps_gc'] = noerror_divide(($store_list[$key]['pres_gc'] - $store_list[$key]['prev_gc']),$store_list[$key]['prev_gc']) * 100;
            $store_list[$key]['comps_sales'] = noerror_divide(($store_list[$key]['pres_sale'] - $store_list[$key]['prev_sale']),$store_list[$key]['prev_sale']) * 100;
        }

        $total_g = array(
            'prev_date' => $prev_date_part[0],
            'pres_date' => $pres_date_part[0],
            'prev_gc' => 0,
            'prev_sale' => 0,
            'pres_gc' => 0,
            'pres_sale' => 0,
            'comps_gc' => 0,
            'comps_sales' => 0,
        );
        foreach ($growth_list as $key => $value) {
            $total_g['prev_gc'] = $total_g['prev_gc'] + $growth_list[$key]['prev_gc'];
            $total_g['prev_sale'] = $total_g['prev_sale'] + $growth_list[$key]['prev_sale'];
            $total_g['pres_gc'] = $total_g['pres_gc'] + $growth_list[$key]['pres_gc'];
            $total_g['pres_sale'] = $total_g['pres_sale'] + $growth_list[$key]['pres_sale'];
            # code...
        }
        array_push($growth_list, $total_g);
        foreach ($growth_list as $key => $value) {
            $growth_list[$key]['comps_gc'] = noerror_divide(($growth_list[$key]['pres_gc'] - $growth_list[$key]['prev_gc']),$growth_list[$key]['prev_gc']) * 100;
            $growth_list[$key]['comps_sales'] = noerror_divide(($growth_list[$key]['pres_sale'] - $growth_list[$key]['prev_sale']),$growth_list[$key]['prev_sale']) * 100;
        }

        $arr = array('comps' => $store_list, 'growth' => $growth_list);

        return $arr;

    }

    function fetch_data_all($previous_date,$present_date){
        include("../../config/db_connect.php");

        $prev_date_part = explode("-", $previous_date);
        $prev_year = intval($prev_date_part[0]);
        $prev_month = intval($prev_date_part[1]);
        $prev_day = intval($prev_date_part[2]);

        $pres_date_part = explode("-", $present_date);
        $pres_year = intval($pres_date_part[0]);
        $pres_month = intval($pres_date_part[1]);
        $pres_day = intval($pres_date_part[2]);

        $store_list = array();
        $growth_list = array();
        $sql_store = "SELECT store_name, code, type FROM ofs_stores AS os LEFT JOIN ofs_profit_center_type AS op ON op.id = os.profit_center_type
                    where code != 'ST_001' and code != 'MCD_API' and  code != 'ST_000' and  code != 'DUMMY' and  code != '999' and  code != '347_'
                    and  code != '373_' and  code != '4455' and  code != '990' and  code != '8888' and  code != '9000'
                    ";
        $res = $query->query($sql_store);
        while($r = $res->fetch_array()){
            $data = array(
                'profit_center' => $r['type'],
                'store_code' => $r['code'],
                'store_name' => $r['store_name'],
                'prev_gc' => NULL,
                'prev_sale' => NULL,
                'pres_gc' => NULL,
                'pres_sale' => NULL,
                'comps_gc' => NULL,
                'comps_sales' => NUll
            );
            array_push($store_list, $data);
        }
        for($x = 1; $x <= $prev_day; $x++){

            $d = sprintf("%02d", $x);
            $mon = date('F', mktime(0, 0, 0, $prev_month, 10));
            $file = fopen('/var/www/mcd_reporting/csv_reports/comps_growth/'.$prev_date_part[0].'/'.$mon.'/'.$prev_date_part[1].''.$d.''.$prev_date_part[0].'.csv', 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
              //$line is an array of the csv elements

              foreach ($store_list as $key => $value) {
                 if($store_list[$key]['store_code'] == $line[0]){
                     $store_list[$key]['prev_gc'] = $store_list[$key]['prev_gc'] + $line[2];
                     $store_list[$key]['prev_sale'] = $store_list[$key]['prev_sale'] + $line[3];
                 }
              }
            }
            fclose($file);

        }
        for($x = 1; $x <= $pres_day; $x++){
            $d = sprintf("%02d", $x);
            $gc = 0;
            $sale = 0;
			$mon = date('F', mktime(0, 0, 0, $prev_month, 10));
            $file = fopen('/var/www/mcd_reporting/csv_reports/comps_growth/'.$pres_date_part[0].'/'.$mon.'/'.$pres_date_part[1].''.$d.''.$pres_date_part[0].'.csv', 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
              //$line is an array of the csv elements
              $gc = $gc + $line[2];
              $sale = $sale + $line[3];
              foreach ($store_list as $key => $value) {
                 if($store_list[$key]['store_code'] == $line[0]){
                     $store_list[$key]['pres_gc'] = $store_list[$key]['pres_gc'] + $line[2];
                     $store_list[$key]['pres_sale'] = $store_list[$key]['pres_sale'] + $line[3];
                 }
              }
            }
            fclose($file);

            $growth_list[$x-1]['pres_date'] = $pres_date_part[0];
            $growth_list[$x-1]['pres_gc'] = $gc;
            $growth_list[$x-1]['pres_sale'] = $sale;
        }
        $profit_centers = array();
        $store_codes = array();
        foreach ($store_list as $key => $value) {
            $profit_centers[$key] = $value['profit_center'];
            $store_codes[$key] = $value['store_code'];
        }
        array_multisort($profit_centers, SORT_ASC | SORT_STRING, $store_codes, SORT_ASC, $store_list);

        $total = array(
            'profit_center' => '',
            'store_code' => '',
            'store_name' => '',
            'prev_gc' => 0,
            'prev_sale' => 0,
            'pres_gc' => 0,
            'pres_sale' => 0,
            'comps_gc' => 0,
            'comps_sales' => 0
        );

        foreach ($store_list as $key => $value) {
            $total['prev_gc'] = $total['prev_gc'] + $store_list[$key]['prev_gc'];
            $total['prev_sale'] = $total['prev_sale'] + $store_list[$key]['prev_sale'];
            $total['pres_gc'] = $total['pres_gc'] + $store_list[$key]['pres_gc'];
            $total['pres_sale'] = $total['pres_sale'] + $store_list[$key]['pres_sale'];
            # code...
        }
        $total['comps_gc'] = noerror_divide(($total['pres_gc'] - $total['prev_gc']),$total['prev_gc']) * 100;
        $total['comps_sales'] = noerror_divide(($total['pres_sale'] - $total['prev_sale']),$total['prev_sale']) * 100;

        array_push($store_list , $total);

        return $store_list;

    }



?>
    <?php if($type !=4){
    ?>
    <div class="row-fluid">
        <div class="span5"><?=$summary;?></div>
    </div>
    <div class="row-fluid">
    <div class="span2">
    <table>
        <tr>
            <th>&nbsp</th>
            <th>&nbsp</th>
            <th style='width:30px;'>GC</th>
            <th>&nbsp</th>
            <th style='width:30px;'>SALE</th>
        </tr>
        <tr>
            <td>Comps</td>
            <td>&nbsp</td>
            <td><?=num_format_0($comps_list[sizeOf($comps_list) - 1]['comps_gc']);?>%</td>
            <td>&nbsp</td>
            <td><?=num_format_0($comps_list[sizeOf($comps_list) - 1]['comps_sales']);?>%</td>
        </tr>
        <tr>
            <td>Growth</td>
            <td>&nbsp</td>
            <td><?=num_format_0($growth_list[sizeOf($growth_list) - 1]['comps_gc']);?>%</td>
            <td>&nbsp</td>
            <td><?=num_format_0($growth_list[sizeOf($growth_list) - 1]['comps_sales']);?>%</td>
        </tr>
    </table>
    </div>
    </div>
    <?php } ?>

<div class="navbar navbar-inner block-header">
    <div class="muted pull-left"><?=$title;?></div>
    <div class="pull-right"><a href="download.php?download=<?php echo $filename.".csv"?>"><span class="badge badge-warning">Download File</span></a></div>
</div>


<div class="block-content collapse in">


    <div class="scroll-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Profit Center</th>
                    <th>Store Code</th>
                    <th>Store Name</th>
                    <th>GC</th>
                    <th>Sales</th>
                    <th>GC</th>
                    <th>Sales</th>
                    <th>GC</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($type == 4){
                    foreach ($comps_list as $key => $value) {
                        if($key == (sizeOf($comps_list) - 1)){
                            $cgc = num_format_0($comps_list[$key]['comps_gc']);
                            $cs = num_format_0($comps_list[$key]['comps_sales']);
                        }
                        else{
                            $cgc = $comps_list[$key]['comps_gc'];
                            $cs = $comps_list[$key]['comps_sales'];
                        }
                        echo "<tr>";
                        echo   "<td width=30>".$comps_list[$key]['profit_center']."</td>";
                        echo   "<td>".$comps_list[$key]['store_code']."</td>";
                        echo   "<td>".$comps_list[$key]['store_name']."</td>";
                        echo   "<td>".$comps_list[$key]['prev_gc']."</td>";
                        echo   "<td>".$comps_list[$key]['prev_sale']."</td>";
                        echo   "<td>".$comps_list[$key]['pres_gc']."</td>";
                        echo   "<td>".$comps_list[$key]['pres_sale']."</td>";
                        echo   "<td>".$cgc."</td>";
                        echo   "<td>".$cs."</td>";
                        echo   "</tr>";
                    }
                }
                else{
                    foreach ($comps_list as $key => $value) {
                        echo "<tr>";
                        echo   "<td width=30>".$comps_list[$key]['profit_center']."</td>";
                        echo   "<td>".$comps_list[$key]['store_code']."</td>";
                        echo   "<td>".$comps_list[$key]['store_name']."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['prev_gc'])."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['prev_sale'])."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['pres_gc'])."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['pres_sale'])."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['comps_gc'])."</td>";
                        echo   "<td>".num_format_0($comps_list[$key]['comps_sales'])."</td>";
                        echo   "</tr>";
                    }
                }
                ?>

            </tbody>
        </table>
        <div class="span2">


                <?php
                foreach ($growth_list as $key => $value) {
                ?>
                <table class="table table-bordered">
                    <tr>
                        <th span="3">
                            <?php
                                if($type == 3){
                                    $date = "";
                                    $m = date("M", strtotime($mon));
                                    $n = $key+1;
                                    $date = $m."&nbsp".$n;
                                    if($key == (sizeOf($growth_list) - 1)){
                                        $date = "MTD";
                                    }
                                    echo $date;
                                }
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>GC</th>
                        <th>SALE</th>
                    </tr>
                    <tr>
                        <td ><?=$growth_list[$key]['prev_date'];?></td>
                        <td><?=num_format_0($growth_list[$key]['prev_gc']);?></td>
                        <td><?=num_format_0($growth_list[$key]['prev_sale']);?></td>
                    </tr>
                    <tr>
                        <td ><?=$growth_list[$key]['pres_date'];?></td>
                        <td><?=num_format_0($growth_list[$key]['pres_gc']);?></td>
                        <td><?=num_format_0($growth_list[$key]['pres_sale']);?></td>
                    </tr>
                    <tr>
                        <td ></td>
                        <td><?=num_format_0($growth_list[$key]['comps_gc']);?></td>
                        <td><?=num_format_0($growth_list[$key]['comps_sales']);?></td>
                    </tr>
                </table>
                <?php
                }
                ?>

        </div>
    </div>
</div>

<?php


    $csv_string = "Profit Center,";
    $csv_string .= "Restaurant Code,";
    $csv_string .= "Restaurant Name,";
    $csv_string .= "GC,";
    $csv_string .= "SALES,";
    $csv_string .= "GC,";
    $csv_string .= "SALES,";
    $csv_string .= "GC,";
    $csv_string .= "SALES,";
    $csv_string .= "\n";


    foreach ($comps_list as $key => $value) {
        $csv_string .= $comps_list[$key]['profit_center'].",";
        $csv_string .= $comps_list[$key]['store_code'].",";
        $csv_string .= $comps_list[$key]['store_name'].",";;
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['prev_gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['prev_sale']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['pres_gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['pres_sale']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['comps_gc']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $comps_list[$key]['comps_sales']).",";
        $csv_string .= "\n";
    }
    foreach ($growth_list as $key => $value) {

    $csv_string .= "\n";
    $csv_string .= "DATE,";
    $csv_string .= "GC,";
    $csv_string .= "SALES,";
    $csv_string .= "\n";

    $csv_string .=$growth_list[$key]['prev_date'].",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['prev_gc']).",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['prev_sale']).",";
    $csv_string .= "\n";

    $csv_string .=$growth_list[$key]['pres_date'].",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['pres_gc']).",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['pres_sale']).",";
    $csv_string .= "\n";

    $csv_string .=",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['comps_gc']).",";
    $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $growth_list[$key]['comps_sales']).",";
    $csv_string .= "\n";
        # code...
    }
    $file_location_monthly = "";
    $file_name = $filename;
    //run to create hourly report script:
    $file_location_hourly = "csv_reports/comps_growth/reports/";
    //run to create hourly report script:
    create_report_file($csv_string,$file_location_hourly,$filename,"w");
?>

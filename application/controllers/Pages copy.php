
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
}

 function index()
 {
    // $this->servicedesk_model->getAllowedIP();
    // $data['stores'] = $this->servicedesk_model->sample();
        // echo "<pre>";
        // print_r($data);
        // echo"</pre>";

    // $this->load->view('templates/header');
    // $this->load->view('templates/footer');
    $this->load->view('templates/index');
    // $this->load->view('address_frequency',$data);
    // $this->load->view('sample',$data);
 }
/////////////////////////// FORMS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 public function report_forms()
 {    
  // $this->servicedesk_model->getAllowedIP();
        $data['stores'] = $this->servicedesk_model->getStores();
        
        $report_name = $this->input->post('report_name');

        switch($report_name){

            case "monthly":
                // directory = "monthly_report/"; 
                $this->load->view('monthly_report/monthly_report_form');
                echo "";
            break;

            case "weekly":
                // directory = "weekly_report/";
                echo "";
            break;

            case "daily":
                echo "";
                $this->load->view('daily_report/daily_report_form');
                // directory = "daily_report/";
            break;

            case "hub_dec_reason":
                echo "";
                // directory = "hub_dec_report/";
            break;

            case "comp":
                echo "";
                // directory = "comp_growth_report/";
            break;

            case "calls_plot":
                $this->load->view('calls_plot_report/calls_plot_report_form',$data);
            break;


        }
 }
////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////// TABLES \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

 public function table_forms()
 {    
        
        $type_report = $this->input->post('type_report');

        $date_for_daily = $this->input->post('date_for_daily');

        $month = $this->input->post('month');
        $year = $this->input->post('year');


        switch($type_report) {
            case "monthly_table_form":
                // echo "monthly_table_form";
                $data['data'] = $this->monthly_report($month,$year);
                $data['month'] = $month;
                $data['year'] = $year;
                // $this->load->view('monthly_report/test');

                $this->load->view('monthly_report/monthly_table_form',$data);
                
            break;
                echo "";
            case "daily_table_form":
                // echo $date_for_daily;
                // $this->daily_repor1t($date_for_daily);
                 $data['data'] = $this->daily_report($date_for_daily);
                 $data['date_for_daily'] = $date_for_daily;
                $this->load->view('daily_report/daily_table_form',$data);
                $data['data'] = $this->get_csv_report($data);


            break;
            case "weekly_table_form":
                echo "weekly_table_form";

            break;
            case "hub_table_form":
                echo "hub_table_form";

            break;
            case "comp_table_form":
                echo "comp_table_form";

            break;
            case "calls_plot_table_form":
                echo "calls_plot_table_form";

            break;

            }

     
 }
////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////// DAILY REPORT \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

  function daily_report($date_for_daily){

        $datepick_temp = $date_for_daily;
        $datepick = date("Y-m-d", strtotime($datepick_temp));
        $date_part = explode("-", $datepick_temp);
        $year = intval($date_part[0]);
        $month = intval($date_part[1]);
        $day = intval($date_part[2]);

        $arr = array('daily' => array());
        $arr['daily']= array(
            'voice' => $this->dailySqlQuery($year, $month, $day, 'voice'),
            'web' => $this->dailySqlQuery($year, $month, $day, 'web'),
            'gcashminiprogram' => $this->dailySqlQuery($year, $month, $day, 'gcashminiprogram'),
            'mobile_app' => $this->dailySqlQuery($year, $month, $day, 'mobile_app'),
            'ctc' => $this->dailySqlQuery($year, $month, $day, 'ctc'),
            'fbchatbot' => $this->dailySqlQuery($year, $month, $day, 'fbchatbot')
        );
        array_push($arr, $this->getOverAll($arr));

        

        return $arr;
  }

  public function dailySqlQuery($year, $month, $day, $source)
  {
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
                $res_daily_sql = $this->servicedesk_model->daily_report($year, $month, $day, $x, $src);


                foreach($res_daily_sql as $result){

                    $ac = $this->noerror_divide($result['total_gross_per_hour'] , $result['total_calls']);
                    $res_arr = array('time' => $x, 'ga' => $result['total_gross_per_hour'], 
                                       'gc' => $result['total_calls'], 
                                       'ac' => $ac
                                    );
                    array_push($temp_arr , $res_arr);

                }


                    
                
            }
            array_push($temp_arr, $this->getTotalUpdate($temp_arr));

            return $temp_arr;

        }

        public function getOverAll($arr = array()){
            $temp_arr = array();
            for($x = 0; $x < 24; $x++){
                $temp_gc = 0;
                $temp_ac = 0;
                $temp_tc = 0;
                $temp_gc = $arr['daily']['voice'][$x]['ga'] + $arr['daily']['web'][$x]['ga'] + $arr['daily']['gcashminiprogram'][$x]['ga'] + $arr['daily']['mobile_app'][$x]['ga'] + $arr['daily']['ctc'][$x]['ga'] + $arr['daily']['fbchatbot'][$x]['ga'];
                $temp_tc = $arr['daily']['voice'][$x]['gc'] + $arr['daily']['web'][$x]['gc'] + $arr['daily']['gcashminiprogram'][$x]['gc'] + $arr['daily']['mobile_app'][$x]['gc'] + $arr['daily']['ctc'][$x]['gc'] + $arr['daily']['fbchatbot'][$x]['gc'];
                $temp_ac = $this->noerror_divide($temp_gc, $temp_tc);
                $res_arr = array('time' => $x, 'ga' => $temp_gc, 'gc' => $temp_tc, 'ac' => $temp_ac);
                array_push($temp_arr, $res_arr);
            }
            array_push($temp_arr, $this->getTotalUpdate($temp_arr));

            return $temp_arr;
        }



       
  //////////////////////////////////////////////////////////////////////////////////////// 


/////////////////////////// MONTHLY REPORT \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            function monthly_report($month,$year)
            {
                        
                // $param['year'] = $month;
                // $param['month'] = $year;

                $year = $year;
                $month = $month;

                // $monthName = date('F', strtotime($year."-".$month));

                $date = $this->getDateNeed($year, $month);

                $arr = array('monthly' => array());
                $arr['monthly'] = array(
                    'mdscsi' => array(),
                    'voice' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'voice'),
                    'web' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'web'),
                    'gcashminiprogram' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'gcashminiprogram'),
                    'mobile_app' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'mobile_app'),
                    'ctc' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'ctc'),
                    'fbchatbot' => $this->queryForMonth($date['year'], $date['month'], $date['from'], $date['to'], 'fbchatbot')
                );
                $arr['monthly']['mdscsi'] = $this->forMonth_getOvrAll($arr);
                
                return $arr;
            }

            function queryForMonth($year, $month, $from, $to, $source)
            {

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
                $daily_sql =  $this->servicedesk_model->monthly_report($year, $month, $from, $to, $src);
               
                foreach($daily_sql as $result){
                    $res_arr = array(
                                        'date' => $year."-".$month."-".$result['days'],
                                        'day' => date('l',strtotime($year."-".$month."-".$result['days'])),
                                        'ga' => $result['total_gross'], 
                                        'gc' => $result['total_calls'],
                                        'ac' => $result['ac'],
                                        'tc_below' => $result['tc_below']
                                    );
                    array_push($temp_arr , $res_arr);
                }

                $mtd = array();
                $mtd = $this->forMonthly_getTtlUpdate($temp_arr);
                array_push($temp_arr, $mtd);
                // array_push($temp_arr, $this->forMonthly_getTtlUpdate($mtd, $year, $month));

                return $temp_arr;

            }
       
            function forMonthly_getTtlUpdate($arr = array()){
                $totalGross = 0;
                $totalCall = 0;
                $totalAc = 0;
                $totalAc = 0;
                $totalCRT = 0;
                $totalTcBelow = 0;
                foreach ($arr as $value) {
                    # code...
                    $totalGross += $value['ga'];
                    $totalCall += $value['gc'];
                    $totalTcBelow += $value['tc_below'];

                }
                $totalAc = $this->noerror_divide($totalGross, $totalCall);
                $newArr = array(
                                'date' => 'MTD Sales',
                                'day' => '',
                                'ga' => $totalGross,
                                'gc' => $totalCall,
                                'ac' => $totalAc,
                                'tc_below' => $totalTcBelow,
                                'crt' => $totalCRT
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
                $d = $this->getDateNeed($year, $month);
                $provi = $d['to'];
                $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $temp = array();
                $trend = $this->noerror_divide($arr['ga'] , $provi) * $last;

                $temp = array(
                                'date' => 'TREND Sales',
                                'day' => '',
                                'ga' => $trend,
                                'gc' => ' ',
                                'ac' => ' ',
                                'tc_below' => ' ',
                                'crt' => ' '
                            );

                return $temp;
            }


            /**
             * [getOverAll description]
             * @param  [type] $arr [description]
             * @return [type]      [description]
             */
            function forMonth_getOvrAll($arr){
                $temp_arr = array();
                foreach ($arr['monthly']['voice'] as $x => $value) {
                    if(count($arr['monthly']['voice']) - 1 != $x){
                        $temp_gc = 0;
                        $temp_ac = 0;
                        $temp_tc = 0;
                        $temp_tcbelow = 0;
                        $temp_crt = 0;

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

                        $temp_ac = $this->noerror_divide($temp_gc , $temp_tc);
                        $temp_crt = $this->noerror_divide($temp_tcbelow , $temp_tc)*100;
                        $res_arr = array(
                                        'date' => $arr['monthly']['voice'][$x]['date'],
                                        'day' => date('l',strtotime($arr['monthly']['voice'][$x]['date'])),
                                        'ga' => $temp_gc, 'gc' => $temp_tc, 'ac' => $temp_ac,
                                        'tc_below' => $temp_tcbelow,
                                        'crt' => $temp_crt
                                    );
                        array_push($temp_arr, $res_arr);
                    }else{
                        $date = explode('-', $arr['monthly']['voice'][$x-2]['date']);
                        $tr = $this->getTrend($temp_arr[$x-1], $date[0], $date[1]);
                        array_push($temp_arr, $tr);
                    }
                }
                return $temp_arr;
            }



        


































  
 ////////////////////////////////  FUNCTION ////////////////////////////////////////////
 
        public function getTotalUpdate($arr = array()){
            $totalGross = 0;
            $totalCall = 0;
            $totalAc = 0;
            for($x = 0; $x < 24; $x++){
                $totalGross += $arr[$x]['ga'];
                $totalCall += $arr[$x]['gc'];

            }
            $totalAc = $this->noerror_divide($totalGross, $totalCall);
            $newArr = array('time' => '', 'ga' => $totalGross, 'gc' => $totalCall, 'ac' => $totalAc);
            return $newArr;
        }

        



        function noerror_divide($num1, $num2){
            $ans = 0;
            $ans = @round(($num1 / $num2),2);
            if(is_nan($ans)){
              return $ans = 0;
            }else{
            return $ans;
              }
          }


    

 function download(){

        $filename = $this->uri->segment(3);

            $document_root = "C:/xampp/htdocs/"."/servicedesk_extrator/";
        
        
          
          if(!empty($filename))
          {
            // Specify file path.
            $path = "";
            if($filename[0] == 'd')
            {
              $path = $document_root.'csv_reports/daily_report/'; // '/uplods/'
            }
            elseif($filename[0] == 'm')
            {
              $path = $document_root.'csv_reports/monthly_report/';
            }
            elseif($filename[0] == 'w')
            {
              $path = $document_root.'csv_reports/weekly_report/';
            }
            elseif($filename[0] == 'h')
            {
              $path = $document_root.'csv_reports/hubdec_reason_report/';
            }
            elseif($filename[0] == 'D')
            {
              $path = $document_root.'csv_reports/comps_growth/reports/';
            }
            $download_file =  $path.$filename;
            // Check file is exists on given path.
            if(file_exists($download_file))
            {
              // Getting file extension.
              // For Gecko browsers
              header('Content-Transfer-Encoding: binary');
              header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
              // Supports for download resume
              header('Accept-Ranges: bytes');
              // Calculate File size
              header('Content-Length: ' . filesize($download_file));
              header('Content-Encoding: none');
              // Change the mime type if the file is not PDF
              header('Content-Type: text/csv');
              // Make the browser display the Save As dialog
              header('Content-Disposition: attachment; filename=' . $filename);
              readfile($download_file);
              exit;
            }
            else
            {
              echo 'File does not exists on given path';
            }
            echo $download_file;
          }
        

    }

    function getDateNeed($year, $month){
        $now_year = intval(date("Y"));
        $now_month = intval(date("m"));

        $from = 1;
        $to = 1;

        if($now_year == $year && $now_month == $month){
            $to = intval(date("d")) - 1;
            if($to == 0){
                $to = 1;
            }
        }
        else {
            $to = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        $date = array('year' => $year,
            'month' => $month,
            'from' => $from,
            'to' => $to
        );

        return $date;
    }
 //////////////////////////////////////////////////////////////////////////////////////// 
 

}



<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();        
    // $this->load->library('excel');

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
            case "monthly_per_store":
                // directory = "monthly_report/"; 
                $this->load->view('monthly_per_store_report/monthly_per_store_report_form');
                echo "";
            break;

            case "monthly_per_store_day":
                // directory = "monthly_report/"; 
                $this->load->view('monthly_per_store_day_report/monthly_per_store_day_report_form');
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

            case "monthly_breakfast":
                $this->load->view('monthly_customized_report/monthly_breakfast_report_form');
            break;

            case "monthly_midnight":
                $this->load->view('monthly_customized_report/monthly_midnight_report_form');
            break;

            case "monthly_pmix":
                $this->load->view('pmix_report/pmix_report_form');
            break;


        }
 }
////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////// TABLES \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

 public function table_forms()
 {    
        
        $type_report = $this->input->post('type_report');

        //-- For Day basis
        $date_for_daily = $this->input->post('date_for_daily');

        //-- For Monthly per day
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        //-- For Monthly per store
        $month_per_store = $this->input->post('month_per_store');
        $year_per_store = $this->input->post('year_per_store');

        //-- For Monthly per store daily
        $month_per_store_day = $this->input->post('month_per_store_day');
        $year_per_store_day = $this->input->post('year_per_store_day');
        // $csv_file = $this->input->post('csv_file');

        //--For Calls plot
        $store = $this->input->post('store');
        $calls_plot_date_from = $this->input->post('calls_plot_date_from');
        $calls_plot_date_to = $this->input->post('calls_plot_date_to');

        //-- For Monthly Breakfast
        $month_breakfast = $this->input->post('month_breakfast');
        $year_breakfast = $this->input->post('year_breakfast');

        //-- For Monthly Midnight
        $month_midnight = $this->input->post('month_midnight');
        $year_midnight = $this->input->post('year_midnight');

        //-- For PMIX Midnight
        $month_pmix = $this->input->post('month_pmix');
        $year_pmix = $this->input->post('year_pmix');


        switch($type_report) {
            case "monthly_table_form":
                // echo "monthly_table_form";
                $data['data'] = $this->monthly_report($month,$year);
                $data['month'] = $month;
                $data['year'] = $year;
                
                $data['month'] = $month;
                $data['year'] = $year;
                // $this->load->view('monthly_report/test');

                $this->load->view('monthly_report/monthly_table_form',$data);
                
            break;

            case "monthly_per_store_table_form":
                $data['data'] = $this->monthly_per_store_report($month_per_store,$year_per_store);
                $data['month'] = $month_per_store;
                $data['year'] = $year_per_store;
                // $data['month'] = $month;
                // $data['year'] = $year;

                $this->load->view('monthly_per_store_report/monthly_per_store_table_form',$data);
                
            break;
            case "monthly_per_store_day_table_form":
                $data['month'] = $month_per_store_day;
                $data['year'] = $year_per_store_day;
                
                $data['data'] = $this->monthly_per_store_day_report($month_per_store_day,$year_per_store_day);

                // $data['month'] = $month;
                // $data['year'] = $year;
                // echo $month_per_store_day; 
                // echo $year_per_store_day;
                // echo $csv_file;
                // echo "<pre>";
                // print_r($csv_file);
                // echo "<pre>";
                

                $this->load->view('monthly_per_store_day_report/monthly_per_store_day_table_form',$data);
                
            break;

             
            case "daily_table_form":
                // echo $date_for_daily;
                // $this->daily_repor1t($date_for_daily);
                 $data['data'] = $this->daily_report($date_for_daily);
                 $data['date_for_daily'] = $date_for_daily;

                
                $this->load->view('daily_report/daily_table_form',$data);
                


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
                // echo "calls_plot_table_form";

                $data['data'] = $this->calls_plot($store, $calls_plot_date_from, $calls_plot_date_to);
                $data['store'] = $this->get_select_store($store);
                // echo $store; 
                $data['calls_plot_date_from'] = $calls_plot_date_from;
                $data['calls_plot_date_to'] = $calls_plot_date_to;
                $data['storeID'] = $store;


                $this->load->view('calls_plot_report/calls_plot_table_form',$data);
                // $this->load->view 

            break;

            case "monthly_breakfast_table_form":

                $data['report_type']  = 'breakfast';
                $data['report_type1']  = 'breakfast';

                $data['month'] = $month_breakfast;
                $data['year'] = $year_breakfast;
                $from ='6';
                $to = '10';
                $report_type = 'breakfast'; 
               
                $data['data'] = $this->monthly_customized($month_breakfast, $year_breakfast , $from, $to, $report_type);

                $this->load->view('monthly_customized_report/monthly_customized_table_form',$data);

            break;

            case "monthly_midnight_table_form":

                $data['report_type']  =  'Midnight';
                $data['report_type1']  =  'zMidnight';

                $data['month'] = $month_midnight;
                $data['year'] = $year_midnight;
                $from ='0';
                $to = '5';
                $report_type = 'zMidnight'; 
               
                $data['data'] = $this->monthly_customized($month_midnight, $year_midnight , $from, $to, $report_type);

                $this->load->view('monthly_customized_report/monthly_customized_table_form',$data);

            break;

            case "pmix_table_form":
                // echo "pmix_table_form";
                $data['month'] = $month_pmix;
                $data['year'] = $year_pmix;

                $data['data'] = $this->pmix_report($month_pmix, $year_pmix);

                $this->load->view('pmix_report/pmix_table_form',$data);

                

            break;

            }

     
 }
///////////////////////////////////////////////////////////////////////////////////////////////


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
        $this->get_csv_report_daily($arr,$month,$year);
        

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


     public function get_csv_report_daily($data = array())
     {
        $datepick = date("Ymd");
                
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
                $csv_string .= $hour.",,".preg_replace('/\.(\d{2}).*/', '.$1', $data[0][$x]['gc']).",".$data[0][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data[0][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['voice'][$x]['gc']).",".$data['daily']['voice'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['voice'][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['web'][$x]['gc']).",".$data['daily']['web'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['web'][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['gcashminiprogram'][$x]['gc']).",".$data['daily']['gcashminiprogram'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['gcashminiprogram'][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['mobile_app'][$x]['gc']).",".$data['daily']['mobile_app'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['mobile_app'][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['ctc'][$x]['gc']).",".$data['daily']['ctc'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['ctc'][$x]['ac']).",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['fbchatbot'][$x]['gc']).",".$data['daily']['fbchatbot'][$x]['ga'].",".preg_replace('/\.(\d{2}).*/', '.$1', $data['daily']['fbchatbot'][$x]['ac']).",,\n";
              
            }
            $file_location_hourly = "";
            $file_name_hourly = $datepick;
            //run to create hourly report script:
            $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/daily_report/";
            //run to create hourly report script:
            $this->create_report_file($csv_string,$file_location_hourly,"daily-report-".$datepick,"w");
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

                $this->get_csv_report_monthly($arr);
                
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


    public function get_csv_report_monthly($arr = array()){

        
        
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
        $file_name_monthly = "monthly_report_".$datepick = date("Ymd");
        //run to create hourly report script:
        $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/monthly_report/";

        //run to create hourly report script:
        $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");


    }
        


///////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////// MONTHLY SALES PER STORE REPORT \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




            function monthly_per_store_report($month_per_store,$year_per_store)
            {
                            
                    // $param['year'] = $month;
                    // $param['month'] = $year;


                    // $monthName = date('F', strtotime($year."-".$month));

                    $date = $this->getDateNeed($year_per_store, $month_per_store);

                    $arr = array('monthly' => array());
                    $arr['monthly'] = array(
                        'mdscsi' => array(),
                        'voice' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'voice'),
                        'web' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'web'),
                        'gcashminiprogram' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'gcashminiprogram'),
                        'mobile_app' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'mobile_app'),
                        'ctc' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'ctc'),
                        'fbchatbot' => $this->queryForMonthStore($date['year'], $date['month'], $date['from'], $date['to'], 'fbchatbot')
                    );
                    $arr['monthly']['mdscsi'] = $this->forMonth_getOvrAllStore($arr);

                    
                    
                    $temp_arr = $arr;

                    $temp_arr['monthly']['voice']['0'] = $this->complete_arr($arr,'voice');
                    $temp_arr['monthly']['web']['0'] = $this->complete_arr($arr,'web');
                    $temp_arr['monthly']['gcashminiprogram']['0'] = $this->complete_arr($arr,'gcashminiprogram');
                    $temp_arr['monthly']['mobile_app']['0'] = $this->complete_arr($arr,'mobile_app');
                    $temp_arr['monthly']['ctc']['0'] = $this->complete_arr($arr,'ctc');
                    $temp_arr['monthly']['fbchatbot']['0'] = $this->complete_arr($arr,'fbchatbot');

                    $this->get_csv_report_monthly_store($temp_arr,$year_per_store, $month_per_store);

                    return $temp_arr;
            }

            public function complete_arr($arr,$source){
                $temp_arr = array();
                foreach ($arr['monthly']['mdscsi']['0'] as $x => $value) {
                        $temp_gc = 0;
                        $temp_ac = 0;
                        $temp_tc = 0;
                        $temp_tcbelow = 0;
                        $temp_crt = 0;

                        $res_arr[$arr['monthly']['mdscsi']['0'][$x]['store_code']] = array(
                                        'store_code' => $arr['monthly']['mdscsi']['0'][$x]['store_code'],
                                        'store_name' => $arr['monthly']['mdscsi']['0'][$x]['store_name'],
                                        'ga' => $temp_gc, 
                                        'gc' => $temp_tc, 
                                        'ac' => $temp_ac,
                                        'tc_below' => $temp_tcbelow,
                                        'crt' => $temp_crt
                                    );
                  
                }
                array_push($temp_arr, $res_arr);
                $y = array_replace($temp_arr['0'],$arr['monthly'][$source]['0']);
                return $y;
                
            }


            function queryForMonthStore($year, $month, $from, $to, $source)
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
                $res_arr = array();
                $daily_sql =  $this->servicedesk_model->monthly_per_store_report($year, $month, $from, $to, $src);
               
                foreach($daily_sql as $result){
                    $res_arr[$result['store_code']] = array(
                                        'store_code' => $result['store_code'],
                                        'store_name' => $result['store_name'],
                                        'ga' => $result['total_gross'], 
                                        'gc' => $result['total_calls'],
                                        'ac' => $result['ac'],
                                        'tc_below' => $result['tc_below']
                                    );
                    
                }
                array_push($temp_arr, $res_arr);
                $mtd = array();
                $mtd = $this->forMonthly_getTtlUpdateStore($temp_arr);
                array_push($temp_arr, $mtd);

                return $temp_arr;
             

            }
       
            function forMonthly_getTtlUpdateStore($arr){
                $totalGross = 0;
                $totalCall = 0;
                $totalAc = 0;
                $totalAc = 0;
                $totalCRT = 0;
                $totalTcBelow = 0;
                foreach ($arr['0'] as $x => $value) {
                    # code...
                    $totalGross += $arr['0'][$x]['ga'];
                    $totalCall += $arr['0'][$x]['gc'];
                    $totalTcBelow += $arr['0'][$x]['tc_below'];

                }
                $totalAc = $this->noerror_divide($totalGross, $totalCall);
                $newArr = array(
                                'store_code' => 'MTD Sales',
                                'store_name' => '',
                                'ga' => $totalGross,
                                'gc' => $totalCall,
                                'ac' => $totalAc,
                                'tc_below' => $totalTcBelow,
                                'crt' => $totalCRT
                            );

                return $newArr;
            }

            function getTrendStore($arr,$year,$month){
                $d = $this->getDateNeed($year, $month);
                $provi = $d['to'];
                $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $temp = array();
                $trend = $this->noerror_divide($arr['ga'] , $provi) * $last;

                $temp = array(
                                'store_code' => 'TREND Sales',
                                'store_name' => '',
                                'ga' => $trend,
                                'gc' => ' ',
                                'ac' => ' ',
                                'tc_below' => ' ',
                                'crt' => ' '
                            );

                return $temp;
            }

            function forMonth_getOvrAllStore($arr){
                $temp_arr = array();
                foreach ($arr['monthly']['mobile_app']['0'] as $x => $value) {
                        $temp_gc = 0;
                        $temp_ac = 0;
                        $temp_tc = 0;
                        $temp_tcbelow = 0;
                        $temp_crt = 0;

                        $temp_tcbelow = 
                                        (isset($arr['monthly']['voice']['0'][$x]['tc_below'])            ? $arr['monthly']['voice']['0'][$x]['tc_below']            : 0) +
                                        (isset($arr['monthly']['web']['0'][$x]['tc_below'])              ? $arr['monthly']['web']['0'][$x]['tc_below']              : 0) +
                                        (isset($arr['monthly']['gcashminiprogram']['0'][$x]['tc_below']) ? $arr['monthly']['gcashminiprogram']['0'][$x]['tc_below'] : 0) +
                                        (isset($arr['monthly']['mobile_app']['0'][$x]['tc_below'])       ? $arr['monthly']['mobile_app']['0'][$x]['tc_below']       : 0) + 
                                        (isset($arr['monthly']['ctc']['0'][$x]['ga'])                    ? $arr['monthly']['ctc']['0'][$x]['ga']                    : 0) + 
                                        (isset($arr['monthly']['fbchatbot']['0'][$x]['tc_below'])        ? $arr['monthly']['fbchatbot']['0'][$x]['tc_below']        : 0);

                        $temp_gc      = 
                                        (isset($arr['monthly']['voice']['0'][$x]['ga'])                  ? $arr['monthly']['voice']['0'][$x]['ga']                  : 0) +
                                        (isset($arr['monthly']['web']['0'][$x]['ga'])                    ? $arr['monthly']['web']['0'][$x]['ga']                    : 0) +
                                        (isset($arr['monthly']['gcashminiprogram']['0'][$x]['ga'])       ? $arr['monthly']['gcashminiprogram']['0'][$x]['ga']       : 0) +
                                        (isset($arr['monthly']['mobile_app']['0'][$x]['ga'])             ? $arr['monthly']['mobile_app']['0'][$x]['ga']             : 0) +
                                        (isset($arr['monthly']['ctc']['0'][$x]['ga'])                    ? $arr['monthly']['ctc']['0'][$x]['ga']                    : 0) +
                                        (isset($arr['monthly']['fbchatbot']['0'][$x]['ga'])              ? $arr['monthly']['fbchatbot']['0'][$x]['ga']              : 0);

                        $temp_tc      = 
                                        (isset($arr['monthly']['voice']['0'][$x]['gc'])                  ? $arr['monthly']['voice']['0'][$x]['gc']                  : 0) +
                                        (isset($arr['monthly']['web']['0'][$x]['gc'])                    ? $arr['monthly']['web']['0'][$x]['gc']                    : 0) +
                                        (isset($arr['monthly']['gcashminiprogram']['0'][$x]['gc'])       ? $arr['monthly']['gcashminiprogram']['0'][$x]['gc']       : 0) + 
                                        (isset($arr['monthly']['mobile_app']['0'][$x]['gc'])             ? $arr['monthly']['mobile_app']['0'][$x]['gc']             : 0) +
                                        (isset($arr['monthly']['ctc']['0'][$x]['gc'])                    ? $arr['monthly']['ctc']['0'][$x]['gc']                    : 0) +
                                        (isset($arr['monthly']['fbchatbot']['0'][$x]['gc'])              ? $arr['monthly']['fbchatbot']['0'][$x]['gc']              : 0);

                        $temp_ac = $this->noerror_divide($temp_gc , $temp_tc);
                        $temp_crt = $this->noerror_divide($temp_tcbelow , $temp_tc)*100;
                        $res_arr[$arr['monthly']['mobile_app']['0'][$x]['store_code']] = array(
                                        'store_code' => $arr['monthly']['mobile_app']['0'][$x]['store_code'],
                                        'store_name' => $arr['monthly']['mobile_app']['0'][$x]['store_name'],
                                        'ga' => $temp_gc, 
                                        'gc' => $temp_tc, 
                                        'ac' => $temp_ac,
                                        'tc_below' => $temp_tcbelow,
                                        'crt' => $temp_crt
                                    );
                    
                }
                array_push($temp_arr, $res_arr);
                $mtd = array();
                $mtd = $this->forMonthly_getTtlUpdateStore($temp_arr);
                array_push($temp_arr, $mtd);
                return $temp_arr;
            }


        public function checkIfNull($temp_res){

            if($temp_res == null || $temp_res == ""){
                return $temp_res = 0;
            }else{
                return $temp_res;
            }


        }

        public function get_csv_report_monthly_store($arr = array(),$year,$month){

        
            
            $csv_string = ",,,MDSCSI Sales TC/AC,";
            $csv_string .= ",,,Voice Sales TC/AC,";
            $csv_string .= ",,,Web Sales TC/AC,";
            $csv_string .= ",,,GcashMiniProgram Sales TC/AC,";
            $csv_string .= ",,,Mobile Apps Sales TC/AC,";
            $csv_string .= ",,,CTC Sales TC/AC,";
            $csv_string .= ",,,fbchatbot Sales TC/AC,";
            $csv_string .= "\n";
            $csv_string .= "Store Code,Store Name,,";
            for ($i=1; $i<=6; $i++) {
                $csv_string .= "Gross Actual,GC,Gross AC,,";
            }
            $csv_string .= "\n";
    
    
            foreach ($arr['monthly']['mdscsi']['0'] as $key => $value) {
                
                $csv_string .= $arr['monthly']['mdscsi']['0'][$key]['store_code'].",";
                $csv_string .= $arr['monthly']['mdscsi']['0'][$key]['store_name'].",,";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['0'][$key]['ac']).",,";
    
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['0'][$key]['ga']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['0'][$key]['gc']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['0'][$key]['ac']).",,";
    
                $csv_string .= "\n";
            }

            $csv_string .= $arr['monthly']['mdscsi']['1']['store_code'].",";
            $csv_string .= $arr['monthly']['mdscsi']['1']['store_name'].",,";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mdscsi']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['voice']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['web']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['gcashminiprogram']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['mobile_app']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['ctc']['1']['ac']).",,";

            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['1']['ga']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['1']['gc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['fbchatbot']['1']['ac']).",,";

            $csv_string .= "\n";



            $file_location_monthly = "";
            $file_name_monthly = "monthly_report_per_store_".$month."-".$year;
            //run to create hourly report script:
            $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/monthly_report_per_store/";
    
            //run to create hourly report script:
            $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");

            
    
    
        }






///////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////// MONTHLY SALES PER STORE DAILY  REPORT \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




    function monthly_per_store_day_report($month_per_store_day,$year_per_store_day)
    {
                    
            // $param['year'] = $month;
            // $param['month'] = $year;


            // $monthName = date('F', strtotime($year."-".$month));

            // $date = $this->getDateNeed($year_per_store, $month_per_store);


            $arr = array('monthly' => array());
            $arr['monthly'] = array(
                'store' => $this->queryForMonthStoreMonth(),
                'mdscsi' => array(),
                '01' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '1'),
                '02' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '2'),
                '03' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '3'),
                '04' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '4'),
                '05' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '5'),
                '06' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '6'),
                '07' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '7'),
                '08' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '8'),
                '09' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '9'),
                '10' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '10'),
                '11' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '11'),
                '12' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '12'),
                '13' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '13'),
                '14' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '14'),
                '15' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '15'),
                '16' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '16'),
                '17' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '17'),
                '18' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '18'),
                '19' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '19'),
                '20' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '20'),
                '21' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '21'),
                '22' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '22'),
                '23' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '23'),
                '24' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '24'),
                '25' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '25'),
                '26' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '26'),
                '27' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '27'),
                '28' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '28'),
                '29' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '29'),
                '30' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '30'),
                '31' => $this->queryForMonthStoreDay($year_per_store_day, $month_per_store_day, '31')
            );

            
            
            $temp_arr = $arr;

            $temp_arr['monthly']['01']['0'] = $this->complete_arr_per_day($arr,'01');
            $temp_arr['monthly']['02']['0'] = $this->complete_arr_per_day($arr,'02');
            $temp_arr['monthly']['03']['0'] = $this->complete_arr_per_day($arr,'03');
            $temp_arr['monthly']['04']['0'] = $this->complete_arr_per_day($arr,'04');
            $temp_arr['monthly']['05']['0'] = $this->complete_arr_per_day($arr,'05');
            $temp_arr['monthly']['06']['0'] = $this->complete_arr_per_day($arr,'06');
            $temp_arr['monthly']['07']['0'] = $this->complete_arr_per_day($arr,'07');
            $temp_arr['monthly']['08']['0'] = $this->complete_arr_per_day($arr,'08');
            $temp_arr['monthly']['09']['0'] = $this->complete_arr_per_day($arr,'09');
            $temp_arr['monthly']['10']['0'] = $this->complete_arr_per_day($arr,'10');
            $temp_arr['monthly']['11']['0'] = $this->complete_arr_per_day($arr,'11');
            $temp_arr['monthly']['12']['0'] = $this->complete_arr_per_day($arr,'12');
            $temp_arr['monthly']['13']['0'] = $this->complete_arr_per_day($arr,'13');
            $temp_arr['monthly']['14']['0'] = $this->complete_arr_per_day($arr,'14');
            $temp_arr['monthly']['15']['0'] = $this->complete_arr_per_day($arr,'15');
            $temp_arr['monthly']['16']['0'] = $this->complete_arr_per_day($arr,'16');
            $temp_arr['monthly']['17']['0'] = $this->complete_arr_per_day($arr,'17');
            $temp_arr['monthly']['18']['0'] = $this->complete_arr_per_day($arr,'18');
            $temp_arr['monthly']['19']['0'] = $this->complete_arr_per_day($arr,'19');
            $temp_arr['monthly']['20']['0'] = $this->complete_arr_per_day($arr,'20');
            $temp_arr['monthly']['21']['0'] = $this->complete_arr_per_day($arr,'21');
            $temp_arr['monthly']['22']['0'] = $this->complete_arr_per_day($arr,'22');
            $temp_arr['monthly']['23']['0'] = $this->complete_arr_per_day($arr,'23');
            $temp_arr['monthly']['24']['0'] = $this->complete_arr_per_day($arr,'24');
            $temp_arr['monthly']['25']['0'] = $this->complete_arr_per_day($arr,'25');
            $temp_arr['monthly']['26']['0'] = $this->complete_arr_per_day($arr,'26');
            $temp_arr['monthly']['27']['0'] = $this->complete_arr_per_day($arr,'27');
            $temp_arr['monthly']['28']['0'] = $this->complete_arr_per_day($arr,'28');
            $temp_arr['monthly']['29']['0'] = $this->complete_arr_per_day($arr,'29');
            $temp_arr['monthly']['30']['0'] = $this->complete_arr_per_day($arr,'30');
            $temp_arr['monthly']['31']['0'] = $this->complete_arr_per_day($arr,'31');

            $temp_arr['monthly']['mdscsi'] = $this->forMonth_perday_getOvrAllStore($temp_arr);


            $this->get_csv_report_monthly_store_perday($temp_arr,$year_per_store_day, $month_per_store_day);

            return $temp_arr;
    }

    public function complete_arr_per_day($arr,$source){
        $temp_arr = array();
        foreach ($arr['monthly']['store']['0'] as $x => $value) {
                $temp_gc = 0;
                $temp_net = 0;
                $temp_tc = 0;

                $res_arr[$arr['monthly']['store']['0'][$x]['store_code']] = array(
                                'store_code' => $arr['monthly']['store']['0'][$x]['store_code'],
                                'store_name' => $arr['monthly']['store']['0'][$x]['store_name'],
                                'gross_sales' => $temp_gc, 
                                'tc' => $temp_tc, 
                                'net_sales' => $temp_net,
                            );
          
        }
        array_push($temp_arr, $res_arr);
        $y = array_replace($temp_arr['0'],$arr['monthly'][$source]['0']);
        return $y;
        
    }




    function queryForMonthStoreDay($year, $month, $day)
    {

        $temp_arr = array();
        $res_arr = array();
        $daily_sql =  $this->servicedesk_model->monthly_per_store_day_report($year, $month, $day);

    
        foreach($daily_sql as $result){
            $res_arr[$result['store_code']] = array(
                                'store_code' => $result['store_code'],
                                'store_name' => $result['store_name'],
                                'gross_sales' => $result['total_gross'], 
                                'tc' => $result['total_calls'],
                                'net_sales' => $result['total_net']
                            );
            
        }
        array_push($temp_arr, $res_arr);
        $mtd = array();
        $mtd = $this->forMonthly_perday_getTtlUpdateStore($temp_arr);
        array_push($temp_arr, $mtd);

        return $temp_arr;
    

    }

    function forMonthly_perday_getTtlUpdateStore($arr){
        $totalGross = 0;
        $totalTC = 0;
        $totalNel = 0;
        foreach ($arr['0'] as $x => $value) {
            # code...
            $totalGross += $arr['0'][$x]['gross_sales'];
            $totalTC += $arr['0'][$x]['tc'];
            $totalNel += $arr['0'][$x]['net_sales'];

        }
        $newArr = array(
                        'store_code' => 'MTD Sales',
                        'store_name' => '',
                        'gross_sales' => $totalGross,
                        'tc' => $totalTC,
                        'net_sales' => $totalNel
                    );

        return $newArr;
    }

    function queryForMonthStoreMonth()
    {

        $temp_arr = array();
        $res_arr = array();
        $daily_sql =  $this->servicedesk_model->monthly_getStores();
    
        foreach($daily_sql as $result){
            $res_arr[$result['code']] = array(
                                'store_code' => $result['code'],
                                'store_name' => $result['store_name'],
                                'gross_sales' => 0, 
                                'tc' => 0,
                                'net_sales' => 0
                            );
            
        }
        array_push($temp_arr, $res_arr);
        // $mtd = array();
        // $mtd = $this->forMonthly_getTtlUpdateStore($temp_arr);
        // array_push($temp_arr, $mtd);

        return $temp_arr;
    

    }

    function forMonth_perday_getOvrAllStore($arr){
        $temp_arr = array();
        foreach ($arr['monthly']['store']['0'] as $x => $value) {
                $temp_gross = 0;
                $temp_tc = 0;
                $temp_net = 0;

                $temp_gross = $arr['monthly']['01']['0'][$x]['gross_sales'] +
                                $arr['monthly']['02']['0'][$x]['gross_sales'] +
                                $arr['monthly']['03']['0'][$x]['gross_sales'] +
                                $arr['monthly']['04']['0'][$x]['gross_sales'] +
                                $arr['monthly']['05']['0'][$x]['gross_sales'] +
                                $arr['monthly']['06']['0'][$x]['gross_sales'] +
                                $arr['monthly']['07']['0'][$x]['gross_sales'] +
                                $arr['monthly']['08']['0'][$x]['gross_sales'] +
                                $arr['monthly']['09']['0'][$x]['gross_sales'] +
                                $arr['monthly']['10']['0'][$x]['gross_sales'] +
                                $arr['monthly']['11']['0'][$x]['gross_sales'] +
                                $arr['monthly']['12']['0'][$x]['gross_sales'] +
                                $arr['monthly']['13']['0'][$x]['gross_sales'] +
                                $arr['monthly']['14']['0'][$x]['gross_sales'] +
                                $arr['monthly']['15']['0'][$x]['gross_sales'] +
                                $arr['monthly']['16']['0'][$x]['gross_sales'] +
                                $arr['monthly']['17']['0'][$x]['gross_sales'] +
                                $arr['monthly']['18']['0'][$x]['gross_sales'] +
                                $arr['monthly']['19']['0'][$x]['gross_sales'] +
                                $arr['monthly']['20']['0'][$x]['gross_sales'] +
                                $arr['monthly']['21']['0'][$x]['gross_sales'] +
                                $arr['monthly']['22']['0'][$x]['gross_sales'] +
                                $arr['monthly']['23']['0'][$x]['gross_sales'] +
                                $arr['monthly']['24']['0'][$x]['gross_sales'] +
                                $arr['monthly']['25']['0'][$x]['gross_sales'] +
                                $arr['monthly']['26']['0'][$x]['gross_sales'] +
                                $arr['monthly']['27']['0'][$x]['gross_sales'] +
                                $arr['monthly']['28']['0'][$x]['gross_sales'] +
                                $arr['monthly']['29']['0'][$x]['gross_sales'] +
                                $arr['monthly']['30']['0'][$x]['gross_sales'] +
                                $arr['monthly']['31']['0'][$x]['gross_sales'];

                $temp_tc = $arr['monthly']['01']['0'][$x]['tc'] +
                                $arr['monthly']['02']['0'][$x]['tc'] +
                                $arr['monthly']['03']['0'][$x]['tc'] +
                                $arr['monthly']['04']['0'][$x]['tc'] +
                                $arr['monthly']['05']['0'][$x]['tc'] +
                                $arr['monthly']['06']['0'][$x]['tc'] +
                                $arr['monthly']['07']['0'][$x]['tc'] +
                                $arr['monthly']['08']['0'][$x]['tc'] +
                                $arr['monthly']['09']['0'][$x]['tc'] +
                                $arr['monthly']['10']['0'][$x]['tc'] +
                                $arr['monthly']['11']['0'][$x]['tc'] +
                                $arr['monthly']['12']['0'][$x]['tc'] +
                                $arr['monthly']['13']['0'][$x]['tc'] +
                                $arr['monthly']['14']['0'][$x]['tc'] +
                                $arr['monthly']['15']['0'][$x]['tc'] +
                                $arr['monthly']['16']['0'][$x]['tc'] +
                                $arr['monthly']['17']['0'][$x]['tc'] +
                                $arr['monthly']['18']['0'][$x]['tc'] +
                                $arr['monthly']['19']['0'][$x]['tc'] +
                                $arr['monthly']['20']['0'][$x]['tc'] +
                                $arr['monthly']['21']['0'][$x]['tc'] +
                                $arr['monthly']['22']['0'][$x]['tc'] +
                                $arr['monthly']['23']['0'][$x]['tc'] +
                                $arr['monthly']['24']['0'][$x]['tc'] +
                                $arr['monthly']['25']['0'][$x]['tc'] +
                                $arr['monthly']['26']['0'][$x]['tc'] +
                                $arr['monthly']['27']['0'][$x]['tc'] +
                                $arr['monthly']['28']['0'][$x]['tc'] +
                                $arr['monthly']['29']['0'][$x]['tc'] +
                                $arr['monthly']['30']['0'][$x]['tc'] +
                                $arr['monthly']['31']['0'][$x]['tc'];

                    $temp_net = $arr['monthly']['01']['0'][$x]['net_sales'] +
                                $arr['monthly']['02']['0'][$x]['net_sales'] +
                                $arr['monthly']['03']['0'][$x]['net_sales'] +
                                $arr['monthly']['04']['0'][$x]['net_sales'] +
                                $arr['monthly']['05']['0'][$x]['net_sales'] +
                                $arr['monthly']['06']['0'][$x]['net_sales'] +
                                $arr['monthly']['07']['0'][$x]['net_sales'] +
                                $arr['monthly']['08']['0'][$x]['net_sales'] +
                                $arr['monthly']['09']['0'][$x]['net_sales'] +
                                $arr['monthly']['10']['0'][$x]['net_sales'] +
                                $arr['monthly']['11']['0'][$x]['net_sales'] +
                                $arr['monthly']['12']['0'][$x]['net_sales'] +
                                $arr['monthly']['13']['0'][$x]['net_sales'] +
                                $arr['monthly']['14']['0'][$x]['net_sales'] +
                                $arr['monthly']['15']['0'][$x]['net_sales'] +
                                $arr['monthly']['16']['0'][$x]['net_sales'] +
                                $arr['monthly']['17']['0'][$x]['net_sales'] +
                                $arr['monthly']['18']['0'][$x]['net_sales'] +
                                $arr['monthly']['19']['0'][$x]['net_sales'] +
                                $arr['monthly']['20']['0'][$x]['net_sales'] +
                                $arr['monthly']['21']['0'][$x]['net_sales'] +
                                $arr['monthly']['22']['0'][$x]['net_sales'] +
                                $arr['monthly']['23']['0'][$x]['net_sales'] +
                                $arr['monthly']['24']['0'][$x]['net_sales'] +
                                $arr['monthly']['25']['0'][$x]['net_sales'] +
                                $arr['monthly']['26']['0'][$x]['net_sales'] +
                                $arr['monthly']['27']['0'][$x]['net_sales'] +
                                $arr['monthly']['28']['0'][$x]['net_sales'] +
                                $arr['monthly']['29']['0'][$x]['net_sales'] +
                                $arr['monthly']['30']['0'][$x]['net_sales'] +
                                $arr['monthly']['31']['0'][$x]['net_sales'];



                $res_arr[$arr['monthly']['store']['0'][$x]['store_code']] = array(
                                'store_code' => $arr['monthly']['store']['0'][$x]['store_code'],
                                'store_name' => $arr['monthly']['store']['0'][$x]['store_name'],
                                'gross_sales' => $temp_gross, 
                                'tc' => $temp_tc, 
                                'net_sales' => $temp_net
                            );
            
        }
        array_push($temp_arr, $res_arr);
        $mtd = array();
        $mtd = $this->forMonthly_perday_getTtlUpdateStore($temp_arr);
        array_push($temp_arr, $mtd);
        return $temp_arr;
    }

    function import()
    {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
            foreach($file_data as $row)
            {
                $data[] = array(
                    'first_name' => $row["First Name"],
                        'last_name'  => $row["Last Name"],
                        'phone'   => $row["Phone"],
                        'email'   => $row["Email"]
            );
            }
        $this->csv_import_model->insert($data);
    }


    public function get_csv_report_monthly_store_perday($arr = array(),$year,$month){

        $csv_string = ",,";
        for ($i=1; $i<=31; $i++) {
            $csv_string .= ",Day $i,";
        }
        $csv_string .= ",,,MDSCSI Sales,";
        $csv_string .= "\n";
        $csv_string .= "Store Code,Store Name,,";
        for ($i=1; $i<=6; $i++) {
            $csv_string .= "TC, Gross Sales, Net Sales,,";
        }
        $csv_string .= "\n";


        foreach ($arr['monthly']['store']['0'] as $key => $value) {
            
            $csv_string .= $arr['monthly']['store']['0'][$key]['store_code'].",";
            $csv_string .= $arr['monthly']['store']['0'][$key]['store_name'].",,"; 
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['0'][$key]['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['0'][$key]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['0'][$key]['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['0'][$key]['net_sales']).",,";

            $csv_string .= "\n";
        }

            $csv_string .= "MDS Sales,,,"; 
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['01']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['02']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['03']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['04']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['05']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['06']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['07']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['08']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['09']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['10']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['11']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['12']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['13']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['14']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['15']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['16']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['17']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['18']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['19']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['20']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['21']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['22']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['23']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['24']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['25']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['26']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['27']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['28']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['29']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['30']['1']['net_sales']).",,";
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['1']['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['1']['gross_sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['monthly']['31']['1']['net_sales']).",,";
        $csv_string .= "\n";



        $file_location_monthly = "";
        $file_name_monthly = "1monthly_report_per_store_perday".$month."-".$year;
        //run to create hourly report script:
        $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/monthly_report_per_store_perday/";

        //run to create hourly report script:
        $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");


    }



///////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////// CALLS PLOT ////////////////////////////////////////////////////


        public function calls_plot($store, $calls_plot_date_from, $calls_plot_date_to){


            // $param = array();
            // $param['date_from'] = $_POST['calls_plot_date_from'];
            // $param['date_to'] = $_POST['calls_plot_date_to'];
            // $param['store'] = $_POST['store'];

            $fromDate = explode('-',$calls_plot_date_from);
            $fromYear = $fromDate[0];
            $fromMonth = $fromDate[1];
            $fromDay = $fromDate[2];
            $fromEomonth = explode('-',date("Y-m-t", strtotime($calls_plot_date_from)));
            $fromEomonth_day = $fromEomonth[2];

            //YEAR - MONTH - DAY
            $toDate = explode('-',$calls_plot_date_to);
            $toYear = $toDate[0];
            $toMonth = $toDate[1];
            $toDay = $toDate[2];
            $toFDomonth = 01;
            $validMonth = abs($toMonth-$fromMonth);
            $storesID = $store;

            if($validMonth >= 2 && $validMonth <= 10)
           {
            echo '2 consecutive months only!'; 
            
            exit(); 
  
            }else
            { 
             if ($storesID == 10002) 
              {
                echo 'Please select store.';
                
                exit(); 
  
              }else
                { 
                      
                  if($fromDay <= $toDay && $fromMonth == $toMonth && $fromYear == $toYear)
                  {
                   $data = $this->servicedesk_model->fetch_data_same_month($toYear,$toMonth,$fromDay,$toDay,$storesID);
                    
                  }elseif($fromDay >= $toDay || $fromDay < $toDay  && $fromMonth < $toMonth || $fromMonth > $toMonth && $fromYear <= $toYear)
                  {
                    $data = $this->servicedesk_model->fetch_data_dif_month($fromYear,$fromMonth,$fromDay,$fromEomonth_day,$toYear,$toMonth,$toFDomonth,$toDay,$storesID);      
                   
                  }  
                
                } 
              }
              $temp_arr = array();
              foreach($data as $result){
                $res_arr = array(
                                    'city_name' => $result['city_name'],
                                    'brgy' => $result['brgy'],
                                    'Location' => $result['Location'], 
                                    'landmark' => $result['landmark'],
                                    'total_order' => $result['total_order'],
                                    'total_gross' => $result['total_gross'],
                                    'promised_time' => $result['promised_time']
                );
            array_push($temp_arr, $res_arr);
                
            }

            $ttl = array();
            $ttl = $this->callsplot_getTotal($temp_arr);
                array_push($temp_arr, $ttl);

            $store_name = $this->servicedesk_model->getSelectStores($store);


            $this->get_csv_calls_plot($temp_arr,$store_name, $store, $calls_plot_date_from, $calls_plot_date_to);



            return $temp_arr;

        }

        function callsplot_getTotal($arr){
            $total_order = 0;
            $total_gross = 0;
            foreach ($arr as $x => $value) {
                # code...
                $total_order += $arr[$x]['total_order'];
                $total_gross += $arr[$x]['total_gross'];

            }
            $newArr = array(
                            'city_name' => '',
                            'brgy' => '',
                            'Location' => '',
                            'landmark' => 'Total',
                            'total_order' => $total_order,
                            'total_gross' => $total_gross,
                            'promised_time' => ''
                        );

            return $newArr;
        }


        public function get_csv_calls_plot($arr, $store_name, $store, $calls_plot_date_from, $calls_plot_date_to){

            $csv_string = ",,,".$store."-".$store_name[0]['store_name']." ".$calls_plot_date_from."_".$calls_plot_date_to." Calls Plot ";
            $csv_string .= "\n";
            
            $csv_string .= "City,";
            $csv_string .= "Barangay,";
            $csv_string .= "Street,";
            $csv_string .= "Landmark,";
            $csv_string .= "Total Orders,";
            $csv_string .= "Total Gross,";
            $csv_string .= "Promised Time,";
            $csv_string .= "\n";
    
    
            foreach ($arr as $x => $value) {
                
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['city_name']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['brgy']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['Location']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['landmark']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['total_order']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['total_gross']).",";
                $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['promised_time']).",";
    
                $csv_string .= "\n";
            }

            $file_location_monthly = "";
            $file_name_monthly = "calls_plot_".$store."_".$calls_plot_date_from."_".$calls_plot_date_to;
            //run to create hourly report script:
            $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/calls_plot/";
    
            //run to create hourly report script:
            $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");
    
    
        }









///////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////// BREAKFAST SALES REPORT ////////////////////////////////////////////////////

    public function monthly_breakfast($month_breakfast, $year_breakfast){

              
                $data = $this->servicedesk_model->monthly_breakfast($month_breakfast, $year_breakfast);
                $temp_arr = array();

                foreach($data as $result){
                    $res_arr = array(
                                        'store_code' => $result['store_code'],
                                        'store_name' => $result['store_name'],
                                        'tc' => $result['tc'], 
                                        'sales' => $result['sales'],
                                        'net_sales' => $result['net_sales']
                    );
                array_push($temp_arr, $res_arr);
                    
                }

            $ttl = array();
            $ttl = $this->breakfast_getTotal($temp_arr);
            array_push($temp_arr, $ttl);


            $this->get_csv_monthly_breakfast($temp_arr,$month_breakfast, $year_breakfast);

            return $temp_arr;


        
    }

    function breakfast_getTotal($arr){
        $total_order = 0;
        $total_gross = 0;
        $total_net = 0;
        foreach ($arr as $x => $value) {
            # code...
            $total_order += $arr[$x]['tc'];
            $total_gross += $arr[$x]['sales'];
            $total_net += $arr[$x]['net_sales'];

        }
        $newArr = array(
                        'store_code' => '',
                        'store_name' => 'Total',
                        'tc' => $total_order,
                        'sales' => $total_gross,
                        'net_sales' => $total_net,
                    );

        return $newArr;
    }

    public function get_csv_monthly_breakfast($arr, $month_breakfast, $year_breakfast){

        $csv_string = ",,".$month_breakfast."-".$year_breakfast." Breakfast Monthly Report";
        $csv_string .= "\n";
        
        $csv_string .= "store_code,";
        $csv_string .= "store_name,";
        $csv_string .= "tc,";
        $csv_string .= "sales,";
        $csv_string .= "net_sales,";
        $csv_string .= "\n";


        foreach ($arr as $x => $value) {
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['store_code']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['store_name']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['net_sales']).",";

            $csv_string .= "\n";
        }

        $file_location_monthly = "";
        $file_name_monthly = "breakfast_sales_report_".$month_breakfast."-".$year_breakfast;
        //run to create hourly report script:
        $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/breakfast_sales_report/";

        //run to create hourly report script:
        $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");


    }
///////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////// CUSTOMIZE SALES REPORT ////////////////////////////////////////////////////

    public function monthly_customized($month, $year, $from, $to, $report_type){

              
                $data = $this->servicedesk_model->monthly_customized_model($month, $year, $from, $to);
                $temp_arr = array();

                foreach($data as $result){
                    $res_arr = array(
                                        'store_code' => $result['store_code'],
                                        'store_name' => $result['store_name'],
                                        'tc' => $result['tc'], 
                                        'sales' => $result['sales'],
                                        'net_sales' => $result['net_sales']
                    );
                array_push($temp_arr, $res_arr);
                    
                }

            $ttl = array();
            $ttl = $this->customized_getTotal($temp_arr);
            array_push($temp_arr, $ttl);


            $this->get_csv_monthly_customized($temp_arr,$month, $year, $report_type);

            return $temp_arr;

         

        
    }

    function customized_getTotal($arr){
        $total_order = 0;
        $total_gross = 0;
        $total_net = 0;
        foreach ($arr as $x => $value) {
            # code...
            $total_order += $arr[$x]['tc'];
            $total_gross += $arr[$x]['sales'];
            $total_net += $arr[$x]['net_sales'];

        }
        $newArr = array(
                        'store_code' => '',
                        'store_name' => 'Total',
                        'tc' => $total_order,
                        'sales' => $total_gross,
                        'net_sales' => $total_net,
                    );

        return $newArr;
    }

    public function get_csv_monthly_customized($arr,$month, $year, $report_type){

        $csv_string = ",,".$month."-".$year." Breakfast Monthly Report";
        $csv_string .= "\n";
        
        $csv_string .= "store_code,";
        $csv_string .= "store_name,";
        $csv_string .= "tc,";
        $csv_string .= "sales,";
        $csv_string .= "net_sales,";
        $csv_string .= "\n";


        foreach ($arr as $x => $value) {
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['store_code']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['store_name']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['tc']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['sales']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr[$x]['net_sales']).",";

            $csv_string .= "\n";
        }

        $file_location_monthly = "";
        $file_name_monthly = $report_type."_sales_report_".$month."-".$year;
        //run to create hourly report script:
        $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/".$report_type."_sales_report/";

        //run to create hourly report script:
        $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");


    }
///////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////// PMIX SALES REPORT ////////////////////////////////////////////////////

    public function pmix_report($month, $year){
        

       $getTotalTC = $this->servicedesk_model->getTotalTC($month, $year);

       $getProductItems = $this->servicedesk_model->getProductItems($year, $month);

       
       $getProductItems_temp_arr = array();

       foreach($getProductItems as $result){
        $res_arr[$result['child_item_poscode']] = array(
                            'child_item_poscode' => $result['child_item_poscode'],
                            'net_sales' => $result['net_sales'],
                            'quantity' => $result['quantity']
                        );
        }
        array_push($getProductItems_temp_arr , $res_arr);



       $getProductList_temp_arr = array();


        $getProductList = $this->servicedesk_model->getProductList();

        foreach($getProductList as $result1){
            $res_arr1[$result1['pos_code']] = array(
                                'pos_code' => $result1['pos_code'],
                                'category' => $result1['category'],
                                'name' => $result1['name']
                            );
        }
        array_push($getProductList_temp_arr , $res_arr1);

        $com_result = $this->arr_merge($getProductList_temp_arr,$getProductItems_temp_arr,$getTotalTC);
        // return $getProductItems_temp_arr;
        // return array_merge_recursive($getProductItems_temp_arr[0],$getProductList_temp_arr[0]);

        $this->get_csv_pmix_report($com_result,$month, $year);

        return $com_result;
        // $getProductItem = $this->servicedesk_model->
    }

    function arr_merge($getProductList_temp_arr,$getProductItems_temp_arr, $getTotalTC){
        $temp_arr = array();

        foreach ($getProductItems_temp_arr['0'] as $x => $value) {
            $temp_upt = 0;

            $temp_upt =  $this->getUPT($getProductItems_temp_arr['0'][$x]['quantity'],$getTotalTC['0']['total_tc']);

                $res_arr[$getProductItems_temp_arr['0'][$x]['child_item_poscode']] = array(
                                'child_item_poscode' => $getProductItems_temp_arr['0'][$x]['child_item_poscode'],
                                'net_sales' => $getProductItems_temp_arr['0'][$x]['net_sales'],
                                'quantity' => $getProductItems_temp_arr['0'][$x]['quantity'], 
                                'upt' => $temp_upt,
                                'category' => $getProductList_temp_arr['0'][$x]['category'], 
                                'name' => $getProductList_temp_arr['0'][$x]['name'],
                            );
            
        }
        array_push($temp_arr, $res_arr);
        $ttl = array();
        $ttl = $this->PMIX_getTtl($temp_arr);
        array_push($temp_arr, $ttl);
        return $temp_arr;

    }

    function getUPT($num1, $num2){
        $ans = 0;
        $ans = @round(($num1 / $num2)*1000,2);
        if(is_nan($ans)){
          return $ans = 0;
        }else{
        return $ans;
          }
    }



    function PMIX_getTtl($arr){
        $totalQuantity = 0;
        $totalNet = 0;
        foreach ($arr['0'] as $x => $value) {
            # code...
            $totalQuantity += $arr['0'][$x]['quantity'];
            $totalNet += $arr['0'][$x]['net_sales'];

        }
        $newArr = array(
                        'child_item_poscode' => '',
                        'net_sales' => $totalNet,
                        'quantity' => $totalQuantity,
                        'upt' => '',
                        'category' => '',
                        'name' => 'Total'
                    );

        return $newArr;
    }



    public function get_csv_pmix_report($arr,$month, $year){

        $csv_string = ",,".$month."-".$year." Product Mix Report";
        $csv_string .= "\n";
        
        $csv_string .= "Poscode,";
        $csv_string .= "Product Name,";
        $csv_string .= "Category,";
        $csv_string .= "Quantity,";
        $csv_string .= "UPT,";
        $csv_string .= "Net Sales,";
        $csv_string .= "\n";


        foreach ($arr['0'] as $x => $value) {
            
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['child_item_poscode']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['name']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['category']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['quantity']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['upt']).",";
            $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['0'][$x]['net_sales']).",";

            $csv_string .= "\n";
        }

        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['child_item_poscode']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['name']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['category']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['quantity']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['upt']).",";
        $csv_string .= preg_replace('/\.(\d{2}).*/', '.$1', $arr['1']['net_sales']).",";

        $csv_string .= "\n";

        $file_location_monthly = "";
        $file_name_monthly = "PMIX_report_".$month."-".$year;
        //run to create hourly report script:
        $file_location_hourly = "C:/xampp/htdocs/servicedesk_extractor/application/csv_reports/PMIX_report/";

        //run to create hourly report script:
        $this->create_report_file($csv_string,$file_location_hourly,$file_name_monthly,"w");


    }






///////////////////////////////////////////////////////////////////////////////////////////////















  
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
       
            $document_root = "C:/xampp/htdocs/servicedesk_extractor/application/";
        
        
          
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
            elseif($filename[0] == 'M')
            {
              $path = $document_root.'csv_reports/monthly_report_per_store/';
            }
            elseif($filename[0] == '1')
            {
              $path = $document_root.'csv_reports/monthly_report_per_store_perday/';
            }
            elseif($filename[0] == 'c')
            {
              $path = $document_root.'csv_reports/calls_plot/';
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
            elseif($filename[0] == 'b')
            {
              $path = $document_root.'csv_reports/breakfast_sales_report/';
            }
            elseif($filename[0] == 'z')
            {
              $path = $document_root.'csv_reports/zMidnight_sales_report/';
            }elseif($filename[0] == 'P')
            {
              $path = $document_root.'csv_reports/PMIX_report/';
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



    function create_report_file($reports_contents,$file_location,$file_name,$write_status)
    {


            $file_holder = $file_location.$file_name;

            $myfile = fopen($file_holder.".csv", $write_status) or die("Unable to open file!");

            fwrite($myfile, $reports_contents);

            fclose($myfile);

    }


    function get_select_store($store){

        return $this->servicedesk_model->getSelectStores($store);
        

    }
//////////////////////////////////////////////////////////////////////////////////////// 
 

}


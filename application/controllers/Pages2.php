
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
/////////////////////////// For Calls Plot \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 public function calls_plot_report()
 {    
  // $this->servicedesk_model->getAllowedIP();
  $data['stores'] = $this->servicedesk_model->getStores();
  $this->load->view('calls_plot_report/calls_plot_report_form',$data);
 }


  public function calls_plot_table_form()
  {
    $storesID = $this->input->post('store');
    $from_date = $this->input->post('calls_plot_date_from');
    $to_date = $this->input->post('calls_plot_date_to');
    $output = '';
    $query = '';
    $this->load->model('servicedesk_model');
  
    $storesID = $this->input->post('store');
  
    $from_date = $this->input->post('calls_plot_date_from');
    $fromDate = explode('-', $from_date);
    $fromYear = $fromDate[0];
    $fromMonth = $fromDate[1];
    $fromDay = $fromDate[2];
    $fromEomonth = explode('-',date("Y-m-t", strtotime($from_date)));
    $fromEomonth_day = $fromEomonth[2];
  
    $to_date = $this->input->post('calls_plot_date_to');
    $toDate = explode('-', $to_date);
    $toYear = $toDate[0];
    $toMonth  = $toDate[1];
    $toDay  = $toDate[2];
    $toFDomonth_day = "01";
  
     $validMonth = abs($toMonth-$fromMonth);
  
  
    if($validMonth >= 2 && $validMonth <= 10)
           {
            echo '<script>alert("2 consecutive months only!")</script>'; 
            echo '  
            <table class="table table-bordered">  
              <tr>  
                <th width="10%">City</th>  
                <th width="10%">Brgy.</th>  
                <th width="25%">Street</th>  
                <th width="25%">Landmark</th>  
                <th width="10%">Total Orders</th>  
                <th width="10%">Total Gross</th>  
                <th width="10%">Promised Time</th>
              </tr>';  
            exit(); 
  
            }else
            { 
             if ($storesID == 10002) 
              {
                echo '<script>alert("Please select store.")</script>';
                echo '  
                <table class="table table-bordered">  
                  <tr>  
                    <th width="10%">City</th>  
                    <th width="10%">Brgy.</th>  
                    <th width="25%">Street</th>  
                    <th width="25%">Landmark</th>  
                    <th width="10%">Total Orders</th>  
                    <th width="10%">Total Gross</th>  
                    <th width="10%">Promised Time</th>
                  </tr>';  
                exit(); 
  
              }else
                 { 
                      
                  if($fromDay <= $toDay && $fromMonth == $toMonth && $fromYear == $toYear)
                  {
                   $data = $this->servicedesk_model->fetch_data_same_month($toYear,$toMonth,$fromDay,$toDay,$storesID);
                    
                  }elseif($fromDay >= $toDay || $fromDay < $toDay  && $fromMonth < $toMonth || $fromMonth > $toMonth && $fromYear <= $toYear)
                  {
                    $data = $this->servicedesk_model->fetch_data_dif_month($fromYear,$fromMonth,$fromDay,$fromEomonth_day,$toYear,$toMonth,$toFDomonth_day,$toDay,$storesID);      
                   
                  }  
                
                } 
              }
              
              // echo "<pre>";
              // print_r($data);
              // echo "</pre>";
    $output .= '
    <div class="table-responsive">
       <table class="table table-bordered table-striped">
    
        <tr>  
          <th width="10%">City</th>  
          <th width="10%">Brgy.</th>  
          <th width="25%">Street</th>  
          <th width="25%">Landmark</th>  
          <th width="10%">Total Orders</th>  
          <th width="10%">Total Gross</th>  
          <th width="10%">Promised Time</th>  
        </tr>
        ';
        $sum = 0;
        $total = count($data);
    if(count($data) > 0)
    {
     foreach($data as $row)
     {
      $output .= '
        <tr>
         <td>'.$row['city_name'].'</td>
         <td>'.$row['brgy'].'</td>
         <td>'.$row['Location'].'</td>
         <td>'.$row['landmark'].'</td>
         <td>1</td>
         <td>'.$row['total_gross'].'</td>
         <td>'.$row['promised_time'].'</td>
        </tr>
      ';
      $sum += $row['total_gross'];
     }
    }
    else
    {
     $output .= '<tr>
         <td colspan="7">No Data Found</td>
        </tr>';
    }
    
    $output .= '<tr>
          <td> </td>  
          <td> </td>  
          <td> </td>  
          <td> </td>  
          <td><b>'.$total.'</b></td>  
          <td><b>'.$sum.'</b></td>  
          <td> </td>  
          </tr>';
  $output .= '</table>  <br /> <br />';
  echo $output;      
    
  }

  /////////////////////////////////////////////////////////////////////////////////

 public function toText()
 {
    
 }
 
}


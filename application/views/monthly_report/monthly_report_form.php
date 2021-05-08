
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Monthly Reports</div>
  
</div>
<div class="block-content collapse in">
   	<div class="span3">
        <select id="selectMonth">

                <?php 

                    $months =  array(
                        
                        '1' => "January",
                        '2' => "February",
                        '3' => "March",
                        '4' => "April",
                        '5' => "May",
                        '6' => "June",
                        '7' => "July",
                        '8' => "August",
                        '9' => "September",
                        '10' => "October",
                        '11' => "November",
                        '12' => "December",

                    );

                        foreach ($months as $mo_val => $month_name) {
                                        

                            echo "<option value='".$mo_val."'>".$month_name."</option>";


                        }


                ?>            



                  
         </select>
     </div>
    

    <?php 


    $previous_year = date("Y",strtotime("now -3 year"));
    $end_year = date("Y",strtotime("now +10 year"));


    ?>


     <div class="span3">
        <select id="selectYear">


        <!-- get the previous year -->

            <?php

                for ($years=$previous_year;$years<=$end_year; $years++) { 
                    
                        echo "<option value='".$years."'>$years</option>";
                }

             ?>        


                
         </select>
     </div>


     <div class="span3">
     	<button class="btn" onclick="gen_table(this)" data-report-name='monthly_table_form'><i class="icon-list-alt" id="gene"></i> Generate</button>
     </div>

</div>

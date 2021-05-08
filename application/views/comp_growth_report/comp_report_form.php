
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Daily Comps And Growth</div>
</div>
<div class="block-content collapse in">
    <div class="span3" style="width:230px;">
      <div class="control-group">
        <label class="control-label" for="date01">Month</label>
        <div class="controls">
            <select id="selectType" style="width:230px;">
                    <?php
                        $types =  array(
                            '1' => "Daily Comps - Calendar Days",
                            '2' => "Daily Comps - Trading Days",
                            '3' => "MTD Comps - Calendar",
                            '4' => "All Store",
                        );
                            foreach ($types as $mo_val => $month_name) {
                                echo "<option value='".$mo_val."'>".$month_name."</option>";
                          }
                    ?>
             </select>
        </div>
      </div>
     </div>
   	<div class="span3" style="width:100px;">
      <div class="control-group">
        <label class="control-label" for="date01">Previous Date</label>
        <div class="controls">
          <input type="text" class="input-xlarge datepicker" id="previous_date" name="datepi" value="<?php echo date('Y-m-d', strtotime("-1 year", time()));?>" data-date-format="yyyy-mm-dd" style="width:100px;">
        </div>
      </div>
     </div>
     <div class="span3" style="width:100px;">
       <div class="control-group">
         <label class="control-label" for="date01">Present Date</label>
         <div class="controls">
           <input type="text" class="input-xlarge datepicker" id="present_date" name="datepi" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd" style="width:100px;">
         </div>
       </div>
      </div>
     <div class="span3">
       <div class="control-group">
         <label class="control-label" for="">&nbsp</label>
         <div class="controls">
     	     <button class="btn" onclick="gen_table(this)" data-report-name='comp_table_form' id="gene"><i class="icon-list-alt"></i> Generate</button>
         </div>
       </div>
     </div>
</div>


<script>
    $(function() {
        $("input#previous_date.input-xlarge.datepicker").datepicker();
    });
    $(function() {
        $("input#present_date.input-xlarge.datepicker").datepicker();
    });
</script>

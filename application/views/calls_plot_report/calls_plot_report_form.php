<div class="navbar navbar-inner block-header">
    <div class="muted pull-left-hub-dec">Calls Plot&nbsp;&nbsp;<span style="font-size:11px"></span></div>
</div>
<div class="block-content collapse in">

		<div style="display:inline-block">

   			<label>  Select Store:
			   <select name="store" id="store" class="form-control">
                      <option value="10002">Select Store</option>
                <?php  foreach($stores as $store){ ?>
                               <option value="<?= $store['code']?>"><?= $store['store_name']?></option>
                <?php } ?>
                
                 </select>
		    Date: From &nbsp;&nbsp;
   			<input type="text" class="input-xlarge datepicker" style="width:100px;height:20px;" id="calls_plot_date_from" name="calls_plot_date_from" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
   			&nbsp;&nbsp;To&nbsp;&nbsp;
   			<input type="text" class="input-xlarge datepicker" style="width:100px;height:20px;" id="calls_plot_date_to" name="calls_plot_date_to" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
     		&nbsp;&nbsp;<button  onclick="gen_table(this)" id="gene" style="margin-top:-11px;" data-report-name='calls_plot_table_form'>Generate Report</button>

		</div>

</div>


<script>
    $(function() {
        $("input#calls_plot_date_from.input-xlarge.datepicker").datepicker();
        $("input#calls_plot_date_to.input-xlarge.datepicker").datepicker();
    });
</script>
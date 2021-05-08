

<div class="navbar navbar-inner block-header">
    <div class="muted pull-left-hub-dec">Hub Declaration Reason - Daily&nbsp;&nbsp;<span style="font-size:11px">[McDonalds Delivery System Custom Reports]</span></div>
</div>
<div class="block-content collapse in">

		<div style="display:inline-block">

			
   			<label>Select Date: From &nbsp;&nbsp;
   			<input type="text" class="input-xlarge datepicker" style="width:100px;height:20px;" id="date_hub_from" name="datepi" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
   			&nbsp;&nbsp;To&nbsp;&nbsp;
   			<input type="text" class="input-xlarge datepicker" style="width:100px;height:20px;" id="date_hub_to" name="datepi" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
     		&nbsp;&nbsp;<button  onclick="gen_table(this)" id="gene" style="margin-top:-11px;" data-report-name='hub_table_form'>Generate Report</button>
			
		</div>

</div>


<script>
    $(function() {
        $("input#date_hub_from.input-xlarge.datepicker").datepicker();
        $("input#date_hub_to.input-xlarge.datepicker").datepicker();
    });
</script>
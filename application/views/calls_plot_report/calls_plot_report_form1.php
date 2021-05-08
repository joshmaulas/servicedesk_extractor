
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
     		&nbsp;&nbsp;<button id="gene" style="margin-top:-11px;" data-report-name='calls_plot_table_form'>Generate Report</button>

		</div>

        
</div>

<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Calls Plot Detailed </div>
    <div class="pull-right"><a href="download.php?download=test-report-.csv"><span class="badge badge-warning">Download File</span></a></div>
</div>
<div class="block-content collapse in">
	<div class="scroll-table">
	<div class="block">
     <div id="table_form"></div>
    </div>


   </div>

</div>

<style>

	.muted{
		color: red !important;
		font-weight: bold;
	}

</style>





<script>
    $(function() {
        $("input#calls_plot_date_from.input-xlarge.datepicker").datepicker();
        $("input#calls_plot_date_to.input-xlarge.datepicker").datepicker();
    });

    $('#gene').click(function(){  
                var calls_plot_date_from = $('#calls_plot_date_from').val();  
                var calls_plot_date_to = $('#calls_plot_date_to').val();
                var store = $('#store').val();
               //  console.log(from_date);
               //  console.log(to_date);
               //  console.log(store);

                if(calls_plot_date_from != '' && calls_plot_date_to != '')  
                {  if (true) {

                        if(calls_plot_date_from > calls_plot_date_to){
                            alert("Please Select Date Properly");
                            document.getElementById("gene").disabled = false;
                        }else{
                            $.ajax({  
                                url:"<?php echo base_url(); ?>Pages/calls_plot_table_form",
                                method:"post",  
                                data:{calls_plot_date_from:calls_plot_date_from, calls_plot_date_to:calls_plot_date_to, store:store},  
                                success:function(data)  
                                {  
                                    $('#table_form').html(data);  
                                    document.getElementById("gene").disabled = false;
                                }  
                            });  
                        }

                    }  
                
                }else{
                     alert("Please Select Date");  
                }

           });
</script>
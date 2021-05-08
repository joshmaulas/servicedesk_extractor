 <?php

//   echo "<pre>";
//     print_r($data);
//     echo"</pre>";
 ?>
<div class="container" style="width:1200px;"> 
                <h2 align="center">Address Frequency - Calls Plot</h2>  
               
                     <div class="col-md-3">
                         <label for="store">Store:</label>
                         <select name="store" id="store" class="form-control">
                         <option value="10002">Select Store</option>
                    <?php  foreach($stores as $store){ ?>
                                   <option value="<?= $store['code'];?>"><?= $store['store_name'];?></option>
                    <?php } ?>
                    
                    </select>

                    </div>   
                    <div class="col-md-3">  
                         <label for="from_date">From:</label>
                         <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date"   />  
                    </div>  
                    <div class="col-md-3">  
                         <label for="to_date">To:</label>
                         <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date"   />  
                    </div>                  
<!--                     
                    <div class="col-md-1">  
                         <input type="button" name="export" id="export" value="Export" class="btn btn-success" />  
                    </div>   -->
               
            
              <div class="col-md-1">  
                     <input type="button" name="filter" id="filter" onClick="this.disabled=true;" value="Extract" class="btn btn-info" />  
              </div>  

              <a href='<?= base_url() ?>Pages/exportCSV123'>Export</a><br><br>

                <div style="clear:both"></div>                     
                <br />  
                <div id="order_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="10%">City</th>  
                               <th width="10%">Brgy.</th>  
                               <th width="25%">Street</th>  
                               <th width="25%">Landmark</th>  
                               <th width="10%">Total Orders</th>  
                               <th width="10%">Total Gross</th>  
                               <th width="10%">Promised Time</th>  
                          </tr> 
                          </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
      $(document).ready(function(){  
           $.datepicker.setDefaults({  
                dateFormat: 'yy-mm-dd'   
           });  
           $(function(){  
                $("#from_date").datepicker();  
                $("#to_date").datepicker();  
           });  


           $('#filter').click(function(){  
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val();
                var store = $('#store').val();
               //  console.log(from_date);
               //  console.log(to_date);
               //  console.log(store);

                if(from_date != '' && to_date != '')  
                {  if (true) {

                        if(from_date > to_date){
                            alert("Please Select Date Properly");
                            document.getElementById("filter").disabled = false;
                        }else{
                            $.ajax({  
                                url:"<?php echo base_url(); ?>Pages/fetch",
                                method:"post",  
                                data:{from_date:from_date, to_date:to_date, store:store},  
                                success:function(data)  
                                {  
                                    $('#order_table').html(data);  
                                    document.getElementById("filter").disabled = false;
                                }  
                            });  
                        }

                    }  
                
                }else{
                     alert("Please Select Date");  
                }

           });  

           $('#customer_data').DataTable({
               "processing" : true,
               "serverSide" : true,
               "ajax" : {
               url:"<?php echo base_url(); ?>Pages/fetch",
               type:"POST"
               },
               dom: 'lBfrtip',
               buttons: [
               'csv', 'copy'
               ]
               });
      });


 </script>	

	
  	</table>
	</div>
	
</div>

  <div class="footer">
<p> POWERED BY: SERVICEDESK</p>
</div> 

</body>
</html>


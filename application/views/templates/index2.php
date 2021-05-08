<html>
        <body>
                <h1 style="font-family:arial">Midnight Sales</h1>
                        <form name="fetching" method="POST" action="midnight_sales.php">
                                Year: <select name="year">
                                                  <option value="2013">2013</option>
                                                  <option value="2014">2014</option>
                          <option value="2015">2015</option>
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                                                </select>&nbsp
                                <!--<input type="text" name="year" id="year" value='<?php /* echo $_POST['year']; */?>'>-->
                                Month: <select name="month">
                                                  <option value="1">January</option>
                                                  <option value="2">February</option>
                                                  <option value="3">March</option>
                                                  <option value="4">April</option>
                                                  <option value="5">May</option>
                                                  <option value="6">June</option>
                                                  <option value="7">July</option>
                                                  <option value="8">August</option>
                                                  <option value="9">September</option>
                                                  <option value="10">October</option>
                                                  <option value="11">November</option>
                                                  <option value="12">December</option>
                                                </select>
                                <!--<input type="text" name="month" id="month" value='<?php /* echo $_POST['month']; */?>'>-->
                                <input name="submit" type="submit" value="Search">
                        </form>

<?php
        // ofsdb connection
                $db1 = "ofs_0_1_2";
                $ofs_connect = mysql_connect("172.16.8.162", "ofs_user", "ictdmdscsi");

                if($ofs_connect){
                        $connect = mysql_select_db($db);
                }else{
                        die("Unable to connect".mysql_error());
                }
                mysql_select_db($db1, $ofs_connect);

        $year = $_POST['year'];
        $month = $_POST['month'];

        if(isset($_POST['submit']))
        {
                // Query for Midnight Sales
                $sql ="SELECT ofs_stores.`code` AS 'store_code',
                                 ofs_stores.store_name 'store_name',
                                 COUNT(ofs_stores.`code`) AS 'tc',
                                 SUM(ofs_orders.total_gross) AS 'sales',
                                 SUM(ofs_orders.total_net) AS 'net_sales'
                           FROM ofs_stores
                           JOIN ofs_orders
                           ON ofs_stores.id = ofs_orders.store_id
                           WHERE
                                `year`= '".$year."'
                           AND `month` = '".$month."'
                           AND HOUR(ofs_orders.order_date) >= 0 AND HOUR(ofs_orders.order_date) < 6
                           AND ofs_orders.`status` = 5
                           GROUP BY ofs_stores.`code`, ofs_stores.store_name
                           ORDER BY ofs_stores.`code`, ofs_stores.store_name";
                $result  = mysql_query($sql);
                echo("Date: $year-$month");

                $head = '<table border="1" cellpadding="1" cellspacing="1" style="width:30%" >';
                $head .= '<tr>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Store Code</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Store Name</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Net Sales</fonth></th>
                                   </tr>';

                while($data = mysql_fetch_array($result))
                {
                $head .=        '<tr>
                                        <td><font size="1">'.$data['store_code'].'</font></td>
                                        <td><font size="1">'.$data['store_name'].'</font></td>
                                        <td><font size="1">'.$data['tc'].'</font></td>
                                        <td><font size="1">'.$data['sales'].'</font></td>
                    <td><font size="1">'.$data['net_sales'].'</font></td>
                                </tr>';
                }
                $head .= '</table>';
                echo $head;
        }else{
                        echo "<p>Please enter date</p>";
        }
?>

</body>
</html>

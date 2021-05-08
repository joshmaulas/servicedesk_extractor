<html>
        <body>
                <h1 style="font-family:arial">MDS Monthly Sales</h1>
                        <form name="fetching" method="POST" action="monthly_sales.php">
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
                                                                        </select>
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
                // Query for Monthly Sales
                $sql ="SELECT
                                ofs_stores.`code` AS 'store_code',
                                ofs_stores.store_name 'store_name',


                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 1) THEN 1 END ) AS 'day_1_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 1) THEN ofs_orders.total_gross END ) AS 'day_1_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 1) THEN ofs_orders.total_net END ) AS 'day_1_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 2) THEN 1 END ) AS 'day_2_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 2) THEN ofs_orders.total_gross END ) AS 'day_2_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 2) THEN ofs_orders.total_net END ) AS 'day_2_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 3) THEN 1 END ) AS 'day_3_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 3) THEN ofs_orders.total_gross END ) AS 'day_3_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 3) THEN ofs_orders.total_net END ) AS 'day_3_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 4) THEN 1 END ) AS 'day_4_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 4) THEN ofs_orders.total_gross END ) AS 'day_4_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 4) THEN ofs_orders.total_net END ) AS 'day_4_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 5) THEN 1 END ) AS 'day_5_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 5) THEN ofs_orders.total_gross END ) AS 'day_5_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 5) THEN ofs_orders.total_net END ) AS 'day_5_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 6) THEN 1 END ) AS 'day_6_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 6) THEN ofs_orders.total_gross END ) AS 'day_6_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 6) THEN ofs_orders.total_net END ) AS 'day_6_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 7) THEN 1 END ) AS 'day_7_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 7) THEN ofs_orders.total_gross END ) AS 'day_7_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 7) THEN ofs_orders.total_net END ) AS 'day_7_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 8) THEN 1 END ) AS 'day_8_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 8) THEN ofs_orders.total_gross END ) AS 'day_8_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 8) THEN ofs_orders.total_net END ) AS 'day_8_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 9) THEN 1 END ) AS 'day_9_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 9) THEN ofs_orders.total_gross END ) AS 'day_9_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 9) THEN ofs_orders.total_net END ) AS 'day_9_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 10) THEN 1 END ) AS 'day_10_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 10) THEN ofs_orders.total_gross END ) AS 'day_10_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 10) THEN ofs_orders.total_net END ) AS 'day_10_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 11) THEN 1 END ) AS 'day_11_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 11) THEN ofs_orders.total_gross END ) AS 'day_11_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 11) THEN ofs_orders.total_net END ) AS 'day_11_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 12) THEN 1 END ) AS 'day_12_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 12) THEN ofs_orders.total_gross END ) AS 'day_12_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 12) THEN ofs_orders.total_net END ) AS 'day_12_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 13) THEN 1 END ) AS 'day_13_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 13) THEN ofs_orders.total_gross END ) AS 'day_13_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 13) THEN ofs_orders.total_net END ) AS 'day_13_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 14) THEN 1 END ) AS 'day_14_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 14) THEN ofs_orders.total_gross END ) AS 'day_14_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 14) THEN ofs_orders.total_net END ) AS 'day_14_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 15) THEN 1 END ) AS 'day_15_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 15) THEN ofs_orders.total_gross END ) AS 'day_15_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 15) THEN ofs_orders.total_net END ) AS 'day_15_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 16) THEN 1 END ) AS 'day_16_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 16) THEN ofs_orders.total_gross END ) AS 'day_16_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 16) THEN ofs_orders.total_net END ) AS 'day_16_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 17) THEN 1 END ) AS 'day_17_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 17) THEN ofs_orders.total_gross END ) AS 'day_17_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 17) THEN ofs_orders.total_net END ) AS 'day_17_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 18) THEN 1 END ) AS 'day_18_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 18) THEN ofs_orders.total_gross END ) AS 'day_18_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 18) THEN ofs_orders.total_net END ) AS 'day_18_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 19) THEN 1 END ) AS 'day_19_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 19) THEN ofs_orders.total_gross END ) AS 'day_19_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 19) THEN ofs_orders.total_net END ) AS 'day_19_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 20) THEN 1 END ) AS 'day_20_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 20) THEN ofs_orders.total_gross END ) AS 'day_20_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 20) THEN ofs_orders.total_net END ) AS 'day_20_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 21) THEN 1 END ) AS 'day_21_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 21) THEN ofs_orders.total_gross END ) AS 'day_21_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 21) THEN ofs_orders.total_net END ) AS 'day_21_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 22) THEN 1 END ) AS 'day_22_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 22) THEN ofs_orders.total_gross END ) AS 'day_22_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 22) THEN ofs_orders.total_net END ) AS 'day_22_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 23) THEN 1 END ) AS 'day_23_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 23) THEN ofs_orders.total_gross END ) AS 'day_23_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 23) THEN ofs_orders.total_net END ) AS 'day_23_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 24) THEN 1 END ) AS 'day_24_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 24) THEN ofs_orders.total_gross END ) AS 'day_24_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 24) THEN ofs_orders.total_net END ) AS 'day_24_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 25) THEN 1 END ) AS 'day_25_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 25) THEN ofs_orders.total_gross END ) AS 'day_25_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 25) THEN ofs_orders.total_net END ) AS 'day_25_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 26) THEN 1 END ) AS 'day_26_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 26) THEN ofs_orders.total_gross END ) AS 'day_26_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 26) THEN ofs_orders.total_net END ) AS 'day_26_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 27) THEN 1 END ) AS 'day_27_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 27) THEN ofs_orders.total_gross END ) AS 'day_27_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 27) THEN ofs_orders.total_net END ) AS 'day_27_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 28) THEN 1 END ) AS 'day_28_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 28) THEN ofs_orders.total_gross END ) AS 'day_28_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 28) THEN ofs_orders.total_net END ) AS 'day_28_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 29) THEN 1 END ) AS 'day_29_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 29) THEN ofs_orders.total_gross END ) AS 'day_29_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 29) THEN ofs_orders.total_net END ) AS 'day_29_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 30) THEN 1 END ) AS 'day_30_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 30) THEN ofs_orders.total_gross END ) AS 'day_30_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 30) THEN ofs_orders.total_net END ) AS 'day_30_net_sales',

                                COUNT(CASE WHEN (DAY(ofs_orders.order_date) = 31) THEN 1 END ) AS 'day_31_tc',
                                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 31) THEN ofs_orders.total_gross END ) AS 'day_31_sales',
                SUM(CASE WHEN (DAY(ofs_orders.order_date) = 31) THEN ofs_orders.total_net END ) AS 'day_31_net_sales'


                                FROM
                                ofs_orders
                                INNER JOIN ofs_stores ON ofs_orders.store_id = ofs_stores.id

                                WHERE ofs_orders.`status` = 5
                                AND `year`= '".$year."'
                                AND `month`= '".$month."'

                                GROUP BY
                                ofs_stores.store_name,
                                ofs_stores.`code`

                                ORDER BY
                                ofs_stores.`code`";

                $result  = mysql_query($sql);
                echo("Date: $year-$month");

                $head = '<table border="1" cellpadding="1" cellspacing="1" style="width:100%" >';
                $head .= '<tr>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Store Code</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Store Name</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 1 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 1 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 1 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 2 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 2 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 2 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 3 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 3 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 3 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 4 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 4 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 4 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 5 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 5 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 5 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 6 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 6 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 6 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 7 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 7 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 7 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 8 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 8 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 8 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 9 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 9 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 9 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 10 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 10 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 10 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 11 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 11 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 11 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 12 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 12 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 12 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 13 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 13 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 13 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 14 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 14 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 14 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 15 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 15 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 15 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 16 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 16 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 16 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 17 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 17 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 17 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 18 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 18 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 18 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 19 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 19 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 19 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 20 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 20 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 20 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 21 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 21 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 21 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 22 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 22 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 22 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 23 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 23 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 23 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 24 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 24 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 24 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 25 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 25 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 25 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 26 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 26 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 26 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 27 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 27 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 27 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 28 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 28 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 28 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 29 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 29 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 29 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 30 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 30 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 30 Net Sales</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 31 TC</fonth></th>
                                                <th bgcolor="#B00000" ><font color="#FFFFFF">Day 31 Sales</fonth></th>
                        <th bgcolor="#B00000" ><font color="#FFFFFF">Day 31 Net Sales</fonth></th>
                                   </tr>';


                                   while($data = mysql_fetch_array($result))
                                   {
                                   $head .=        '<tr>
                                                           <td><font size="1">'.$data['store_code'].'</font></td>
                                                           <td><font size="1">'.$data['store_name'].'</font></td>
                                                           <td><font size="1">'.$data['day_1_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_1_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_1_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_2_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_2_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_2_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_3_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_3_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_3_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_4_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_4_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_4_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_5_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_5_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_5_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_6_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_6_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_6_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_7_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_7_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_7_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_8_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_8_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_8_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_9_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_9_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_9_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_10_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_10_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_10_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_11_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_11_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_11_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_12_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_12_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_12_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_13_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_13_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_13_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_14_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_14_sales'].'</font></td>
                                       <td><font size="1">'.$data['day_14_net_sales'].'</font></td>
                                                           <td><font size="1">'.$data['day_15_tc'].'</font></td>
                                                           <td><font size="1">'.$data['day_15_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_15_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_16_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_16_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_16_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_17_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_17_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_17_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_18_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_18_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_18_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_19_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_19_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_19_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_20_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_20_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_20_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_21_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_21_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_21_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_22_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_22_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_22_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_23_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_23_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_23_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_24_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_24_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_24_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_25_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_25_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_25_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_26_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_26_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_26_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_27_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_27_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_27_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_28_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_28_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_28_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_29_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_29_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_30_net_sales'].'</font></td>
                                                            <td><font size="1">'.$data['day_31_tc'].'</font></td>
                                                            <td><font size="1">'.$data['day_31_sales'].'</font></td>
                                        <td><font size="1">'.$data['day_31_net_sales'].'</font></td>
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
                    
                   



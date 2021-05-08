<?php
class Servicedesk_model extends CI_Model
{

 public function fetch_data_same_month($toYear,$toMonth,$fromDay,$toDay,$storesID)
 {
    $sql = "SELECT 
            oo.city_name,
            osl.brgy,
            osl.Location,
            oo.landmark ,
            CASE WHEN oo.id THEN 1 END AS 'total_order',
            oo.total_gross ,
            oo.promised_time

            FROM ofs_orders AS oo
            LEFT JOIN ofs_street_list as osl ON osl.POINT_X = oo.rta_x AND  osl.POINT_Y = oo.rta_y
                                                                                
            WHERE oo.year = $toYear
            AND oo.month = $toMonth
            AND oo.day >= $fromDay
            AND oo.day <= $toDay
            AND oo.store_code = $storesID
            AND oo.status = 5
            GROUP BY oo.id
            ORDER BY osl.brgy, osl.Location, oo.landmark  ASC";
    $result = $this->db->query($sql);

    return $result->result_array();
 }

 public function fetch_data_dif_month($fromYear,$fromMonth,$fromDay,$fromEomonth_day,$toYear,$toMonth,$toFDomonth_day,$toDay,$storesID)
 {
     $sql = "SELECT *
            FROM ( 
            SELECT oo.city_name,
            osl.brgy,
            osl.Location,
            oo.landmark ,
            CASE WHEN oo.id THEN 1 END AS 'total_order',
            oo.total_gross ,
            oo.promised_time 

            FROM ofs_orders AS oo
            LEFT JOIN ofs_street_list as osl ON osl.POINT_X = oo.rta_x AND  osl.POINT_Y = oo.rta_y
                                            
            WHERE oo.year = $fromYear
            AND oo.month = $fromMonth
            AND oo.day >= $fromDay
            AND oo.day <= $fromEomonth_day
            AND oo.store_code = $storesID
            AND oo.status = 5
            GROUP BY oo.id
            
            UNION ALL

            SELECT oo.city_name,
            osl.brgy,
            osl.Location,
            oo.landmark ,
            CASE WHEN oo.id THEN 1 END AS 'total_order',
            oo.total_gross ,
            oo.promised_time

            FROM ofs_orders AS oo
            LEFT JOIN ofs_street_list as osl ON osl.POINT_X = oo.rta_x AND  osl.POINT_Y = oo.rta_y

            WHERE oo.year = $toYear
            AND oo.month = $toMonth
            AND oo.day >= $toFDomonth_day
            AND oo.day <= $toDay
            AND oo.store_code = $storesID
            AND oo.status = 5
            GROUP BY oo.id) AS C ORDER BY brgy,Location,landmark ASC";
    $result = $this->db->query($sql);

    return $result->result_array();
 }




 public function getStores(){

        $this->db->where('is_active',"1");
        $this->db->order_by("store_name", "asc");
        $query = $this->db->get('ofs_stores');
        return $query->result_array();

    }

    public function monthly_getStores(){

        $this->db->select('code , store_name');
        $this->db->where('is_active',"1");      
        $this->db->order_by("code", "asc");
        $query = $this->db->get('ofs_stores');
        return $query->result_array();

    }



    public function getSelectStores($store){

        $this->db->select('store_name');
        $this->db->where('is_active',"1");
        $this->db->order_by("store_name", "asc");
        $this->db->where("code", $store);
        $query = $this->db->get('ofs_stores');
        return $query->result_array();

    }

    public function getAllowedIP()
    {
	 $allow = array("172.16.8.109", "172.16.8.124", "172.16.8.105","172.16.8.121", "172.16.8.125","172.16.8.122"); //allowed IPs

                if(!in_array($_SERVER['REMOTE_ADDR'], $allow) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {

                        header("Location: http://172.16.8.124/codeigniter-3/"); //redirect

                        exit();

                }

        }


        public function monthly_report($year, $month, $from, $to, $src)
        {
                $select_query = "SELECT 1 as days ";
                $temp_arr = array();
                for($x=$from;$x<=$to;$x++){
                    $select_query .= "UNION SELECT $x ";
                }
                $ac = 0;

                $sql = "SELECT IFNULL(SUM(total_gross),0) as total_gross,
                COUNT(id) as total_calls, 
                days,
                IFNULL(SUM(total_gross)/COUNT(id),0) as ac,
                COUNT(CASE promised_time WHEN '30' THEN IF(30 > TIMESTAMPDIFF(MINUTE, order_date, customer_receive_datetime), 30, NULL) ELSE NULL END) AS tc_below
                FROM($select_query) AS Alldays
                LEFT JOIN `ofs_orders` ON day = days
                        AND source_id = $src
                        AND status = 5
                        AND year = $year
                        AND month = $month
                GROUP BY days
                ORDER BY days";

           $result = $this->db->query($sql);
       
           return $result->result_array();
        }

        //--------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------


        public function monthly_per_store_report($year, $month, $from, $to, $src)
        {
                $select_query = "SELECT 1 as days ";
                $temp_arr = array();
                for($x=$from;$x<=$to;$x++){
                    $select_query .= "UNION SELECT $x ";
                }
                $ac = 0;

                $sql = "SELECT 
                ofs_stores.code AS store_code,
                ofs_stores.store_name,
                IFNULL(SUM(ofs_orders.total_gross),0) as total_gross,
                COUNT(ofs_orders.id) as total_calls, 
                CAST(IFNULL(SUM(ofs_orders.total_gross)/COUNT(ofs_orders.id),0) AS DECIMAL(10,2)) as ac,
                COUNT(CASE ofs_orders.promised_time WHEN '30' THEN IF(30 > TIMESTAMPDIFF(MINUTE, ofs_orders.order_date, ofs_orders.customer_receive_datetime), 30, NULL) ELSE NULL END) AS tc_below
                FROM($select_query) AS Alldays
                     LEFT JOIN ofs_orders ON ofs_orders.day = days
                     INNER JOIN ofs_stores ON ofs_orders.store_id = ofs_stores.id
                        AND ofs_orders.source_id = $src
                        AND ofs_orders.status = 5
                        AND ofs_orders.year = $year
                        AND ofs_orders.month = $month

                                GROUP BY
                                ofs_stores.store_name,
                                ofs_stores.code

                                ORDER BY
                                ofs_stores.code ASC";
                                

           $result = $this->db->query($sql);
       
           return $result->result_array();
        }
        //--------------------------------------------------------------------------------------

        public function monthly_per_store_day_report($year, $month, $day)
        {
              

                $sql = "SELECT 
                ofs_stores.code AS store_code,
                ofs_stores.store_name,
                IFNULL(SUM(ofs_orders.total_gross),0) as total_gross,
                COUNT(ofs_orders.id) as total_calls, 
                IFNULL(SUM(ofs_orders.total_net),0) as total_net
                FROM ofs_orders INNER JOIN ofs_stores ON ofs_orders.store_id = ofs_stores.id
                        AND ofs_orders.status = 5
                        AND ofs_orders.year = $year
                        AND ofs_orders.month = $month
                        AND ofs_orders.day = $day

                                GROUP BY
                                ofs_stores.store_name,
                                ofs_stores.code

                                ORDER BY
                                ofs_stores.code ASC";
                                

           $result = $this->db->query($sql);
       
           return $result->result_array();
        }

        //--------------------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------------------
        public function monthly_customized_model($month, $year, $from, $to){


                $sql = "SELECT ofs_stores.code AS store_code,
                                ofs_stores.store_name AS store_name,
                                COUNT(ofs_stores.`code`) AS 'tc',
                                SUM(ofs_orders.total_gross) AS 'sales',
                                SUM(ofs_orders.total_net) AS 'net_sales'
                                FROM ofs_stores
                                JOIN ofs_orders
                                ON ofs_stores.id = ofs_orders.store_id
                                WHERE
                                 `year`= $year
                                AND `month` = $month
                                AND HOUR(ofs_orders.order_date) >= $from AND HOUR(ofs_orders.order_date) <= $to
                                AND ofs_orders.`status` = 5
                                GROUP BY ofs_stores.`code`, ofs_stores.store_name
                                ORDER BY ofs_stores.`code`, ofs_stores.store_name";
     
                $result = $this->db->query($sql);
            
                return $result->result_array();
                

        }

        //--------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------

        public function daily_report($year, $month, $day, $x, $src)
        {
           $sql = "SELECT IFNULL(SUM(total_gross),0) as total_gross_per_hour, COUNT(id) as total_calls
           FROM ofs_orders
           WHERE year = $year AND month = $month AND day = $day AND HOUR = $x AND status = 5 AND source_id = $src";

           $result = $this->db->query($sql);
       
           return $result->result_array();
        }

        //------------------------------------------------------------------------------
        //------------------------------------------------------------------------------

        public function getTotalTC($month, $year){

                $sql = "SELECT count(*) AS total_tc
                
                         FROM ofs_orders
        
                        WHERE year = $year
                        AND month = $month
                        AND status = 5";
        
                   $result = $this->db->query($sql);
               
                   return $result->result_array();
        
            }

        public function getProductItems($year, $month){

                $sql = "SELECT 
                `ofs_order_items`.`child_item_poscode`,
                CAST(SUM(`ofs_order_items`.`item_basic_price`) AS DECIMAL(10,2)) as net_sales,
                SUM(`ofs_order_items`.`quantity`) AS quantity
                
                FROM `ofs_order_items`
                INNER JOIN `ofs_orders` ON `ofs_orders`.`id` = `ofs_order_items`.`order_id`
                WHERE `ofs_orders`.`status` = 5 
                
                AND `ofs_orders`.`year`=$year
                AND `ofs_orders`.`month`=$month
                AND `ofs_order_items`.`is_deleted` = '0'
                
                group by `ofs_order_items`.`child_item_poscode`
                "; 
        
                   $result = $this->db->query($sql);
               
                   return $result->result_array();


                   
        
            }

            public function getProductList(){

                $sql = "SELECT `pos_code`,
                        `category`,
                        `name`
                        
                        FROM `ofs_products` 
                        WHERE store_id = '1'";
        
                   $result = $this->db->query($sql);
               
                   return $result->result_array();
        
            }
        //------------------------------------------------------------------------------
        //------------------------------------------------------------------------------
        




}
?>
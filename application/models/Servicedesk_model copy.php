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
            -- CASE WHEN oo.id THEN 1 END AS 'Total Orders',
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
            -- CASE WHEN oo.id THEN 1 END AS 'Total Orders',
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
            -- CASE WHEN oo.id THEN 1 END AS 'Total Orders',
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

    public function getAllowedIP()
    {
	 $allow = array("172.16.8.109", "172.16.8.124", "172.16.8.105","172.16.8.121", "172.16.8.125","172.16.8.122"); //allowed IPs

                if(!in_array($_SERVER['REMOTE_ADDR'], $allow) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {

                        header("Location: http://172.16.8.124/codeigniter-3/"); //redirect

                        exit();

                }

        }
        




}
?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AstroModel extends CI_Model{
    public function getHoroscopeToday(){
        $today = date('Y-m-d');
        $sql = "SELECT t1.*, t2.name, t2.image FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$today'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(empty($result)){
            $url = 'https://alwaysfirst.in/astroGet/getData.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t1.*, t2.name,t2.image FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$today'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }else {
            return $result;
        }
    }
    public function getHoroscopeYesterday(){
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $sql = "SELECT t2.name, t2.image, t1.*  FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$yesterday'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function getHoroscopeTomorrow(){
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $sql = "SELECT t1.*, t2.name, t2.image FROM next_day_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$tomorrow'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(empty($result)){
            $url = 'https://alwaysfirst.in/astroGet/getDataTo.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t1.*, t2.name,t2.image FROM next_day_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$tomorrow'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }else {
            return $result;
        }
    }
    public function getHoroscopeMonth(){
        $month = date("F");
        $year = date("Y");
        $sql = "SELECT t1.*, t2.name, t2.image FROM astro_monthly_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.month='$month' AND t1.year='$year'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(empty($result)){
            $url = 'https://alwaysfirst.in/astroGet/getDataMonth.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t1.*, t2.name,t2.image FROM astro_monthly_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.month='$month' AND t1.year='$year'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            // return $result;
        }else {
            return $result;
        }
        foreach($result as $row){
            $normal_horoscope = $row['normal_horoscope'];
            $normal_horoscope_title = explode("HOROSCOPE_DATA", $normal_horoscope)[0];
            $normal_horoscope_title = explode("HOROSCOPE_TITLE", $normal_horoscope_title)[1];
            $normal_horoscope_data = explode("HOROSCOPE_DATA", $normal_horoscope)[1];
            $workspace_horoscope = $row['workspace_horoscope'];
            $workspace_horoscope_title = explode("HOROSCOPE_DATA", $workspace_horoscope)[0];
            $workspace_horoscope_title = explode("HOROSCOPE_TITLE", $workspace_horoscope_title)[1];
            $workspace_horoscope_data = explode("HOROSCOPE_DATA", $workspace_horoscope)[1];
            $financial_horoscope = $row['financial_horoscope'];
            $financial_horoscope_title = explode("HOROSCOPE_DATA", $financial_horoscope)[0];
            $financial_horoscope_title = explode("HOROSCOPE_TITLE", $financial_horoscope_title)[1];
            $financial_horoscope_data = explode("HOROSCOPE_DATA", $financial_horoscope)[1];
            $physical_horoscope = $row['physical_horoscope'];
            $physical_horoscope_title = explode("HOROSCOPE_DATA", $physical_horoscope)[0];
            $physical_horoscope_title = explode("HOROSCOPE_TITLE", $physical_horoscope_title)[1];
            $physical_horoscope_data = explode("HOROSCOPE_DATA", $physical_horoscope)[1];
            $love_horoscope = $row['love_horoscope'];
            $love_horoscope_title = explode("HOROSCOPE_DATA", $love_horoscope)[0];
            $love_horoscope_title = explode("HOROSCOPE_TITLE", $love_horoscope_title)[1];
            $love_horoscope_data = explode("HOROSCOPE_DATA", $love_horoscope)[1];
            $family_horoscope = $row['family_horoscope'];
            $family_horoscope_title = explode("HOROSCOPE_DATA", $family_horoscope)[0];
            $family_horoscope_title = explode("HOROSCOPE_TITLE", $family_horoscope_title)[1];
            $family_horoscope_data = explode("HOROSCOPE_DATA", $family_horoscope)[1];
            $remedy = $row['remedy'];
            $remedy_title = explode("HOROSCOPE_DATA", $remedy)[0];
            $remedy_title = explode("HOROSCOPE_TITLE", $remedy_title)[1];
            $remedy_data = explode("HOROSCOPE_DATA", $remedy)[1];
            $image = $row['image'];
            $rashi_eng = $row['image'];
            $rashi_eng = str_replace(".png", "", $rashi_eng);
            $rashi_eng = str_replace("https://alwaysfirst.in/api/icons/", "", $rashi_eng);
            $data[] = array(
                'id' => $row['id'],
                'rashi_id' => $row['rashi_id'],
                'rashi_eng' => $rashi_eng,
                'name' => $row['name'],
                'image' => $image,
                'month' => $row['month'],
                'year' => $row['year'],
                'horoscope' => array(
                    array('title' => $normal_horoscope_title, 'data' => $normal_horoscope_data),
                    array('title' => $workspace_horoscope_title, 'data' => $workspace_horoscope_data),
                    array('title' => $financial_horoscope_title, 'data' => $financial_horoscope_data),
                    array('title' => $physical_horoscope_title, 'data' => $physical_horoscope_data),
                    array('title' => $love_horoscope_title, 'data' => $love_horoscope_data),
                    array('title' => $family_horoscope_title, 'data' => $family_horoscope_data),
                    array('title' => $remedy_title, 'data' => $remedy_data)
                )
            );
        }
        return $data;
    }
    public function getHoroscope(){
        $todayHoroscope = $this->getHoroscopeToday();
        $yesterdayHoroscope = $this->getHoroscopeYesterday();
        $tomorrowHoroscope = $this->getHoroscopeTomorrow();
        $monthHoroscope = $this->getHoroscopeMonth();
        foreach ($todayHoroscope as $key => $value) {
            $result[] = array(
                'name' => $value['name'],
                'rashi_eng' => $monthHoroscope[$key]['rashi_eng'],
                'rashi_id' => $value['rashi_id'],
                'image' => $monthHoroscope[$key]['image'],
                'today' => array(
                    'id' => $value['id'],
                    'date' => $value['date'],
                    'horoscope' => $value['horoscope'],
                    'lucky_number' => $value['lucky_number'],
                    'lucky_color' => $value['lucky_color'],
                    'remedy' => $value['remedy']
                ),
                'yesterday' => array(
                    'id' => $yesterdayHoroscope[$key]['id'],
                    'date' => $yesterdayHoroscope[$key]['date'],
                    'horoscope' => $yesterdayHoroscope[$key]['horoscope'],
                    'lucky_number' => $yesterdayHoroscope[$key]['lucky_number'],
                    'lucky_color' => $yesterdayHoroscope[$key]['lucky_color'],
                    'remedy' => $yesterdayHoroscope[$key]['remedy']
                ),
                'tomorrow' => array(
                    'id' => $tomorrowHoroscope[$key]['id'],
                    'date' => $tomorrowHoroscope[$key]['date'],
                    'horoscope' => $tomorrowHoroscope[$key]['horoscope'],
                    'lucky_number' => $tomorrowHoroscope[$key]['lucky_number'],
                    'lucky_color' => $tomorrowHoroscope[$key]['lucky_color'],
                    'remedy' => $tomorrowHoroscope[$key]['remedy']
                ),
                'month' => array(
                    'id' => $monthHoroscope[$key]['id'],
                    'month' => $monthHoroscope[$key]['month'],
                    'year' => $monthHoroscope[$key]['year'],
                    'horoscope' => $monthHoroscope[$key]['horoscope'],
                )
            );
        }
        return $result;
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AstroModel extends CI_Model
{
    public function getHoroscopeToday(){
        $today = date('Y-m-d');
        $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$today'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if (empty($result)) {
            $url = 'https://alwaysfirst.in/astroGet/getData.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$today'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        } else {
            return $result;
        }
    }
    public function getHoroscopeYesterday(){
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.*  FROM daily_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$yesterday'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function getHoroscopeTomorrow(){
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM next_day_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$tomorrow'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if (empty($result)) {
            $url = 'https://alwaysfirst.in/astroGet/getDataTo.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM next_day_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.date='$tomorrow'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        } else {
            return $result;
        }
    }
    public function getHoroscopeMonth(){
        $month = date("F");
        $year = date("Y");
        $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM astro_monthly_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.month='$month' AND t1.year='$year'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if (empty($result)) {
            $url = 'https://alwaysfirst.in/astroGet/getDataMonth.php';
            exec("curl -X POST -d 'url=$url' $url");
            // $this->curl->simple_get($url);
            $sql = "SELECT t2.name, t2.image, t2.name_eng, t1.* FROM astro_monthly_horoscope as t1 LEFT JOIN rashi as t2 ON t1.rashi_id = t2.id WHERE t1.month='$month' AND t1.year='$year'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            // return $result;
        } else {
            // return $result;
        }
        foreach ($result as $row) {
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
            $data[] = array(
                'id' => $row['id'],
                'rashi_id' => $row['rashi_id'],
                'name_eng' => $row['name_eng'],
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
                'rashi_eng' => $value['name_eng'],
                'name_eng' => $monthHoroscope[$key]['name_eng'],
                'rashi_id' => $value['rashi_id'],
                'image' => $monthHoroscope[$key]['image'],
                'today' => array(
                    'id' => $value['id'],
                    'date' => $value['date'],
                    'name' => $value['name'],
                    'rashi_eng' => $value['name_eng'],
                    'name_eng' => $monthHoroscope[$key]['name_eng'],
                    'image' => $monthHoroscope[$key]['image'],
                    'horoscope' => $value['horoscope'],
                    'lucky_number' => $value['lucky_number'],
                    'lucky_color' => $value['lucky_color'],
                    'remedy' => $value['remedy']
                ),
                'yesterday' => array(
                    'id' => $yesterdayHoroscope[$key]['id'],
                    'date' => $yesterdayHoroscope[$key]['date'],
                    'name' => $value['name'],
                    'rashi_eng' => $value['name_eng'],
                    'name_eng' => $monthHoroscope[$key]['name_eng'],
                    'image' => $monthHoroscope[$key]['image'],
                    'horoscope' => $yesterdayHoroscope[$key]['horoscope'],
                    'lucky_number' => $yesterdayHoroscope[$key]['lucky_number'],
                    'lucky_color' => $yesterdayHoroscope[$key]['lucky_color'],
                    'remedy' => $yesterdayHoroscope[$key]['remedy']
                ),
                'tomorrow' => array(
                    'id' => $tomorrowHoroscope[$key]['id'],
                    'date' => $tomorrowHoroscope[$key]['date'],
                    'name' => $value['name'],
                    'rashi_eng' => $value['name_eng'],
                    'name_eng' => $monthHoroscope[$key]['name_eng'],
                    'image' => $monthHoroscope[$key]['image'],
                    'horoscope' => $tomorrowHoroscope[$key]['horoscope'],
                    'lucky_number' => $tomorrowHoroscope[$key]['lucky_number'],
                    'lucky_color' => $tomorrowHoroscope[$key]['lucky_color'],
                    'remedy' => $tomorrowHoroscope[$key]['remedy']
                ),
                'month' => array(
                    'id' => $monthHoroscope[$key]['id'],
                    'month' => $monthHoroscope[$key]['month'],
                    'year' => $monthHoroscope[$key]['year'],
                    'name' => $value['name'],
                    'rashi_eng' => $value['name_eng'],
                    'name_eng' => $monthHoroscope[$key]['name_eng'],
                    'image' => $monthHoroscope[$key]['image'],
                    'horoscope' => $monthHoroscope[$key]['horoscope'],
                )
            );
        }
        return $result;
    }
    public function jokes($post_data){
        $before_days = isset($post_data['before_days']) ? $post_data['before_days'] - 1 : 0;
        // check before days between 0 and 365
        if ($before_days > 365) {
            $before_days = 365;
        } else if ($before_days < 0) {
            $before_days = 0;
        } 
        $today = date('Y-m-d');
        // Getting Before Date
        $before_days_date = date('Y-m-d', strtotime('-' . $before_days . ' days'));
        $sql = "SELECT * FROM `aaws_jokes` WHERE `date` BETWEEN '$before_days_date' AND '$today' ORDER BY `date` DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function quotes($post_data){
        $before_days = isset($post_data['before_days']) ? $post_data['before_days'] - 1 : 0;
        // check before days between 0 and 365
        if ($before_days > 365) {
            $before_days = 365;
        } else if ($before_days < 0) {
            $before_days = 0;
        } 
        $today = date('Y-m-d');
        // Getting Before Date
        $before_days_date = date('Y-m-d', strtotime('-' . $before_days . ' days'));
        $sql = "SELECT * FROM `aaws_quotes` WHERE `date` BETWEEN '$before_days_date' AND '$today' ORDER BY `date` DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function photos($post_data){
        $before_days = isset($post_data['before_days']) ? $post_data['before_days'] - 1 : 0;
        // check before days between 0 and 365
        if ($before_days > 365) {
            $before_days = 365;
        } else if ($before_days < 0) {
            $before_days = 0;
        } 
        $today = date('Y-m-d');
        // Getting Before Date
        $before_days_date = date('Y-m-d', strtotime('-' . $before_days . ' days'));
        $sql = "SELECT * FROM `aaws_photos` WHERE `date` BETWEEN '$before_days_date' AND '$today' ORDER BY `date` DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function quotesToday(){
        $date = date('j');
        $month = date('F');
        $day = date('l');
        $year = date('Y');
        $sql = "SELECT * FROM `aaws_inc_quotes_2022` WHERE `date` = '$date' AND `month` = '$month' AND `day` = '$day' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function jki($post_data){
        $before_days = isset($post_data['before_days']) ? ($post_data['before_days'] == 0 ? 0 : $post_data['before_days'] - 1) : 0;
        if($before_days == 0){
            $jokes_data = $this->jokes($post_data);
            $result['jokes'] = array(
                'name' => 'Jokes',
                'link' => 'https://www.alwaysfirst.in/jokes/',
                'image' => $jokes_data[0]['image'],
            );
            $quotes_data = $this->quotes($post_data);
            $result['quotes'] = array(
                'name' => 'Quotes',
                'link' => ' https://www.alwaysfirst.in/quotes/',
                'image' => $quotes_data[0]['image'],
            );
            $photos_data = $this->photos($post_data);
            $result['photos'] = array(
                'name' => 'Photos',
                'link' => 'https://www.alwaysfirst.in/photos/',
                'image' => $photos_data[0]['image'],
            );
        }else{
            $result['jokes'] = $this->jokes($post_data);
            $result['quotes'] = $this->quotes($before_days);
            $result['photos'] = $this->photos($before_days);
        }
        return $result;
    }
    public function jqi($post_data){
        $post_data['before_days'] = isset($post_data['before_days']) ? $post_data['before_days'] - 1 : 7;
        $jokes_data = $this->jokes($post_data);
        // maping jokes data
        $jokes = array();
        foreach ($jokes_data as $key => $value) {
            $jokes[$key]['id'] = $value['id'];
            $jokes[$key]['image'] = $value['image'];
        }
        $result[] = array(
            'name' => 'Jokes',
            'data' => $jokes,
        );
        $quotes_data = $this->quotes($post_data);
        // maping quotes data
        $quotes = array();
        foreach ($quotes_data as $key => $value) {
            $quotes[$key]['id'] = $value['id'];
            $quotes[$key]['image'] = $value['image'];
        }
        $result[] = array(
            'name' => 'Quotes',
            'data' => $quotes,
        );
        $photos_data = $this->photos($post_data);
        // maping photos data
        $photos = array();
        foreach ($photos_data as $key => $value) {
            $photos[$key]['id'] = $value['id'];
            $photos[$key]['image'] = $value['image'];
        }
        $result[] = array(
            'name' => 'Photos',
            'data' => $photos,
        );
        return $result;
    }
}

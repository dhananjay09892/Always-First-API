<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Curl');
    } 
    // Advertisement API
    public function getAds()
    {
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/06/Thermatic-Exhibition.jpeg',
            'redirect' => 'off',
            'link' => 'https://www.alwaysfirst.in/',
        );
        return $adsArray;
        $none = null;
        // return $none;
    }
    public function getAdsCategory()
    {
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/06/Thermatic-Exhibition.jpeg',
            'redirect' => 'off',
            'link' => 'https://www.alwaysfirst.in/',
        );
        return $adsArray;
        $none = null;
        // return $none;
    }
    public function getAdsArticle(){
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/06/Thermatic-Exhibition.jpeg',
            'redirect' => 'off',
            'link' => 'https://www.alwaysfirst.in/',
        );
        return $adsArray;
        // $none = null;
        // return $none;
    }
    // Always First API
    public function getPostsAll($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $url = 'https://alwaysfirst.in/wp-json/wp/v2/posts/?_embed';
        $url .= $per_page != '' ? '&per_page=' . $per_page : '';
        $url .= $page != '' ? '&page=' . $page : '';
        $url .= $category_get != '' ? '&categories=' . $category_get : '';
        $url .= $search_get != '' ? '&search=' . $search_get : '';
        $url .= $author_get != '' ? '&author=' . $author_get : '';
        $url .= $tags_get != '' ? '&tags=' . $tags_get : '';

        $data = $this->curl->simple_get($url);
        $data = json_decode($data, true);
        foreach ($data as  $value) {
            $id = $value['id'];
            $post_data = array(
                'title' => $value['title']['rendered'],
                'content' => strip_tags($value['content']['rendered'], '<img><iframe>'),
                'link' => $value['link'],
                'date' => $value['modified'],
                'feature_image' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'],
                'feature_image_thumb' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'],
                'feature_image_medium' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url'],
            );
            $author = array(
                'author_id' => $value['_embedded']['author'][0]['id'],
                'author_name' => $value['_embedded']['author'][0]['name'],
                'author_link' => $value['_embedded']['author'][0]['link']
            );
            $cat_count = 0;
            $tag_count = 0;
            foreach ($value['_embedded']['wp:term'] as $terms) {
                foreach ($terms as $value) {
                    if ($value['taxonomy'] == 'category') {
                        $category[$cat_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $cat_count++;
                    }
                    if ($value['taxonomy'] == 'post_tag') {
                        $tag[$tag_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $tag_count++;
                    }
                }
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $category,
                'tags' => $tag
            );
        }
        return $result;
    }
    public function getCategory()
    {
        $json_data =
                '[ { "id": 35, "name": "Art & Culture", "link": "https://www.alwaysfirst.in/category/art-and-culture/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/35.png", "children": [ { "id": 2541, "name": "Art & Design", "link": "https://www.alwaysfirst.in/category/art-and-culture/art-and-design/", "type": "category", "parent": 35 }, { "id": 13090, "name": "Culture", "link": "https://www.alwaysfirst.in/category/art-and-culture/culture/", "type": "category", "parent": 35 } ] }, { "id": 36, "name": "Business", "link": "https://www.alwaysfirst.in/category/business/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/36.png", "children": [ { "id": 13092, "name": "Business General News", "link": "https://www.alwaysfirst.in/category/business/business-general-news/", "type": "category", "parent": 36 }, { "id": 13091, "name": "Corporate", "link": "https://www.alwaysfirst.in/category/business/corporate/", "type": "category", "parent": 36 } ] }, { "id": 8248, "name": "Crime", "link": "https://www.alwaysfirst.in/category/crime/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/8248.png", "children": [] }, { "id": 8096, "name": "Defence", "link": "https://www.alwaysfirst.in/category/defence/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/8096.png", "children": [] }, { "id": 131, "name": "Entertainment", "link": "https://www.alwaysfirst.in/category/entertainment/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/131.png", "children": [ { "id": 162, "name": "Bollywood", "link": "https://www.alwaysfirst.in/category/entertainment/bollywood/", "type": "category", "parent": 131 }, { "id": 8835, "name": "Hollywood", "link": "https://www.alwaysfirst.in/category/entertainment/hollywood/", "type": "category", "parent": 131 }, { "id": 133, "name": "Latest Updates", "link": "https://www.alwaysfirst.in/category/entertainment/latest-updates/", "type": "category", "parent": 131 }, { "id": 163, "name": "Music", "link": "https://www.alwaysfirst.in/category/entertainment/music/", "type": "category", "parent": 131 } ] }, { "id": 12849, "name": "Environment", "link": "https://www.alwaysfirst.in/category/environment/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/12849.png", "children": [ { "id": 13095, "name": "Energy", "link": "https://www.alwaysfirst.in/category/environment/energy/", "type": "category", "parent": 12849 }, { "id": 13099, "name": "Natural Calamities", "link": "https://www.alwaysfirst.in/category/environment/natural-calamities/", "type": "category", "parent": 12849 }, { "id": 13097, "name": "Oil & Gas", "link": "https://www.alwaysfirst.in/category/environment/oil-gas/", "type": "category", "parent": 12849 }, { "id": 13100, "name": "Other News", "link": "https://www.alwaysfirst.in/category/environment/other-news/", "type": "category", "parent": 12849 }, { "id": 13096, "name": "Power", "link": "https://www.alwaysfirst.in/category/environment/power/", "type": "category", "parent": 12849 }, { "id": 13098, "name": "Renewable", "link": "https://www.alwaysfirst.in/category/environment/renewable/", "type": "category", "parent": 12849 } ] }, { "id": 3490, "name": "Featured Stories", "link": "https://www.alwaysfirst.in/category/featured-stories/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/3490.png", "children": [] }, { "id": 92, "name": "Handloom & Handicraft", "link": "https://www.alwaysfirst.in/category/handloom-and-handicraft/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/92.png", "children": [] }, { "id": 27, "name": "Lifestyle", "link": "https://www.alwaysfirst.in/category/lifestyle/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/27.png", "children": [ { "id": 8246, "name": "Animal & Wild life", "link": "https://www.alwaysfirst.in/category/lifestyle/animal-and-wild-life/", "type": "category", "parent": 27 }, { "id": 107, "name": "Beauty", "link": "https://www.alwaysfirst.in/category/lifestyle/beauty/", "type": "category", "parent": 27 }, { "id": 106, "name": "Fashion", "link": "https://www.alwaysfirst.in/category/lifestyle/fashion/", "type": "category", "parent": 27 }, { "id": 8237, "name": "Fitness", "link": "https://www.alwaysfirst.in/category/lifestyle/fitness/", "type": "category", "parent": 27 }, { "id": 159, "name": "Health", "link": "https://www.alwaysfirst.in/category/lifestyle/health/", "type": "category", "parent": 27 }, { "id": 13086, "name": "Parenting", "link": "https://www.alwaysfirst.in/category/lifestyle/parenting/", "type": "category", "parent": 27 }, { "id": 13089, "name": "Quirky", "link": "https://www.alwaysfirst.in/category/lifestyle/quirky/", "type": "category", "parent": 27 }, { "id": 124, "name": "Recipes & Food", "link": "https://www.alwaysfirst.in/category/lifestyle/recipes-and-food/", "type": "category", "parent": 27 }, { "id": 13087, "name": "Relationship", "link": "https://www.alwaysfirst.in/category/lifestyle/relationship/", "type": "category", "parent": 27 }, { "id": 13088, "name": "Sexuality", "link": "https://www.alwaysfirst.in/category/lifestyle/sexuality/", "type": "category", "parent": 27 }, { "id": 8268, "name": "Travel", "link": "https://www.alwaysfirst.in/category/lifestyle/travel-international/", "type": "category", "parent": 27 } ] }, { "id": 8403, "name": "National", "link": "https://www.alwaysfirst.in/category/national/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/8403.png", "children": [ { "id": 13094, "name": "Apne Desh ki Khabar", "link": "https://www.alwaysfirst.in/category/national/apne-desh-ki-khabar/", "type": "category", "parent": 8403 }, { "id": 12859, "name": "General News", "link": "https://www.alwaysfirst.in/category/national/general-news/", "type": "category", "parent": 8403 }, { "id": 5648, "name": "Politics", "link": "https://www.alwaysfirst.in/category/national/politics/", "type": "category", "parent": 8403 } ] }, { "id": 2639, "name": "Science & Tech", "link": "https://www.alwaysfirst.in/category/science-tech/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/2639.png", "children": [ { "id": 128, "name": "Gadget", "link": "https://www.alwaysfirst.in/category/science-tech/gadget/", "type": "category", "parent": 2639 }, { "id": 8277, "name": "Internet", "link": "https://www.alwaysfirst.in/category/science-tech/internet/", "type": "category", "parent": 2639 }, { "id": 13082, "name": "Science", "link": "https://www.alwaysfirst.in/category/science-tech/science/", "type": "category", "parent": 2639 }, { "id": 126, "name": "Technology", "link": "https://www.alwaysfirst.in/category/science-tech/technology/", "type": "category", "parent": 2639 } ] }, { "id": 16, "name": "Sports", "link": "https://www.alwaysfirst.in/category/sports/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/16.png", "children": [ { "id": 17, "name": "Cricket", "link": "https://www.alwaysfirst.in/category/sports/cricket/", "type": "category", "parent": 16 }, { "id": 20, "name": "Football", "link": "https://www.alwaysfirst.in/category/sports/football/", "type": "category", "parent": 16 }, { "id": 8279, "name": "Hockey", "link": "https://www.alwaysfirst.in/category/sports/hockey/", "type": "category", "parent": 16 }, { "id": 13084, "name": "Latest Update", "link": "https://www.alwaysfirst.in/category/sports/latest-update/", "type": "category", "parent": 16 }, { "id": 13085, "name": "Other Sports", "link": "https://www.alwaysfirst.in/category/sports/other-sports/", "type": "category", "parent": 16 }, { "id": 13083, "name": "Tennis", "link": "https://www.alwaysfirst.in/category/sports/tennis/", "type": "category", "parent": 16 } ] }, { "id": 65, "name": "World", "link": "https://www.alwaysfirst.in/category/world/", "type": "category", "icon": "https://alwaysfirst.in/api/icons/65.png", "children": [ { "id": 8094, "name": "Asia", "link": "https://www.alwaysfirst.in/category/world/asia/", "type": "category", "parent": 65 }, { "id": 94, "name": "Europe", "link": "https://www.alwaysfirst.in/category/world/europe/", "type": "category", "parent": 65 }, { "id": 13093, "name": "Latest News", "link": "https://www.alwaysfirst.in/category/world/latest-news/", "type": "category", "parent": 65 }, { "id": 96, "name": "Mideast", "link": "https://www.alwaysfirst.in/category/world/mideast/", "type": "category", "parent": 65 }, { "id": 8095, "name": "Pacific", "link": "https://www.alwaysfirst.in/category/world/pacific/", "type": "category", "parent": 65 }, { "id": 8093, "name": "United States", "link": "https://www.alwaysfirst.in/category/world/united-states/", "type": "category", "parent": 65 } ] } ]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getMenuCategory()
    {
        $json_data =
            '[{"name":"Business","link":"https:\/\/www.alwaysfirst.in\/category\/business\/","id":36,"type":"category"},{"name":"Continents","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/","id":65,"type":"category"},{"name":"Entertainment","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/","id":131,"type":"category"},{"name":"Politics","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/","id":5648,"type":"category"},{"name":"Sports","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/","id":16,"type":"category"}]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getCats()
    {
        $url = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100';
        $url1 = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        $data = $this->curl->simple_get($url);
        $data1 = $this->curl->simple_get($url1);
        $data = json_decode($data, true);
        $data1 = json_decode($data1, true);
        $data = array_merge($data, $data1);
        foreach ($data as $value) {
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                $category[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'link' => $value['link'],
                    'type' => $value['taxonomy'],
                    'children' => array(),
                );
            } elseif ($value['parent'] != 0 && $value['name'] != 'Uncategorized') {
                $r_c[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'link' => $value['link'],
                    'type' => $value['taxonomy'],
                    'parent' => $value['parent']
                );
            }
        }
        foreach ($r_c as $value) {
            foreach ($category as $key => $val) {
                if ($value['parent'] == $val['id']) {
                    $category[$key]['children'][] = $value;
                }
            }
        }
        // foreach ($category as $cat){
        //     foreach ($r_c as $r) {
        //         if($cat['id'] == $r['parent']){
        //             $cat['children'][] = $r;
        //         }
        //     }
        // }
        return $category;
    }
    public function getMenuCats()
    {
        $url = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100';
        $url1 = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        $ids = [16, 36, 54, 65, 131, 5648];
        $data = $this->curl->simple_get($url);
        $data1 = $this->curl->simple_get($url1);
        $data = json_decode($data, true);
        $data1 = json_decode($data1, true);
        foreach ($data as $value) {
            $id = $value['id'];
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                if (in_array($id, $ids)) {
                    $category[] = array(
                        'name' => $value['name'],
                        'link' => $value['link'],
                        'id' => $value['id'],
                        'type' => $value['taxonomy']
                    );
                }
            }
        }
        foreach ($data1 as $value) {
            $id = $value['id'];
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                if (in_array($id, $ids)) {
                    $category[] = array(
                        'name' => $value['name'],
                        'link' => $value['link'],
                        'id' => $value['id'],
                        'type' => $value['taxonomy']
                    );
                }
            }
        }
        return $category;
    }
    public function socialLinks()
    {
        $links[] = array(
            'name' => 'Facebook',
            'link' => 'https://www.facebook.com/officialalwaysfirst/',
            'icon' => 'https://alwaysfirst.in/api/icons/Facebook.png'
        );
        $links[] = array(
            'name' => 'Twitter',
            'link' => 'https://twitter.com/alwaysFTweets',
            'icon' => 'https://alwaysfirst.in/api/icons/Twitter.png'
        );
        $links[] = array(
            'name' => 'Instagram',
            'link' => 'https://www.instagram.com/officialalwaysfirst/',
            'icon' => 'https://alwaysfirst.in/api/icons/Instagram.png'
        );
        $links[] = array(
            'name' => 'Youtube',
            'link' => 'https://www.youtube.com/channel/UCgnOc1a4uPHuityfGou3tLg',
            'icon' => 'https://alwaysfirst.in/api/icons/Youtube.png'
        );
        $links[] = array(
            'name' => 'Pinterest',
            'link' => 'https://pinterest.com/alwaysfirst501',
            'icon' => 'https://alwaysfirst.in/api/icons/Pintrest.png'
        );
        $links[] = array(
            'name' => 'linkedin',
            'link' => 'https://www.linkedin.com/company/always-first/',
            'icon' => 'https://alwaysfirst.in/api/icons/linkedin.png'
        );
        return $links;
    }

    // SuryyasKiran.in API

    public function getPostsAllSK($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $url = 'https://suryyaskiran.in/wp-json/wp/v2/posts/?_embed';
        $url .= $per_page != '' ? '&per_page=' . $per_page : '';
        $url .= $page != '' ? '&page=' . $page : '';
        $url .= $category_get != '' ? '&categories=' . $category_get : '';
        $url .= $search_get != '' ? '&search=' . $search_get : '';
        $url .= $author_get != '' ? '&author=' . $author_get : '';
        $url .= $tags_get != '' ? '&tags=' . $tags_get : '';

        $data = $this->curl->simple_get($url);
        $data = json_decode($data, true);
        foreach ($data as  $value) {
            $id = $value['id'];
            $post_data = array(
                'title' => $value['title']['rendered'],
                'content' => strip_tags($value['content']['rendered'], '<img><iframe>'),
                'link' => $value['link'],
                'date' => $value['modified'],
                'feature_image' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url'],
                'feature_image_thumb' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'],
                'feature_image_medium' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url'],
            );
            $author = array(
                'author_id' => $value['_embedded']['author'][0]['id'],
                'author_name' => $value['_embedded']['author'][0]['name'],
                'author_link' => $value['_embedded']['author'][0]['link']
            );
            $cat_count = 0;
            $tag_count = 0;
            foreach ($value['_embedded']['wp:term'] as $terms) {
                foreach ($terms as $value) {
                    if ($value['taxonomy'] == 'category') {
                        $category[$cat_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $cat_count++;
                    }
                    if ($value['taxonomy'] == 'post_tag') {
                        $tag[$tag_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $tag_count++;
                    }
                }
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $category,
                'tags' => $tag
            );
        }
        return $result;
    }
    public function getCategorySK()
    {

        $json_data =
            '[{"id":62,"name":"অপৰাধ আৰু ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/","type":"category","children":[{"id":194,"name":"অধিকাৰসমূহ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/rights\/","type":"category","parent":62},{"id":63,"name":"অপৰাধ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/crime\/","type":"category","parent":62},{"id":187,"name":"আদালত","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court\/","type":"category","parent":62},{"id":188,"name":"আদালত আৰু আইন","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court-and-law\/","type":"category","parent":62},{"id":190,"name":"এজাহাৰ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/fir\/","type":"category","parent":62},{"id":189,"name":"ঘৰুৱা হি","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/domestic-violence\/","type":"category","parent":62},{"id":186,"name":"দুৰ্ঘটনা","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/accident\/","type":"category","parent":62},{"id":191,"name":"ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/justice\/","type":"category","parent":62},{"id":193,"name":"পুলিচ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/police\/","type":"category","parent":62},{"id":192,"name":"শাৰীৰিক","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/physically-assault\/","type":"category","parent":62},{"id":65,"name":"সন্ত্ৰাসবাদ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/terrorism\/","type":"category","parent":62}]},{"id":482,"name":"অৰ্থনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a7%b0%e0%a7%8d%e0%a6%a5%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","type":"category"},{"id":250,"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a6%b8%e0%a6%ae\/","type":"category"},{"id":248,"name":"আছাম ৰাইজিং( ইভেন্টে)","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%86%e0%a6%9b%e0%a6%be%e0%a6%ae-%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a6%bf%e0%a6%82-%e0%a6%87%e0%a6%ad%e0%a7%87%e0%a6%a8%e0%a7%8d%e0%a6%9f%e0%a7%87\/","type":"category"},{"id":234,"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/international\/","type":"category","children":[{"id":240,"name":"কূটনীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/diplomacy\/","type":"category","parent":234},{"id":236,"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/international\/agreement-international\/","type":"category","parent":234},{"id":238,"name":"পৰ্যটক","link":"https:\/\/suryyaskiran.in\/category\/international\/tourist\/","type":"category","parent":234},{"id":239,"name":"বিমান পৰিবহন","link":"https:\/\/suryyaskiran.in\/category\/international\/airlines\/","type":"category","parent":234},{"id":235,"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/foreign-policy-international\/","type":"category","parent":234},{"id":237,"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/international\/travel-international\/","type":"category","parent":234}]},{"id":154,"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","type":"category","children":[{"id":159,"name":"অৰুণাচল প্ৰদেশ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/arunachal-pradesh\/","type":"category","parent":154},{"id":161,"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/assam\/","type":"category","parent":154},{"id":160,"name":"ছিকিম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/sikkim\/","type":"category","parent":154},{"id":155,"name":"ত্ৰিপুৰা","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/tripura\/","type":"category","parent":154},{"id":162,"name":"নাগালেণ্ড","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/nagaland\/","type":"category","parent":154},{"id":157,"name":"মণিপুৰ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/manipur\/","type":"category","parent":154},{"id":158,"name":"মিজোৰাম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/mizoram\/","type":"category","parent":154},{"id":156,"name":"মেঘালয়","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/meghalaya\/","type":"category","parent":154}]},{"id":258,"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%89%e0%a6%a4%e0%a7%8d%e0%a6%a4%e0%a7%b0-%e0%a6%aa%e0%a7%82%e0%a7%b0%e0%a7%8d%e0%a6%ac%e0%a6%be%e0%a6%9e%e0%a7%8d%e0%a6%9a%e0%a6%b2\/","type":"category"},{"id":270,"name":"ক্রীড়া-জগত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%95%e0%a7%8d%e0%a6%b0%e0%a7%80%e0%a7%9c%e0%a6%be-%e0%a6%9c%e0%a6%97%e0%a6%a4\/","type":"category"},{"id":114,"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","type":"category","children":[{"id":119,"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/sports\/international-sports\/","type":"category","parent":114},{"id":115,"name":"ক্ৰিকেট","link":"https:\/\/suryyaskiran.in\/category\/sports\/cricket\/","type":"category","parent":114},{"id":241,"name":"গল্ফ","link":"https:\/\/suryyaskiran.in\/category\/sports\/golf\/","type":"category","parent":114},{"id":243,"name":"প্ৰতিযোগিতা","link":"https:\/\/suryyaskiran.in\/category\/sports\/compitition\/","type":"category","parent":114},{"id":116,"name":"ফুটবল","link":"https:\/\/suryyaskiran.in\/category\/sports\/football\/","type":"category","parent":114},{"id":118,"name":"বিভিন্ন ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/game-sports\/","type":"category","parent":114},{"id":242,"name":"বিশ্বকাপ","link":"https:\/\/suryyaskiran.in\/category\/sports\/worldcup\/","type":"category","parent":114},{"id":120,"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/sports\/national-sports\/","type":"category","parent":114}]},{"id":266,"name":"গ্ৰাম্যৰ্থ","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%97%e0%a7%8d%e0%a7%b0%e0%a6%be%e0%a6%ae%e0%a7%8d%e0%a6%af%e0%a7%b0%e0%a7%8d%e0%a6%a5\/","type":"category"},{"id":87,"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/","type":"category","children":[{"id":91,"name":"কলা আৰু ডিজাইন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/art-design\/","type":"category","parent":87},{"id":93,"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/lifestyle-documentation\/","type":"category","parent":87},{"id":92,"name":"পৰ্যটন আৰু ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/tourism-travel\/","type":"category","parent":87},{"id":208,"name":"পানীয়","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/drinks\/","type":"category","parent":87},{"id":89,"name":"ফেশ্বন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/fashion\/","type":"category","parent":87},{"id":207,"name":"ৰেষ্টুৰেণ্ট","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/restaurant\/","type":"category","parent":87}]},{"id":502,"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%9c%e0%a7%80%e0%a7%b1%e0%a6%a8%e0%a6%b6%e0%a7%88%e0%a6%b2%e0%a7%80\/","type":"category"},{"id":132,"name":"নগৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/","type":"category","children":[{"id":149,"name":"কোকৰাঝাৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/kokrajhar\/","type":"category","parent":132},{"id":142,"name":"গহপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/gohpur\/","type":"category","parent":132},{"id":133,"name":"গুৱাহাটী","link":"https:\/\/suryyaskiran.in\/category\/city\/guwahati\/","type":"category","parent":132},{"id":147,"name":"গোলাঘাট","link":"https:\/\/suryyaskiran.in\/category\/city\/golaghat\/","type":"category","parent":132},{"id":138,"name":"গোৱালপাৰা","link":"https:\/\/suryyaskiran.in\/category\/city\/goalpara\/","type":"category","parent":132},{"id":150,"name":"ডিফু","link":"https:\/\/suryyaskiran.in\/category\/city\/diphu\/","type":"category","parent":132},{"id":135,"name":"ডিব্ৰুগড়","link":"https:\/\/suryyaskiran.in\/category\/city\/dibrugarh\/","type":"category","parent":132},{"id":146,"name":"তিনিচুকীয়া","link":"https:\/\/suryyaskiran.in\/category\/city\/tinsukia\/","type":"category","parent":132},{"id":141,"name":"তেজপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/tezpur\/","type":"category","parent":132},{"id":140,"name":"দৰং","link":"https:\/\/suryyaskiran.in\/category\/city\/darrang\/","type":"category","parent":132},{"id":136,"name":"ধুবুৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/dhubri\/","type":"category","parent":132},{"id":144,"name":"ধেমাজি","link":"https:\/\/suryyaskiran.in\/category\/city\/dhemaji\/","type":"category","parent":132},{"id":151,"name":"নগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/nagaon\/","type":"category","parent":132},{"id":137,"name":"নলবাৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/nalbari\/","type":"category","parent":132},{"id":139,"name":"বৰপেটা","link":"https:\/\/suryyaskiran.in\/category\/city\/barpeta\/","type":"category","parent":132},{"id":148,"name":"বিশ্বনাথ","link":"https:\/\/suryyaskiran.in\/category\/city\/biswanath\/","type":"category","parent":132},{"id":145,"name":"মৰাণ","link":"https:\/\/suryyaskiran.in\/category\/city\/moran\/","type":"category","parent":132},{"id":152,"name":"মৰিগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/morigaon\/","type":"category","parent":132},{"id":153,"name":"মাজুলী","link":"https:\/\/suryyaskiran.in\/category\/city\/majuli\/","type":"category","parent":132},{"id":134,"name":"যোৰহাট","link":"https:\/\/suryyaskiran.in\/category\/city\/jorhat\/","type":"category","parent":132},{"id":143,"name":"লখিমপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/lakhimpur\/","type":"category","parent":132}]},{"id":264,"name":"প্ৰকৃতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%95%e0%a7%83%e0%a6%a4%e0%a6%bf\/","type":"category"},{"id":73,"name":"প্ৰতিৰক্ষা","link":"https:\/\/suryyaskiran.in\/category\/defence\/","type":"category","children":[{"id":196,"name":"অগ্নিকাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/defence\/fire\/","type":"category","parent":73},{"id":197,"name":"অন্যান্য বিষয়","link":"https:\/\/suryyaskiran.in\/category\/defence\/other-issue\/","type":"category","parent":73},{"id":79,"name":"এন.আই.এ.","link":"https:\/\/suryyaskiran.in\/category\/defence\/nia\/","type":"category","parent":73},{"id":78,"name":"নিৰাপত্তা","link":"https:\/\/suryyaskiran.in\/category\/defence\/security\/","type":"category","parent":73},{"id":76,"name":"নৌসেনা","link":"https:\/\/suryyaskiran.in\/category\/defence\/navy\/","type":"category","parent":73},{"id":75,"name":"বিএছএফ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bsf\/","type":"category","parent":73},{"id":195,"name":"বোমা বিস্ফোৰণ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bomb-blast\/","type":"category","parent":73},{"id":77,"name":"যুদ্ধ","link":"https:\/\/suryyaskiran.in\/category\/defence\/war\/","type":"category","parent":73}]},{"id":43,"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","type":"category","children":[{"id":47,"name":"আমদানি- ৰপ্তানি","link":"https:\/\/suryyaskiran.in\/category\/business\/export-import\/","type":"category","parent":43},{"id":184,"name":"উদ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/business\/industry\/","type":"category","parent":43},{"id":185,"name":"কাৰখানা","link":"https:\/\/suryyaskiran.in\/category\/business\/factory\/","type":"category","parent":43},{"id":45,"name":"বীমা","link":"https:\/\/suryyaskiran.in\/category\/business\/insurance\/","type":"category","parent":43},{"id":48,"name":"ব্যৱসায় আৰু বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/trade-commerce\/","type":"category","parent":43},{"id":183,"name":"মিউচুৱেল ফাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/business\/mutual-fund\/","type":"category","parent":43},{"id":46,"name":"শ্বেয়াৰ বজাৰ","link":"https:\/\/suryyaskiran.in\/category\/business\/share-market\/","type":"category","parent":43}]},{"id":514,"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%be%e0%a6%a3%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%af\/","type":"category"},{"id":56,"name":"বিজ্ঞান","link":"https:\/\/suryyaskiran.in\/category\/science\/","type":"category","children":[{"id":59,"name":"আৱিষ্কাৰ","link":"https:\/\/suryyaskiran.in\/category\/science\/discovery\/","type":"category","parent":56},{"id":58,"name":"গৱেষণা","link":"https:\/\/suryyaskiran.in\/category\/science\/research\/","type":"category","parent":56},{"id":61,"name":"জীৱ আৰু বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/science\/animal-wild-life\/","type":"category","parent":56},{"id":212,"name":"পৰিৱেশ","link":"https:\/\/suryyaskiran.in\/category\/science\/environment\/","type":"category","parent":56},{"id":60,"name":"পৰীক্ষণ","link":"https:\/\/suryyaskiran.in\/category\/science\/testing\/","type":"category","parent":56},{"id":107,"name":"প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/science\/technology\/","type":"category","parent":56},{"id":213,"name":"ভূমিকম্প","link":"https:\/\/suryyaskiran.in\/category\/science\/earthquake\/","type":"category","parent":56}]},{"id":268,"name":"বিজ্ঞান-প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%9e%e0%a6%be%e0%a6%a8-%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%af%e0%a7%81%e0%a6%95%e0%a7%8d%e0%a6%a4%e0%a6%bf\/","type":"category"},{"id":256,"name":"বিনোদন","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%a8%e0%a7%8b%e0%a6%a6%e0%a6%a8\/","type":"category"},{"id":165,"name":"বিশেষ বাতৰি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/","type":"category","children":[{"id":226,"name":"অন্তৰ্দৃষ্টি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/insight\/","type":"category","parent":165},{"id":221,"name":"উৎসৱ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/festival\/","type":"category","parent":165},{"id":125,"name":"কলা আৰু সংস্কৃতি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/art-culture\/","type":"category","parent":165},{"id":129,"name":"গাওঁ আৰু চহৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/village-town\/","type":"category","parent":165},{"id":126,"name":"চৰকাৰী বিভাগসমূহ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/govt-departments\/","type":"category","parent":165},{"id":230,"name":"তুষাৰপাত","link":"https:\/\/suryyaskiran.in\/category\/special-news\/snowfall\/","type":"category","parent":165},{"id":220,"name":"দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/disaster\/","type":"category","parent":165},{"id":130,"name":"ধৰ্ম","link":"https:\/\/suryyaskiran.in\/category\/special-news\/religion\/","type":"category","parent":165},{"id":231,"name":"পাচলি আৰু ফল","link":"https:\/\/suryyaskiran.in\/category\/special-news\/vegetables-fruit\/","type":"category","parent":165},{"id":225,"name":"প্ৰব্ৰজন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/immigration\/","type":"category","parent":165},{"id":216,"name":"প্ৰশাসন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/administration\/","type":"category","parent":165},{"id":122,"name":"প্ৰাকৃতিক দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/natural-calamities\/","type":"category","parent":165},{"id":121,"name":"ফিছাৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/featured-stories\/","type":"category","parent":165},{"id":223,"name":"বন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/forest\/","type":"category","parent":165},{"id":232,"name":"বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/wild-life\/","type":"category","parent":165},{"id":222,"name":"বানপানী আৰু বৰষুণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/flood-rain\/","type":"category","parent":165},{"id":131,"name":"ভিডিঅ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/videos\/","type":"category","parent":165},{"id":233,"name":"মহিলা সৱলীকৰণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/women-empowerment\/","type":"category","parent":165},{"id":124,"name":"মুখ্যাংশ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/highlight\/","type":"category","parent":165},{"id":227,"name":"মৃত্যু","link":"https:\/\/suryyaskiran.in\/category\/special-news\/passes-away\/","type":"category","parent":165},{"id":228,"name":"ৰজহুৱা সভা","link":"https:\/\/suryyaskiran.in\/category\/special-news\/public-rally\/","type":"category","parent":165},{"id":127,"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/national\/","type":"category","parent":165},{"id":229,"name":"ৰোমাঞ্চ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/romance\/","type":"category","parent":165},{"id":218,"name":"সম্প্ৰদায়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/community\/","type":"category","parent":165}]},{"id":94,"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","type":"category","children":[{"id":203,"name":"অনুষ্ঠান","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/function\/","type":"category","parent":94},{"id":97,"name":"খেল","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/game\/","type":"category","parent":94},{"id":202,"name":"চলচ্চিত্ৰ আৰু অভিনেতা","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/movie-and-actor\/","type":"category","parent":94},{"id":201,"name":"টলিউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tollywood\/","type":"category","parent":94},{"id":99,"name":"টিভি ধাৰাবাহিক","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tv-serial\/","type":"category","parent":94},{"id":100,"name":"প্ৰচাৰ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/promotion\/","type":"category","parent":94},{"id":95,"name":"বক্স অফিচ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/box-office\/","type":"category","parent":94},{"id":200,"name":"বলীউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/bollywood\/","type":"category","parent":94},{"id":98,"name":"ৱেব ছিৰিজ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/web-series\/","type":"category","parent":94},{"id":96,"name":"সংগীত","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/music\/","type":"category","parent":94}]},{"id":254,"name":"মৰ্মাহত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%b0%e0%a7%8d%e0%a6%ae%e0%a6%be%e0%a6%b9%e0%a6%a4\/","type":"category"},{"id":166,"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","type":"category","children":[{"id":170,"name":"অষ্ট্ৰেলিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/australia\/","type":"category","parent":166},{"id":167,"name":"আফ্ৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/africa\/","type":"category","parent":166},{"id":168,"name":"আমেৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/america\/","type":"category","parent":166},{"id":171,"name":"ইউৰোপ","link":"https:\/\/suryyaskiran.in\/category\/continents\/europe\/","type":"category","parent":166},{"id":169,"name":"এছিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/asia\/","type":"category","parent":166}]},{"id":253,"name":"মুখ্য-পৃষ্ঠা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%81%e0%a6%96%e0%a7%8d%e0%a6%af-%e0%a6%aa%e0%a7%83%e0%a6%b7%e0%a7%8d%e0%a6%a0%e0%a6%be\/","type":"category"},{"id":172,"name":"মেট্ৰ পলিটান","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/","type":"category","children":[{"id":180,"name":"আহমেদাবাদ","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/ahmadabad\/","type":"category","parent":172},{"id":176,"name":"কলকাতা","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/kolkata\/","type":"category","parent":172},{"id":181,"name":"চুৰাট","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/surat\/","type":"category","parent":172},{"id":177,"name":"চেন্নাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/chennai\/","type":"category","parent":172},{"id":174,"name":"নতুন দিল্লী","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/new-delhi\/","type":"category","parent":172},{"id":178,"name":"পুনে","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/pune\/","type":"category","parent":172},{"id":182,"name":"বিশাখাপট্টনম","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/vishakhapatnam\/","type":"category","parent":172},{"id":175,"name":"বেংগালুৰু","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/bengaluru\/","type":"category","parent":172},{"id":173,"name":"মুম্বাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/mumbai\/","type":"category","parent":172}]},{"id":249,"name":"ৰাইজৰ বাৰ্তা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a7%b0-%e0%a6%ac%e0%a6%be%e0%a7%b0%e0%a7%8d%e0%a6%a4%e0%a6%be\/","type":"category"},{"id":101,"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","type":"category","children":[{"id":103,"name":"দলীয় ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/party-politics\/","type":"category","parent":101},{"id":102,"name":"নিৰ্বাচন","link":"https:\/\/suryyaskiran.in\/category\/politics\/election\/","type":"category","parent":101},{"id":211,"name":"পঞ্চায়ত আৰু পৰিষদ","link":"https:\/\/suryyaskiran.in\/category\/politics\/panchayat-council\/","type":"category","parent":101},{"id":210,"name":"ভোটদান আৰু ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/politics\/voting-result\/","type":"category","parent":101},{"id":104,"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/politics-state-policy\/","type":"category","parent":101},{"id":105,"name":"ৰাষ্ট্ৰীয় নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/national-policy\/","type":"category","parent":101},{"id":106,"name":"সভা আৰু সমদল","link":"https:\/\/suryyaskiran.in\/category\/politics\/meeting-rally\/","type":"category","parent":101}]},{"id":267,"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%9c%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","type":"category"},{"id":80,"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","type":"category","children":[{"id":209,"name":"অন্যান্য প্ৰসংগ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/general\/","type":"category","parent":80},{"id":84,"name":"কৰ আৰু সেৱাসমূহ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/tax-services\/","type":"category","parent":80},{"id":85,"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/agreement\/","type":"category","parent":80},{"id":82,"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/foreign-policy\/","type":"category","parent":80},{"id":86,"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/travel\/","type":"category","parent":80},{"id":83,"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/state-policy\/","type":"category","parent":80}]},{"id":483,"name":"ৰাষ্ট্ৰীয়-আন্তঃৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80%e0%a7%9f-%e0%a6%86%e0%a6%a8%e0%a7%8d%e0%a6%a4%e0%a6%83%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80\/","type":"category"},{"id":67,"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/","type":"category","children":[{"id":198,"name":"কিতাপ","link":"https:\/\/suryyaskiran.in\/category\/education\/books\/","type":"category","parent":67},{"id":199,"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/education\/documentation\/","type":"category","parent":67},{"id":68,"name":"পৰীক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/examination\/","type":"category","parent":67},{"id":71,"name":"প্ৰকাশন","link":"https:\/\/suryyaskiran.in\/category\/education\/publication\/","type":"category","parent":67},{"id":69,"name":"ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/education\/result\/","type":"category","parent":67},{"id":72,"name":"বিদ্যালয় আৰু মহাবিদ্যালয়","link":"https:\/\/suryyaskiran.in\/category\/education\/school-college\/","type":"category","parent":67}]},{"id":485,"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b6%e0%a6%bf%e0%a6%95%e0%a7%8d%e0%a6%b7%e0%a6%be\/","type":"category"},{"id":1,"name":"শ্ৰেণী বহিভূৰ্ত","link":"https:\/\/suryyaskiran.in\/category\/uncategorized\/","type":"category"},{"id":484,"name":"সম্পাদকীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b8%e0%a6%ae%e0%a7%8d%e0%a6%aa%e0%a6%be%e0%a6%a6%e0%a6%95%e0%a7%80%e0%a7%9f\/","type":"category"}]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getMenuCategorySK()
    {
        $json_data =
            '[{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","id":154,"type":"category"},{"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","id":114,"type":"category"},{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","id":43,"type":"category"},{"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","id":94,"type":"category"},{"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","id":166,"type":"category"},{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","id":101,"type":"category"},{"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","id":80,"type":"category"}]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getCatsSK()
    {
        $url = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100';
        $url1 = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        $data = $this->curl->simple_get($url);
        $data1 = $this->curl->simple_get($url1);
        $data = json_decode($data, true);
        $data1 = json_decode($data1, true);
        $data = array_merge($data, $data1);
        foreach ($data as $value) {
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                $category[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'link' => $value['link'],
                    'type' => $value['taxonomy']
                );
            } elseif ($value['parent'] != 0 && $value['name'] != 'Uncategorized') {
                $r_c[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'link' => $value['link'],
                    'type' => $value['taxonomy'],
                    'parent' => $value['parent']
                );
            }
        }
        foreach ($r_c as $value) {
            foreach ($category as $key => $val) {
                if ($value['parent'] == $val['id']) {
                    $category[$key]['children'][] = $value;
                }
            }
        }
        // foreach ($category as $cat){
        //     foreach ($r_c as $r) {
        //         if($cat['id'] == $r['parent']){
        //             $cat['children'][] = $r;
        //         }
        //     }
        // }
        return $category;
    }
    public function getMenuCatsSK()
    {
        $url = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100';
        $url1 = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        $ids = [43, 80, 94, 101, 114, 154, 166];
        $data = $this->curl->simple_get($url);
        $data1 = $this->curl->simple_get($url1);
        $data = json_decode($data, true);
        $data1 = json_decode($data1, true);
        foreach ($data as $value) {
            $id = $value['id'];
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                if (in_array($id, $ids)) {
                    $category[] = array(
                        'name' => $value['name'],
                        'link' => $value['link'],
                        'id' => $value['id'],
                        'type' => $value['taxonomy']
                    );
                }
            }
        }
        foreach ($data1 as $value) {
            $id = $value['id'];
            if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
                if (in_array($id, $ids)) {
                    $category[] = array(
                        'name' => $value['name'],
                        'link' => $value['link'],
                        'id' => $value['id'],
                        'type' => $value['taxonomy']
                    );
                }
            }
        }
        return $category;
    }
    public function getSkPostsAll($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $url = 'https://suryyaskiran.in/wp-json/wp/v2/posts/?_embed';
        $url .= $per_page != '' ? '&per_page=' . $per_page : '';
        $url .= $page != '' ? '&page=' . $page : '';
        $url .= $category_get != '' ? '&categories=' . $category_get : '';
        $url .= $search_get != '' ? '&search=' . $search_get : '';
        $url .= $author_get != '' ? '&author=' . $author_get : '';
        $url .= $tags_get != '' ? '&tags=' . $tags_get : '';
        $data = $this->curl->simple_get($url);
        $data = json_decode($data, true);
        foreach ($data as  $value) {
            $id = $value['id'];
            $post_data = array(
                'title' => $value['title']['rendered'],
                'content' => strip_tags($value['content']['rendered']),
                'link' => $value['link'],
                'date' => $value['modified'],
                'feature_image' => $value['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']['source_url']
            );
            $author = array(
                'author_id' => $value['_embedded']['author'][0]['id'],
                'author_name' => $value['_embedded']['author'][0]['name'],
                'author_link' => $value['_embedded']['author'][0]['link']
            );
            $cat_count = 0;
            $tag_count = 0;
            foreach ($value['_embedded']['wp:term'] as $terms) {
                foreach ($terms as $value) {
                    if ($value['taxonomy'] == 'category') {
                        $category[$cat_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $cat_count++;
                    }
                    if ($value['taxonomy'] == 'post_tag') {
                        $tag[$tag_count] = array(
                            'name' => $value['name'],
                            'link' => $value['link'],
                            'id' => $value['id'],
                            'type' => $value['taxonomy']
                        );
                        $tag_count++;
                    }
                }
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $category,
                'tags' => $tag
            );
        }
        return $result;
    }
    public function getSkCategory()
    {
        // $url = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100';
        // $url1 = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        // $data = $this->curl->simple_get($url);
        // $data1 = $this->curl->simple_get($url1);
        // $data = json_decode($data, true);
        // $data1 = json_decode($data1, true);
        // foreach ($data as  $value) {
        //     $id = $value['id'];
        //     if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
        //         $category[$id] = array(
        //             'name' => $value['name'],
        //             'link' => $value['link'],
        //             'id' => $value['id'],
        //             'type' => $value['taxonomy']
        //         );
        //     } else {
        //         $rem_category[$id] = array(
        //             'name' => $value['name'],
        //             'link' => $value['link'],
        //             'id' => $value['id'],
        //             'type' => $value['taxonomy'],
        //             'parent' => $value['parent']
        //         );
        //     }
        // }
        // foreach ($data1 as  $value) {
        //     $id = $value['id'];
        //     if ($value['parent'] == 0 && $value['name'] != 'Uncategorized') {
        //         $category[$id] = array(
        //             'name' => $value['name'],
        //             'link' => $value['link'],
        //             'id' => $value['id'],
        //             'type' => $value['taxonomy']
        //         );
        //     } else {
        //         $rem_category[$id] = array(
        //             'name' => $value['name'],
        //             'link' => $value['link'],
        //             'id' => $value['id'],
        //             'type' => $value['taxonomy'],
        //             'parent' => $value['parent']
        //         );
        //     }
        // }
        // foreach ($rem_category as $key => $value) {
        //     if (isset($category[$value['parent']])) {
        //         $category[$value['parent']]['child'][$key] = array(
        //             'name' => $value['name'],
        //             'link' => $value['link'],
        //             'id' => $value['id'],
        //             'type' => $value['type'],
        //             'parent' => $value['parent']
        //         );
        //     }
        // }
        $json_data =
            '{"62":{"name":"অপৰাধ আৰু ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/","id":62,"type":"category","child":{"194":{"name":"অধিকাৰসমূহ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/rights\/","id":194,"type":"category","parent":62},"63":{"name":"অপৰাধ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/crime\/","id":63,"type":"category","parent":62},"187":{"name":"আদালত","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court\/","id":187,"type":"category","parent":62},"188":{"name":"আদালত আৰু আইন","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court-and-law\/","id":188,"type":"category","parent":62},"190":{"name":"এজাহাৰ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/fir\/","id":190,"type":"category","parent":62},"189":{"name":"ঘৰুৱা হি","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/domestic-violence\/","id":189,"type":"category","parent":62},"186":{"name":"দুৰ্ঘটনা","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/accident\/","id":186,"type":"category","parent":62},"191":{"name":"ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/justice\/","id":191,"type":"category","parent":62},"193":{"name":"পুলিচ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/police\/","id":193,"type":"category","parent":62},"192":{"name":"শাৰীৰিক","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/physically-assault\/","id":192,"type":"category","parent":62},"65":{"name":"সন্ত্ৰাসবাদ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/terrorism\/","id":65,"type":"category","parent":62}}},"482":{"name":"অৰ্থনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a7%b0%e0%a7%8d%e0%a6%a5%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","id":482,"type":"category"},"250":{"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a6%b8%e0%a6%ae\/","id":250,"type":"category"},"248":{"name":"আছাম ৰাইজিং( ইভেন্টে)","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%86%e0%a6%9b%e0%a6%be%e0%a6%ae-%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a6%bf%e0%a6%82-%e0%a6%87%e0%a6%ad%e0%a7%87%e0%a6%a8%e0%a7%8d%e0%a6%9f%e0%a7%87\/","id":248,"type":"category"},"234":{"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/international\/","id":234,"type":"category","child":{"240":{"name":"কূটনীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/diplomacy\/","id":240,"type":"category","parent":234},"236":{"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/international\/agreement-international\/","id":236,"type":"category","parent":234},"238":{"name":"পৰ্যটক","link":"https:\/\/suryyaskiran.in\/category\/international\/tourist\/","id":238,"type":"category","parent":234},"239":{"name":"বিমান পৰিবহন","link":"https:\/\/suryyaskiran.in\/category\/international\/airlines\/","id":239,"type":"category","parent":234},"235":{"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/foreign-policy-international\/","id":235,"type":"category","parent":234},"237":{"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/international\/travel-international\/","id":237,"type":"category","parent":234}}},"154":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","id":154,"type":"category","child":{"159":{"name":"অৰুণাচল প্ৰদেশ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/arunachal-pradesh\/","id":159,"type":"category","parent":154},"161":{"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/assam\/","id":161,"type":"category","parent":154},"160":{"name":"ছিকিম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/sikkim\/","id":160,"type":"category","parent":154},"155":{"name":"ত্ৰিপুৰা","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/tripura\/","id":155,"type":"category","parent":154},"162":{"name":"নাগালেণ্ড","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/nagaland\/","id":162,"type":"category","parent":154},"157":{"name":"মণিপুৰ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/manipur\/","id":157,"type":"category","parent":154},"158":{"name":"মিজোৰাম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/mizoram\/","id":158,"type":"category","parent":154},"156":{"name":"মেঘালয়","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/meghalaya\/","id":156,"type":"category","parent":154}}},"258":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%89%e0%a6%a4%e0%a7%8d%e0%a6%a4%e0%a7%b0-%e0%a6%aa%e0%a7%82%e0%a7%b0%e0%a7%8d%e0%a6%ac%e0%a6%be%e0%a6%9e%e0%a7%8d%e0%a6%9a%e0%a6%b2\/","id":258,"type":"category"},"270":{"name":"ক্রীড়া-জগত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%95%e0%a7%8d%e0%a6%b0%e0%a7%80%e0%a7%9c%e0%a6%be-%e0%a6%9c%e0%a6%97%e0%a6%a4\/","id":270,"type":"category"},"114":{"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","id":114,"type":"category","child":{"119":{"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/sports\/international-sports\/","id":119,"type":"category","parent":114},"115":{"name":"ক্ৰিকেট","link":"https:\/\/suryyaskiran.in\/category\/sports\/cricket\/","id":115,"type":"category","parent":114},"241":{"name":"গল্ফ","link":"https:\/\/suryyaskiran.in\/category\/sports\/golf\/","id":241,"type":"category","parent":114},"243":{"name":"প্ৰতিযোগিতা","link":"https:\/\/suryyaskiran.in\/category\/sports\/compitition\/","id":243,"type":"category","parent":114},"116":{"name":"ফুটবল","link":"https:\/\/suryyaskiran.in\/category\/sports\/football\/","id":116,"type":"category","parent":114},"118":{"name":"বিভিন্ন ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/game-sports\/","id":118,"type":"category","parent":114},"242":{"name":"বিশ্বকাপ","link":"https:\/\/suryyaskiran.in\/category\/sports\/worldcup\/","id":242,"type":"category","parent":114},"120":{"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/sports\/national-sports\/","id":120,"type":"category","parent":114}}},"266":{"name":"গ্ৰাম্যৰ্থ","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%97%e0%a7%8d%e0%a7%b0%e0%a6%be%e0%a6%ae%e0%a7%8d%e0%a6%af%e0%a7%b0%e0%a7%8d%e0%a6%a5\/","id":266,"type":"category"},"87":{"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/","id":87,"type":"category","child":{"91":{"name":"কলা আৰু ডিজাইন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/art-design\/","id":91,"type":"category","parent":87},"93":{"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/lifestyle-documentation\/","id":93,"type":"category","parent":87},"92":{"name":"পৰ্যটন আৰু ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/tourism-travel\/","id":92,"type":"category","parent":87},"208":{"name":"পানীয়","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/drinks\/","id":208,"type":"category","parent":87},"89":{"name":"ফেশ্বন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/fashion\/","id":89,"type":"category","parent":87},"207":{"name":"ৰেষ্টুৰেণ্ট","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/restaurant\/","id":207,"type":"category","parent":87}}},"502":{"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%9c%e0%a7%80%e0%a7%b1%e0%a6%a8%e0%a6%b6%e0%a7%88%e0%a6%b2%e0%a7%80\/","id":502,"type":"category"},"132":{"name":"নগৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/","id":132,"type":"category","child":{"149":{"name":"কোকৰাঝাৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/kokrajhar\/","id":149,"type":"category","parent":132},"142":{"name":"গহপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/gohpur\/","id":142,"type":"category","parent":132},"133":{"name":"গুৱাহাটী","link":"https:\/\/suryyaskiran.in\/category\/city\/guwahati\/","id":133,"type":"category","parent":132},"147":{"name":"গোলাঘাট","link":"https:\/\/suryyaskiran.in\/category\/city\/golaghat\/","id":147,"type":"category","parent":132},"138":{"name":"গোৱালপাৰা","link":"https:\/\/suryyaskiran.in\/category\/city\/goalpara\/","id":138,"type":"category","parent":132},"150":{"name":"ডিফু","link":"https:\/\/suryyaskiran.in\/category\/city\/diphu\/","id":150,"type":"category","parent":132},"135":{"name":"ডিব্ৰুগড়","link":"https:\/\/suryyaskiran.in\/category\/city\/dibrugarh\/","id":135,"type":"category","parent":132},"146":{"name":"তিনিচুকীয়া","link":"https:\/\/suryyaskiran.in\/category\/city\/tinsukia\/","id":146,"type":"category","parent":132},"141":{"name":"তেজপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/tezpur\/","id":141,"type":"category","parent":132},"140":{"name":"দৰং","link":"https:\/\/suryyaskiran.in\/category\/city\/darrang\/","id":140,"type":"category","parent":132},"136":{"name":"ধুবুৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/dhubri\/","id":136,"type":"category","parent":132},"144":{"name":"ধেমাজি","link":"https:\/\/suryyaskiran.in\/category\/city\/dhemaji\/","id":144,"type":"category","parent":132},"151":{"name":"নগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/nagaon\/","id":151,"type":"category","parent":132},"137":{"name":"নলবাৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/nalbari\/","id":137,"type":"category","parent":132},"139":{"name":"বৰপেটা","link":"https:\/\/suryyaskiran.in\/category\/city\/barpeta\/","id":139,"type":"category","parent":132},"148":{"name":"বিশ্বনাথ","link":"https:\/\/suryyaskiran.in\/category\/city\/biswanath\/","id":148,"type":"category","parent":132},"145":{"name":"মৰাণ","link":"https:\/\/suryyaskiran.in\/category\/city\/moran\/","id":145,"type":"category","parent":132},"152":{"name":"মৰিগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/morigaon\/","id":152,"type":"category","parent":132},"153":{"name":"মাজুলী","link":"https:\/\/suryyaskiran.in\/category\/city\/majuli\/","id":153,"type":"category","parent":132},"134":{"name":"যোৰহাট","link":"https:\/\/suryyaskiran.in\/category\/city\/jorhat\/","id":134,"type":"category","parent":132},"143":{"name":"লখিমপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/lakhimpur\/","id":143,"type":"category","parent":132}}},"264":{"name":"প্ৰকৃতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%95%e0%a7%83%e0%a6%a4%e0%a6%bf\/","id":264,"type":"category"},"73":{"name":"প্ৰতিৰক্ষা","link":"https:\/\/suryyaskiran.in\/category\/defence\/","id":73,"type":"category","child":{"196":{"name":"অগ্নিকাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/defence\/fire\/","id":196,"type":"category","parent":73},"197":{"name":"অন্যান্য বিষয়","link":"https:\/\/suryyaskiran.in\/category\/defence\/other-issue\/","id":197,"type":"category","parent":73},"79":{"name":"এন.আই.এ.","link":"https:\/\/suryyaskiran.in\/category\/defence\/nia\/","id":79,"type":"category","parent":73},"78":{"name":"নিৰাপত্তা","link":"https:\/\/suryyaskiran.in\/category\/defence\/security\/","id":78,"type":"category","parent":73},"76":{"name":"নৌসেনা","link":"https:\/\/suryyaskiran.in\/category\/defence\/navy\/","id":76,"type":"category","parent":73},"75":{"name":"বিএছএফ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bsf\/","id":75,"type":"category","parent":73},"195":{"name":"বোমা বিস্ফোৰণ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bomb-blast\/","id":195,"type":"category","parent":73},"77":{"name":"যুদ্ধ","link":"https:\/\/suryyaskiran.in\/category\/defence\/war\/","id":77,"type":"category","parent":73}}},"43":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","id":43,"type":"category","child":{"47":{"name":"আমদানি- ৰপ্তানি","link":"https:\/\/suryyaskiran.in\/category\/business\/export-import\/","id":47,"type":"category","parent":43},"184":{"name":"উদ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/business\/industry\/","id":184,"type":"category","parent":43},"185":{"name":"কাৰখানা","link":"https:\/\/suryyaskiran.in\/category\/business\/factory\/","id":185,"type":"category","parent":43},"45":{"name":"বীমা","link":"https:\/\/suryyaskiran.in\/category\/business\/insurance\/","id":45,"type":"category","parent":43},"48":{"name":"ব্যৱসায় আৰু বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/trade-commerce\/","id":48,"type":"category","parent":43},"183":{"name":"মিউচুৱেল ফাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/business\/mutual-fund\/","id":183,"type":"category","parent":43},"46":{"name":"শ্বেয়াৰ বজাৰ","link":"https:\/\/suryyaskiran.in\/category\/business\/share-market\/","id":46,"type":"category","parent":43}}},"514":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%be%e0%a6%a3%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%af\/","id":514,"type":"category"},"56":{"name":"বিজ্ঞান","link":"https:\/\/suryyaskiran.in\/category\/science\/","id":56,"type":"category","child":{"59":{"name":"আৱিষ্কাৰ","link":"https:\/\/suryyaskiran.in\/category\/science\/discovery\/","id":59,"type":"category","parent":56},"58":{"name":"গৱেষণা","link":"https:\/\/suryyaskiran.in\/category\/science\/research\/","id":58,"type":"category","parent":56},"61":{"name":"জীৱ আৰু বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/science\/animal-wild-life\/","id":61,"type":"category","parent":56},"212":{"name":"পৰিৱেশ","link":"https:\/\/suryyaskiran.in\/category\/science\/environment\/","id":212,"type":"category","parent":56},"60":{"name":"পৰীক্ষণ","link":"https:\/\/suryyaskiran.in\/category\/science\/testing\/","id":60,"type":"category","parent":56},"107":{"name":"প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/science\/technology\/","id":107,"type":"category","parent":56},"213":{"name":"ভূমিকম্প","link":"https:\/\/suryyaskiran.in\/category\/science\/earthquake\/","id":213,"type":"category","parent":56}}},"268":{"name":"বিজ্ঞান-প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%9e%e0%a6%be%e0%a6%a8-%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%af%e0%a7%81%e0%a6%95%e0%a7%8d%e0%a6%a4%e0%a6%bf\/","id":268,"type":"category"},"256":{"name":"বিনোদন","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%a8%e0%a7%8b%e0%a6%a6%e0%a6%a8\/","id":256,"type":"category"},"165":{"name":"বিশেষ বাতৰি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/","id":165,"type":"category","child":{"226":{"name":"অন্তৰ্দৃষ্টি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/insight\/","id":226,"type":"category","parent":165},"221":{"name":"উৎসৱ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/festival\/","id":221,"type":"category","parent":165},"125":{"name":"কলা আৰু সংস্কৃতি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/art-culture\/","id":125,"type":"category","parent":165},"129":{"name":"গাওঁ আৰু চহৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/village-town\/","id":129,"type":"category","parent":165},"126":{"name":"চৰকাৰী বিভাগসমূহ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/govt-departments\/","id":126,"type":"category","parent":165},"230":{"name":"তুষাৰপাত","link":"https:\/\/suryyaskiran.in\/category\/special-news\/snowfall\/","id":230,"type":"category","parent":165},"220":{"name":"দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/disaster\/","id":220,"type":"category","parent":165},"130":{"name":"ধৰ্ম","link":"https:\/\/suryyaskiran.in\/category\/special-news\/religion\/","id":130,"type":"category","parent":165},"231":{"name":"পাচলি আৰু ফল","link":"https:\/\/suryyaskiran.in\/category\/special-news\/vegetables-fruit\/","id":231,"type":"category","parent":165},"225":{"name":"প্ৰব্ৰজন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/immigration\/","id":225,"type":"category","parent":165},"216":{"name":"প্ৰশাসন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/administration\/","id":216,"type":"category","parent":165},"122":{"name":"প্ৰাকৃতিক দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/natural-calamities\/","id":122,"type":"category","parent":165},"121":{"name":"ফিছাৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/featured-stories\/","id":121,"type":"category","parent":165},"223":{"name":"বন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/forest\/","id":223,"type":"category","parent":165},"232":{"name":"বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/wild-life\/","id":232,"type":"category","parent":165},"222":{"name":"বানপানী আৰু বৰষুণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/flood-rain\/","id":222,"type":"category","parent":165},"131":{"name":"ভিডিঅ\'","link":"https:\/\/suryyaskiran.in\/category\/special-news\/videos\/","id":131,"type":"category","parent":165},"233":{"name":"মহিলা সৱলীকৰণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/women-empowerment\/","id":233,"type":"category","parent":165},"124":{"name":"মুখ্যাংশ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/highlight\/","id":124,"type":"category","parent":165},"227":{"name":"মৃত্যু","link":"https:\/\/suryyaskiran.in\/category\/special-news\/passes-away\/","id":227,"type":"category","parent":165},"228":{"name":"ৰজহুৱা সভা","link":"https:\/\/suryyaskiran.in\/category\/special-news\/public-rally\/","id":228,"type":"category","parent":165},"127":{"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/national\/","id":127,"type":"category","parent":165},"229":{"name":"ৰোমাঞ্চ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/romance\/","id":229,"type":"category","parent":165},"218":{"name":"সম্প্ৰদায়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/community\/","id":218,"type":"category","parent":165}}},"94":{"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","id":94,"type":"category","child":{"203":{"name":"অনুষ্ঠান","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/function\/","id":203,"type":"category","parent":94},"97":{"name":"খেল","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/game\/","id":97,"type":"category","parent":94},"202":{"name":"চলচ্চিত্ৰ আৰু অভিনেতা","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/movie-and-actor\/","id":202,"type":"category","parent":94},"201":{"name":"টলিউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tollywood\/","id":201,"type":"category","parent":94},"99":{"name":"টিভি ধাৰাবাহিক","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tv-serial\/","id":99,"type":"category","parent":94},"100":{"name":"প্ৰচাৰ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/promotion\/","id":100,"type":"category","parent":94},"95":{"name":"বক্স অফিচ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/box-office\/","id":95,"type":"category","parent":94},"200":{"name":"বলীউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/bollywood\/","id":200,"type":"category","parent":94},"98":{"name":"ৱেব ছিৰিজ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/web-series\/","id":98,"type":"category","parent":94},"96":{"name":"সংগীত","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/music\/","id":96,"type":"category","parent":94}}},"254":{"name":"মৰ্মাহত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%b0%e0%a7%8d%e0%a6%ae%e0%a6%be%e0%a6%b9%e0%a6%a4\/","id":254,"type":"category"},"166":{"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","id":166,"type":"category","child":{"170":{"name":"অষ্ট্ৰেলিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/australia\/","id":170,"type":"category","parent":166},"167":{"name":"আফ্ৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/africa\/","id":167,"type":"category","parent":166},"168":{"name":"আমেৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/america\/","id":168,"type":"category","parent":166},"171":{"name":"ইউৰোপ","link":"https:\/\/suryyaskiran.in\/category\/continents\/europe\/","id":171,"type":"category","parent":166},"169":{"name":"এছিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/asia\/","id":169,"type":"category","parent":166}}},"253":{"name":"মুখ্য-পৃষ্ঠা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%81%e0%a6%96%e0%a7%8d%e0%a6%af-%e0%a6%aa%e0%a7%83%e0%a6%b7%e0%a7%8d%e0%a6%a0%e0%a6%be\/","id":253,"type":"category"},"172":{"name":"মেট্ৰ\'পলিটান","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/","id":172,"type":"category","child":{"180":{"name":"আহমেদাবাদ","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/ahmadabad\/","id":180,"type":"category","parent":172},"176":{"name":"কলকাতা","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/kolkata\/","id":176,"type":"category","parent":172},"181":{"name":"চুৰাট","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/surat\/","id":181,"type":"category","parent":172},"177":{"name":"চেন্নাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/chennai\/","id":177,"type":"category","parent":172},"174":{"name":"নতুন দিল্লী","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/new-delhi\/","id":174,"type":"category","parent":172},"178":{"name":"পুনে","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/pune\/","id":178,"type":"category","parent":172},"182":{"name":"বিশাখাপট্টনম","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/vishakhapatnam\/","id":182,"type":"category","parent":172},"175":{"name":"বেংগালুৰু","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/bengaluru\/","id":175,"type":"category","parent":172},"173":{"name":"মুম্বাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/mumbai\/","id":173,"type":"category","parent":172}}},"249":{"name":"ৰাইজৰ বাৰ্তা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a7%b0-%e0%a6%ac%e0%a6%be%e0%a7%b0%e0%a7%8d%e0%a6%a4%e0%a6%be\/","id":249,"type":"category"},"101":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","id":101,"type":"category","child":{"103":{"name":"দলীয় ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/party-politics\/","id":103,"type":"category","parent":101},"102":{"name":"নিৰ্বাচন","link":"https:\/\/suryyaskiran.in\/category\/politics\/election\/","id":102,"type":"category","parent":101},"211":{"name":"পঞ্চায়ত আৰু পৰিষদ","link":"https:\/\/suryyaskiran.in\/category\/politics\/panchayat-council\/","id":211,"type":"category","parent":101},"210":{"name":"ভোটদান আৰু ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/politics\/voting-result\/","id":210,"type":"category","parent":101},"104":{"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/politics-state-policy\/","id":104,"type":"category","parent":101},"105":{"name":"ৰাষ্ট্ৰীয় নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/national-policy\/","id":105,"type":"category","parent":101},"106":{"name":"সভা আৰু সমদল","link":"https:\/\/suryyaskiran.in\/category\/politics\/meeting-rally\/","id":106,"type":"category","parent":101}}},"267":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%9c%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","id":267,"type":"category"},"80":{"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","id":80,"type":"category","child":{"209":{"name":"অন্যান্য প্ৰসংগ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/general\/","id":209,"type":"category","parent":80},"84":{"name":"কৰ আৰু সেৱাসমূহ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/tax-services\/","id":84,"type":"category","parent":80},"85":{"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/agreement\/","id":85,"type":"category","parent":80},"82":{"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/foreign-policy\/","id":82,"type":"category","parent":80},"86":{"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/travel\/","id":86,"type":"category","parent":80},"83":{"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/state-policy\/","id":83,"type":"category","parent":80}}},"483":{"name":"ৰাষ্ট্ৰীয়-আন্তঃৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80%e0%a7%9f-%e0%a6%86%e0%a6%a8%e0%a7%8d%e0%a6%a4%e0%a6%83%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80\/","id":483,"type":"category"},"67":{"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/","id":67,"type":"category","child":{"198":{"name":"কিতাপ","link":"https:\/\/suryyaskiran.in\/category\/education\/books\/","id":198,"type":"category","parent":67},"199":{"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/education\/documentation\/","id":199,"type":"category","parent":67},"68":{"name":"পৰীক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/examination\/","id":68,"type":"category","parent":67},"71":{"name":"প্ৰকাশন","link":"https:\/\/suryyaskiran.in\/category\/education\/publication\/","id":71,"type":"category","parent":67},"69":{"name":"ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/education\/result\/","id":69,"type":"category","parent":67},"72":{"name":"বিদ্যালয় আৰু মহাবিদ্যালয়","link":"https:\/\/suryyaskiran.in\/category\/education\/school-college\/","id":72,"type":"category","parent":67}}},"485":{"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b6%e0%a6%bf%e0%a6%95%e0%a7%8d%e0%a6%b7%e0%a6%be\/","id":485,"type":"category"},"484":{"name":"সম্পাদকীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b8%e0%a6%ae%e0%a7%8d%e0%a6%aa%e0%a6%be%e0%a6%a6%e0%a6%95%e0%a7%80%e0%a7%9f\/","id":484,"type":"category"}}';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getMenuSkCategory()
    {
        // $url = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100';
        // $url1 = 'https://suryyaskiran.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        // $ids = [43, 80, 94, 101, 114, 154, 166];
        // $data = $this->curl->simple_get($url);
        // $data1 = $this->curl->simple_get($url1);
        // $data = json_decode($data, true);
        // $data1 = json_decode($data1, true);
        // foreach ($data as  $value) {
        //     $id = $value['id'];
        //     if ($value['parent'] == 0 && $value['id'] != 1) {
        //         if (in_array($id, $ids)) {
        //             $category[$id] = array(
        //                 'name' => $value['name'], 
        //                 'link' => $value['link'], 
        //                 'id' => $value['id'], 
        //                 'type' => $value['taxonomy']
        //             );
        //         }
        //     }
        // }
        // foreach ($data1 as  $value) {
        //     $id = $value['id'];
        //     if ($value['parent'] == 0 && $value['id'] != 1) {
        //         if (in_array($id, $ids)) {
        //             $category[$id] = array(
        //                 'name' => $value['name'],
        //                 'link' => $value['link'],
        //                 'id' => $value['id'],
        //                 'type' => $value['taxonomy']
        //             );
        //         }
        //     } 
        // }
        $json_data =
            '{"154":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","id":154,"type":"category"},"114":{"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","id":114,"type":"category"},"43":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","id":43,"type":"category"},"94":{"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","id":94,"type":"category"},"166":{"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","id":166,"type":"category"},"101":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","id":101,"type":"category"},"80":{"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","id":80,"type":"category"}}';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getCategoriesSK()
    {
        $json_data_full =
            '{"62":{"name":"অপৰাধ আৰু ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/","id":62,"type":"category","child":{"194":{"name":"অধিকাৰসমূহ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/rights\/","id":194,"type":"category","parent":62},"63":{"name":"অপৰাধ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/crime\/","id":63,"type":"category","parent":62},"187":{"name":"আদালত","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court\/","id":187,"type":"category","parent":62},"188":{"name":"আদালত আৰু আইন","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/court-and-law\/","id":188,"type":"category","parent":62},"190":{"name":"এজাহাৰ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/fir\/","id":190,"type":"category","parent":62},"189":{"name":"ঘৰুৱা হি","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/domestic-violence\/","id":189,"type":"category","parent":62},"186":{"name":"দুৰ্ঘটনা","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/accident\/","id":186,"type":"category","parent":62},"191":{"name":"ন্যায়","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/justice\/","id":191,"type":"category","parent":62},"193":{"name":"পুলিচ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/police\/","id":193,"type":"category","parent":62},"192":{"name":"শাৰীৰিক","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/physically-assault\/","id":192,"type":"category","parent":62},"65":{"name":"সন্ত্ৰাসবাদ","link":"https:\/\/suryyaskiran.in\/category\/crime-justice\/terrorism\/","id":65,"type":"category","parent":62}}},"482":{"name":"অৰ্থনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a7%b0%e0%a7%8d%e0%a6%a5%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","id":482,"type":"category"},"250":{"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%85%e0%a6%b8%e0%a6%ae\/","id":250,"type":"category"},"248":{"name":"আছাম ৰাইজিং( ইভেন্টে)","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%86%e0%a6%9b%e0%a6%be%e0%a6%ae-%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a6%bf%e0%a6%82-%e0%a6%87%e0%a6%ad%e0%a7%87%e0%a6%a8%e0%a7%8d%e0%a6%9f%e0%a7%87\/","id":248,"type":"category"},"234":{"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/international\/","id":234,"type":"category","child":{"240":{"name":"কূটনীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/diplomacy\/","id":240,"type":"category","parent":234},"236":{"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/international\/agreement-international\/","id":236,"type":"category","parent":234},"238":{"name":"পৰ্যটক","link":"https:\/\/suryyaskiran.in\/category\/international\/tourist\/","id":238,"type":"category","parent":234},"239":{"name":"বিমান পৰিবহন","link":"https:\/\/suryyaskiran.in\/category\/international\/airlines\/","id":239,"type":"category","parent":234},"235":{"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/international\/foreign-policy-international\/","id":235,"type":"category","parent":234},"237":{"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/international\/travel-international\/","id":237,"type":"category","parent":234}}},"154":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","id":154,"type":"category","child":{"159":{"name":"অৰুণাচল প্ৰদেশ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/arunachal-pradesh\/","id":159,"type":"category","parent":154},"161":{"name":"অসম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/assam\/","id":161,"type":"category","parent":154},"160":{"name":"ছিকিম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/sikkim\/","id":160,"type":"category","parent":154},"155":{"name":"ত্ৰিপুৰা","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/tripura\/","id":155,"type":"category","parent":154},"162":{"name":"নাগালেণ্ড","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/nagaland\/","id":162,"type":"category","parent":154},"157":{"name":"মণিপুৰ","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/manipur\/","id":157,"type":"category","parent":154},"158":{"name":"মিজোৰাম","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/mizoram\/","id":158,"type":"category","parent":154},"156":{"name":"মেঘালয়","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/meghalaya\/","id":156,"type":"category","parent":154}}},"258":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%89%e0%a6%a4%e0%a7%8d%e0%a6%a4%e0%a7%b0-%e0%a6%aa%e0%a7%82%e0%a7%b0%e0%a7%8d%e0%a6%ac%e0%a6%be%e0%a6%9e%e0%a7%8d%e0%a6%9a%e0%a6%b2\/","id":258,"type":"category"},"270":{"name":"ক্রীড়া-জগত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%95%e0%a7%8d%e0%a6%b0%e0%a7%80%e0%a7%9c%e0%a6%be-%e0%a6%9c%e0%a6%97%e0%a6%a4\/","id":270,"type":"category"},"114":{"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","id":114,"type":"category","child":{"119":{"name":"আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/sports\/international-sports\/","id":119,"type":"category","parent":114},"115":{"name":"ক্ৰিকেট","link":"https:\/\/suryyaskiran.in\/category\/sports\/cricket\/","id":115,"type":"category","parent":114},"241":{"name":"গল্ফ","link":"https:\/\/suryyaskiran.in\/category\/sports\/golf\/","id":241,"type":"category","parent":114},"243":{"name":"প্ৰতিযোগিতা","link":"https:\/\/suryyaskiran.in\/category\/sports\/compitition\/","id":243,"type":"category","parent":114},"116":{"name":"ফুটবল","link":"https:\/\/suryyaskiran.in\/category\/sports\/football\/","id":116,"type":"category","parent":114},"118":{"name":"বিভিন্ন ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/game-sports\/","id":118,"type":"category","parent":114},"242":{"name":"বিশ্বকাপ","link":"https:\/\/suryyaskiran.in\/category\/sports\/worldcup\/","id":242,"type":"category","parent":114},"120":{"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/sports\/national-sports\/","id":120,"type":"category","parent":114}}},"266":{"name":"গ্ৰাম্যৰ্থ","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%97%e0%a7%8d%e0%a7%b0%e0%a6%be%e0%a6%ae%e0%a7%8d%e0%a6%af%e0%a7%b0%e0%a7%8d%e0%a6%a5\/","id":266,"type":"category"},"87":{"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/","id":87,"type":"category","child":{"91":{"name":"কলা আৰু ডিজাইন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/art-design\/","id":91,"type":"category","parent":87},"93":{"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/lifestyle-documentation\/","id":93,"type":"category","parent":87},"92":{"name":"পৰ্যটন আৰু ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/tourism-travel\/","id":92,"type":"category","parent":87},"208":{"name":"পানীয়","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/drinks\/","id":208,"type":"category","parent":87},"89":{"name":"ফেশ্বন","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/fashion\/","id":89,"type":"category","parent":87},"207":{"name":"ৰেষ্টুৰেণ্ট","link":"https:\/\/suryyaskiran.in\/category\/lifestyle\/restaurant\/","id":207,"type":"category","parent":87}}},"502":{"name":"জীৱনশৈলী","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%9c%e0%a7%80%e0%a7%b1%e0%a6%a8%e0%a6%b6%e0%a7%88%e0%a6%b2%e0%a7%80\/","id":502,"type":"category"},"132":{"name":"নগৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/","id":132,"type":"category","child":{"149":{"name":"কোকৰাঝাৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/kokrajhar\/","id":149,"type":"category","parent":132},"142":{"name":"গহপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/gohpur\/","id":142,"type":"category","parent":132},"133":{"name":"গুৱাহাটী","link":"https:\/\/suryyaskiran.in\/category\/city\/guwahati\/","id":133,"type":"category","parent":132},"147":{"name":"গোলাঘাট","link":"https:\/\/suryyaskiran.in\/category\/city\/golaghat\/","id":147,"type":"category","parent":132},"138":{"name":"গোৱালপাৰা","link":"https:\/\/suryyaskiran.in\/category\/city\/goalpara\/","id":138,"type":"category","parent":132},"150":{"name":"ডিফু","link":"https:\/\/suryyaskiran.in\/category\/city\/diphu\/","id":150,"type":"category","parent":132},"135":{"name":"ডিব্ৰুগড়","link":"https:\/\/suryyaskiran.in\/category\/city\/dibrugarh\/","id":135,"type":"category","parent":132},"146":{"name":"তিনিচুকীয়া","link":"https:\/\/suryyaskiran.in\/category\/city\/tinsukia\/","id":146,"type":"category","parent":132},"141":{"name":"তেজপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/tezpur\/","id":141,"type":"category","parent":132},"140":{"name":"দৰং","link":"https:\/\/suryyaskiran.in\/category\/city\/darrang\/","id":140,"type":"category","parent":132},"136":{"name":"ধুবুৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/dhubri\/","id":136,"type":"category","parent":132},"144":{"name":"ধেমাজি","link":"https:\/\/suryyaskiran.in\/category\/city\/dhemaji\/","id":144,"type":"category","parent":132},"151":{"name":"নগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/nagaon\/","id":151,"type":"category","parent":132},"137":{"name":"নলবাৰী","link":"https:\/\/suryyaskiran.in\/category\/city\/nalbari\/","id":137,"type":"category","parent":132},"139":{"name":"বৰপেটা","link":"https:\/\/suryyaskiran.in\/category\/city\/barpeta\/","id":139,"type":"category","parent":132},"148":{"name":"বিশ্বনাথ","link":"https:\/\/suryyaskiran.in\/category\/city\/biswanath\/","id":148,"type":"category","parent":132},"145":{"name":"মৰাণ","link":"https:\/\/suryyaskiran.in\/category\/city\/moran\/","id":145,"type":"category","parent":132},"152":{"name":"মৰিগাঁও","link":"https:\/\/suryyaskiran.in\/category\/city\/morigaon\/","id":152,"type":"category","parent":132},"153":{"name":"মাজুলী","link":"https:\/\/suryyaskiran.in\/category\/city\/majuli\/","id":153,"type":"category","parent":132},"134":{"name":"যোৰহাট","link":"https:\/\/suryyaskiran.in\/category\/city\/jorhat\/","id":134,"type":"category","parent":132},"143":{"name":"লখিমপুৰ","link":"https:\/\/suryyaskiran.in\/category\/city\/lakhimpur\/","id":143,"type":"category","parent":132}}},"264":{"name":"প্ৰকৃতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%95%e0%a7%83%e0%a6%a4%e0%a6%bf\/","id":264,"type":"category"},"73":{"name":"প্ৰতিৰক্ষা","link":"https:\/\/suryyaskiran.in\/category\/defence\/","id":73,"type":"category","child":{"196":{"name":"অগ্নিকাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/defence\/fire\/","id":196,"type":"category","parent":73},"197":{"name":"অন্যান্য বিষয়","link":"https:\/\/suryyaskiran.in\/category\/defence\/other-issue\/","id":197,"type":"category","parent":73},"79":{"name":"এন.আই.এ.","link":"https:\/\/suryyaskiran.in\/category\/defence\/nia\/","id":79,"type":"category","parent":73},"78":{"name":"নিৰাপত্তা","link":"https:\/\/suryyaskiran.in\/category\/defence\/security\/","id":78,"type":"category","parent":73},"76":{"name":"নৌসেনা","link":"https:\/\/suryyaskiran.in\/category\/defence\/navy\/","id":76,"type":"category","parent":73},"75":{"name":"বিএছএফ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bsf\/","id":75,"type":"category","parent":73},"195":{"name":"বোমা বিস্ফোৰণ","link":"https:\/\/suryyaskiran.in\/category\/defence\/bomb-blast\/","id":195,"type":"category","parent":73},"77":{"name":"যুদ্ধ","link":"https:\/\/suryyaskiran.in\/category\/defence\/war\/","id":77,"type":"category","parent":73}}},"43":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","id":43,"type":"category","child":{"47":{"name":"আমদানি- ৰপ্তানি","link":"https:\/\/suryyaskiran.in\/category\/business\/export-import\/","id":47,"type":"category","parent":43},"184":{"name":"উদ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/business\/industry\/","id":184,"type":"category","parent":43},"185":{"name":"কাৰখানা","link":"https:\/\/suryyaskiran.in\/category\/business\/factory\/","id":185,"type":"category","parent":43},"45":{"name":"বীমা","link":"https:\/\/suryyaskiran.in\/category\/business\/insurance\/","id":45,"type":"category","parent":43},"48":{"name":"ব্যৱসায় আৰু বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/trade-commerce\/","id":48,"type":"category","parent":43},"183":{"name":"মিউচুৱেল ফাণ্ড","link":"https:\/\/suryyaskiran.in\/category\/business\/mutual-fund\/","id":183,"type":"category","parent":43},"46":{"name":"শ্বেয়াৰ বজাৰ","link":"https:\/\/suryyaskiran.in\/category\/business\/share-market\/","id":46,"type":"category","parent":43}}},"514":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%be%e0%a6%a3%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%af\/","id":514,"type":"category"},"56":{"name":"বিজ্ঞান","link":"https:\/\/suryyaskiran.in\/category\/science\/","id":56,"type":"category","child":{"59":{"name":"আৱিষ্কাৰ","link":"https:\/\/suryyaskiran.in\/category\/science\/discovery\/","id":59,"type":"category","parent":56},"58":{"name":"গৱেষণা","link":"https:\/\/suryyaskiran.in\/category\/science\/research\/","id":58,"type":"category","parent":56},"61":{"name":"জীৱ আৰু বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/science\/animal-wild-life\/","id":61,"type":"category","parent":56},"212":{"name":"পৰিৱেশ","link":"https:\/\/suryyaskiran.in\/category\/science\/environment\/","id":212,"type":"category","parent":56},"60":{"name":"পৰীক্ষণ","link":"https:\/\/suryyaskiran.in\/category\/science\/testing\/","id":60,"type":"category","parent":56},"107":{"name":"প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/science\/technology\/","id":107,"type":"category","parent":56},"213":{"name":"ভূমিকম্প","link":"https:\/\/suryyaskiran.in\/category\/science\/earthquake\/","id":213,"type":"category","parent":56}}},"268":{"name":"বিজ্ঞান-প্ৰযুক্তি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%9c%e0%a7%8d%e0%a6%9e%e0%a6%be%e0%a6%a8-%e0%a6%aa%e0%a7%8d%e0%a7%b0%e0%a6%af%e0%a7%81%e0%a6%95%e0%a7%8d%e0%a6%a4%e0%a6%bf\/","id":268,"type":"category"},"256":{"name":"বিনোদন","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ac%e0%a6%bf%e0%a6%a8%e0%a7%8b%e0%a6%a6%e0%a6%a8\/","id":256,"type":"category"},"165":{"name":"বিশেষ বাতৰি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/","id":165,"type":"category","child":{"226":{"name":"অন্তৰ্দৃষ্টি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/insight\/","id":226,"type":"category","parent":165},"221":{"name":"উৎসৱ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/festival\/","id":221,"type":"category","parent":165},"125":{"name":"কলা আৰু সংস্কৃতি","link":"https:\/\/suryyaskiran.in\/category\/special-news\/art-culture\/","id":125,"type":"category","parent":165},"129":{"name":"গাওঁ আৰু চহৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/village-town\/","id":129,"type":"category","parent":165},"126":{"name":"চৰকাৰী বিভাগসমূহ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/govt-departments\/","id":126,"type":"category","parent":165},"230":{"name":"তুষাৰপাত","link":"https:\/\/suryyaskiran.in\/category\/special-news\/snowfall\/","id":230,"type":"category","parent":165},"220":{"name":"দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/disaster\/","id":220,"type":"category","parent":165},"130":{"name":"ধৰ্ম","link":"https:\/\/suryyaskiran.in\/category\/special-news\/religion\/","id":130,"type":"category","parent":165},"231":{"name":"পাচলি আৰু ফল","link":"https:\/\/suryyaskiran.in\/category\/special-news\/vegetables-fruit\/","id":231,"type":"category","parent":165},"225":{"name":"প্ৰব্ৰজন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/immigration\/","id":225,"type":"category","parent":165},"216":{"name":"প্ৰশাসন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/administration\/","id":216,"type":"category","parent":165},"122":{"name":"প্ৰাকৃতিক দুৰ্যোগ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/natural-calamities\/","id":122,"type":"category","parent":165},"121":{"name":"ফিছাৰ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/featured-stories\/","id":121,"type":"category","parent":165},"223":{"name":"বন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/forest\/","id":223,"type":"category","parent":165},"232":{"name":"বন্য জীৱন","link":"https:\/\/suryyaskiran.in\/category\/special-news\/wild-life\/","id":232,"type":"category","parent":165},"222":{"name":"বানপানী আৰু বৰষুণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/flood-rain\/","id":222,"type":"category","parent":165},"131":{"name":"ভিডিঅ\'","link":"https:\/\/suryyaskiran.in\/category\/special-news\/videos\/","id":131,"type":"category","parent":165},"233":{"name":"মহিলা সৱলীকৰণ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/women-empowerment\/","id":233,"type":"category","parent":165},"124":{"name":"মুখ্যাংশ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/highlight\/","id":124,"type":"category","parent":165},"227":{"name":"মৃত্যু","link":"https:\/\/suryyaskiran.in\/category\/special-news\/passes-away\/","id":227,"type":"category","parent":165},"228":{"name":"ৰজহুৱা সভা","link":"https:\/\/suryyaskiran.in\/category\/special-news\/public-rally\/","id":228,"type":"category","parent":165},"127":{"name":"ৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/national\/","id":127,"type":"category","parent":165},"229":{"name":"ৰোমাঞ্চ","link":"https:\/\/suryyaskiran.in\/category\/special-news\/romance\/","id":229,"type":"category","parent":165},"218":{"name":"সম্প্ৰদায়","link":"https:\/\/suryyaskiran.in\/category\/special-news\/community\/","id":218,"type":"category","parent":165}}},"94":{"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","id":94,"type":"category","child":{"203":{"name":"অনুষ্ঠান","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/function\/","id":203,"type":"category","parent":94},"97":{"name":"খেল","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/game\/","id":97,"type":"category","parent":94},"202":{"name":"চলচ্চিত্ৰ আৰু অভিনেতা","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/movie-and-actor\/","id":202,"type":"category","parent":94},"201":{"name":"টলিউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tollywood\/","id":201,"type":"category","parent":94},"99":{"name":"টিভি ধাৰাবাহিক","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/tv-serial\/","id":99,"type":"category","parent":94},"100":{"name":"প্ৰচাৰ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/promotion\/","id":100,"type":"category","parent":94},"95":{"name":"বক্স অফিচ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/box-office\/","id":95,"type":"category","parent":94},"200":{"name":"বলীউড","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/bollywood\/","id":200,"type":"category","parent":94},"98":{"name":"ৱেব ছিৰিজ","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/web-series\/","id":98,"type":"category","parent":94},"96":{"name":"সংগীত","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/music\/","id":96,"type":"category","parent":94}}},"254":{"name":"মৰ্মাহত","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%b0%e0%a7%8d%e0%a6%ae%e0%a6%be%e0%a6%b9%e0%a6%a4\/","id":254,"type":"category"},"166":{"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","id":166,"type":"category","child":{"170":{"name":"অষ্ট্ৰেলিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/australia\/","id":170,"type":"category","parent":166},"167":{"name":"আফ্ৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/africa\/","id":167,"type":"category","parent":166},"168":{"name":"আমেৰিকা","link":"https:\/\/suryyaskiran.in\/category\/continents\/america\/","id":168,"type":"category","parent":166},"171":{"name":"ইউৰোপ","link":"https:\/\/suryyaskiran.in\/category\/continents\/europe\/","id":171,"type":"category","parent":166},"169":{"name":"এছিয়া","link":"https:\/\/suryyaskiran.in\/category\/continents\/asia\/","id":169,"type":"category","parent":166}}},"253":{"name":"মুখ্য-পৃষ্ঠা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%ae%e0%a7%81%e0%a6%96%e0%a7%8d%e0%a6%af-%e0%a6%aa%e0%a7%83%e0%a6%b7%e0%a7%8d%e0%a6%a0%e0%a6%be\/","id":253,"type":"category"},"172":{"name":"মেট্ৰ\'পলিটান","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/","id":172,"type":"category","child":{"180":{"name":"আহমেদাবাদ","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/ahmadabad\/","id":180,"type":"category","parent":172},"176":{"name":"কলকাতা","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/kolkata\/","id":176,"type":"category","parent":172},"181":{"name":"চুৰাট","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/surat\/","id":181,"type":"category","parent":172},"177":{"name":"চেন্নাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/chennai\/","id":177,"type":"category","parent":172},"174":{"name":"নতুন দিল্লী","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/new-delhi\/","id":174,"type":"category","parent":172},"178":{"name":"পুনে","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/pune\/","id":178,"type":"category","parent":172},"182":{"name":"বিশাখাপট্টনম","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/vishakhapatnam\/","id":182,"type":"category","parent":172},"175":{"name":"বেংগালুৰু","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/bengaluru\/","id":175,"type":"category","parent":172},"173":{"name":"মুম্বাই","link":"https:\/\/suryyaskiran.in\/category\/metropolitan\/mumbai\/","id":173,"type":"category","parent":172}}},"249":{"name":"ৰাইজৰ বাৰ্তা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%87%e0%a6%9c%e0%a7%b0-%e0%a6%ac%e0%a6%be%e0%a7%b0%e0%a7%8d%e0%a6%a4%e0%a6%be\/","id":249,"type":"category"},"101":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","id":101,"type":"category","child":{"103":{"name":"দলীয় ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/party-politics\/","id":103,"type":"category","parent":101},"102":{"name":"নিৰ্বাচন","link":"https:\/\/suryyaskiran.in\/category\/politics\/election\/","id":102,"type":"category","parent":101},"211":{"name":"পঞ্চায়ত আৰু পৰিষদ","link":"https:\/\/suryyaskiran.in\/category\/politics\/panchayat-council\/","id":211,"type":"category","parent":101},"210":{"name":"ভোটদান আৰু ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/politics\/voting-result\/","id":210,"type":"category","parent":101},"104":{"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/politics-state-policy\/","id":104,"type":"category","parent":101},"105":{"name":"ৰাষ্ট্ৰীয় নীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/national-policy\/","id":105,"type":"category","parent":101},"106":{"name":"সভা আৰু সমদল","link":"https:\/\/suryyaskiran.in\/category\/politics\/meeting-rally\/","id":106,"type":"category","parent":101}}},"267":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%9c%e0%a6%a8%e0%a7%80%e0%a6%a4%e0%a6%bf\/","id":267,"type":"category"},"80":{"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","id":80,"type":"category","child":{"209":{"name":"অন্যান্য প্ৰসংগ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/general\/","id":209,"type":"category","parent":80},"84":{"name":"কৰ আৰু সেৱাসমূহ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/tax-services\/","id":84,"type":"category","parent":80},"85":{"name":"চুক্তি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/agreement\/","id":85,"type":"category","parent":80},"82":{"name":"বৈদেশিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/foreign-policy\/","id":82,"type":"category","parent":80},"86":{"name":"ভ্ৰমণ","link":"https:\/\/suryyaskiran.in\/category\/national-international\/travel\/","id":86,"type":"category","parent":80},"83":{"name":"ৰাজ্যিক নীতি","link":"https:\/\/suryyaskiran.in\/category\/national-international\/state-policy\/","id":83,"type":"category","parent":80}}},"483":{"name":"ৰাষ্ট্ৰীয়-আন্তঃৰাষ্ট্ৰীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80%e0%a7%9f-%e0%a6%86%e0%a6%a8%e0%a7%8d%e0%a6%a4%e0%a6%83%e0%a7%b0%e0%a6%be%e0%a6%b7%e0%a7%8d%e0%a6%9f%e0%a7%8d%e0%a7%b0%e0%a7%80\/","id":483,"type":"category"},"67":{"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/","id":67,"type":"category","child":{"198":{"name":"কিতাপ","link":"https:\/\/suryyaskiran.in\/category\/education\/books\/","id":198,"type":"category","parent":67},"199":{"name":"নথিপত্ৰ","link":"https:\/\/suryyaskiran.in\/category\/education\/documentation\/","id":199,"type":"category","parent":67},"68":{"name":"পৰীক্ষা","link":"https:\/\/suryyaskiran.in\/category\/education\/examination\/","id":68,"type":"category","parent":67},"71":{"name":"প্ৰকাশন","link":"https:\/\/suryyaskiran.in\/category\/education\/publication\/","id":71,"type":"category","parent":67},"69":{"name":"ফলাফল","link":"https:\/\/suryyaskiran.in\/category\/education\/result\/","id":69,"type":"category","parent":67},"72":{"name":"বিদ্যালয় আৰু মহাবিদ্যালয়","link":"https:\/\/suryyaskiran.in\/category\/education\/school-college\/","id":72,"type":"category","parent":67}}},"485":{"name":"শিক্ষা","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b6%e0%a6%bf%e0%a6%95%e0%a7%8d%e0%a6%b7%e0%a6%be\/","id":485,"type":"category"},"484":{"name":"সম্পাদকীয়","link":"https:\/\/suryyaskiran.in\/category\/%e0%a6%b8%e0%a6%ae%e0%a7%8d%e0%a6%aa%e0%a6%be%e0%a6%a6%e0%a6%95%e0%a7%80%e0%a7%9f\/","id":484,"type":"category"}}';



        $json_data_menu =
            '{"154":{"name":"উত্তৰ-পূৰ্বাঞ্চল","link":"https:\/\/suryyaskiran.in\/category\/ne-region\/","id":154,"type":"category"},"114":{"name":"ক্ৰীড়া","link":"https:\/\/suryyaskiran.in\/category\/sports\/","id":114,"type":"category"},"43":{"name":"বাণিজ্য","link":"https:\/\/suryyaskiran.in\/category\/business\/","id":43,"type":"category"},"94":{"name":"মনোৰঞ্জন","link":"https:\/\/suryyaskiran.in\/category\/entertainment\/","id":94,"type":"category"},"166":{"name":"মহাদেশসমূহ","link":"https:\/\/suryyaskiran.in\/category\/continents\/","id":166,"type":"category"},"101":{"name":"ৰাজনীতি","link":"https:\/\/suryyaskiran.in\/category\/politics\/","id":101,"type":"category"},"80":{"name":"ৰাষ্ট্ৰীয় আৰু আন্তৰ্জাতিক","link":"https:\/\/suryyaskiran.in\/category\/national-international\/","id":80,"type":"category"}}';
        $json_data = array(
            'all_categories' => json_decode($json_data_full, true),
            'menu_categories' => json_decode($json_data_menu, true),
        );
        return $json_data;
    }
    public function getSocialLinksSK()
    {
        $links[] = array(
            'name' => 'Facebook',
            'link' => 'https://facebook.com/সূৰ্য্যৰকিৰণ-106092685404708/',
            'icon' => 'fa fa-facebook',
        );
        $links[] = array(
            'name' => 'Twitter',
            'link' => 'https://twitter.com/suryyas_kiran',
            'icon' => 'fa fa-twitter',
        );
        $links[] = array(
            'name' => 'Instagram',
            'link' => 'https://instagram.com/suryyaskiranofficial',
            'icon' => 'fa fa-instagram',
        );
        $links[] = array(
            'name' => 'Youtube',
            'link' => 'https://www.youtube.com/channel/UCZjnNF5lR5w8uiM0S-NafDA/',
            'icon' => 'fa fa-youtube',
        );
        return $links;
    }

    // public function getAdsArticle()
        // {
        //     $adsArray[] = array(
        //         'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/04/27-April-to-7-May.jpeg.png',
        //         'redirect' => 'on',
        //         'link' => 'https://www.alwaysfirst.in/',
        //     );
        //     $adsArray[] = array(
        //         'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/03/Gandhi-Shilp-Bazar-2.png',
        //         'redirect' => 'off',
        //         'link' => 'https://www.alwaysfirst.in/',
        //     );
        //     return $adsArray;
        //     $none = null;
        //     // return $none;
        // }
        // public function getScriptAds()
        // {
        //     $adsArray[] = array(
        //         'script' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>',
        //     );
        //     $adsArray[] = array(
        //         'script' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>',
        //     );
        //     return $adsArray;
        //     $none = null;
        //     // return $none;
        // }
    public function feedback($data)
    {
        $this->db->insert('feedback', $data);
        return array("status" => 201, "message" => "Data has been created");
    }
    public function privacyPolicy(){
        $json_data = '[{
                "privacyPolicy" : "<h1>Privacy Policy for Always First Publication Private Limited</h1><p>At Always First, accessible from https://www.alwaysfirst.in/, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Always First and how we use it.</p><p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p><p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in Always First. This policy is not applicable to any information collected offline or via channels other than this website.</p><h2>Consent</h2><p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p><h2>Information we collect</h2><p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p><p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p><p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p><h2>How we use your information</h2><p>We use the information we collect in various ways, including to:</p><ul><li>Provide, operate, and maintain our website</li><li>Improve, personalize, and expand our website</li><li>Understand and analyze how you use our website</li><li>Develop new products, services, features, and functionality</li><li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li><li>Send you emails</li><li>Find and prevent fraud</li></ul><h2>Log Files</h2><p>Always First follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p><h2>Our Advertising Partners</h2><p>Some of advertisers on our site may use cookies and web beacons. Our advertising partners are listed below. Each of our advertising partners has their own Privacy Policy for their policies on user data. For easier access, we hyperlinked to their Privacy Policies below.</p><ul><li><p>Google</p><p>https://policies.google.com/technologies/ads</p></li></ul><h2>Advertising Partners Privacy Policies</h2><P>You may consult this list to find the Privacy Policy for each of the advertising partners of Always First.</p><p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on Always First, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p><p>Note that Always First has no access to or control over these cookies that are used by third-party advertisers.</p><h2>Third Party Privacy Policies</h2><p>Always First\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p><p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p><h2>CCPA Privacy Rights (Do Not Sell My Personal Information)</h2><p>Under the CCPA, among other rights, California consumers have the right to:</p><p>Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p><p>Request that a business delete any personal data about the consumer that a business has collected.</p><p>Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p><p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p><h2>GDPR Data Protection Rights</h2><p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p><p>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p><p>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p><p>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p><p>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p><p>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p><p>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p><p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p><h2>Children\'s Information</h2><p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p><p>Always First does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>"
            }]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function termsAndConditions(){
        $json_data = '[{
                "termsAndConditions" : "<h2><strong>Terms and Conditions</strong></h2><p>Welcome to Always First!</p><p>These terms and conditions outline the rules and regulations for the use of Always First Publication Private Limited\'s Website, located at https://www.alwaysfirst.in/.</p><p>By accessing this website we assume you accept these terms and conditions. Do not continue to use Always First if you do not agree to take all of the terms and conditions stated on this page.</p><p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: \"Client\", \"You\" and \"Your\" refers to you, the person log on this website and compliant to the Company’s terms and conditions. \"The Company\", \"Ourselves\", \"We\", \"Our\" and \"Us\", refers to our Company. \"Party\", \"Parties\", or \"Us\", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p><h3><strong>Cookies</strong></h3><p>We employ the use of cookies. By accessing Always First, you agreed to use cookies in agreement with the Always First Publication Private Limited\'s Privacy Policy. </p><p>Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p><h3><strong>License</strong></h3><p>Unless otherwise stated, Always First Publication Private Limited and/or its licensors own the intellectual property rights for all material on Always First. All intellectual property rights are reserved. You may access this from Always First for your own personal use subjected to restrictions set in these terms and conditions.</p><p>You must not:</p><ul><li>Republish material from Always First</li><li>Sell, rent or sub-license material from Always First</li><li>Reproduce, duplicate or copy material from Always First</li><li>Redistribute content from Always First</li></ul><p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the Terms And Conditions Template.</p><p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Always First Publication Private Limited does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Always First Publication Private Limited,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Always First Publication Private Limited shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p><p>Always First Publication Private Limited reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p><p>You warrant and represent that:</p><ul><li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li><li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li><li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li><li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li></ul><p>You hereby grant Always First Publication Private Limited a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p><h3><strong>Hyperlinking to our Content</strong></h3><p>The following organizations may link to our Website without prior written approval:</p><ul><li>Government agencies;</li><li>Search engines;</li><li>News organizations;</li><li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li><li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li></ul><p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party’s site.</p><p>We may consider and approve other link requests from the following types of organizations:</p><ul><li>commonly-known consumer and/or business information sources;</li><li>dot.com community sites;</li><li>associations or other groups representing charities;</li><li>online directory distributors;</li>    <li>internet portals;</li><li>accounting, law and consulting firms; and</li><li>educational institutions and trade associations.</li></ul><p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of Always First Publication Private Limited; and (d) the link is in the context of general resource information.</p><p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party’s site.</p><p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Always First Publication Private Limited. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p><p>Approved organizations may hyperlink to our Website as follows:</p><ul><li>By use of our corporate name; or</li><li>By use of the uniform resource locator being linked to; or</li><li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party’s site.</li></ul><p>No use of Always First Publication Private Limited\'s logo or other artwork will be allowed for linking absent a trademark license agreement.</p><h3><strong>iFrames</strong></h3><p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p><h3><strong>Content Liability</strong></h3><p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p><h3><strong>Your Privacy</strong></h3><p>Please read Privacy Policy</p><h3><strong>Reservation of Rights</strong></h3><p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it’s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p><h3><strong>Removal of links from our website</strong></h3><p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p><p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>"
            }]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function marketAPI(){
        $query = $this->db->query("SELECT * FROM `market_data`");
        $result = $query->result_array();
        return $result;
    }
    public function getCategorySetting(){
        $cat_data = $this->db->query("SELECT * FROM `category_setting`");
        foreach ($cat_data->result_array() as $key => $value) {
            $result[] = array(
                'id' => (int)$value['cat_id'],
                'name' => $value['name'],
                'icon' => $value['icon_link'],
                'color' => $value['color'],
            );
        }
        return $result;
        // $json = '[
            //             {"id": 35,"name": "Art & Culture","icon": "https://alwaysfirst.in/api/icons/35.png"},
            //             {"id": 162,"name": "Bollywood","icon": "https://alwaysfirst.in/api/icons/162.png"},
            //             {"id": 36,"name": "Business","icon": "https://alwaysfirst.in/api/icons/36.png"},
            //             {"id": 8248,"name": "Crime","icon": "https://alwaysfirst.in/api/icons/8248.png"},
            //             {"id": 8096,"name": "Defence","icon": "https://alwaysfirst.in/api/icons/8096.png"},
            //             {"id": 131,"name": "Entertainment","icon": "https://alwaysfirst.in/api/icons/131.png"},
            //             {"id": 12849,"name": "Environment","icon": "https://alwaysfirst.in/api/icons/12849.png"},
            //             {"id": 3490,"name": "Featured Stories","icon": "https://alwaysfirst.in/api/icons/3490.png"},
            //             {"id": 92,"name": "Handloom & Handicraft","icon": "https://alwaysfirst.in/api/icons/92.png"},
            //             {"id": 159,"name": "Health","icon": "https://alwaysfirst.in/api/icons/159.png"},
            //             {"id": 27,"name": "Lifestyle","icon": "https://alwaysfirst.in/api/icons/27.png"},
            //             {"id": 8403,"name": "National","icon": "https://alwaysfirst.in/api/icons/8403.png"},
            //             {"id": 2639,"name": "Science & Tech","icon": "https://alwaysfirst.in/api/icons/2639.png"},
            //             {"id": 16,"name": "Sports","icon": "https://alwaysfirst.in/api/icons/16.png"},
            //             {"id": 65,"name": "World","icon": "https://alwaysfirst.in/api/icons/65.png"}
            //         ]';
            // $json_data = json_decode($json, true);
            // return $json_data;
    }
    public function getUserCategorySetting($user_id){
        $cat_data = $this->db->query("SELECT * FROM `category_setting`")->result_array();
        $category = $this->db->query("SELECT * FROM `app_data` WHERE `user_id` = '$user_id'")->row_array();
        $category_array = explode(',', $category['category']);
        foreach ($cat_data as $key => $value) {
            if(in_array($value['cat_id'], $category_array)){
                $result[] = array(
                    'id' => (int)$value['cat_id'],
                    'name' => $value['name'],
                    'icon' => $value['icon_link'],
                    'color' => $value['color'],
                    'is_selected' => true,
                );
            }else {
                $result[] = array(
                    'id' => (int)$value['cat_id'],
                    'name' => $value['name'],
                    'icon' => $value['icon_link'],
                    'color' => $value['color'],
                    'is_selected' => false,
                );
            }
        }
        return $result;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{

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
        // $url = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100';
        // $url1 = 'https://alwaysfirst.in/wp-json/wp/v2/categories/?per_page=100&page=2';
        // $data = $this->curl->simple_get($url);
        // $data1 = $this->curl->simple_get($url1);
        // $data = json_decode($data, true);
        // $data1 = json_decode($data1, true);
        // foreach ($data as  $value) {
        //     $id = $value['id'];
        //     if($value['parent'] == 0 && $value['name'] != 'Uncategorized'){
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
        //     if(isset($category[$value['parent']])){
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
            '[{"id":35,"name":"Art &amp; Culture","link":"https:\/\/www.alwaysfirst.in\/category\/art-and-culture\/","type":"category"},{"id":36,"name":"Business","link":"https:\/\/www.alwaysfirst.in\/category\/business\/","type":"category","children":[{"id":12847,"name":"Banking","link":"https:\/\/www.alwaysfirst.in\/category\/business\/banking\/","type":"category","parent":36},{"id":8104,"name":"Export Import","link":"https:\/\/www.alwaysfirst.in\/category\/business\/export-import\/","type":"category","parent":36},{"id":905,"name":"Indian Business","link":"https:\/\/www.alwaysfirst.in\/category\/business\/indian-business\/","type":"category","parent":36},{"id":8103,"name":"Insurance","link":"https:\/\/www.alwaysfirst.in\/category\/business\/insurance\/","type":"category","parent":36},{"id":907,"name":"International Business","link":"https:\/\/www.alwaysfirst.in\/category\/business\/international-business\/","type":"category","parent":36},{"id":12846,"name":"Market","link":"https:\/\/www.alwaysfirst.in\/category\/business\/market\/","type":"category","parent":36},{"id":12844,"name":"Retail &amp; Online Market","link":"https:\/\/www.alwaysfirst.in\/category\/business\/retail-online-market\/","type":"category","parent":36},{"id":12845,"name":"Sensex","link":"https:\/\/www.alwaysfirst.in\/category\/business\/sensex\/","type":"category","parent":36},{"id":8102,"name":"Share Market","link":"https:\/\/www.alwaysfirst.in\/category\/business\/share-market\/","type":"category","parent":36},{"id":8105,"name":"Trade &amp; Commerce","link":"https:\/\/www.alwaysfirst.in\/category\/business\/trade-and-commerce\/","type":"category","parent":36}]},{"id":65,"name":"Continents","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/","type":"category","children":[{"id":96,"name":"Africa","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/africa\/","type":"category","parent":65},{"id":8093,"name":"America","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/america\/","type":"category","parent":65},{"id":8094,"name":"Asia","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/asia\/","type":"category","parent":65},{"id":8095,"name":"Australia","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/australia\/","type":"category","parent":65},{"id":94,"name":"Europe","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/europe\/","type":"category","parent":65}]},{"id":6141,"name":"Crime &amp; Justice","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/","type":"category","children":[{"id":8248,"name":"Crime","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/crime\/","type":"category","parent":6141},{"id":8251,"name":"Justice","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/justice\/","type":"category","parent":6141},{"id":12851,"name":"Law","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/law\/","type":"category","parent":6141},{"id":8249,"name":"Police","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/police-crime-and-justice\/","type":"category","parent":6141},{"id":12852,"name":"Rights","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/rights\/","type":"category","parent":6141},{"id":8250,"name":"Terrorism","link":"https:\/\/www.alwaysfirst.in\/category\/crime-and-justice\/terrorism-crime-and-justice\/","type":"category","parent":6141}]},{"id":8096,"name":"Defence","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/","type":"category","children":[{"id":6076,"name":"Army","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/army\/","type":"category","parent":8096},{"id":8097,"name":"BSF","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/bsf\/","type":"category","parent":8096},{"id":8098,"name":"Navy","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/navy\/","type":"category","parent":8096},{"id":6872,"name":"NIA","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/nia\/","type":"category","parent":8096},{"id":8101,"name":"Security","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/security\/","type":"category","parent":8096},{"id":8099,"name":"War","link":"https:\/\/www.alwaysfirst.in\/category\/defence\/war\/","type":"category","parent":8096}]},{"id":104,"name":"Education","link":"https:\/\/www.alwaysfirst.in\/category\/education\/","type":"category","children":[{"id":110,"name":"Examination","link":"https:\/\/www.alwaysfirst.in\/category\/education\/examination\/","type":"category","parent":104},{"id":113,"name":"Government Exam","link":"https:\/\/www.alwaysfirst.in\/category\/education\/government-exam\/","type":"category","parent":104},{"id":8261,"name":"Interview","link":"https:\/\/www.alwaysfirst.in\/category\/education\/interview\/","type":"category","parent":104},{"id":109,"name":"Job","link":"https:\/\/www.alwaysfirst.in\/category\/education\/job\/","type":"category","parent":104},{"id":8262,"name":"Publication","link":"https:\/\/www.alwaysfirst.in\/category\/education\/publication\/","type":"category","parent":104},{"id":111,"name":"Result","link":"https:\/\/www.alwaysfirst.in\/category\/education\/result\/","type":"category","parent":104},{"id":8263,"name":"School &amp; College","link":"https:\/\/www.alwaysfirst.in\/category\/education\/school-and-college\/","type":"category","parent":104}]},{"id":131,"name":"Entertainment","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/","type":"category","children":[{"id":162,"name":"Bollywood","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/bollywood\/","type":"category","parent":131},{"id":132,"name":"Gaming","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/gaming\/","type":"category","parent":131},{"id":8835,"name":"Hollywood","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/hollywood\/","type":"category","parent":131},{"id":133,"name":"Movie","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/movie\/","type":"category","parent":131},{"id":163,"name":"Music","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/music\/","type":"category","parent":131},{"id":8264,"name":"TV Serial","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/tv-serial\/","type":"category","parent":131},{"id":99,"name":"Web Series","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/web-series\/","type":"category","parent":131}]},{"id":92,"name":"Handloom &amp; Handicraft","link":"https:\/\/www.alwaysfirst.in\/category\/handloom-and-handicraft\/","type":"category"},{"id":159,"name":"Health","link":"https:\/\/www.alwaysfirst.in\/category\/health\/","type":"category","children":[{"id":5996,"name":"Covid","link":"https:\/\/www.alwaysfirst.in\/category\/health\/covid\/","type":"category","parent":159},{"id":157,"name":"Covid -19 Updates","link":"https:\/\/www.alwaysfirst.in\/category\/health\/covid-19-updates\/","type":"category","parent":159},{"id":8237,"name":"Fitness","link":"https:\/\/www.alwaysfirst.in\/category\/health\/fitness\/","type":"category","parent":159},{"id":8236,"name":"Hospital","link":"https:\/\/www.alwaysfirst.in\/category\/health\/hospital\/","type":"category","parent":159},{"id":12848,"name":"Medicine","link":"https:\/\/www.alwaysfirst.in\/category\/health\/medicine\/","type":"category","parent":159},{"id":8238,"name":"Yoga","link":"https:\/\/www.alwaysfirst.in\/category\/health\/yoga\/","type":"category","parent":159}]},{"id":8403,"name":"India","link":"https:\/\/www.alwaysfirst.in\/category\/india\/","type":"category"},{"id":5433,"name":"International","link":"https:\/\/www.alwaysfirst.in\/category\/international\/","type":"category","children":[{"id":8267,"name":"Agreement","link":"https:\/\/www.alwaysfirst.in\/category\/international\/agreement\/","type":"category","parent":5433},{"id":12853,"name":"Diplomacy","link":"https:\/\/www.alwaysfirst.in\/category\/international\/diplomacy\/","type":"category","parent":5433},{"id":8266,"name":"Foreign Policy","link":"https:\/\/www.alwaysfirst.in\/category\/international\/foreign-policy\/","type":"category","parent":5433},{"id":8268,"name":"Travel","link":"https:\/\/www.alwaysfirst.in\/category\/international\/travel-international\/","type":"category","parent":5433}]},{"id":27,"name":"Lifestyle","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/","type":"category","children":[{"id":2541,"name":"Art &amp; Design","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/art-and-design\/","type":"category","parent":27},{"id":107,"name":"Beauty","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/beauty\/","type":"category","parent":27},{"id":8265,"name":"Documentation","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/documentation\/","type":"category","parent":27},{"id":106,"name":"Fashion","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/fashion\/","type":"category","parent":27},{"id":12854,"name":"Human Interest","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/human-interest\/","type":"category","parent":27},{"id":124,"name":"Recipes &amp; Food","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/recipes-and-food\/","type":"category","parent":27},{"id":43,"name":"Tourism &amp; Travel","link":"https:\/\/www.alwaysfirst.in\/category\/lifestyle\/tourism-and-travel\/","type":"category","parent":27}]},{"id":47,"name":"Metropolitan","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/","type":"category","children":[{"id":48,"name":"Ahmedabad","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/ahmedabad\/","type":"category","parent":47},{"id":8222,"name":"Bengaluru","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/bengaluru\/","type":"category","parent":47},{"id":8224,"name":"Chennai","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/chennai\/","type":"category","parent":47},{"id":93,"name":"Guwahati","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/guwahati\/","type":"category","parent":47},{"id":8228,"name":"Hyderabad","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/hyderabad\/","type":"category","parent":47},{"id":8223,"name":"Kolkata","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/kolkata\/","type":"category","parent":47},{"id":8221,"name":"Mumbai","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/mumbai\/","type":"category","parent":47},{"id":50,"name":"New Delhi","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/new-delhi\/","type":"category","parent":47},{"id":8225,"name":"Pune","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/pune\/","type":"category","parent":47},{"id":8229,"name":"Surat","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/surat\/","type":"category","parent":47},{"id":8230,"name":"Vishakhapatnam","link":"https:\/\/www.alwaysfirst.in\/category\/metropolitan\/vishakhapatnam\/","type":"category","parent":47}]},{"id":2553,"name":"More","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/","type":"category","children":[{"id":12861,"name":"Accident","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/accident\/","type":"category","parent":2553},{"id":12863,"name":"Agriculture","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/agriculture\/","type":"category","parent":2553},{"id":164,"name":"Astrology","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/astrology\/","type":"category","parent":2553},{"id":12860,"name":"Disaster","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/disaster\/","type":"category","parent":2553},{"id":3490,"name":"Featured Stories","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/featured-stories\/","type":"category","parent":2553},{"id":12857,"name":"Festival","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/festival\/","type":"category","parent":2553},{"id":12859,"name":"General","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/general\/","type":"category","parent":2553},{"id":101,"name":"Highlight","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/highlight\/","type":"category","parent":2553},{"id":12862,"name":"Immigration","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/immigration\/","type":"category","parent":2553},{"id":11872,"name":"live","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/live\/","type":"category","parent":2553},{"id":8272,"name":"Natural Calamities","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/natural-calamities\/","type":"category","parent":2553},{"id":160,"name":"Religion","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/religion\/","type":"category","parent":2553},{"id":12858,"name":"Society","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/society\/","type":"category","parent":2553},{"id":5995,"name":"Tollywood","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/tollywood\/","type":"category","parent":2553},{"id":3632,"name":"Videos","link":"https:\/\/www.alwaysfirst.in\/category\/covid-astrology-religian\/videos\/","type":"category","parent":2553}]},{"id":8444,"name":"National","link":"https:\/\/www.alwaysfirst.in\/category\/national-2\/","type":"category"},{"id":5648,"name":"Politics","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/","type":"category","children":[{"id":8273,"name":"Election","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/election\/","type":"category","parent":5648},{"id":8276,"name":"Meeting &amp; Rally","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/meeting-rally\/","type":"category","parent":5648},{"id":8275,"name":"National Policy","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/national-policy\/","type":"category","parent":5648},{"id":8274,"name":"State Policy","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/state-policy\/","type":"category","parent":5648}]},{"id":54,"name":"Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/","type":"category","children":[{"id":8293,"name":"Central Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/central-region\/","type":"category","parent":54},{"id":8290,"name":"Eastern Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/eastern-region\/","type":"category","parent":54},{"id":5430,"name":"National","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/national\/","type":"category","parent":54},{"id":8288,"name":"NE Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/ne-region\/","type":"category","parent":54},{"id":8291,"name":"Northern Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/northern-region\/","type":"category","parent":54},{"id":8292,"name":"Southern Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/southern-region\/","type":"category","parent":54},{"id":8289,"name":"Western Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/western-region\/","type":"category","parent":54}]},{"id":2639,"name":"Science","link":"https:\/\/www.alwaysfirst.in\/category\/science\/","type":"category","children":[{"id":8246,"name":"Animal &amp; Wild life","link":"https:\/\/www.alwaysfirst.in\/category\/science\/animal-and-wild-life\/","type":"category","parent":2639},{"id":8242,"name":"Discovery","link":"https:\/\/www.alwaysfirst.in\/category\/science\/discovery\/","type":"category","parent":2639},{"id":12849,"name":"Environment","link":"https:\/\/www.alwaysfirst.in\/category\/science\/environment\/","type":"category","parent":2639},{"id":8241,"name":"Research","link":"https:\/\/www.alwaysfirst.in\/category\/science\/research\/","type":"category","parent":2639},{"id":126,"name":"Technology","link":"https:\/\/www.alwaysfirst.in\/category\/science\/technology\/","type":"category","parent":2639},{"id":8245,"name":"Testing","link":"https:\/\/www.alwaysfirst.in\/category\/science\/testing-science\/","type":"category","parent":2639},{"id":12850,"name":"Weather &amp; Temperature","link":"https:\/\/www.alwaysfirst.in\/category\/science\/weather-temperature\/","type":"category","parent":2639}]},{"id":16,"name":"Sports","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/","type":"category","children":[{"id":12855,"name":"Athletics","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/athletics\/","type":"category","parent":16},{"id":17,"name":"Cricket","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/cricket\/","type":"category","parent":16},{"id":20,"name":"Football","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/football\/","type":"category","parent":16},{"id":909,"name":"Game &amp; Sports","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/game-and-sports\/","type":"category","parent":16},{"id":8279,"name":"Hockey","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/hockey\/","type":"category","parent":16},{"id":8280,"name":"International","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/international-sports\/","type":"category","parent":16},{"id":850,"name":"IPL","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/ipl\/","type":"category","parent":16},{"id":8281,"name":"National","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/national-sports\/","type":"category","parent":16}]}]';
        $json_data = json_decode($json_data, true);
        return $json_data;
    }
    public function getMenuCategory()
    {
        $json_data =
            '[{"name":"Business","link":"https:\/\/www.alwaysfirst.in\/category\/business\/","id":36,"type":"category"},{"name":"Continents","link":"https:\/\/www.alwaysfirst.in\/category\/continents\/","id":65,"type":"category"},{"name":"Entertainment","link":"https:\/\/www.alwaysfirst.in\/category\/entertainment\/","id":131,"type":"category"},{"name":"Politics","link":"https:\/\/www.alwaysfirst.in\/category\/politics\/","id":5648,"type":"category"},{"name":"Region","link":"https:\/\/www.alwaysfirst.in\/category\/region-india\/","id":54,"type":"category"},{"name":"Sports","link":"https:\/\/www.alwaysfirst.in\/category\/sports\/","id":16,"type":"category"}]';
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
            'icon' => 'fa fa-facebook'
        );
        $links[] = array(
            'name' => 'Twitter',
            'link' => 'https://twitter.com/alwaysFTweets',
            'icon' => 'fa fa-twitter'
        );
        $links[] = array(
            'name' => 'Instagram',
            'link' => 'https://www.instagram.com/officialalwaysfirst/',
            'icon' => 'fa fa-instagram'
        );
        $links[] = array(
            'name' => 'Youtube',
            'link' => 'https://www.youtube.com/channel/UCgnOc1a4uPHuityfGou3tLg',
            'icon' => 'fa fa-youtube'
        );
        $links[] = array(
            'name' => 'pinterest',
            'link' => 'https://pinterest.com/alwaysfirst501',
            'icon' => 'fa fa-pinterest'
        );
        $links[] = array(
            'name' => 'linkedin',
            'link' => 'https://www.linkedin.com/company/always-first/',
            'icon' => 'fa fa-linkedin'
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

    // Advertisement API
    public function getAds()
    {
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/04/27-April-to-7-May.jpeg.png',
            'redirect' => 'off',
            'link' => 'https://www.alwaysfirst.in/',
        );
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/03/Gandhi-Shilp-Bazar-2.png',
            'redirect' => 'on',
            'link' => 'https://www.alwaysfirst.in/',
        );
        return $adsArray;
        $none = null;
        // return $none;
    }
    public function getAdsArticle()
    {
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/04/27-April-to-7-May.jpeg.png',
            'redirect' => 'on',
            'link' => 'https://www.alwaysfirst.in/',
        );
        $adsArray[] = array(
            'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/03/Gandhi-Shilp-Bazar-2.png',
            'redirect' => 'off',
            'link' => 'https://www.alwaysfirst.in/',
        );
        return $adsArray;
        $none = null;
        // return $none;
    }
    public function getScriptAds()
    {
        $adsArray[] = array(
            'script' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>',
        );
        $adsArray[] = array(
            'script' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>',
        );
        return $adsArray;
        $none = null;
        // return $none;
    }
}

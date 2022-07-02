<?php
defined('BASEPATH') or exit('No direct script access allowed');


class PostModel extends CI_Model
{
    public function Ads(){
        $result = array(
                'image' => 'https://www.alwaysfirst.in/wp-content/uploads/2022/05/WhatsApp-Image-2022-05-07-at-7.35.15-AM.jpeg',
                'redirect' => 'off',
                'link' => 'https://www.alwaysfirst.in/'
        );
        return $result;
    }
    public function baseUrl()
    {
        $base_url = 'http://localhost/newsify/';
        return $base_url;
        // return $this->config->base_url();
    }
    public function get_permalink($id)
    {
        $query = $this->db->query("SELECT post_name FROM wp_posts WHERE ID = '$id'");
        $data = $query->result_array();
        $post_name = $data[0]['post_name'];
        return $this->baseUrl() . $post_name;
    }
    public function getThumbnailImage($Image)
    {
        $feature_image_thumb = explode('.', $Image);
        $feature_image_thumb[count($feature_image_thumb) - 2] = $feature_image_thumb[count($feature_image_thumb) - 2] . '-150x150';
        $feature_image_thumb = implode('.', $feature_image_thumb);
        return $feature_image_thumb;
    }
    public function getDataFromSql($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $ads = $this->Ads();
        $per_page = $per_page ? $per_page : 50;
        $page = $page ? $page : 1;
        $start = ($page - 1) * $per_page;
        $end = $per_page;
        $per_page_sql = "LIMIT $start, $end";
        // DONE: get category
        $category_sql = $category_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$category_get') = $category_get" : '';
        // DONE: search
        $search_sql = $search_get ? "AND (post_title LIKE '%$search_get%' OR post_content LIKE '%$search_get%')" : '';
        // DONE: author
        $author_sql = $author_get ? "AND post_author = '$author_get'" : '';
        // DONE: tags
        $tags_sql = $tags_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$tags_get') = $tags_get" : '';
        // Wordpress query
        $query = $this->db->query("SELECT DISTINCT id,
                            post_title,post_content,post_modified,
                            post_author AS author_id,
                            ( SELECT display_name FROM wp_users WHERE ID = post_author) AS author_name,
                            ( SELECT pm2.meta_value FROM `wp_posts` AS p INNER JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file' AND pm1.meta_key = '_thumbnail_id' WHERE p.id = wp_posts.ID) AS feature_image,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories_id,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags_id
                        FROM wp_posts
                        WHERE
                            post_type = 'post'
                            AND post_status = 'publish'
                            $category_sql
                            $search_sql
                            $author_sql
                            $tags_sql
                        ORDER BY post_modified DESC $per_page_sql");
        $data = $query->result_array();

        foreach ($data as $key => $value) {
            $id = (int)$value['id'];            
            $post_content = $value['post_content'];
            // Strip HTML comments
            $post_content = preg_replace('/<!--(.|\s)*?-->/', '', $post_content);
            // Strip script tags
            $post_content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $post_content);
            // Strip br tags
            $post_content = preg_replace('/<br\s*\/?>/i', "\n\n", $post_content);
            // Strip HTML tags 
            $post_content = strip_tags($post_content, '<img><iframe>');
            $post_content = strip_tags($post_content, '');
            // Ignore 61 characters from the start of the post
            if (str_contains($value['Categories_id'], '3632')) { 
            }else{
                $post_content = substr($post_content, 61);
            }
            // Remove ad tags
            $post_content = str_replace("[ad_1]", "", $post_content);
            $post_content = str_replace("[ad_2]", "", $post_content);
            // trim the post content
            $post_content = trim($post_content);
            // Remove brackets from the post content
            $post_content = preg_replace('/\([^)]*\)/', '', $post_content);
            // remove \r\n from the post content
            $post_content = str_replace("\r\n", "", $post_content);
            // remove &nbsp; from the post content
            $post_content = str_replace("&nbsp;", "", $post_content);

            $feature_image = $value['feature_image'];
            // Feature thumbnail image
            $feature_image_thumb = $this->getThumbnailImage($feature_image);
            // Modified date
            $date = $value['post_modified'];
            $date = str_replace(' ', 'T', $date);
            $post_data = array(
                'title' => $value['post_title'],
                'content' => $post_content,
                'date' => $date,
                'feature_image' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image,
                'feature_image_thumb' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image_thumb
            );
            $author = array(
                'id' => (int)$value['author_id'],
                'name' => $value['author_name']
            );
            if ($value['Categories']) {
                $cat_name = explode(',', $value['Categories']);
                $cat_id = explode(',', $value['Categories_id']);
                $cat_slug = explode(',', $value['Categories_slug']);
                $categories = array();
                for ($i = 0; $i < count($cat_name); $i++) {
                    $categories[] = array(
                        'id' => (int)trim($cat_id[$i]),
                        'name' => trim($cat_name[$i])
                    );
                }
            } else {
                $categories = array();
            }
            if ($value['Tags']) {
                $tags_name = explode(',', $value['Tags']);
                $tags_id = explode(',', $value['Tags_id']);
                $tags_slug = explode(',', $value['Tags_slug']);
                $tags = array();
                for ($i = 0; $i < count($tags_name); $i++) {
                    $tags[] = array(
                        'id' => (int)trim($tags_id[$i]),
                        'name' => trim($tags_name[$i])
                    );
                }
            } else {
                $tags = array();
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $categories,
                'tags' => $tags
            );
        }
        foreach($result as $key => $value){
                $newI = $key;
                $rel1 = ($newI+2)>=count($result) ? $newI+2 - count($result) : $newI+2;
                $rel2 = ($newI+3)>=count($result) ? $newI+3 - count($result) : $newI+3;
                $post_data = array(
                    'id' => $result[$newI]['id'],
                    'post_data' => $result[$newI]['post_data'],
                    'author' => $result[$newI]['author'],
                    'category' => $result[$newI]['category'],
                    'tags' => $result[$newI]['tags'],
                    'ads'=> $ads,
                    'related_posts' => array(
                            array(
                                'id' => $result[$rel1]['id'],
                                'post_data' => $result[$rel1]['post_data'],
                                'author' => $result[$rel1]['author'],
                                'category' => $result[$rel1]['category'],
                                'tags' => $result[$rel1]['tags']
                            ),
                            array(
                                'id' => $result[$rel2]['id'],
                                'post_data' => $result[$rel2]['post_data'],
                                'author' => $result[$rel2]['author'],
                                'category' => $result[$rel2]['category'],
                                'tags' => $result[$rel2]['tags']
                            ),
                        )
                    );
            $final_result[] = $post_data;
            unset($post_data);
        }
        return $final_result;
    }
    public function videos($per_page, $page, $category_get, $search_get, $author_get, $tags_get){
        $search_get = '[embed';
        $data = $this->getDataFromSql($per_page, $page, $category_get, $search_get, $author_get, $tags_get);
        foreach ($data as $key => $value) {
            $embed = $value['post_data']['content'];
            $post_content = preg_replace('/\[embed(.*?)\](.*?)\[\/embed\]/', '', $value['post_data']['content']);
            // remove \r\n from the post content
            $post_content = str_replace("\r\n", "", $post_content);
            // remove nbsp; from the post content
            $post_content = str_replace("&nbsp;", "", $post_content);
            // find text between embed tags
            // $embed = preg_match('/\[embed.*?\]/', $embed, $matches);
            preg_match('/\[embed\](.*)\[\/embed\]/', $embed, $matches);
            $url = $matches[1];
            // $url = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $url);
            $url = str_replace('https://youtu.be/', '', $url);
            $url = str_replace('http://youtu.be/', '', $url);
            $url = str_replace('https://www.youtube.com/watch?v=', '', $url);
            $url_embed = 'https://youtu.be/'.$url;
            $url_embed2 = 'https://www.youtube.com/embed/'.$url;
            if (isset($matches[1])) {
                $result[] = array(
                    'id' => $value['id'],
                    'title' => $value['post_data']['title'],
                    'post_content' =>$post_content,
                    'category' => $value['category'],
                    'date' => $value['post_data']['date'],
                    'embed' => $url,
                    'embed1' => $url_embed,
                    'embed2' => $url_embed2,
                );
            }
        }
        return $result;
    }
    public function getDataFromSqlRelated($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $per_page = $per_page ? $per_page : 50;
        $page = $page ? $page : 1;
        $start = ($page - 1) * $per_page;
        $end = $per_page;
        $per_page_sql = "LIMIT $start, $end";
        // DONE: get category
        $category_sql = $category_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$category_get') = $category_get" : '';
        // DONE: search
        $search_sql = $search_get ? "AND (post_title LIKE '%$search_get%' OR post_content LIKE '%$search_get%')" : '';
        // DONE: author
        $author_sql = $author_get ? "AND post_author = '$author_get'" : '';
        // DONE: tags
        $tags_sql = $tags_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$tags_get') = $tags_get" : '';
        // Wordpress query
        $query = $this->db->query("SELECT DISTINCT id,
                            post_title,post_content,post_modified,
                            post_author AS author_id,
                            ( SELECT display_name FROM wp_users WHERE ID = post_author) AS author_name,
                            ( SELECT pm2.meta_value FROM `wp_posts` AS p INNER JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file' AND pm1.meta_key = '_thumbnail_id' WHERE p.id = wp_posts.ID) AS feature_image,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories_id,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags_id
                        FROM wp_posts
                        WHERE
                            post_type = 'post'
                            AND post_status = 'publish'
                            $category_sql
                            $search_sql
                            $author_sql
                            $tags_sql
                        ORDER BY post_modified DESC $per_page_sql");
        $data = $query->result_array();

        foreach ($data as $key => $value) {
            $id = (int)$value['id'];            
            $post_content = $value['post_content'];
            // Strip HTML comments
            $post_content = preg_replace('/<!--(.|\s)*?-->/', '', $post_content);
            // Strip script tags
            $post_content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $post_content);
            // Strip br tags
            $post_content = preg_replace('/<br\s*\/?>/i', "\n\n", $post_content);
            // Strip HTML tags 
            $post_content = strip_tags($post_content, '<img><iframe>');
            // Ignore 61 characters from the start of the post
            if (str_contains($value['Categories_id'], '3632')) { 
            }else{
                $post_content = substr($post_content, 61);
            }
            // Remove ad tags
            $post_content = str_replace("[ad_1]", "", $post_content);
            $post_content = str_replace("[ad_2]", "", $post_content);
            // trim the post content
            $post_content = trim($post_content);
            // Remove brackets from the post content
            $post_content = preg_replace('/\([^)]*\)/', '', $post_content);

            $feature_image = $value['feature_image'];
            // Feature thumbnail image
            $feature_image_thumb = $this->getThumbnailImage($feature_image);
            // Modified date
            $date = $value['post_modified'];
            $date = str_replace(' ', 'T', $date);
            $post_data = array(
                'title' => $value['post_title'],
                'content' => $post_content,
                'date' => $date,
                'feature_image' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image,
                'feature_image_thumb' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image_thumb
            );
            $author = array(
                'id' => (int)$value['author_id'],
                'name' => $value['author_name']
            );
            if ($value['Categories']) {
                $cat_name = explode(',', $value['Categories']);
                $cat_id = explode(',', $value['Categories_id']);
                $cat_slug = explode(',', $value['Categories_slug']);
                $categories = array();
                for ($i = 0; $i < count($cat_name); $i++) {
                    $categories[] = array(
                        'id' => (int)trim($cat_id[$i]),
                        'name' => trim($cat_name[$i])
                    );
                }
            } else {
                $categories = array();
            }
            if ($value['Tags']) {
                $tags_name = explode(',', $value['Tags']);
                $tags_id = explode(',', $value['Tags_id']);
                $tags_slug = explode(',', $value['Tags_slug']);
                $tags = array();
                for ($i = 0; $i < count($tags_name); $i++) {
                    $tags[] = array(
                        'id' => (int)trim($tags_id[$i]),
                        'name' => trim($tags_name[$i])
                    );
                }
            } else {
                $tags = array();
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $categories,
                'tags' => $tags
            );
        }
        foreach($result as $key => $value){
            $arrayPosts = 7;
            for($i = 0; $i < $arrayPosts; $i++){
                $newI = ($key + $i)>=count($result) ? $key + $i - count($result) : $key + $i;
                $rel1 = ($newI+2)>=$arrayPosts ? $newI+2 - $arrayPosts : $newI+2;
                $rel2 = ($newI+3)>=$arrayPosts ? $newI+3 - $arrayPosts : $newI+3;
                $post_data = array(
                    'id' => $result[$newI]['id'],
                    'post_data' => $result[$newI]['post_data'],
                    'author' => $result[$newI]['author'],
                    'category' => $result[$newI]['category'],
                    'tags' => $result[$newI]['tags'],
                    'related_posts' => array(
                        array(
                            'id' => $result[$rel1]['id'],
                            'post_data' => $result[$rel1]['post_data'],
                            'author' => $result[$rel1]['author'],
                            'category' => $result[$rel1]['category'],
                            'tags' => $result[$rel1]['tags']
                        ),
                        array(
                            'id' => $result[$rel2]['id'],
                            'post_data' => $result[$rel2]['post_data'],
                            'author' => $result[$rel2]['author'],
                            'category' => $result[$rel2]['category'],
                            'tags' => $result[$rel2]['tags']
                        ),
                    )
                    );
                $demoArray[] = $post_data;
            }
            $final_result[] = $demoArray;
            unset($demoArray);
        }
        return $final_result;
    }
    public function getDataFromSqlTest($per_page, $page, $category_get, $search_get, $author_get, $tags_get)
    {
        $per_page = $per_page ? $per_page : 50;
        $page = $page ? $page : 1;
        $start = ($page - 1) * $per_page;
        $end = $per_page;
        $per_page_sql = "LIMIT $start, $end";
        // DONE: get category
        $category_sql = $category_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$category_get') = $category_get" : '';
        // DONE: search
        $search_sql = $search_get ? "AND (post_title LIKE '%$search_get%' OR post_content LIKE '%$search_get%')" : '';
        // DONE: author
        $author_sql = $author_get ? "AND post_author = '$author_get'" : '';
        // DONE: tags
        $tags_sql = $tags_get ? "AND ( SELECT DISTINCT wp_terms.term_id FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr ON wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' AND wp_posts.ID = wpr.object_id  AND wp_term_taxonomy.term_taxonomy_id = '$tags_get') = $tags_get" : '';
        // Wordpress query
        $query = $this->db->query("SELECT DISTINCT id,
                            post_title,post_content,post_modified,
                            post_author AS author_id,
                            ( SELECT display_name FROM wp_users WHERE ID = post_author) AS author_name,
                            ( SELECT pm2.meta_value FROM `wp_posts` AS p INNER JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file' AND pm1.meta_key = '_thumbnail_id' WHERE p.id = wp_posts.ID) AS feature_image,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS Categories_id,
                            ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags,
                            ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS Tags_id
                        FROM wp_posts
                        WHERE
                            post_type = 'post'
                            AND post_status = 'publish'
                            $category_sql
                            $search_sql
                            $author_sql
                            $tags_sql
                        ORDER BY post_modified DESC $per_page_sql");
        $data = $query->result_array();

        foreach ($data as $key => $value) {
            $id = (int)$value['id'];            
            $post_content = $value['post_content'];
            // Strip HTML comments
            $post_content = preg_replace('/<!--(.|\s)*?-->/', '', $post_content);
            // Strip script tags
            $post_content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $post_content);
            // Strip br tags
            $post_content = preg_replace('/<br\s*\/?>/i', "\n\n", $post_content);
            // Strip HTML tags 
            $post_content = strip_tags($post_content, '<img><iframe>');
            // Ignore 61 characters from the start of the post
            if (str_contains($value['Categories_id'], '3632')) { 
            }else{
                $post_content = substr($post_content, 61);
            }
            // Remove ad tags
            $post_content = str_replace("[ad_1]", "", $post_content);
            $post_content = str_replace("[ad_2]", "", $post_content);
            // trim the post content
            $post_content = trim($post_content);
            // Remove brackets from the post content
            $post_content = preg_replace('/\([^)]*\)/', '', $post_content);

            $feature_image = $value['feature_image'];
            // Feature thumbnail image
            $feature_image_thumb = $this->getThumbnailImage($feature_image);
            // Modified date
            $date = $value['post_modified'];
            $date = str_replace(' ', 'T', $date);
            $post_data = array(
                'title' => $value['post_title'],
                'content' => $post_content,
                'date' => $date,
                'feature_image' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image,
                'feature_image_thumb' => $this->baseUrl() . 'wp-content/uploads/' . $feature_image_thumb
            );
            $author = array(
                'id' => (int)$value['author_id'],
                'name' => $value['author_name']
            );
            if ($value['Categories']) {
                $cat_name = explode(',', $value['Categories']);
                $cat_id = explode(',', $value['Categories_id']);
                $cat_slug = explode(',', $value['Categories_slug']);
                $categories = array();
                for ($i = 0; $i < count($cat_name); $i++) {
                    $categories[] = array(
                        'id' => (int)trim($cat_id[$i]),
                        'name' => trim($cat_name[$i])
                    );
                }
            } else {
                $categories = array();
            }
            if ($value['Tags']) {
                $tags_name = explode(',', $value['Tags']);
                $tags_id = explode(',', $value['Tags_id']);
                $tags_slug = explode(',', $value['Tags_slug']);
                $tags = array();
                for ($i = 0; $i < count($tags_name); $i++) {
                    $tags[] = array(
                        'id' => (int)trim($tags_id[$i]),
                        'name' => trim($tags_name[$i])
                    );
                }
            } else {
                $tags = array();
            }
            $result[] = array(
                'id' => $id,
                'post_data' => $post_data,
                'author' => $author,
                'category' => $categories,
                'tags' => $tags
            );
        }
        foreach($result as $key => $value){
                $newI = $key;
                $rel1 = ($newI+2)>=count($result) ? $newI+2 - count($result) : $newI+2;
                $rel2 = ($newI+3)>=count($result) ? $newI+3 - count($result) : $newI+3;
                $post_data = array(
                    'id' => $result[$newI]['id'],
                    'post_data' => $result[$newI]['post_data'],
                    'author' => $result[$newI]['author'],
                    'category' => $result[$newI]['category'],
                    'tags' => $result[$newI]['tags'],
                    'related_posts' => array(
                        array(
                            'id' => $result[$rel1]['id'],
                            'post_data' => $result[$rel1]['post_data'],
                            'author' => $result[$rel1]['author'],
                            'category' => $result[$rel1]['category'],
                            'tags' => $result[$rel1]['tags']
                        ),
                        array(
                            'id' => $result[$rel2]['id'],
                            'post_data' => $result[$rel2]['post_data'],
                            'author' => $result[$rel2]['author'],
                            'category' => $result[$rel2]['category'],
                            'tags' => $result[$rel2]['tags']
                        ),
                    )
                    );
            $final_result[] = $post_data;
            unset($post_data);
        }
        return $final_result;
    }
}
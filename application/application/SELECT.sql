SELECT
    DISTINCT id,
    post_title,
    post_content,
    post_modified,
    post_author AS author_id,
    ( SELECT display_name FROM wp_users WHERE ID = post_author) AS author_name,
    ( SELECT pm2.meta_value FROM `wp_posts` AS p INNER JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file' AND pm1.meta_key = '_thumbnail_id' WHERE p.id = wp_posts.ID) AS feature_image,
    -- ( SELECT pm2.meta_value FROM `wp_posts` AS p INNER JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file' AND pm1.meta_key = '_thumbnail_id' WHERE p.id = wp_posts.ID ) AS feature_image_thumb,
    ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id ) AS "Categories",
    ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'category' and wp_posts.ID = wpr.object_id) AS "Categories_id",
    ( SELECT group_concat(wp_terms.name separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS "Tags",
    ( SELECT group_concat(wp_terms.term_id separator ', ') FROM wp_terms INNER JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id INNER JOIN wp_term_relationships wpr on wpr.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id WHERE taxonomy = 'post_tag' and wp_posts.ID = wpr.object_id) AS "Tags_id"
FROM
    wp_posts
WHERE
    post_type = 'post'
ORDER BY
    post_date DESC
LIMIT
    10;

    -- SELECT
    -- id,
    -- post_title,
    -- post_content,
    -- link,
    -- post_modified,
    -- feature_image,
    -- feature_image_thumb,
    -- feature_image_medium,
    -- author_id,
    -- author_name,
    -- category_name,
    -- category_id,
    -- tags_name,
    -- tags_id
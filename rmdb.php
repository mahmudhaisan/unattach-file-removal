<?php

/**
 * Plugin Name: Remove files from db
 * Plugin URI: https://github.com/mahmudhaisan
 * Description: emove files from db
 * Version: 1.0
 * Author: Mahmud haisan
 * Author URI: http://mahmudhaisan.com/
 * Developer: Mahmud Haisan
 * Developer URI: http://mahmudhaisan.com/
 * Text Domain: rmdb493
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


if (!defined('ABSPATH')) {
    die;
}


function rmdb()
{

    // duplicate_posts();
    duplicate_items_query();
}






function duplicate_posts()
{

    global $wpdb;
    $results = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'attachment',
        'order' => "ASC"
    ));

    /**
     * duplicate one post in 4 time
     */
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 4; $j++) {
            $post_name = $results[$i]->post_name;
            $post_title = $results[$i]->post_title;
            $post_guid = $results[$i]->guid;
            $post_type = $results[$i]->post_type;
            $post_mime_type = $results[$i]->post_mime_type;
            $db_insertation = $wpdb->insert('wp_posts', array(
                'post_name' => $post_name,
                'post_title' => $post_title,
                'guid' => $post_guid,
                'post_type' => $post_type, // ... and so on
                'post_mime_type' => $post_mime_type, // ... and so on
            ));
        }

        print_r($db_insertation);
    }
}




function duplicate_items_query()
{
    global $wpdb;
    $duplicate_items_count = $wpdb->get_results("SELECT guid,Count(*) FROM wp_posts GROUP BY guid HAVING count(*)>1");
    $duplicate_items_value = $wpdb->get_results("SELECT DISTINCT (wp_posts.`post_title`) FROM wp_posts");

    echo '<pre>';

    // showing field value and its total count
    // print_r($duplicate_items_count);

    //showing duplicate items value
    print_r($duplicate_items_value);

    echo '</pre>';
}






add_shortcode('shortcode', 'rmdb');

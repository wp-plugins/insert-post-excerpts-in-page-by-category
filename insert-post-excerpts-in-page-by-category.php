<?php

/*
 * Plugin Name: Insert Post Excerpts in Page by Category
 * Description: Allows a user to insert post excerpts in a similar manner to category view or posts view on any page.
 * Version: 1.0
 * Author: ITS Alaska
 * Author URI: http://ITSCanFixThat.com/
 * Plugin URI: http://plugins.svn.wordpress.org/insert-post-excerpts-in-page-by-category/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Shortcode insert-posts
 * Example usage:
 * [insert-posts categories="1,2,3" limit=5 order_by="post_date"]
 * All fields are optional.
 */

class insert_post_excerpts_in_page_by_category {
    
    /*
     * Constructor: adds a hook for the shortcode which calls the "display"
     * function
     */
    public function __construct() {
        add_shortcode('insert-posts',array(
            'insert_post_excerpts_in_page_by_category',
            'insert'
        ));
    }
    
    /*
     * Insert: core of the plugin, inserts post excerpts in page by category.
     */
    public function insert($atts) {
        
        // Extract the shortcode variables
        extract(shortcode_atts(array(
            'categories' => false,
            'limit' => 5,
            'orderby' => 'post_date'
        ), $atts));
        
        // Populate the get_posts array
        $get_posts_array = array();
        if ($categories) $get_posts_array['category'] = $categories;
        $get_posts_array['numberposts'] = $limit;
        $get_posts_array['orderby'] = $order_by;
        
        // Call the get_posts function to get the array of objects
        $posts_array = get_posts($get_posts_array);
        
        // Display the posts
        if ($posts_array) {
            foreach( $posts_array as $post_object ) {
                setup_postdata( $post_object );
                $return_data =  "<div class='post'>";
                
                $return_data .= "<h3>";
                $return_data .= "<a href='";
                $return_data .= get_permalink($post_object->ID);
                $return_data .= "'>";
                $return_data .= $post_object->post_title;
                $return_data .= "</a>";
                $return_data .= "</h3>";
                
                $return_data .= get_the_excerpt();
                
                $return_data .= "<br />";
                $return_data .= "<a href='";
                $return_data .= get_permalink($post_object->ID);
                $return_data .= "' rel='bookmark'>";
                $return_data .= "Read more &raquo;";
                $return_data .= "</a>";
                
                $return_data .= "</div>";
            }
        }
        
        return $return_data;
        
    }
    
}

new insert_post_excerpts_in_page_by_category();

?>
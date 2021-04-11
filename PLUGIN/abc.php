<?php

/*
Plugin Name: ABC
Plugin URI: 
Description: 
Author: L
Version: 1.7.2
Author URI:
*/
register_activation_hook(__FILE__, 'si_activation');
register_deactivation_hook(__FILE__, 'si_deactivation');
register_uninstall_hook(__FILE__, 'si_delete');

function si_activation(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'si_settings';
    if($wpdb->get_var("SHOW TABLE LIKE $table_name") !== $table_name){
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name`(
            `msg_text` text NOT NULL
        ) CHARSET=utf8";
        $wpdb->query($sql);
        $wpdb->query("INSERT INTO `$table_name` (`msg_text`) VALUES('Hello World)");
    }

}

function si_deactivation(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'si_settings';
    $wpdb->query("DELETE FROM $table_name");
}

function si_delete(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'si_settings';
    $wpdb->query("DROP TABLE $table_name");
}

add_action('wp_footer', function(){
  echo '<p class="ABC"></p>';
});
?>
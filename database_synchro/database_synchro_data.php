<?php
/**
 * Created by PhpStorm.
 * User: unflux
 * Date: 04/05/18
 * Time: 14:51
 */

class Database_Synchro_Data
{
    public static function install(){
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cga_sync_info (id INT AUTO_INCREMENT PRIMARY KEY, info_name VARCHAR(255), info_value VARCHAR(255));");
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'last_sync', 'id' => 1));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_key', 'id' => 2));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_url', 'id' => 3, 'info_value' => 'http://www.concours-agricole.com/api/palmares'));
    }

    public static function uninstall()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cga_sync_info;");
    }

    public static function changeApiKey($api){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $api), array('info_name' => 'api_key'));
    }

    public static function changeApiUrl($url){
        global $wpdb;
        $url = rtrim($url, '/');
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $url), array('info_name' => 'api_url'));
    }

    public static function changeLastSync(){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => current_time( 'mysql' )), array('info_name' => 'last_sync'));
        return 1;
    }

    public static function selectAll(){
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}cga_sync_info");
    }

    public static function traitementRender($api){
    $json_string = file_get_contents( $api);
    return $parsed_json = json_decode($json_string);
    }
}
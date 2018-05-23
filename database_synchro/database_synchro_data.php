<?php
class Database_Synchro_Data
{
    /*
     * Installation of the database
     */
    public static function install(){
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cga_sync_info (id INT AUTO_INCREMENT PRIMARY KEY, info_name VARCHAR(255), info_value VARCHAR(255));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours ( `id` INT NOT NULL, `libelle` TEXT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_annee (`id_concours` INT NOT NULL , `annee` INT NOT NULL , PRIMARY KEY (`id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` INT NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region_administrative ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` INT NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_categorie_vins ( `id_region` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, PRIMARY KEY (`id_region`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_type_appellation ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, `annee` INT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'last_sync', 'id' => 1));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_key', 'id' => 2));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_url', 'id' => 3, 'info_value' => 'http://www.concours-agricole.com/api/palmares'));
    }

    /*
     * Uninstallation of the database
     */
    public static function uninstall()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cga_sync_info;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region_administrative;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_categorie_vins;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_type_appellation;");
    }

    /*
     * Change the Api Key in the database
     */
    public static function changeApiKey($api){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $api), array('info_name' => 'api_key'));
    }

    /*
     * Change the Api url in the database
     */
    public static function changeApiUrl($url){
        global $wpdb;
        $url = rtrim($url, '/');
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $url), array('info_name' => 'api_url'));
    }

    /*
     * Change the date of last synchronization
     */
    public static function changeLastSync(){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => current_time( 'mysql' )), array('info_name' => 'last_sync'));
    }

    /*
     * Select the date of last synchronization and datas of api
     */
    public static function selectAllSync(){
        global $wpdb;
        $url = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_url'");
        $key = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_key'");
        $dateSync = date_create($wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'last_sync'"));
        $date = date_format($dateSync, "d/m/Y à H:i:s");
        return array($url, $key, $date);
    }
}


/*
 * function Ajax to PHP
 */
add_action('wp_ajax_updateDate', 'dbUpdateDateSync');
function dbUpdateDateSync()
{
    Database_Synchro_Data::changeLastSync();
    echo Database_Synchro_Data::selectAllSync()[2];
    die();
}
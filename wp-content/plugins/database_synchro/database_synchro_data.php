<?php
/*
 *
 *  This is a part of CGA CLIENT API library
 *
 *  (c) unflux <support@unflux.fr>
 *
 *  Website : https://www.unflux.fr
 *
 */

class DatabaseSynchroData
{
    /*
     * Installation of the database
     */
    public static function install(){
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cga_sync_info (id INT AUTO_INCREMENT PRIMARY KEY, info_name VARCHAR(255), info_value VARCHAR(255));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours ( `id` INT NOT NULL, `libelle` TEXT NOT NULL , PRIMARY KEY (`id`)) ;");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_annee (`id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region_viticole ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_departement ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `id_region` INT NOT NULL, `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`, `id_region`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_categories_vin (`id` INT NOT NULL,  `id_region_viticole` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `id_region_viticole`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_types_appellations ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_couleurs ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations ( `id` INT NOT NULL AUTO_INCREMENT, `id_region` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, PRIMARY KEY (`id`,`id_region`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_category ( `id_cat` INT NOT NULL , `id_concours` INT NOT NULL , `id_appel` INT NOT NULL , PRIMARY KEY (`id_cat`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_couleurs ( `id_couleur` INT NOT NULL , `id_concours` INT NOT NULL ,`id_appel` INT NOT NULL , PRIMARY KEY (`id_couleur`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_types_appellations ( `id_types_appel` INT NOT NULL , `id_concours` INT NOT NULL ,`id_appel` INT NOT NULL , PRIMARY KEY (`id_types_appel`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL , `id_concours` INT NOT NULL ,`region_viticole` TEXT NOT NULL ,`appellation` TEXT NOT NULL ,`couleur` TEXT NOT NULL, `millesime` TEXT NOT NULL, `medaille` TEXT NOT NULL, `marque` TEXT DEFAULT NULL, `cepages` TEXT DEFAULT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille_candidat (`id` INT NOT NULL AUTO_INCREMENT, `raison_social` TEXT NOT NULL , `address` TEXT NOT NULL ,`cp` TEXT NOT NULL ,`commune` TEXT NOT NULL ,`tel` TEXT DEFAULT NULL, `fax` TEXT DEFAULT NULL, `email` TEXT DEFAULT NULL, `web` TEXT DEFAULT NULL, `id_vin_medaille` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille_info (`annee` VARCHAR(255) NOT NULL,  `nb_medaille_or` INT NOT NULL,  `nb_medaille_argent` INT NOT NULL,  `nb_medaille_bronze` INT NOT NULL, PRIMARY KEY (`annee`));");
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'last_sync', 'id' => 1));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_key', 'id' => 2));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_url', 'id' => 3, 'info_value' => 'http://www.concours-agricole.com/api/palmares'));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_suffixe', 'id' => 4));
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
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region_viticole;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_departement;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_categories_vin;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_type_appellation;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_couleurs;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_category;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_couleurs;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_types_appellations;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille_candidat;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille_info;");
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
     * Change the Api suffixe in the database
     */
    public static function changeApiSuffixe($suffixe){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $suffixe), array('info_name' => 'api_suffixe'));
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
        $suffixe = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_suffixe'");
        $dateSync = date_create($wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'last_sync'"));
        $date = date_format($dateSync, "d/m/Y à H:i:s");
        return array($date, $key, $url, $suffixe);
    }
}


/*
 * function Ajax to PHP
 */
add_action('wp_ajax_updateDate', 'dbUpdateDateSync');
function dbUpdateDateSync()
{
    echo DatabaseSynchroData::selectAllSync()[0];
    die();
}
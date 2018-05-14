<?php
/*
Plugin Name: database_synchro
Description: synchronisation de base de donnée
Version: 0.1
Author: François Darrigade
License: unflux
*/


/*
 * Initializing the plugin
 */
class Database_Synchro{

    public function __construct(){
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_data.php';
        register_activation_hook(__FILE__, array('database_synchro_data', 'install'));
        register_uninstall_hook(__FILE__, array('database_synchro_data', 'uninstall'));
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_formulaire.php';
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_widget.php';
        new Database_Synchro_Formulaire();
        new Database_Synchro_Widget();
    }
}
new Database_Synchro();

/*
 * function Ajax to PHP
 */
add_action('wp_ajax_updateDate', 'dbUpdateDateSync');
function dbUpdateDateSync()
{
    Database_Synchro_Data::changeLastSync();
    echo Database_Synchro_Data::selectLastSync();
    die();
}
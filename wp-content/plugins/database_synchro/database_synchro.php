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

/*
Plugin Name: Cga API Plugin
Description: Synchronization plugin for Cga API
Version: 0.6
Author: unflux : https://www.unflux.fr
*/


/*
 * Initializing the plugin
 */
class DatabaseSynchro{

    public function __construct(){
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_data.php';
        register_activation_hook(__FILE__, array('databasesynchrodata', 'install'));
        register_uninstall_hook(__FILE__, array('databasesynchrodata', 'uninstall'));
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_formulaire.php';
        include_once plugin_dir_path( __FILE__ ).'/database_synchro_widget.php';
        new DatabaseSynchroFormulaire();
        new DatabaseSynchroWidget();
    }
}
new DatabaseSynchro();

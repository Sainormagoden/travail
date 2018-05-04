<?php
/*
Plugin Name: database_synchro
Description: synchronisation de base de donnée
Version: 0.1
Author: François Darrigade
License: unflux
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
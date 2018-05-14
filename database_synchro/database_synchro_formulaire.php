<?php
include_once plugin_dir_path( __FILE__ ).'/database_synchro_widget.php';

/*
 * Insert form in Back Office
 */
add_action('admin_menu', 'addMenuWidget');
function addMenuWidget(){
    Add_menu_page ('Synchronisation bdd', 'Synchronisation bdd', 'manage_options', 'Synchronisation bdd', 'Database_Synchro_Widget::widget');
}

class Database_Synchro_Formulaire{

    /*
     * Insert form in widget
     */
    public function __construct()
    {
        add_action('widgets_init', function(){register_widget('Database_Synchro_Widget');});
    }
}
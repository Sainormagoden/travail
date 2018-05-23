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

include_once plugin_dir_path( __FILE__ ).'/database_synchro_widget.php';

/*
 * Insert form in Back Office
 */
add_action('admin_menu', 'addMenuWidget');
function addMenuWidget(){
    Add_menu_page ('Cga API', 'Cga API', 'manage_options', 'Cga API', 'DatabaseSynchroWidget::widget');
}

class DatabaseSynchroFormulaire{

    /*
     * Insert form in widget
     */
    public function __construct()
    {
        add_action('widgets_init', function(){register_widget('DatabaseSynchroWidget');});
    }
}
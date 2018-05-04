<?php

include_once plugin_dir_path( __FILE__ ).'/database_synchro_widget.php';

class Database_Synchro_Formulaire{

    public function __construct()
    {
        add_action('widgets_init', function(){register_widget('Database_Synchro_Widget');});
    }

}
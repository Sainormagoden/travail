<?php


class Database_Synchro_Widget extends WP_Widget{

    public function __construct(){
        parent::__construct('database_synchro_widget', 'form_database_widget', array('description' => 'affichade pour la synchronisation de la bdd'));
    }

    public function widget($args, $instance)
    {
        if (isset($_POST['database_synchro_api']) && !empty($_POST['database_synchro_api'])) {
            Database_Synchro_Data::changeApiKey($_POST['database_synchro_api']);
        }
        if (isset($_POST['database_synchro_apiurl']) && !empty($_POST['database_synchro_apiurl'])) {
            Database_Synchro_Data::changeApiUrl($_POST['database_synchro_apiurl']);
        }

        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script>
            $('#synchronisation').click(function () {
                alert('nya');
                $.post('database_synchro_data.php',{function:'changeLastSync'},function(donnees){
                    if(donnees==1){
                        $('database_synchro_date').html("MDP ok");
                    }
                    else
                        $('database_synchro_date').html("MDP erreur");
                });
            });
        </script>
        <p>
        <label for="database_synchro_date">Date de dernière synchro : xx-xx-xxxx</label>
        <form action="" method="post">
            <label for="database_synchro_api">API ID:</label>
            <input id="database_synchro_api" name="database_synchro_api" type="text"/>
            <label for="database_synchro_apiurl">API URL :</label>
            <input id="database_synchro_apiurl" name="database_synchro_apiurl" type="url"/>
            <input type="submit" value="Changer API"/>
        </form>
        <label for="database_synchro_date">Actions :</label>
        <input type="button" value="Synchronisation" id="synchronisation"/>
        <label for="database_synchro_date">Status : En cours de test</label>
        </p>

        <?php
    }
}
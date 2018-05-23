<?php
class Database_Synchro_Widget extends WP_Widget{

    public function __construct(){
        parent::__construct('database_synchro_widget', 'form_database_widget', array('description' => 'affichade pour la synchronisation de la bdd'));
    }

    /*
     * Form display
     */
    public function widget($args = null, $instance = null)
    {
        /*
         * Test if the form is already filled
         * If yes, change api in database
         */
        if (isset($_POST['database_synchro_api']) && !empty($_POST['database_synchro_api'])) {
            Database_Synchro_Data::changeApiKey($_POST['database_synchro_api']);
        }
        if (isset($_POST['database_synchro_apiurl']) && !empty($_POST['database_synchro_apiurl'])) {
            Database_Synchro_Data::changeApiUrl($_POST['database_synchro_apiurl']);
        }
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="<?= plugins_url('database_synchro'); ?>/function.js"></script>
        <script>
            /*
            * Activate synchronization if click on the button
            */
            $(document).ready(function() {
                var test = '';
                $("#synchronisation").click( function (){
                    startSyncAjax(function(msg){
                        test = msg;
                        if (test.message == "syncstart"){
                            syncAjax(function(msg){
                                test = msg;
                                if (test.message == "syncend"){
                                    lastSyncAjax("<?= admin_url('admin-ajax.php'); ?>");
                                }
                                else{
                                    $("#database_synchro_status").text("Erreur synchronisation!");
                                }
                            })
                        }
                        else{
                            $("#database_synchro_status").text("Erreur lors du lancement de la synchronisation!");
                        }
                    });
                });
            });
        </script>
        <?php $lastSync = Database_Synchro_Data::selectAllSync();?>
        <p>
            <label>Date de dernière synchro : </label>
            <label id="database_synchro_date"><?=$lastSync[2]?></label>
            <form action="" method="post">
                <label for="database_synchro_api">API ID:</label>
                <input id="database_synchro_api" name="database_synchro_api" type="text" value="<?=$lastSync[1]?>"/>
                <label for="database_synchro_apiurl">API URL :</label>
                <input id="database_synchro_apiurl" name="database_synchro_apiurl" type="url" value="<?=$lastSync[0]?>"/>
                <input type="submit" value="Changer API"/>
            </form>
            <label>Actions :</label>
            <input type="button" value="Synchronisation" id="synchronisation"/>
            <label>Status : </label>
            <label id="database_synchro_status"> Synchronisation pas commencée. </label>
        </p>
        <?php
    }
}
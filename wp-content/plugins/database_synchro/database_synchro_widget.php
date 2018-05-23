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

class DatabaseSynchroWidget extends WP_Widget{

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
            DatabaseSynchroData::changeApiKey($_POST['database_synchro_api']);
        }
        if (isset($_POST['database_synchro_apiurl']) && !empty($_POST['database_synchro_apiurl'])) {
            DatabaseSynchroData::changeApiUrl($_POST['database_synchro_apiurl']);
        }
        if (isset($_POST['database_synchro_apisuffixe']) && !empty($_POST['database_synchro_apisuffixe'])) {
            DatabaseSynchroData::changeApiSuffixe($_POST['database_synchro_apisuffixe']);
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
                    $("#database_synchro_status").text("Synchronisation en cours...");
                    syncAjax(function(msg){
                        test = msg;
                        if (test.message == "syncend"){
                            $("#database_synchro_message").find(".dsm").html("");
                            $("#database_synchro_message").hide();
                            lastSyncAjax("<?= admin_url('admin-ajax.php'); ?>");
                        }
                        else{
                            $("#database_synchro_message").find(".dsm").html(msg.responseText);
                            $("#database_synchro_message").show();
                            $("#database_synchro_status").text("Erreur synchronisation !");
                        }
                    },  "<?= plugins_url('database_synchro/cga-client-api/cga_client_api_load.php'); ?>");
                });
            });
        </script>
        <?php $dataSync = DatabaseSynchroData::selectAllSync();?>
        <p>
            <label>Date de dernière synchro : </label>
            <label id="database_synchro_date"><?=$dataSync[0]?></label>
            <form action="" method="post">
                <label for="database_synchro_api">API ID:</label>
                <input id="database_synchro_api" name="database_synchro_api" type="text" value="<?=$dataSync[1]?>"/>
                <br>
                <label for="database_synchro_apiurl">API URL :</label>
                <input id="database_synchro_apiurl" name="database_synchro_apiurl" type="url" value="<?=$dataSync[2]?>"/>
                <br>
                <label for="database_synchro_apisuffixe">API Suffixe :</label>
                <input id="database_synchro_apisuffixe" name="database_synchro_apisuffixe" type="text" value="<?=$dataSync[3]?>"/>
                <br>
                <input type="submit" value="Changer API"/>
            </form>
            <label>Actions :</label>
            <input type="button" value="Synchronisation" id="synchronisation"/>
            <label>Status : </label>
            <label id="database_synchro_status"> Synchronisation pas commencée. </label>
            <br/>
            <div id="database_synchro_message" style="display:none">
            <label>Message d'erreur :</label>
            <label class="dsm"> </label>
            </div>
        </p>
        <?php
    }
}
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= plugins_url('database_synchro'); ?>/style.css">
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
                        if (msg.message == "syncend"){
                            $("#database_synchro_message").find(".dsm").html("");
                            $("#database_synchro_message").hide();
                            $("#database_synchro_nbAppel").text(msg.necalls);
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
        <div class="row"><div class="col-md-12"><h2>CGA API</h2><div></div>
        <div class="row">
            <div class="col-md-2"><label>Date de dernière synchro : </label></div>
            <div class="col-md-4"><label id="database_synchro_date"><?=$dataSync[0]?></div>
        </div>
        <form action="" method="post"> 
            <div class="row">
                <div class="col-md-2"><label for="database_synchro_api">API ID:</label></div>
                <div class="col-md-4"><input class="form-control" id="database_synchro_api" name="database_synchro_api" type="text" value="<?=$dataSync[1]?>"/></div>
            </div>
            <div class="row">
                <div class="col-md-2"><label for="database_synchro_apiurl">API URL :</label></div>
                <div class="col-md-4"><input class="form-control" id="database_synchro_apiurl" name="database_synchro_apiurl" type="url" value="<?=$dataSync[2]?>"/></div>
            </div>
            <div class="row">
                <div class="col-md-2"><label for="database_synchro_apisuffixe">API Suffixe :</label></div>
                <div class="col-md-4"><input class="form-control" id="database_synchro_apisuffixe" name="database_synchro_apisuffixe" type="text" value="<?=$dataSync[3]?>"/></div>
            </div>
            <div class="row">
                <div class="col-md-2"><label>Actions :</label></div>
                <div class="col-md-1"><input type="submit" value="Changer API" class="btn btn-dark"/></div>
                <div class="col-md-1"><input type="button" value="Synchronisation" id="synchronisation" class="btn btn-dark"/></div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-2"><label>Status : </label></div>
            <div class="col-md-4"><label id="database_synchro_status"> Synchronisation pas commencée. </label></div>
        </div>
        <div class="row">
            <div class="col-md-2"><label>Nombre d'appel : </label></div>
            <div class="col-md-4"><label id="database_synchro_nbAppel"> 0 </label></div>
        </div>
        <div class="row" id="database_synchro_message" style="display:none">
            <div class="col-md-2"><label>Message d'erreur :</label></div>
            <div class="col-md-4"><label class="dsm"> </label></div>
        </div>

        <?php
    }
}
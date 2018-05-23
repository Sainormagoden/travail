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
* Update and Select the last date of synchronization
*/
function lastSyncAjax(urlPHP){
    $.ajax({
        type: "POST",
        url: urlPHP,
        data:  {'action' : 'updateDate'},
        success : function(msg){
            $("#database_synchro_status").text("Synchronisation terminée!");
            $("#database_synchro_date").text(msg);
        },
        error : function(msg){
            $("#database_synchro_status").text("Erreur synchronisation lors de la synchronisation de la date!");
        }
    });
}

/*
* First step of synchronization :
* synchronization database,
* launch the update of the last synchronization date
*/
function syncAjax(callback, urlPHP){
    $.ajax({
        type: "GET",
        url: urlPHP,
        dataType : 'json',
        success : function(msg){
            $("#database_synchro_message").find(".dsm").html("");
            $("#database_synchro_message").hide();
            $("#database_synchro_status").text("Synchronisation en cours...");
            callback(msg)
        },
        error : function(msg){
            console.log(msg);
            $("#database_synchro_message").find(".dsm").html(msg.responseText);
            $("#database_synchro_message").show();
            $("#database_synchro_status").text("Erreur synchronisation !");
        }
    });
}
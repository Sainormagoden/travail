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
* launch the second step if the good message is received
*/
function startSyncAjax(callback){
    $.ajax({
        type: "GET",
        url: "http://localhost/API_rest/user?id=1",
        dataType : 'json',
        success : function(msg){
            $("#database_synchro_status").text("Synchronisation en cours...");
            callback(msg);
        },
        error : function(msg){
            $("#database_synchro_status").text("Erreur lors du lancement de la synchronisation!");
        }
    });
}

/*
* Second step of synchronization :
* synchronization database,
* launch the update of the last synchronization date
*/
function syncAjax(callback){
    $.ajax({
        type: "GET",
        url: "http://localhost/API_rest/user?id=2",
        dataType : 'json',
        success : function(msg){
            $("#database_synchro_status").text("Synchronisation presque terminée...");
            callback(msg)
        },
        error : function(msg){
            $("#database_synchro_status").text("Erreur synchronisation!");
        }
    });
}
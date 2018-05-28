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

class DatabaseSynchroData
{
    /*
     * Installation of the database
     */
    public static function install(){
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}cga_sync_info (id INT AUTO_INCREMENT PRIMARY KEY, info_name VARCHAR(255), info_value VARCHAR(255));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours ( `id` INT NOT NULL, `libelle` TEXT NOT NULL , PRIMARY KEY (`id`)) ;");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_annee (`id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region_viticole ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_region ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_departement ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `id_region` INT NOT NULL, `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`, `id_region`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_categories_vin (`id` INT NOT NULL,  `id_region_viticole` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `id_region_viticole`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_types_appellations ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_couleurs ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations ( `id` INT NOT NULL AUTO_INCREMENT, `id_region` INT NOT NULL , `id_concours` INT NOT NULL , `libelle` TEXT NOT NULL, PRIMARY KEY (`id`,`id_region`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_category ( `id_cat` INT NOT NULL , `id_concours` INT NOT NULL , `id_appel` INT NOT NULL , PRIMARY KEY (`id_cat`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_couleurs ( `id_couleur` INT NOT NULL , `id_concours` INT NOT NULL ,`id_appel` INT NOT NULL , PRIMARY KEY (`id_couleur`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_appellations_types_appellations ( `id_types_appel` INT NOT NULL , `id_concours` INT NOT NULL ,`id_appel` INT NOT NULL , PRIMARY KEY (`id_types_appel`, `id_appel`, `id_concours`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL , `id_concours` INT NOT NULL ,`region_viticole` TEXT NOT NULL ,`appellation` TEXT NOT NULL ,`couleur` TEXT NOT NULL, `millesime` TEXT NOT NULL, `medaille` TEXT NOT NULL, `marque` TEXT DEFAULT NULL, `cepages` TEXT DEFAULT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille_candidat (`id` INT NOT NULL AUTO_INCREMENT, `raison_social` TEXT NOT NULL , `address` TEXT NOT NULL ,`cp` TEXT NOT NULL ,`commune` TEXT NOT NULL ,`tel` TEXT DEFAULT NULL, `fax` TEXT DEFAULT NULL, `email` TEXT DEFAULT NULL, `web` TEXT DEFAULT NULL, `id_vin_medaille` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_vin_medaille_info (`annee` VARCHAR(255) NOT NULL,  `nb_medaille_or` INT NOT NULL,  `nb_medaille_argent` INT NOT NULL,  `nb_medaille_bronze` INT NOT NULL, PRIMARY KEY (`annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_agro_ecologiques (`id` INT NOT NULL AUTO_INCREMENT,`annee` VARCHAR(255) NOT NULL, `typeDePrix` VARCHAR(255), `categorie` VARCHAR(255), `section` VARCHAR(255), `agriculteur_raison_social` TEXT, `organisateur` TEXT, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_prix_excellence (`id` INT NOT NULL AUTO_INCREMENT,`annee` VARCHAR(255) NOT NULL, `typeDeConcours` VARCHAR(255), `concours` VARCHAR(255), `id_agriculteur` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_prix_excellence_candidat (`id` INT NOT NULL AUTO_INCREMENT, `raison_sociale` TEXT NOT NULL , `address1` TEXT NOT NULL , `address2` TEXT NOT NULL ,`code_postal` TEXT NOT NULL ,`ville` TEXT NOT NULL ,`tel` TEXT DEFAULT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_classes ( `id` INT NOT NULL , `id_concours` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_categories ( `id` INT NOT NULL , `id_concours` INT NOT NULL, `id_classe` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_sections ( `id` INT NOT NULL , `id_concours` INT NOT NULL, `id_classe` INT NOT NULL , `annee` VARCHAR(255) NOT NULL, `libelle` TEXT NOT NULL, PRIMARY KEY (`id`, `id_concours`, `annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_medaille (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL , `id_concours` INT NOT NULL ,`categorie` TEXT NOT NULL ,`section` TEXT NOT NULL ,`infos` TEXT NOT NULL, `matiere_grasse` TEXT NOT NULL, `medaille` TEXT NOT NULL, `marque` TEXT DEFAULT NULL, `lait` TEXT DEFAULT NULL, `poids` TEXT DEFAULT NULL, `arome` TEXT DEFAULT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_medaille_producteur (`id` INT NOT NULL AUTO_INCREMENT, `raison_social` TEXT NOT NULL , `address` TEXT NOT NULL, `address2` TEXT DEFAULT NULL ,`cp` TEXT NOT NULL ,`commune` TEXT NOT NULL ,`tel` TEXT DEFAULT NULL, `fax` TEXT DEFAULT NULL, `email` TEXT DEFAULT NULL, `web` TEXT DEFAULT NULL, `id_produit_medaille` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_medaille_affineur (`id` INT NOT NULL AUTO_INCREMENT, `raison_social` TEXT NOT NULL , `address` TEXT NOT NULL, `address2` TEXT DEFAULT NULL ,`cp` TEXT NOT NULL ,`commune` TEXT NOT NULL ,`tel` TEXT DEFAULT NULL, `fax` TEXT DEFAULT NULL, `email` TEXT DEFAULT NULL, `web` TEXT DEFAULT NULL, `id_produit_medaille` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_produits_medaille_info (`annee` VARCHAR(255) NOT NULL,  `nb_medaille_or` INT NOT NULL,  `nb_medaille_argent` INT NOT NULL,  `nb_medaille_bronze` INT NOT NULL, PRIMARY KEY (`annee`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL , `id_concours` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_eleveur (`id` INT NOT NULL AUTO_INCREMENT, `raison_social` TEXT NOT NULL , `address` TEXT NOT NULL, `address2` TEXT DEFAULT NULL ,`cp` TEXT NOT NULL,`tel` TEXT DEFAULT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_lot (`id` INT NOT NULL AUTO_INCREMENT, `lot` INT NOT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_espece ( `id` INT NOT NULL , `libelle` TEXT NOT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`, `id_animaux_palmares`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_race ( `id` INT NOT NULL , `libelle` TEXT NOT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_concours ( `id` INT NOT NULL , `libelle` TEXT NOT NULL, `code` TEXT NOT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_animaux_palmares_animal ( `id` INT NOT NULL , `nom_affichage` TEXT NOT NULL, `date_naissance` TEXT NOT NULL, `pere` TEXT NOT NULL, `mere` TEXT NOT NULL, `grand_pere_maternel` TEXT NOT NULL, `qualification` TEXT NOT NULL, `qualification_pere` TEXT NOT NULL, `qualification_mere` TEXT NOT NULL, `rang` INT NOT NULL, `laureat` INT NOT NULL, `meilleure_mamelle` INT NOT NULL, `id_animaux_palmares` INT NOT NULL , PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_professionel (`id` INT NOT NULL,`libelle` TEXT NOT NULL, `acronyme` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_annee (`id` INT NOT NULL AUTO_INCREMENT, `id_sous_concours` INT NOT NULL, `annee` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_category_cjaj (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL, `libelle` VARCHAR(255) NOT NULL, `id_categorie` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_palmares_cjaj (`id` INT NOT NULL AUTO_INCREMENT, `id_categorie` INT NOT NULL, `rang` VARCHAR(255) NOT NULL, `id_candidat` INT NOT NULL, `id_etablissement` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_candidat_cjaj (`id_candidat` INT NOT NULL AUTO_INCREMENT, `nom` VARCHAR(255) NOT NULL, `prenom` VARCHAR(255) NOT NULL, `code_postal` VARCHAR(255) NOT NULL, `ville` VARCHAR(255) NOT NULL, PRIMARY KEY (`id_candidat`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_etablissement_cjaj (`id_etablissement` INT NOT NULL AUTO_INCREMENT, `nom` VARCHAR(255) NOT NULL, `code_postal` VARCHAR(255) NOT NULL, `ville` VARCHAR(255) NOT NULL, PRIMARY KEY (`id_etablissement`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_palmares_cjpv (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL, `type_palmares` VARCHAR(255) NOT NULL, `rang` INT NOT NULL, `pays` VARCHAR(255) NOT NULL, `section` VARCHAR(255) NOT NULL, `points` INT NOT NULL, `bonus_communication` INT NOT NULL, `caracterisation` INT NOT NULL, `notation` INT NOT NULL, `degustation_commentee` INT NOT NULL, `id_eleve` INT NOT NULL, `id_etablissement`INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_etablissement_cjpv (`id_etablissement` INT NOT NULL AUTO_INCREMENT, `nom` VARCHAR(255) NOT NULL, `ville` VARCHAR(255) NOT NULL, PRIMARY KEY (`id_etablissement`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_candidat_cjpv (`id_candidat` INT NOT NULL AUTO_INCREMENT, `nom` VARCHAR(255) NOT NULL, `prenom` VARCHAR(255) NOT NULL, PRIMARY KEY (`id_candidat`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_palmares_tnla (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL, `section` VARCHAR(255) NOT NULL, `rang` INT NOT NULL, `laureat`  INT NOT NULL, `ligne1` VARCHAR(255), `ligne2` VARCHAR(255), `ligne3` VARCHAR(255), `ligne4` VARCHAR(255), PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_palmares_etj (`id` INT NOT NULL AUTO_INCREMENT, `annee` VARCHAR(255) NOT NULL, `rang` VARCHAR(255) NOT NULL, `laureat` INT NOT NULL, `id_etablissement` INT NOT NULL, PRIMARY KEY (`id`));");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}concours_jeune_etablissement_etj (`id_etablissement` INT NOT NULL AUTO_INCREMENT, `nom_palmares` VARCHAR(255) NOT NULL, `code_postal` VARCHAR(255) NOT NULL, `ville` VARCHAR(255) NOT NULL, PRIMARY KEY (`id_etablissement`));");

        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'last_sync', 'id' => 1));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_key', 'id' => 2));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_url', 'id' => 3, 'info_value' => 'http://www.concours-agricole.com/api/palmares'));
        $wpdb->insert("{$wpdb->prefix}cga_sync_info", array('info_name' => 'api_suffixe', 'id' => 4));
    }

    /*
     * Uninstallation of the database
     */
    public static function uninstall()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cga_sync_info;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region_viticole;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_region;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_departement;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_categories_vin;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_type_appellation;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_couleurs;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_category;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_couleurs;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_appellations_types_appellations;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille_candidat;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_vin_medaille_info;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_agro_ecologiques;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_prix_excellence;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_prix_excellence_candidat;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_classes;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_categories;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_sections;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_medaille;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_medaille_producteur;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_medaille_affineur;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_produits_medaille_info;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_eleveur;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_lot;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_espece;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_race;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_concours;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_animaux_palmares_animal;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_professionel;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_category_cjaj;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_palmares_cjaj;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_candidat_cjaj;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_etablissement_cjaj;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_palmares_cjpv;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_etablissement_cjpv;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_candidat_cjpv;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_palmares_tnla;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_palmares_etj;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}concours_jeune_etablissement_etj;");
    }

    /*
     * Change the Api Key in the database
     */
    public static function changeApiKey($api){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $api), array('info_name' => 'api_key'));
    }

    /*
     * Change the Api url in the database
     */
    public static function changeApiUrl($url){
        global $wpdb;
        $url = rtrim($url, '/');
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $url), array('info_name' => 'api_url'));
    }

    /*
     * Change the Api suffixe in the database
     */
    public static function changeApiSuffixe($suffixe){
        global $wpdb;
        $wpdb->update("{$wpdb->prefix}cga_sync_info", array('info_value' => $suffixe), array('info_name' => 'api_suffixe'));
    }

    /*
     * Select the date of last synchronization and datas of api
     */
    public static function selectAllSync(){
        global $wpdb;
        $url = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_url'");
        $key = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_key'");
        $suffixe = $wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'api_suffixe'");
        $dateSync = date_create($wpdb->get_var("SELECT info_value FROM {$wpdb->prefix}cga_sync_info WHERE info_name = 'last_sync'"));
        $date = date_format($dateSync, "d/m/Y à H:i:s");
        return array($date, $key, $url, $suffixe);
    }
}


/*
 * function Ajax to PHP
 */
add_action('wp_ajax_updateDate', 'dbUpdateDateSync');
function dbUpdateDateSync()
{
    echo DatabaseSynchroData::selectAllSync()[0];
    die();
}
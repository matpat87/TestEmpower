<?php
    //OnTrack #1218 - change dropdown to text
    require_once('custom/entrypoints/classes/MigrateFields.php');

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    $migrateFields = new MigrateFields();
    $migrateFields->process();
?>
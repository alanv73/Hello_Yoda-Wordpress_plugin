<?php
/**
 * 
 * 
 */

 function hello_yoda_uninstall() {
    Global $wpdb;

    $table_name = $wpdb->prefix . 'quotes';

    $wpdb->query( 
        "DROP TABLE IF EXISTS {$table_name}"
    );
}

hello_yoda_uninstall();
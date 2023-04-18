<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wecode.agency
 * @since      1.0.0
 *
 * @package    petition
 * @subpackage petition/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    petition
 * @subpackage petition/admin
 * @author     Tobiasz Gerczuk <tobiasz.gerczuk@wecode.agency>
 */
class Petition_Database{

    public function __construct() {
      $this->create_petition_table();
    }


    function create_petition_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'avalon_petition';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                  id INT NOT NULL AUTO_INCREMENT,
                  first_name VARCHAR(50) NOT NULL,
                  last_name VARCHAR(50) NOT NULL,
                  petition_id VARCHAR(50) NOT NULL,
                  email VARCHAR(100) NOT NULL,
                  anonymous TINYINT(1) DEFAULT 0,
                  confirmed TINYINT(1) DEFAULT 0,
                  featured TINYINT(1) DEFAULT 0,
                  PRIMARY KEY (id)
                ) $wpdb->charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }





    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */


}

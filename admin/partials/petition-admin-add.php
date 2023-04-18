<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wecode.agency
 * @since      1.0.0
 *
 * @package    petition
 * @subpackage petition/admin/partials
 */
?>
<div class="petition_admin_edit_page">
    <a class="return_petition_list" href="/wp-admin/admin.php?page=petition"> <- <?php echo __('Back to list', 'petition'); ?></a>
    <h3> <?php echo __('Add petition', 'petition'); ?> <strong style="color:orangered;"><?php echo $_GET['email']; ?></strong></h3>

    <?php
    global $wpdb;

    if(isset($_POST['submit_add_petition'])){

        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $petition_id = $_POST['petition_id'];
        $anonymous = $_POST['anonymous'];
        $confirmed = $_POST['confirmed'];
        $featured = $_POST['featured'];

        $result = $wpdb->get_results( "SELECT * FROM wp_avalon_petition WHERE email = '$email'" );

        if ( !empty( $result ) ) {
            $message_update = "<h2 style='max-width:20%;background-color:green;color:#fff;padding:1rem 2rem;'>".__('This petition is already exist!','petition')."</h2>";
        } else {
            $table_name = 'wp_avalon_petition';
            $data = array(
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'petition_id' => $petition_id,
                'anonymous' => $anonymous,
                'confirmed' => $confirmed,
                'featured' => $featured,
            );
            $add_petition = $wpdb->insert($table_name, $data);

            if($add_petition){
                $message_update = "<h2 style='max-width:20%;background-color:green;color:#fff;padding:1rem 2rem;'>".__('Petition added','petition')."</h2>";
            }
        }

    }

    echo $message_update;

    ?>

    <form action="" name="add_petition" id="edit_petition_form" method="post">

            <label for="first_name"> <?php echo __('First name', 'petition'); ?>
                <input type="text" name="first_name" >
            </label>
            <label for="first_name"> <?php echo __('Lat name', 'petition'); ?>
                <input type="text" name="last_name" >
            </label>
            <label for="first_name"> <?php echo __('Email', 'petition'); ?>
                <input required type="email" name="email" ">
            </label>
            <label for="petition_id"> <?php echo __('Petition ID', 'petition'); ?>
                <input style="max-width: 150px;" type="text" name="petition_id" ">
            </label>
            <label for="anonymous"> <?php echo __('Anonymous', 'petition'); ?>
                <input type="checkbox" name="anonymous" value="1"  >
            </label>
            <label for="confirmed"> <?php echo __('Confirmed', 'petition'); ?>
                <input type="checkbox" name="confirmed" value="1">
            </label> <label for="featured"> <?php echo __('Featured', 'petition'); ?>
                <input type="checkbox" name="featured" value="1">
            </label>
            <input type="hidden" name="id" >

        <div class="input_sumit_add_petition">
            <input name="submit_add_petition" type="submit" value="<?php echo __('Add', 'petition'); ?>">

        </div>




    </form>
</div>


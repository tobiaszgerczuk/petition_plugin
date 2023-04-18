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
    <h3> <?php echo __('Edit petition', 'petition'); ?> <strong style="color:orangered;"><?php echo $_GET['email']; ?></strong></h3>

    <?php
    global $wpdb;

    if(isset($_POST['submit_edit_petition'])){


        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $petition_id = $_POST['petition_id'];
        $anonymous = $_POST['anonymous'];
        $confirmed = $_POST['confirmed'];
        $featured = $_POST['featured'];



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
        $where = array(
            'id' => $id,
        );
        $update_petycjonariusz = $wpdb->update($table_name, $data, $where);

        if($update_petycjonariusz){
            $message_update = "<h2 style='max-width:20%;background-color:green;color:#fff;padding:1rem 2rem;'>".__("Updated successfully.",'petition')."</h2>";
        }
    }

    echo $message_update;

    $id = $_GET['id'];
    $results = $wpdb->get_results("SELECT * FROM wp_avalon_petition where id=$id ");

    ?>

    <form action="" name="update_petition" id="edit_petition_form" method="post">
        <?php

        foreach ($results as $result){
            ?>
            <label for="first_name"> <?php echo __('First name', 'petition'); ?>
            <input type="text" name="first_name" value="<?php echo ($result->first_name != '') ? $result->first_name : '' ?>">
            </label>
            <label for="first_name"> <?php echo __('Last name', 'petition'); ?>
                <input type="text" name="last_name" value="<?php echo ($result->last_name != '') ? $result->last_name : '' ?>">
            </label>
            <label for="first_name"> <?php echo __('Email', 'petition'); ?>
                <input type="text" name="email" value="<?php echo ($result->email != '') ? $result->email : '' ?>">
            </label>
            <label for="petition_id"> <?php echo __('Petition ID', 'petition'); ?>
                <input style="max-width: 150px;" type="text" name="petition_id" value="<?php echo ($result->petition_id != '') ? $result->petition_id : '' ?>">
            </label>
            <label for="anonymous"> <?php echo __('Anonymous', 'petition'); ?>
                <input type="checkbox" name="anonymous" value="1"  <?php echo ($result->anonymous ? 'checked' : ''); ?>>
            </label>
            <label for="confirmed"> <?php echo __('Confirmed', 'petition'); ?>
                <input type="checkbox" name="confirmed" value="1"  <?php echo ($result->confirmed ? 'checked' : ''); ?>>
            </label> <label for="featured"> <?php echo __('Featured', 'petition'); ?>
                <input type="checkbox" name="featured" value="1"  <?php echo ($result->featured ? 'checked' : ''); ?>>
            </label>
            <input type="hidden" name="id" value="<?php echo $result->id; ?>">

        <?php

        }
        ?>
        <div class="input_submit_edit_petition">
            <input name="submit_edit_petition" type="submit" value="<?php echo __('Upadate', 'petition'); ?>">

        </div>




    </form>
</div>


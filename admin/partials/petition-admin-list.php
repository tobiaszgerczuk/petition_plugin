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

<div class="petition_admin_page">

<h1> <?php echo _e('Petition list', 'petition'); ?></h1>


    <?php
    global $wpdb;
    $message_deleted = '';
    if(isset($_POST['sub'])){
        $delete_petitioner = $delete_petitioner = $wpdb->delete(
            'wp_avalon_petition',
            array( 'id' => $_POST['id'] )
        );
        if($delete_petitioner){
            $message_deleted = "<h2 style='background-color:green;color:#fff;padding:1rem 2rem;'>".__('Deleted successfully', 'petition')."</h2>";
        }

    }

    echo $message_deleted;


    ?>

    <form method="post" class="filter_email_petition">
        <label for="filter_email"><?php echo _e('Filter by email:', 'petition'); ?></label>
        <input type="text" id="filter_email" name="filter_email" value="<?php echo isset($_POST['filter_email']) ? $_POST['filter_email'] : ''; ?>">
        <input type="submit" value="<?php echo __('Filter', 'petition'); ?>">
    </form>

    <?php

    $results = $wpdb->get_results("SELECT * FROM wp_avalon_petition");
    if (isset($_POST['filter_email'])) {
        $filter_email = sanitize_email($_POST['filter_email']);
        if (!empty($filter_email)) {
            $results = $wpdb->get_results("SELECT * FROM wp_avalon_petition WHERE email LIKE '%$filter_email%'");
            $filter_button = true;
        }
    }
    $per_page = 4; // Liczba wyników na stronie
    $current_page = isset($_GET['paged']) ? $_GET['paged'] : 1; // Aktualna strona

    $total_items = count($results); // Liczba wszystkich wyników
    $total_pages = ceil($total_items / $per_page); // Liczba wszystkich stron

    // Wybierz tylko wyniki dla bieżącej strony
    $results = array_slice($results, ($current_page - 1) * $per_page, $per_page);

    if($filter_button == true){
        ?>
            <a class="return_petition_list" href="/wp-admin/admin.php?page=petition"> <- <?php echo __('Back to list', 'petition'); ?></a>
        <?php
    }
    ?>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <tr>
            <th width="20"><?php echo __('ID', 'petition'); ?></th>
            <th width="120"><?php echo __('First name', 'petition'); ?></th>
            <th width="120"><?php echo __('Last name', 'petition'); ?></th>
            <th><?php echo __('Email', 'petition'); ?></th>
            <th><?php echo __('Petition ID', 'petition'); ?></th>
            <th><?php echo __('Anonymous', 'petition'); ?></th>
            <th><?php echo __('Confirmed', 'petition'); ?></th>
            <th ><?php echo __('Featured', 'petition'); ?></th>
            <th width="200" class="actions_last_edit_petition" colspan="2"><?php echo __('Actions', 'petition'); ?></th>

        </tr>
    <?php
    if($results){
        foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result->id; ?></td>
                <td><?php echo $result->first_name; ?></td>
                <td><?php echo $result->last_name; ?></td>
                <td><?php echo $result->email; ?></td>
                <td><?php echo $result->petition_id; ?></td>
                <td><?php echo ($result->anonymous ? _e('Yes','petition') : _e('No','petition') ) ; ?></td>
                <td><?php echo ($result->confirmed ? _e('Yes','petition') : _e('No','petition') ); ?></td>
                <td><?php echo ($result->featured ? _e('Yes','petition') : _e('No','petition') ); ?></td>
                <td width="100" style="text-align:center;"><?php echo '<a class="edit_petition_button" href="?page=petition_edit&action=edit&id=' . $result->id . '&email=' . $result->email . '">'.__('Edit','petition').'</a>'; ?></td>
                <td width="100" style="text-align:center;">
                    <form action="" name="submit_delete_petitioner" method="post">
                        <input class="delete_petition_button" type="submit" name="sub" value="<?php echo  _e('Delete','petition'); ?>">
                        <input type="hidden" name="id" value="<?php echo $result->id; ?>">
                    </form>
                </td>
            </tr>
            <?php
        }
    }
    else{
        echo "<h2>".__('No petitions', 'petition')."</h2>";
    }
    ?>

    </table>

    <?php if ($total_pages > 1) { ?>
        <div class="tablenav">
            <div class="tablenav-pages">
                <?php
                $paginate_links = paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'prev_text' => __('&laquo; Previous'),
                    'next_text' => __('Next &raquo;'),
                    'total' => $total_pages,
                    'current' => $current_page,
                    'show_all' => false,
                    'end_size' => 1,
                    'mid_size' => 2,
                    'type' => 'plain',
                ));

                echo $paginate_links;
                ?>
            </div>
        </div>
    <?php } ?>

</div>

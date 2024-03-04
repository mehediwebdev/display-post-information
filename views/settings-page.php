<?php
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="POST">
            <?php
            settings_fields('wp_post_information_options_group');
            do_settings_sections('wp-post-information-settings');
            submit_button( esc_html__( 'Save Settings', 'wp-post-information' ) );
            ?>
        </form>
    </div>
    
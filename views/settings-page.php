<?php
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="POST">
            <?php
            settings_fields('display_post_information_options_group');
            do_settings_sections('display-post-information-settings');
            submit_button( esc_html__( 'Save Settings', 'display-post-information' ) );
            ?>
        </form>
    </div>
    
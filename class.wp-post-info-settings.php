<?php
if (!class_exists('WPI_WP_Post_Info_Settings')) {
    class WPI_WP_Post_Info_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option('wp_post_information_options');
            add_action('admin_init', array($this, 'admin_init_fields'));
        }

        public function admin_init_fields()
        {
            register_setting(
                'wp_post_information_options_group',
                'wp_post_information_options',
                array($this, 'wpi_resgister_settings_validation_callback')
            );

            add_settings_section(
                'wp_post_information_main_section', // ID
                esc_html__('How Does It work', 'wp-post-information'), // Title
                null, //array($this, 'wpi_main_section_callback'),   // Callback
                'wp-post-information-settings' // Page
            );


            add_settings_field(
                'wpi_display_location',
                esc_html__('Display Location', 'wp-post-information'),
                array($this, 'wpi_display_location_callback'),
                'wp-post-information-settings',
                'wp_post_information_main_section'
            );

            add_settings_field(
                'wpi_display_headline',
                esc_html__('Display Headline', 'wp-post-information'),
                array($this, 'wpi_display_headline_callback'),
                'wp-post-information-settings',
                'wp_post_information_main_section'
            );

            add_settings_field(
                'wpi_display_word_count',
                esc_html__('Display Word Count', 'wp-post-information'),
                array($this, 'wpi_display_word_count_callback'),
                'wp-post-information-settings',
                'wp_post_information_main_section'
            );

            add_settings_field(
                'wpi_display_character_count',
                esc_html__('Display Character Count', 'wp-post-information'),
                array($this, 'wpi_display_character_count_callback'),
                'wp-post-information-settings',
                'wp_post_information_main_section'
            );

            add_settings_field(
                'wpi_display_read_time',
                esc_html__('Display Read Time', 'wp-post-information'),
                array($this, 'wpi_display_read_time_callback'),
                'wp-post-information-settings',
                'wp_post_information_main_section'
            );
        }

      

        public function wpi_display_location_callback()
        {
            ?>
            <select
                    id="wpi_display_location"
                    name="wp_post_information_options[wpi_display_location]">
                <option
                        value="0"
                    <?php isset(self::$options['wpi_display_location']) ? selected('0', self::$options['wpi_display_location'], true) : ''; ?>><?php esc_html_e('Beginning of post', 'wp-post-information'); ?></option>
                <option value="1"
                    <?php isset(self::$options['wpi_display_location']) ? selected('1', self::$options['wpi_display_location'], true) : ''; ?>><?php esc_html_e('End of post', 'wp-post-information'); ?></option>
            </select>
            <?php
        }

        public function wpi_display_headline_callback()
        {
            ?>
            <input
                    type="text"
                    name="wp_post_information_options[wpi_display_headline]"
                    id="wpi_display_headline"
                    value="<?php echo isset(self::$options['wpi_display_headline']) ? esc_attr(self::$options['wpi_display_headline']) : ''; ?>"
            />
            <?php
        }

        public function wpi_display_word_count_callback()
        {
            ?>
            <input
                    type="checkbox"
                    name="wp_post_information_options[wpi_display_word_count]"
                    id="wpi_display_word_count"
                    value="1"
                <?php
                if (isset(self::$options['wpi_display_word_count'])) {
                    checked("1", self::$options['wpi_display_word_count'], true);
                }
                ?>
            />
            <label for="wpi_display_word_count"><?php esc_html_e('Yes/No', 'wp-post-information'); ?></label>
            <?php
        }

        public function wpi_display_character_count_callback()
        {
            ?>
            <input
                    type="checkbox"
                    name="wp_post_information_options[wpi_display_character_count]"
                    id="wpi_display_character_count"
                    value="1"
                <?php
                if (isset(self::$options['wpi_display_character_count'])) {
                    checked("1", self::$options['wpi_display_character_count'], true);
                }
                ?>
            />
            <label for="wpi_display_character_count"><?php esc_html_e('Yes/No', 'wp-post-information'); ?></label>
            <?php
        }

        public function wpi_display_read_time_callback()
        {
            ?>
            <input
                    type="checkbox"
                    name="wp_post_information_options[wpi_display_read_time]"
                    id="wpi_display_read_time"
                    value="1"
                <?php
                if (isset(self::$options['wpi_display_read_time'])) {
                    checked("1", self::$options['wpi_display_read_time'], true);
                }
                ?>
            />
            <label for="wpi_display_read_time"><?php esc_html_e('Yes/No', 'wp-post-information'); ?></label>
            <?php
        }

        public function wpi_resgister_settings_validation_callback( $input ){
           $new_input = array();
           foreach( $input as $key => $value ){
             switch($key){
                case 'wpi_display_location':
                    $new_input[$key] = absint( $value );
                break;
                case 'wpi_display_headline':
                    if ( empty( $value ) ){
                        $value = "Please, Type some text";
                    }
                    $new_input[$key] = sanitize_text_field( $value );
                break;
                case 'wpi_display_word_count':
                    $new_input[$key] = absint( $value );
                break;
                case 'wpi_display_character_count':
                    $new_input[$key] = absint( $value );
                break;
                case 'wpi_display_read_time':
                    $new_input[$key] = absint( $value );
                break;
                default:
                $new_input[$key] = sanitize_text_field( $value );
                break;
             }
           }
           return $new_input;
        }
    }
}

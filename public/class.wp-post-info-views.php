<?php
if (!class_exists('WPI_WP_Post_Info_Views')) {
    class WPI_WP_Post_Info_Views {
        public static $options;

        public function __construct() {
            self::$options = get_option('wp_post_information_options');
            add_filter('the_content', array($this, 'wp_post_info_views'));
        }

        public function wp_post_info_views($content) {
            if ((is_main_query() && is_single()) && (
                isset(self::$options['wpi_display_word_count']) && self::$options['wpi_display_word_count'] == '1' ||
                isset(self::$options['wpi_display_character_count']) && self::$options['wpi_display_character_count'] == '1' ||
                isset(self::$options['wpi_display_read_time']) && self::$options['wpi_display_read_time'] == '1'
            )) {
                return $this->createHTML($content);
            }
            return $content;
        }

        public function createHTML($content) {
            $headline = isset(self::$options['wpi_display_headline']) ? esc_html(self::$options['wpi_display_headline']) : 'Post Information';
            $html = '<h3>' . $headline . '</h3>';

            $wordCount = 0; // Define $wordCount before using it

            if (isset(self::$options['wpi_display_word_count']) && self::$options['wpi_display_word_count'] == '1') {
                $wordCount = str_word_count(strip_tags($content));               
                $html .= sprintf(
                    // translators: %s is replaced with the number of words
                    __('This post has %s Words.<br>', 'wp-post-information'),   
                    esc_html($wordCount)
                );
            }

            if (isset(self::$options['wpi_display_character_count']) && self::$options['wpi_display_character_count'] == '1') {
                $html .= sprintf(
                     // translators: %s is replaced with the number of characters
                    __('This post has %s characters.<br>', 'wp-post-information'),
                    esc_html(strlen(strip_tags($content)))
                );
            }
            if (isset(self::$options['wpi_display_read_time']) && self::$options['wpi_display_read_time'] == '1') {          
                if ($wordCount > 0) {                   
                    $html .= sprintf(
                        // translators: %s is replaced with the approximate reading time in minutes
                        __('This post will take about %s min(s) to read.', 'wp-post-information'),
                        esc_html(round($wordCount / 225))
                    );
                }
            }

            if (isset(self::$options['wpi_display_location']) && self::$options['wpi_display_location'] == '0') {
                return $html . $content;
            } else {
                return $content . $html;
            }
        }
    }
}

<?php
/**
 * Replace Gravity Forms buttons with WordPress block buttons
 * 
 * Replaces Gravity Forms button markup with actual WordPress block buttons 
 * rendered through Gutenberg for full theme integration
 * 
 * @package Groundworx\Snippets
 * @author Johanne Courtright
 * @link https://groundworxagency.com
 * @requires Gravity Forms 2.5+
 * @requires WordPress 6.4+ (for WP_HTML_Processor)
 * @version 1.0.0
 * @license GPL-2.0-or-later
 */

namespace Groundworx\Snippets;

/**
 * Replaces Gravity Forms buttons with WordPress block buttons
 */
class GravityForms_Block_Buttons {

    /**
     * Button style for primary action buttons (submit, next)
     * 
     * @var string Button style class (e.g., 'is-style-fill', 'is-style-outline')
     */
    private static $primary_button_style = '';

    /**
     * Button style for secondary action buttons (previous, back)
     * 
     * @var string Button style class (e.g., 'is-style-fill', 'is-style-outline')
     */
    private static $secondary_button_style = 'is-style-outline';

    /**
     * Additional classes for primary action button wrapper
     * 
     * @var string Additional CSS classes
     */
    private static $primary_button_classes = '';

    /**
     * Additional classes for secondary action button wrapper
     * 
     * @var string Additional CSS classes
     */
    private static $secondary_button_classes = '';

    /**
     * Initialize the class and set up hooks
     * 
     * @param array $args Optional configuration arguments
     *                    - primary_style: Button style for submit/next buttons
     *                    - secondary_style: Button style for previous/back buttons
     *                    - primary_classes: Additional classes for primary buttons
     *                    - secondary_classes: Additional classes for secondary buttons
     */
    public static function init( $args = [] ) {
        // Allow configuration override
        if ( isset( $args['primary_style'] ) ) {
            self::$primary_button_style = $args['primary_style'];
        }
        if ( isset( $args['secondary_style'] ) ) {
            self::$secondary_button_style = $args['secondary_style'];
        }
        if ( isset( $args['primary_classes'] ) ) {
            self::$primary_button_classes = $args['primary_classes'];
        }
        if ( isset( $args['secondary_classes'] ) ) {
            self::$secondary_button_classes = $args['secondary_classes'];
        }

        add_filter( 'gform_submit_button', [ __CLASS__, 'convert_primary_button' ], 10, 2 );
        add_filter( 'gform_next_button', [ __CLASS__, 'convert_secondary_button' ], 20, 2 );
        add_filter( 'gform_previous_button', [ __CLASS__, 'convert_secondary_button' ], 20, 2 );
        add_filter( 'gform_get_form_filter', [ __CLASS__, 'add_footer_wrapper_classes' ], 20, 2 );
    }

    /**
     * Convert primary action button to block button format (submit, next)
     * 
     * @param string $button Button HTML
     * @param array $form Gravity Forms form array
     * @return string Modified button HTML
     */
    public static function convert_primary_button( $button, $form ) {
        $fragment = \WP_HTML_Processor::create_fragment( $button );
        $fragment->next_token();

        $class_attr = (string) $fragment->get_attribute( 'class' );
        $has_full   = preg_match( '/(?:^|\s)gform-button--width-full(?:\s|$)/', $class_attr ) === 1;
     
        $fragment->remove_class( 'button' );
        $fragment->add_class( 'wp-block-button__link' );
        $fragment->add_class( 'wp-element-button' );
        $fragment->remove_class( 'gform-button--width-full' );

        $attributes = self::extract_attributes( $fragment );
        
        // Build wrapper classes
        $wrapper_classes = array_filter( [
            $has_full ? 'gform-button--width-full' : '',
            self::$primary_button_style,
            self::$primary_button_classes
        ] );
        
        return do_blocks( sprintf(
            '<!-- wp:button {"className":"%3$s"} -->
                <div class="wp-block-button %3$s">
                    <button %1$s>%2$s</button>
                </div>
                <!-- /wp:button -->',
            implode( ' ', $attributes ),
            esc_html( $fragment->get_attribute( 'value' ) ),
            esc_attr( implode( ' ', $wrapper_classes ) )
        ) );
    }

    /**
     * Convert secondary action button to block button format (previous, back)
     * 
     * @param string $button Button HTML
     * @param array $form Gravity Forms form array
     * @return string Modified button HTML
     */
    public static function convert_secondary_button( $button, $form ) {
        $fragment = \WP_HTML_Processor::create_fragment( $button );
        $fragment->next_token();
     
        $fragment->remove_class( 'button' );
        $fragment->remove_class( 'gform_previous_button' );
        $fragment->remove_class( 'gform_next_button' );
        $fragment->add_class( 'wp-block-button__link' );
        $fragment->add_class( 'wp-element-button' );

        $attributes = self::extract_attributes( $fragment );

        // Build wrapper classes
        $wrapper_classes = array_filter( [
            self::$secondary_button_style,
            self::$secondary_button_classes
        ] );

        return do_blocks( sprintf(
            '<!-- wp:button {"className":"%3$s"} -->
                <div class="wp-block-button %3$s">
                    <button %1$s>%2$s</button>
                </div>
                <!-- /wp:button -->',
            implode( ' ', $attributes ),
            esc_html( $fragment->get_attribute( 'value' ) ),
            esc_attr( implode( ' ', $wrapper_classes ) )
        ) );
    }

    /**
     * Add block button wrapper classes to form footers
     * 
     * @param string $form_html Complete form HTML
     * @param array $form Gravity Forms form array
     * @return string Modified form HTML
     */
    public static function add_footer_wrapper_classes( $form_html, $form ) {
        $fragment = new \WP_HTML_Tag_Processor( $form_html );
        
        $footer_classes = [
            'gform-page-footer',
            'gform-footer'
        ];

        foreach ( $footer_classes as $footer_class ) {
            while ( $fragment->next_tag( [ 
                'tag_name' => 'div', 
                'class_name' => $footer_class 
            ] ) ) {
                $fragment->add_class( 'wp-block-buttons' );
                $fragment->add_class( 'is-layout-flex' );
                $fragment->add_class( 'wp-block-buttons-is-layout-flex' );
            }
        }
        
        return $fragment->get_updated_html();
    }

    /**
     * Extract all attributes from HTML fragment as formatted string array
     * 
     * @param \WP_HTML_Processor $fragment HTML processor instance
     * @return array Array of formatted attribute strings
     */
    private static function extract_attributes( $fragment ) {
        $attributes = $fragment->get_attribute_names_with_prefix( '' );
        $new_attributes = [];

        foreach ( $attributes as $attribute ) {
            $value = $fragment->get_attribute( $attribute );
            if ( ! empty( $value ) ) {
                $new_attributes[] = sprintf( '%s="%s"', $attribute, esc_attr( $value ) );
            }
        }

        return $new_attributes;
    }
}

// Initialize with default settings
GravityForms_Block_Buttons::init();

// Or customize:
// GravityForms_Block_Buttons::init( [
//     'primary_style' => 'is-style-fill',
//     'secondary_style' => 'is-style-outline',
//     'primary_classes' => 'my-custom-class',
//     'secondary_classes' => 'another-class'
// ] );
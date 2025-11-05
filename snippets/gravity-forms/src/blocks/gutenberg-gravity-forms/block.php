<?php
defined( 'ABSPATH' ) || exit;

/**
 * Server-side rendering of the `groundworx/gutenberg-gravity-forms` block.
 *
 * @package WordPress
 */

/**
 * Registers the `groundworx/gutenberg-gravity-forms` block on server.
 */
function register_block_groundworx_groundworx_gutenberg_gravity_forms() {
	register_block_type_from_metadata(
		__DIR__,
		array(
			'render_callback' => array( 'GWXGutenbergGravityForms', 'render' ),
		)
	);
}
add_action( 'init', 'register_block_groundworx_groundworx_gutenberg_gravity_forms' );

class GWXGutenbergGravityForms {

	private static function get_styles( $attributes ) {
		$colors       = static::build_css_colors( $attributes );
		$block_styles = isset( $attributes['styles'] ) ? $attributes['styles'] : '';

		return $block_styles . $colors['inline_styles'];
	}

	private static function build_css_colors( $attributes ) {

		$colors = array(
			'css_classes'           => array(),
			'inline_styles'         => static::get_color_css_vars( $attributes )
		);

		// Label color.
		$has_named_label_color  = array_key_exists( 'labelColor', $attributes );
		$has_custom_label_color = array_key_exists( 'customLabelColor', $attributes );

		if ( $has_custom_label_color || $has_named_label_color ) {
			$colors['css_classes'][] = 'has-label-color';
		}

		// Required color.
		$has_named_required_color  = array_key_exists( 'requiredColor', $attributes );
		$has_custom_required_color = array_key_exists( 'customRequiredColor', $attributes );

		if ( $has_custom_required_color || $has_named_required_color ) {
			$colors['css_classes'][] = 'has-label-required-color';
		}

		// Input text color.
		$has_named_input_text_color  = array_key_exists( 'inputTextColor', $attributes );
		$has_custom_input_text_color = array_key_exists( 'customInputTextColor', $attributes );

		if ( $has_custom_input_text_color || $has_named_input_text_color ) {
			$colors['css_classes'][] = 'has-input-color';
		}

		// Input background color.
		$has_named_input_background_color  = array_key_exists( 'inputBackgroundColor', $attributes );
		$has_custom_input_background_color = array_key_exists( 'customInputBackgroundColor', $attributes );

		if ( $has_custom_input_background_color || $has_named_input_background_color ) {
			$colors['css_classes'][] = 'has-input-background-color';
		}
		
		// Input border color.
		$has_named_input_border_color  = array_key_exists( 'inputBorderColor', $attributes );
		$has_custom_input_border_color = array_key_exists( 'customInputBorderColor', $attributes );

		if ( $has_custom_input_border_color || $has_named_input_border_color ) {
			$colors['css_classes'][] = 'has-input-border-color';
		}
		
		// Input radio background color.
		$has_named_input_radio_background_color  = array_key_exists( 'inputRadioBackgroundColor', $attributes );
		$has_custom_input_radio_background_color = array_key_exists( 'customInputRadioBackgroundColor', $attributes );

		if ( $has_custom_input_radio_background_color || $has_named_input_radio_background_color ) {
			$colors['css_classes'][] = 'has-input-checkbox-radio-background-color';
		}

		// Input radio background color.
		$has_named_input_radio_text_color  = array_key_exists( 'inputRadioTextColor', $attributes );
		$has_custom_input_radio_text_color = array_key_exists( 'customInputRadioTextColor', $attributes );

		if ( $has_custom_input_radio_text_color || $has_named_input_radio_text_color ) {
			$colors['css_classes'][] = 'has-input-checkbox-radio-text-color';
		}

		// Progressbar foreground color
		$has_named_progressbar_foreground_color  = array_key_exists( 'progressbarForegroundColor', $attributes );
		$has_custom_progressbar_foreground_color = array_key_exists( 'customProgressbarForegroundColor', $attributes );

		if ( $has_custom_progressbar_foreground_color || $has_named_progressbar_foreground_color ) {
			$colors['css_classes'][] = 'has-progressbar-foreground-color';
		}

		// Progressbar foreground text color
		$has_named_progressbar_foreground_text_color  = array_key_exists( 'progressbarForegroundTextColor', $attributes );
		$has_custom_progressbar_foreground_text_color = array_key_exists( 'customProgressbarForegroundTextColor', $attributes );

		if ( $has_custom_progressbar_foreground_text_color || $has_named_progressbar_foreground_text_color ) {
			$colors['css_classes'][] = 'has-progressbar-foreground-text-color';
		}

		// Progressbar background color
		$has_named_progressbar_background_color  = array_key_exists( 'progressbarBackgroundColor', $attributes );
		$has_custom_progressbar_background_color = array_key_exists( 'customProgressbarBackgroundColor', $attributes );

		if ( $has_custom_progressbar_background_color || $has_named_progressbar_background_color ) {
			$colors['css_classes'][] = 'has-progressbar-background-color';
		}

		return $colors;
	}
	
	private static function get_css_var_color( $preset, $custom, $var_name ) {
		if ( $preset ) {
			return "{$var_name}: var(--wp--preset--color--{$preset});";
		}
		if ( $custom ) {
			return "{$var_name}: {$custom};";
		}
		return '';
	}

	public static function get_color_css_vars( $attributes ) {
		$css = '';

		$css .= self::get_css_var_color( $attributes['labelColor'] ?? '', 					$attributes['customLabelColor'] ?? '', 					'--form--labels' );
		$css .= self::get_css_var_color( $attributes['requiredColor'] ?? '', 				$attributes['customRequiredColor'] ?? '', 				'--form--labels--required' );
		
		$css .= self::get_css_var_color( $attributes['inputTextColor'] ?? '', 				$attributes['customInputTextColor'] ?? '', 				'--form--input--text' );
		$css .= self::get_css_var_color( $attributes['inputBackgroundColor'] ?? '', 		$attributes['customInputBackgroundColor'] ?? '', 		'--form--input--background' );
		$css .= self::get_css_var_color( $attributes['inputBorderColor'] ?? '', 			$attributes['customInputBorderColor'] ?? '', 			'--form--input--border--color' );

		$css .= self::get_css_var_color( $attributes['inputRadioTextColor'] ?? '', 			$attributes['customInputRadioTextColor'] ?? '', 		'--form--checkbox-radio--text' );
		$css .= self::get_css_var_color( $attributes['inputRadioBackgroundColor'] ?? '', 	$attributes['customInputRadioBackgroundColor'] ?? '', 	'--form--checkbox-radio--background' );

		$css .= self::get_css_var_color( $attributes['progressbarForegroundTextColor'] ?? '', 	$attributes['customProgressbarForegroundTextColor'] ?? '', 	'--form--progressbar--foreground--text' );
		$css .= self::get_css_var_color( $attributes['progressbarForegroundColor'] ?? '', 	$attributes['customProgressbarForegroundColor'] ?? '', 	'--form--progressbar--foreground' );
		$css .= self::get_css_var_color( $attributes['progressbarBackgroundColor'] ?? '', 	$attributes['customProgressbarBackgroundColor'] ?? '', 	'--form--progressbar--background' );
		
		$css .= self::get_select_arrow_svg( $attributes );

		return $css;
	}

	private static function get_select_arrow_svg( $attributes ) {
		$color = $attributes['rgbInputTextColor'] ?? '';

		if ( empty( $color ) ) {
			return '';
		}
		
		$encoded_color = rawurlencode( $color );
		
		$svg = "--form--select--arrow: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 7.41'%3E%3Cpath d='M10.02,6,8.61,7.41,13.19,12,8.61,16.59,10.02,18l6-6Z' transform='translate(18 -8.61) rotate(90)' fill='{$encoded_color}'/%3E%3C/svg%3E\");";
		
		return $svg;
	}

	private static function get_classes( $attributes ) {
		$colors       = static::build_css_colors( $attributes );

		$classes = array_merge(
			$colors['css_classes']
		);

		return implode( ' ', $classes );
	}

	public static function render( $attributes, $content, $block ) {
		$style     	   = static::get_styles( $attributes );
		$class         = static::get_classes( $attributes );
		$extra_atts = [
			'class' => $class,
			'style' => $style
		];

		// Get GF attributes
		$gf_attributes = $attributes['gfAttributes'] ?? array();
		
		// Create a Gravity Forms block and render it
		$gf_block = array(
			'blockName'    => 'gravityforms/form',
			'attrs'        => $gf_attributes,
			'innerBlocks'  => array(),
			'innerHTML'    => '',
			'innerContent' => array(),
		);
		
		$gf_content = render_block( $gf_block );
		
		// Get wrapper attributes with all block supports
		$wrapper_attributes = get_block_wrapper_attributes( $extra_atts );
		
		return sprintf(
			'<div %1$s>%2$s</div>',
			$wrapper_attributes,
			$gf_content
		);
	}

}
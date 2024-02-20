<?php
/*
Plugin Name: Floating Text Effect
Description: Adds a floating text effect to your WordPress site.[floating_logo text="FLOATING" font_size="15vw" color="#ff0000"]

Version: 1.0
Author: Hassan Naqvi
*/

// Enqueue stylesheet
function floating_text_effect_enqueue_style() {
    wp_enqueue_style( 'floating-text-effect-style', plugins_url( 'style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'floating_text_effect_enqueue_style' );

function floating_logo_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'text' => '',        // Default empty
            'font_size' => '16px', // Default font size
            'color' => '#000000', // Default color
        ),
        $atts,
        'floating_logo'
    );

    // Sanitize and set text
    $text = sanitize_text_field($atts['text']);
    // Sanitize and set font size
    $font_size = sanitize_text_field($atts['font_size']);
    // Sanitize and set color
    $color = sanitize_hex_color($atts['color']);

    // Construct HTML output
    $output = '<div aria-label="Floating Logo" class="floating-logo" style="font-size: ' . esc_attr($font_size) . '; color: ' . esc_attr($color) . '">';
    $output .= '<div class="tilt">';
    // Loop through each character of the provided text
    for ($i = 0; $i < strlen($text); $i++) {
        // Output each character wrapped in a <span>
        $output .= '<span>' . esc_html($text[$i]) . '</span>';
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('floating_logo', 'floating_logo_shortcode');




// Function to display the settings page content
function floating_text_effect_settings_page() {
    ?>
    <div class="wrap">
        <h1>Floating Text Effect Plugin</h1>
        <p>Welcome to the Floating Text Effect plugin settings page.</p>
        <h2>How to Use Shortcode</h2>
        <p>To add a floating text effect to your WordPress site, use the following shortcode:</p>

        <pre>[floating_text text="YOUR_TEXT_HERE" font_size="FONT_SIZE_HERE" color="COLOR_CODE_HERE"]</pre>

        <p>Replace "YOUR_TEXT_HERE" with the desired text, "FONT_SIZE_HERE" with the font size (e.g., "15vw"), and "COLOR_CODE_HERE" with the color code (e.g., "#ff0000").</p>
    </div>
    <?php
}

// Function to add the settings page to the admin menu
function floating_text_effect_add_menu() {
    add_options_page('Floating Text Effect Settings', 'Floating Text Effect', 'manage_options', 'floating-text-effect-settings', 'floating_text_effect_settings_page');
}

// Hook to add the settings page
add_action('admin_menu', 'floating_text_effect_add_menu');

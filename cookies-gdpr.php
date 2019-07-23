<?php
/**
 * @package CookiesGdpr
 * @version 1.0.0
 */
/*
Plugin Name: Cookies GDPR
Plugin URI: github.com/mizalewski/wordpress--cookies-gdpr
Author: Michał Zalewski
Version: 1.0.0
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function cookies_gdpr_settings_api_init()
{
    // Add the section to reading settings so we can add our
    // fields to it
    add_settings_section(
        'cookies_gdpr_setting_section',
        'Pliki cookies',
        'cookies_gdpr_setting_section_callback_function',
        'general'
    );

    add_settings_field(
        'cookies_gdpr_setting_privacy_policy_link',
        'Adres polityki prywatności',
        'cookies_gdpr_setting_cookies_gdpr_id_callback_function',
        'general',
        'cookies_gdpr_setting_section'
    );

    register_setting('general', 'cookies_gdpr_setting_privacy_policy_link');
}

function cookies_gdpr_enqueue_scripts()
{
    wp_enqueue_script('cookies-gdpr-bar-js', plugins_url('/js/bar.js', __FILE__));
    wp_enqueue_style('cookies-gdpr-bar-css', plugins_url('/css/bar.css', __FILE__));
}

function cookies_gdpr_wp_footer()
{
    $privacyPolicyLink = get_option('cookies_gdpr_setting_privacy_policy_link');

    echo '
    <div id="cookies_gdpr_bar" class="cookies-gdpr-bar" style="display: none">
      <span class="cookies-gdpr-text">Strona używa plików cookie w celu poprawy jej funkcjonalności</span>
      <a class="cookies-gdpr-button cookies-gdpr-accept-button" data-user-action="accept">Akceptuję</a>
      <a class="cookies-gdpr-button cookies-gdpr-privacy-policy-button" href="' . $privacyPolicyLink . '">Polityka Prywatności</a>
    </div>';
}

function cookies_gdpr_setting_section_callback_function()
{
}

function cookies_gdpr_setting_cookies_gdpr_id_callback_function()
{
    echo '<input name="cookies_gdpr_setting_privacy_policy_link" id="cookies_gdpr_setting_privacy_policy_link" type="text" value="' . get_option('cookies_gdpr_setting_privacy_policy_link') . '" />';
}

add_action('wp_footer', 'cookies_gdpr_wp_footer');
add_action('admin_init', 'cookies_gdpr_settings_api_init');
add_action('wp_enqueue_scripts', 'cookies_gdpr_enqueue_scripts');

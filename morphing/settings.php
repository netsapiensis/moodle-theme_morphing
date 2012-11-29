<?php

defined('MOODLE_INTERNAL') || die;

global $PAGE;

if ($ADMIN->fulltree) {

    require_once dirname(__FILE__) . '/lib.php';
    require_once dirname(__FILE__) . '/settingslib.php';
    
    $s = new Morphing_Theme_Settings();
    $allowedtabs = $s->getAllTabs();
    
    $reset_all = optional_param('theme_morphing_reset_all', false, PARAM_INT);
    $tab = strtolower(optional_param('theme_morphing_settings_tab', 'general', PARAM_RAW));
    if (!in_array($tab, $allowedtabs)) {
        $tab = 'general'; //quietly display the general tab
    }
    
    if ($reset_all === 1) { //reset everything to default
        foreach ($allowedtabs as $_t) {
            if ($_t != 'reset') {
                foreach ($s->getSettingsSection($_t) as $setting) {
                    $setting->write_setting($setting->defaultsetting);
                }
            }
        }
        purge_all_caches();
        $settings->add(new theme_morphing_admin_setting_confightml('success', '', '', ''));
    }
    
    if ($tab == 'reset') {
        //hide save settings button
        $PAGE->add_body_class('morphing-settings-submit-hidden');
    }
    
    //-- ADD the html needed for the tabs navigation
    $settings->add(new theme_morphing_admin_setting_confightml('tabs', $tab, $allowedtabs, ''));
    
    //all visible settings
    $visible = $s->getSettingsSection($tab);
    foreach ($visible as $setting) {
        $settings->add($setting);
    }
    
    //add the hidden field to remember the active tab
    $settings->add(new theme_morphing_admin_setting_confightml('hidden', 'theme_morphing_settings_tab', $tab, ''));
    
}
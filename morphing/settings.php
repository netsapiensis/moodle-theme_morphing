<?php
/*
 * ---------------------------------------------------------------------------------------------------------------------
 * This file is part of the Morphing theme for Moodle
 *
 * The Morphing theme for Moodle software package is Copyright © 2008 onwards NetSapiensis AB and is provided
 * under the terms of the GNU GENERAL PUBLIC LICENSE Version 3 (GPL). This program is free software: you can
 * redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program. If not, see
 * http://www.gnu.org/licenses/
 * ---------------------------------------------------------------------------------------------------------------------
 */

defined('MOODLE_INTERNAL') || die;

global $PAGE;

if ($ADMIN->fulltree) {
    
    require_once dirname(__FILE__) . '/lib.php';
    require_once dirname(__FILE__) . '/settingslib.php';
    
    //handle everything in this class, keep this file simple
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
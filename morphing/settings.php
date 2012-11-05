<?php

defined('MOODLE_INTERNAL') || die;

require_once dirname(__FILE__) . '/lib.php';

if ($ADMIN->fulltree) {

    require_once dirname(__FILE__) . '/settingslib.php';

    $s = new Morphing_Theme_Settings();

    $reset_all = optional_param('theme_morphing_reset_all', false, PARAM_INT);

    //-- RESET EVERYTHING TO DEFAULT -------------------------------------------
    $settings->add($s->getAdminSetting('reset_everything'));

    //-- GENERAL SETTINGS ------------------------------------------------------
    $general = $s->getSettingsSection('general');

    //-- HEADER SETTINGS -------------------------------------------------------
    $header = $s->getSettingsSection('header');

    //-- LOGO SETTINGS ---------------------------------------------------------
    $logo = $s->getSettingsSection('logo');

    //-- BLOCK SETTINGS --------------------------------------------------------
    $block = $s->getSettingsSection('block');

    //-- MISCELLANEOUS SETTINGS ------------------------------------------------
    $miscellaneous = $s->getSettingsSection('miscellaneous');

    //-- CUSTOM MENU SETTINGS --------------------------------------------------
    $custommenu = $s->getSettingsSection('custommenu');

    if ($reset_all === 1) { //reset everything to default
        foreach (array_merge($general, $header, $logo, $block, $miscellaneous, $custommenu) as $s) {
            $s->write_setting($s->defaultsetting);
        }
        purge_all_caches();
    }

    //-- ADD THE SETTINGS TO THE PAGE ------------------------------------------
    foreach (array_merge($general, $header, $logo, $block, $miscellaneous, $custommenu) as $s) {
        $settings->add($s);
    }
}
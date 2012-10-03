<?php

defined('MOODLE_INTERNAL') || die;

require_once dirname(__FILE__) . '/lib.php';

if ($ADMIN->fulltree) {
    
    $theme_settings = array();
    
    $reset_all = optional_param('theme_morphing_reset_all', false, PARAM_INT);
    
    // font size reference
    $name = 'theme_morphing/fontsizereference';
    $title = get_string('fontsizereference', 'theme_morphing');
    $description = get_string('fontsizereferencedesc', 'theme_morphing');
    $default = '13';
    $choices = array(11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $theme_settings []= $setting;
    
    //breadcrumb font size
    $name = 'theme_morphing/breadcrumbfontsize';
    $title = get_string('breadcrumbfontsize', 'theme_morphing');
    $description = get_string('breadcrumbfontsizedesc', 'theme_morphing');
    $default = '12';
    $choices = array();
    for($i = 9; $i < 21; $i++) {
        $choices[$i] = $i . 'px';
    }
    $theme_settings []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    // block "label" font size
    $name = 'theme_morphing/blocktitlefontsize';
    $title = get_string('blocktitlefontsize', 'theme_morphing');
    $description = get_string('blocktitlefontsizedesc', 'theme_morphing');
    $default = '12';
    $choices = array();
    for($i = 9; $i < 21; $i++) {
        $choices[$i] = $i . 'px';
    }
    $theme_settings []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    //block label positioning
    $name = 'theme_morphing/blocktitlealign';
    $title = get_string('blocktitlealign', 'theme_morphing');
    $description = get_string('blocktitlealigndesc', 'theme_morphing');
    $default = 'left';
    $choices = array('left' => get_string('alignleft', 'theme_morphing'), 'center' => get_string('aligncenter', 'theme_morphing'), 'right' => get_string('alignright', 'theme_morphing'));
    $theme_settings []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    //block label left offset
    $name = 'theme_morphing/blocktitleleft';
    $title = get_string('blocktitleleft', 'theme_morphing');
    $description = get_string('blocktitleleftdesc', 'theme_morphing');
    $default = 5;
    $theme_settings []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    
    // font color reference
    $name = 'theme_morphing/fontcolor';
    $title = get_string('fontcolor', 'theme_morphing');
    $description = get_string('fontcolordesc', 'theme_morphing');
    $default = '#000000';
    $previewconfig = array('selector' => 'html,body,.form-description', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $theme_settings []= $setting;

    // page header background color setting
    $name = 'theme_morphing/headerbgc';
    $title = get_string('headerbgc', 'theme_morphing');
    $description = get_string('headerbgcdesc', 'theme_morphing');
    $default = '#1f465e';
    $previewconfig = array('selector' => '#headerwrap', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $theme_settings []= $setting;

    // Background color setting
    $name = 'theme_morphing/backgroundcolor';
    $title = get_string('backgroundcolor', 'theme_morphing');
    $description = get_string('backgroundcolordesc', 'theme_morphing');
    $default = '#F7F6F1';
    $previewconfig = array('selector' => '.block .content', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $theme_settings []= $setting;

    // Logo file setting
    $name = 'theme_morphing/logo';
    $title = get_string('logo', 'theme_morphing');
    $description = get_string('logodesc', 'theme_morphing');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $theme_settings []= $setting;

    //Logo offset width
    $name = 'theme_morphing/logooffsetleft';
    $title = get_string('logooffsetleft', 'theme_morphing');
    $description = get_string('logooffsetleftdesc', 'theme_morphing');
    $default = 105;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $theme_settings []= $setting;

    //Logo offset height
    $name = 'theme_morphing/logooffsettop';
    $title = get_string('logooffsettop', 'theme_morphing');
    $description = get_string('logooffsettopdesc', 'theme_morphing');
    $default = 15;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $theme_settings []= $setting;

    // Block region width
    $name = 'theme_morphing/regionwidth';
    $title = get_string('regionwidth', 'theme_morphing');
    $description = get_string('regionwidthdesc', 'theme_morphing');
    $default = 200;
    $choices = array(150 => '150px', 170 => '170px', 200 => '200px', 240 => '240px', 290 => '290px', 350 => '350px', 420 => '420px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $theme_settings []= $setting;

    // Header height
    $name = 'theme_morphing/headerheight';
    $title = get_string('headerheight', 'theme_morphing');
    $description = get_string('headerheightdesc', 'theme_morphing');
    $default = 80;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $theme_settings []= $setting;

    //Breadcrumb height
    $name = 'theme_morphing/breadcrumbheight';
    $title = get_string('breadcrumbheight', 'theme_morphing');
    $description = get_string('breadcrumbheightdesc', 'theme_morphing');
    $default = 35;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $theme_settings []= $setting;
    
    //Breadcrumb left offset
    $name = 'theme_morphing/breadcrumbleft';
    $title = get_string('breadcrumbleft', 'theme_morphing');
    $description = get_string('breadcrumbleftdesc', 'theme_morphing');
    $default = 15;
    $theme_settings []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    
    //Breadcrumb top offset
    $name = 'theme_morphing/breadcrumbtop';
    $title = get_string('breadcrumbtop', 'theme_morphing');
    $description = get_string('breadcrumbtopdesc', 'theme_morphing');
    $default = 0;
    $theme_settings []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);

    // alwayslangmenu setting
    $name = 'theme_morphing/alwayslangmenu';
    $title = get_string('alwayslangmenu', 'theme_morphing');
    $description = get_string('alwayslangmenudesc', 'theme_morphing');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $theme_settings []= $setting;

    // Foot note setting
    $name = 'theme_morphing/footnote';
    $title = get_string('footnote', 'theme_morphing');
    $description = get_string('footnotedesc', 'theme_morphing');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $theme_settings []= $setting;

    // Custom CSS file
    $name = 'theme_morphing/customcss';
    $title = get_string('customcss', 'theme_morphing');
    $description = get_string('customcssdesc', 'theme_morphing');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $theme_settings []= $setting;

    // link color setting
    $name = 'theme_morphing/linkcolor';
    $title = get_string('linkcolor', 'theme_morphing');
    $description = get_string('linkcolordesc', 'theme_morphing');
    $default = '#113759';
    $previewconfig = array('selector' => 'html a,body a', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $theme_settings []= $setting;
    
    //visited link color
    $name = 'theme_morphing/visitedlinkcolor';
    $title = get_string('visitedlinkcolor', 'theme_morphing');
    $description = get_string('visitedlinkcolordesc', 'theme_morphing');
    $default = '#113759';
    $theme_settings []= new admin_setting_configcolourpicker($name, $title, $description, $default, null);

    // main color setting
    $name = 'theme_morphing/maincolor';
    $title = get_string('maincolor', 'theme_morphing');
    $description = get_string('maincolordesc', 'theme_morphing');
    $default = '#1f465e';
    $previewconfig = array('selector' => 'div#jcontrols_button,#footerwrapper,.block div.header,#dock', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $theme_settings []= $setting;
    
    $name = 'theme_morphing/loggedincolor';
    $title = get_string('loggedincolor', 'theme_morphing');
    $description = get_string('loggedincolordesc', 'theme_morphing');
    $default = '#00aeef';
    $previewconfig = array('selector' => 'a.logged-in-link', 'style' => 'color');
    $theme_settings []= new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    
    $name = 'theme_morphing/reset_everything';
    $title = get_string('resettitle', 'theme_morphing');
    $reset_all_setting = new morphing_admin_setting_confightml($name, $title, '', '');
    
    if ($reset_all === 1) { //reset everything to default
        foreach ($theme_settings as $s) {
            $s->write_setting($s->defaultsetting);
        }
        purge_all_caches();
    }
    
    foreach ($theme_settings as $s) {
        $settings->add($s);
    }
    
    $settings->add($reset_all_setting);
}
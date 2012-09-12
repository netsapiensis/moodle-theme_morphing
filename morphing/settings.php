<?php

 
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // font size reference
    $name = 'theme_morphing/fontsizereference';
    $title = get_string('fontsizereference','theme_morphing');
    $description = get_string('fontsizereferencedesc', 'theme_morphing');
    $default = '13';
    $choices = array(11=>'11px', 12=>'12px', 13=>'13px', 14=>'14px', 15=>'15px', 16=>'16px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
    // font colour reference
    $name = 'theme_morphing/fontcolour';
    $title = get_string('fontcolour','theme_morphing');
    $description = get_string('fontcolourdesc', 'theme_morphing');
    $default = '#000000';
    $previewconfig = array('selector' => 'html,body,.form-description', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);
    
    // page header background colour setting
    $name = 'theme_morphing/headerbgc';
    $title = get_string('headerbgc','theme_morphing');
    $description = get_string('headerbgcdesc', 'theme_morphing');
    $default = '#0A1F33';
    $previewconfig = array('selector'=>'#headerwrap', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);
    
    // Background colour setting
    $name = 'theme_morphing/backgroundcolor';
    $title = get_string('backgroundcolor','theme_morphing');
    $description = get_string('backgroundcolordesc', 'theme_morphing');
    $default = '#F7F6F1';
    $previewconfig = array('selector'=>'.block .content', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);
    
    // Logo file setting
    $name = 'theme_morphing/logo';
    $title = get_string('logo','theme_morphing');
    $description = get_string('logodesc', 'theme_morphing');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $settings->add($setting);
    
    //Logo offset width
    $name = 'theme_morphing/logooffsetleft';
    $title = get_string('logooffsetleft', 'theme_morphing');
    $description = get_string('logooffsetleftdesc', 'theme_morphing');
    $default = 105;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $settings->add($setting);
    
    //Logo offset height
    $name = 'theme_morphing/logooffsettop';
    $title = get_string('logooffsettop', 'theme_morphing');
    $description = get_string('logooffsettopdesc', 'theme_morphing');
    $default = 15;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $settings->add($setting);
    
    // Block region width
    $name = 'theme_morphing/regionwidth';
    $title = get_string('regionwidth','theme_morphing');
    $description = get_string('regionwidthdesc', 'theme_morphing');
    $default = 200;
    $choices = array(150=>'150px', 170=>'170px', 200=>'200px', 240=>'240px', 290=>'290px', 350=>'350px', 420=>'420px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
    // Header height
    $name = 'theme_morphing/headerheight';
    $title = get_string('headerheight', 'theme_morphing');
    $description = get_string('headerheightdesc', 'theme_morphing');
    $default = 80;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $settings->add($setting);
    
    //Breadcrumb height
    $name = 'theme_morphing/breadcrumbheight';
    $title = get_string('breadcrumbheight', 'theme_morphing');
    $description = get_string('breadcrumbheightdesc', 'theme_morphing');
    $default = 35;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $settings->add($setting);
    
    // alwayslangmenu setting
    $name = 'theme_morphing/alwayslangmenu';
    $title = get_string('alwayslangmenu','theme_morphing');
    $description = get_string('alwayslangmenudesc', 'theme_morphing');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $settings->add($setting);
    
    // Foot note setting
    $name = 'theme_morphing/footnote';
    $title = get_string('footnote','theme_morphing');
    $description = get_string('footnotedesc', 'theme_morphing');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_morphing/customcss';
    $title = get_string('customcss','theme_morphing');
    $description = get_string('customcssdesc', 'theme_morphing');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);

// link color setting
	$name = 'theme_morphing/linkcolor';
	$title = get_string('linkcolor','theme_morphing');
	$description = get_string('linkcolordesc', 'theme_morphing');
	$default = '#113759';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);

// main color setting
	$name = 'theme_morphing/maincolor';
	$title = get_string('maincolor','theme_morphing');
	$description = get_string('maincolordesc', 'theme_morphing');
	$default = '#0a1f33';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);


}
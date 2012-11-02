<?php

defined('MOODLE_INTERNAL') || die;

require_once dirname(__FILE__) . '/lib.php';

if ($ADMIN->fulltree) {
    
    $general = $header = $logo = $block = $custommenu = $miscellaneous = $features =  array();
    
    $reset_all = optional_param('theme_morphing_reset_all', false, PARAM_INT);
    
    $name = 'theme_morphing/reset_everything';
    $title = get_string('resettitle', 'theme_morphing');
    $reset_all_setting = new morphing_admin_setting_confightml($name, $title, '', '');
    
    $settings->add($reset_all_setting);
    
    //-- GENERAL SETTINGS ------------------------------------------------------
    $general []= new morphing_admin_setting_header(get_string('general', 'theme_morphing'));
    
    // font size reference
    $name = 'theme_morphing/fontsizereference';
    $title = get_string('fontsizereference', 'theme_morphing');
    $description = get_string('fontsizereferencedesc', 'theme_morphing');
    $default = '13';
    $choices = array(11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $general []= $setting;
    
    // (default) font color reference
    $name = 'theme_morphing/fontcolor';
    $title = get_string('fontcolor', 'theme_morphing');
    $description = get_string('fontcolordesc', 'theme_morphing');
    $default = '#000000';
    $previewconfig = array('selector' => 'html,body,.form-description', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $general []= $setting;
    
    // link color setting
    $name = 'theme_morphing/linkcolor';
    $title = get_string('linkcolor', 'theme_morphing');
    $description = get_string('linkcolordesc', 'theme_morphing');
    $default = '#113759';
    $previewconfig = array('selector' => 'html a,body a', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $general []= $setting;
    
    //visited link color
    $name = 'theme_morphing/visitedlinkcolor';
    $title = get_string('visitedlinkcolor', 'theme_morphing');
    $description = get_string('visitedlinkcolordesc', 'theme_morphing');
    $default = '#113759';
    $general []= new admin_setting_configcolourpicker($name, $title, $description, $default, null);

    // main color setting
    $name = 'theme_morphing/maincolor';
    $title = get_string('maincolor', 'theme_morphing');
    $description = get_string('maincolordesc', 'theme_morphing');
    $default = '#1f465e';
    $previewconfig = array('selector' => 'div#jcontrols_button,#footerwrapper,.block div.header,#dock', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $general []= $setting;
    
    //logged in color
    $name = 'theme_morphing/loggedincolor';
    $title = get_string('loggedincolor', 'theme_morphing');
    $description = get_string('loggedincolordesc', 'theme_morphing');
    $default = '#00aeef';
    $previewconfig = array('selector' => 'a.logged-in-link', 'style' => 'color');
    $general []= new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    
    // show language menu setting
    $name = 'theme_morphing/alwayslangmenu';
    $title = get_string('alwayslangmenu', 'theme_morphing');
    $description = get_string('alwayslangmenudesc', 'theme_morphing');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $general []= $setting;
    
    // layout type settings
    $name = 'theme_morphing/layouttype';
    $title = get_string('layouttype', 'theme_morphing');
    $description = get_string('layouttypedesc', 'theme_morphing');
    $default = 'fluid';
    $choices = array('fluid' => get_string('layouttypefluid', 'theme_morphing'), 'fixed' => get_string('layouttypefixed', 'theme_morphing'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $general []= $setting;
    
    // fluid width percentage
    $name = 'theme_morphing/layoutfluidwidth';
    $title = get_string('layoutfluidwidth', 'theme_morphing');
    $description = get_string('layoutfluidwidthdesc', 'theme_morphing');
    $default = '100%';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $general []= $setting;
    
    // fixed width (px)
    $name = 'theme_morphing/layoutfixedwidth';
    $title = get_string('layoutfixedwidth', 'theme_morphing');
    $description = get_string('layoutfixedwidthdesc', 'theme_morphing');
    $default = '900px';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $general []= $setting;
    
    //theme background color
    $name = 'theme_morphing/mainbackgroundcolor';
    $title = get_string('mainbackgroundcolor', 'theme_morphing');
    $description = get_string('mainbackgroundcolordesc', 'theme_morphing');
    $default = '#E0E0E0';
    $previewconfig = array('selector' => 'html, body', 'style' => 'background');
    $general []= new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    //-- End GENERAL SETTINS ---------------------------------------------------
    
    //-- HEADER SETTINGS -------------------------------------------------------
    $header []= new morphing_admin_setting_header(get_string('header', 'theme_morphing'));
    
    // header background color setting
    $name = 'theme_morphing/headerbgc';
    $title = get_string('headerbgc', 'theme_morphing');
    $description = get_string('headerbgcdesc', 'theme_morphing');
    $default = '#1f465e';
    $previewconfig = array('selector' => '#headerwrap', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $header []= $setting;
    
    // Header height
    $name = 'theme_morphing/headerheight';
    $title = get_string('headerheight', 'theme_morphing');
    $description = get_string('headerheightdesc', 'theme_morphing');
    $default = 80;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $header []= $setting;
    
    // Header link color
    $name = 'theme_morphing/headerlinkcolor';
    $title = get_string('headerlinkcolor', 'theme_morphing');
    $description = get_string('headerlinkcolordesc', 'theme_morphing');
    $default = '#FFFFFF';
    $previewconfig = array('selector' => '#headerwrap a, #jcontrols_button a', 'style' => 'color');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $header []= $setting;
    
    //-- end HEADER SETTINGS ---------------------------------------------------
    
    //-- LOGO SETTINGS ---------------------------------------------------------
    $logo []= new morphing_admin_setting_header(get_string('logo', 'theme_morphing'));
    // Logo Url
    $name = 'theme_morphing/logo';
    $title = get_string('logo', 'theme_morphing');
    $description = get_string('logodesc', 'theme_morphing');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $logo []= $setting;

    //Logo offset width
    $name = 'theme_morphing/logooffsetleft';
    $title = get_string('logooffsetleft', 'theme_morphing');
    $description = get_string('logooffsetleftdesc', 'theme_morphing');
    $default = 105;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $logo []= $setting;

    //Logo offset height
    $name = 'theme_morphing/logooffsettop';
    $title = get_string('logooffsettop', 'theme_morphing');
    $description = get_string('logooffsettopdesc', 'theme_morphing');
    $default = 15;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $logo []= $setting;
    
    //breadcrumb font size
    $name = 'theme_morphing/breadcrumbfontsize';
    $title = get_string('breadcrumbfontsize', 'theme_morphing');
    $description = get_string('breadcrumbfontsizedesc', 'theme_morphing');
    $default = '12';
    $choices = array();
    for($i = 9; $i < 21; $i++) {
        $choices[$i] = $i . 'px';
    }
    $logo []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    //Breadcrumb height
    $name = 'theme_morphing/breadcrumbheight';
    $title = get_string('breadcrumbheight', 'theme_morphing');
    $description = get_string('breadcrumbheightdesc', 'theme_morphing');
    $default = 35;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $logo []= $setting;
    
    //Breadcrumb left offset
    $name = 'theme_morphing/breadcrumbleft';
    $title = get_string('breadcrumbleft', 'theme_morphing');
    $description = get_string('breadcrumbleftdesc', 'theme_morphing');
    $default = 15;
    $logo []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    
    //Breadcrumb top offset
    $name = 'theme_morphing/breadcrumbtop';
    $title = get_string('breadcrumbtop', 'theme_morphing');
    $description = get_string('breadcrumbtopdesc', 'theme_morphing');
    $default = 0;
    $logo []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    
    //-- end LOGO SETTINGS -----------------------------------------------------
    
    //-- BLOCK SETTINGS --------------------------------------------------------
    $block []= new morphing_admin_setting_header(get_string('block', 'theme_morphing'));
    // block title font size
    $name = 'theme_morphing/blocktitlefontsize';
    $title = get_string('blocktitlefontsize', 'theme_morphing');
    $description = get_string('blocktitlefontsizedesc', 'theme_morphing');
    $default = '12';
    $choices = array();
    for($i = 9; $i < 21; $i++) {
        $choices[$i] = $i . 'px';
    }
    $block []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    // Block region width
    $name = 'theme_morphing/regionwidth';
    $title = get_string('regionwidth', 'theme_morphing');
    $description = get_string('regionwidthdesc', 'theme_morphing');
    $default = 200;
    $choices = array(150 => '150px', 170 => '170px', 200 => '200px', 240 => '240px', 290 => '290px', 350 => '350px', 420 => '420px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $block []= $setting;
    
    //block title alignment
    $name = 'theme_morphing/blocktitlealign';
    $title = get_string('blocktitlealign', 'theme_morphing');
    $description = get_string('blocktitlealigndesc', 'theme_morphing');
    $default = 'left';
    $choices = array('left' => get_string('alignleft', 'theme_morphing'), 'center' => get_string('aligncenter', 'theme_morphing'), 'right' => get_string('alignright', 'theme_morphing'));
    $block []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    //block title left offset
    $name = 'theme_morphing/blocktitleleft';
    $title = get_string('blocktitleleft', 'theme_morphing');
    $description = get_string('blocktitleleftdesc', 'theme_morphing');
    $default = 5;
    $block []= new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    
    // Background color setting
    $name = 'theme_morphing/backgroundcolor';
    $title = get_string('backgroundcolor', 'theme_morphing');
    $description = get_string('backgroundcolordesc', 'theme_morphing');
    $default = '#F7F6F1';
    $previewconfig = array('selector' => '.block .content', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $block []= $setting;
    
    // Block header color
    $name = 'theme_morphing/blockheadercolor';
    $title = get_string('blockheadercolor', 'theme_morphing');
    $description = get_string('blockheadercolordesc', 'theme_morphing');
    $default = '#1F465E';
    $previewconfig = array('selector' => '.block div.header', 'style' => 'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $block []= $setting;
    
    // Block border color
    $name = 'theme_morphing/blockbordercolor';
    $title = get_string('blockbordercolor', 'theme_morphing');
    $description = get_string('blockbordercolordesc', 'theme_morphing');
    $default = '#CCCCCC';
    $previewconfig = array('selector' => '.block', 'style' => 'border');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $block []= $setting;
    
    //-- end BLOCK SETTINGS ----------------------------------------------------
    
    
    //-- MISCELLANEOUS SETTINGS ------------------------------------------------
    $miscellaneous []= new morphing_admin_setting_header(get_string('miscellaneous', 'theme_morphing'));
    // Foot note setting
    $name = 'theme_morphing/footnote';
    $title = get_string('footnote', 'theme_morphing');
    $description = get_string('footnotedesc', 'theme_morphing');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $miscellaneous []= $setting;

    // Custom CSS file
    $name = 'theme_morphing/customcss';
    $title = get_string('customcss', 'theme_morphing');
    $description = get_string('customcssdesc', 'theme_morphing');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $miscellaneous []= $setting;
    //-- end MISCELLANEOUS SETTINGS --------------------------------------------
    
    //-- CUSTOM MENU SETTINGS --------------------------------------------------
    $custommenu []= new morphing_admin_setting_header(get_string('custommenu', 'theme_morphing'));
    
    //where to display
    $name = 'theme_morphing/custommenudisplay';
    $title = get_string('custommenudisplay', 'theme_morphing');
    $description = get_string('custommenudisplaydesc', 'theme_morphing');
    $default = 'none';
    $choices = array(
        'none' => get_string('none', 'theme_morphing'), 
        'front' => get_string('frontpage', 'theme_morphing'),
        'all' => get_string('allpages', 'theme_morphing'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $custommenu []= $setting;
    
    //Custom menu height
    $name = 'theme_morphing/custommenuheight';
    $title = get_string('custommenuheight', 'theme_morphing');
    $description = get_string('custommenuheightdesc', 'theme_morphing');
    $default = 35;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $header []= $setting;
    
    //custom menu items - this will be the same as the default moodle custom items
    $custommenu []= new admin_setting_configtextarea('custommenuitems', get_string('custommenuitemsdesc', 'theme_morphing') . '<br />' . new lang_string('custommenuitems', 'admin'), new lang_string('configcustommenuitems', 'admin'), '', PARAM_TEXT, '50', '10');
    
    //custom menu alignment
    $name = 'theme_morphing/custommenualign';
    $title = get_string('custommenualign', 'theme_morphing');
    $description = get_string('custommenualigndesc', 'theme_morphing');
    $default = 'left';
    $choices = array('left' => get_string('alignleft', 'theme_morphing'), 'center' => get_string('aligncenter', 'theme_morphing'));
    $custommenu []= new admin_setting_configselect($name, $title, $description, $default, $choices);
    
    //-- end CUSTOM MENU SETTINGS ----------------------------------------------
    
    //new features
    $features []= new morphing_admin_setting_header(' ');
    
    // theme background image url
    $name = 'theme_morphing/mainbackgroundimage';
    $title = get_string('backgroundimage', 'theme_morphing');
    $description = get_string('backgroundimagedesc', 'theme_morphing');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $features []= $setting;
    
    // header second image
    $name = 'theme_morphing/secondlogo';
    $title = get_string('headersecondimage', 'theme_morphing');
    $description = get_string('headersecondimagedesc', 'theme_morphing');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $features []= $setting;
    
    if ($reset_all === 1) { //reset everything to default
        foreach (array_merge($general, $header, $logo, $block, $miscellaneous, $custommenu, $features) as $s) {
            $s->write_setting($s->defaultsetting);
        }
        purge_all_caches();
    }
    
    foreach (array_merge($general, $header, $logo, $block, $miscellaneous, $custommenu, $features) as $s) {
        $settings->add($s);
    }
    
}
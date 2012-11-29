<?php

defined('MOODLE_INTERNAL') || die;

global $PAGE;

$url = clone $PAGE->url;

$tab_param = 'theme_morphing_settings_tab';
$currenttab = $this->visiblename; //:-)

$tabs = array();
foreach(array('general', 'header', 'logo', 'block', 'custommenu', 'miscellaneous', 'reset') as $tab) {
    $url->param($tab_param, $tab);
    $tabs []= new tabobject($tab, $url->__toString(), get_string($tab, 'theme_morphing'));
}

print_tabs(array($tabs), $currenttab);
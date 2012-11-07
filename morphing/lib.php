<?php

require_once $CFG->dirroot . '/lib/adminlib.php';
require_once dirname(__FILE__) . '/settingslib.php';

function morphing_process_css($css, $theme)
{
    global $OUTPUT;
    $s = new Morphing_Theme_Settings($theme);
    //layout type
    $type = $s->get('layouttype');
    switch ($type) {
        case 'fixed':
            $width = intval(str_replace(array('px', '%'), '', $s->get('layoutfixedwidth')));
            if ($width < 0) {
                $width = 900;
            }
            $width .= 'px';
            break;
        case 'fluid':
        default:
            $width = intval(str_replace(array('px', '%'), '', $s->get('layoutfluidwidth')));
            $width .= '%';
            break;
    }
    $css = str_replace('[[setting:layoutwidth]]', $width, $css);
    
    //apply each setting that can be applied directly, without further processing
    $autoApply = array('mainbackgroundcolor', 'headerlinkcolor', 'blockheadercolor', 'blockbordercolor', 'fontcolor', 'headerbgc');
    
    $image = !empty($theme->settings->mainbackgroundimage) ? $theme->settings->mainbackgroundimage: $OUTPUT->pix_url('theme_background', 'theme');
    if (!empty($image)) {
        $image = 'url(' . $image . ')';
    }
    $css = str_replace('[[setting:mainbackgroundimage]]', $image, $css);
    
    //custom menu height
    $custommenuheight = intval($s->get('custommenuheight'));
    $css = str_replace('[[setting:custommenuheight]]', $custommenuheight . 'px', $css);
    $top = intval(($custommenuheight - 24) / 2);
    $css = str_replace('[[setting:custommenutop]]', $top . 'px', $css);
    
    //custom menu alignment
    $align = $s->get('custommenualign');
    if ($align == 'center') {
        $align = 'text-align: center;';
    } else {
        $align = '';
    }
    $css = str_replace('[[setting:custommenualign]]', $align, $css);
    
    // Set the font reference size
    $fontsizereference = intval($s->get('fontsizereference'));
    $css = str_replace('[[setting:fontsizereference]]', $fontsizereference . 'px', $css);
    
    //block title font size
    $bfs = $s->get('blocktitlefontsize');
    $css = str_replace('[[setting:blocktitlefontsize]]', $bfs . 'px', $css);
    
    //breadcrumb font size
    $bfs = $s->get('breadcrumbfontsize');
    $css = str_replace('[[setting:breadcrumbfontsize]]', $bfs . 'px', $css);

    
    // Set the page header background color
    $autoApply []= 'headerbgc';
    //background color
    $autoApply []= 'backgroundcolor';
    
    // Set the region width
    $regionwidth = $s->get('regionwidth');
    $css = morphing_set_regionwidth($css, $regionwidth);
    
    //set the block title alignement and offset
    $blocktitlealign = $s->get('blocktitlealign');
    $css = str_replace('[[setting:blocktitlealign]]', $blocktitlealign, $css);
    if ($blocktitlealign != 'right') { //if right alignment, there is no need for left padding
        $blocktitleleft = !empty($theme->settings->blocktitleleft) ? $theme->settings->blocktitleleft : 5;
        $css = str_replace('[[setting:blocktitleleft]]', $blocktitleleft . 'px', $css);
    }

    //set the header height
    $headerheight = $s->get('headerheight') . 'px';
    $css = str_replace('[[setting:headerheight]]', $headerheight, $css);

    //set the logo position
    $logotop = $s->get('logooffsettop') . 'px';
    $css = str_replace('[[setting:logotop]]', $logotop, $css);
    $logoleft = $s->get('logooffsetleft') . 'px';
    $css = str_replace('[[setting:logoleft]]', $logoleft, $css);

    //breadcrumb height
    $navbarheight = $s->get('breadcrumbheight') . 'px';
    $css = str_replace('[[setting:navheight]]', $navbarheight, $css);
    
    //breadcrumb left offset
    $left = $s->get('breadcrumbleft') . 'px';
    $css = str_replace('[[setting:breadcrumbleft]]', $left, $css);
    
    //breadcrumb top offset
    $top = $s->get('breadcrumbtop') . 'px';
    $css = str_replace('[[setting:breadcrumbtop]]', $top, $css);

    // Set the link color
    $autoApply []= 'linkcolor';
    
    // Set the visited link color
    $autoApply []= 'visitedlinkcolor';

    // Set the main color
    $autoApply []= 'maincolor';
    
    //set the logged in user link color
    $autoApply []= 'loggedincolor';

    // Set the custom CSS
    $autoApply []= 'customcss';
    
    foreach($autoApply as $tag) {
        $css = $s->apply($tag, $css);
    }
    
    return $css;
}

/**
 * Sets the region width variable in CSS
 *
 * @param string $css
 * @param mixed $regionwidth
 * @return string
 */
function morphing_set_regionwidth($css, $regionwidth)
{
    $tag = '[[setting:regionwidth]]';
    $doubletag = '[[setting:regionwidthdouble]]';
    $replacement = $regionwidth;
    $css = str_replace($tag, $replacement . 'px', $css);
    $css = str_replace($doubletag, ($replacement * 2) . 'px', $css);
    $css = str_replace($tag, ($replacement + 10) . 'px', $css);
    return $css;
}

class morphing_admin_setting_confightml extends admin_setting
{

    public function get_setting()
    {
        return 'mama';
    }

    public function write_setting($data)
    {
        
    }

    public function __construct($name, $visiblename, $description, $defaultsetting)
    {
        $this->name = $name;
        $this->visiblename = $visiblename;
    }

    /**
     * Returns the fullname prefixed by the plugin
     * @return string
     */
    public function get_full_name()
    {
        return '';
    }

    /**
     * Returns the ID string based on plugin and name
     * @return string
     */
    public function get_id()
    {
        return '';
    }

    /**
     * @param bool $affectsmodinfo If true, changes to this setting will
     *   cause the course cache to be rebuilt
     */
    public function set_affects_modinfo($affectsmodinfo)
    {
        
    }

    /**
     * Returns the config if possible
     *
     * @return mixed returns config if successful else null
     */
    public function config_read($name)
    {
        return null;
    }

    /**
     * Used to set a config pair and log change
     *
     * @param string $name
     * @param mixed $value Gets converted to string if not null
     * @return bool Write setting to config table
     */
    public function config_write($name, $value)
    {
        return true; // BC only
    }

    /**
     * Returns default setting if exists
     * @return mixed array or string depending on instance; NULL means no default, user must supply
     */
    public function get_defaultsetting()
    {
        return '';
    }

    /**
     * Return part of form with setting
     * This function should always be overwritten
     *
     * @param mixed $data array or string depending on setting
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '')
    {
        global $PAGE;
        $url = clone $PAGE->url;
        if ($url instanceof moodle_url) {
            $url->param('theme_morphing_reset_all', 1);
        }
        $_url = $url->__toString();
        
        return '<div class="form-item clearfix"><div class="form-label"><label>' . $this->visiblename . '</label></div>
            <div class="form-setting">
                <a href="' . $_url . '" onclick="return confirm(\''. get_string('resetconfirm', 'theme_morphing') . '\');">' . get_string('reset', 'theme_morphing') . '</a>
            </div>
            </div>';
    }

    /**
     * Function called if setting updated - cleanup, cache reset, etc.
     * @param string $functionname Sets the function name
     * @return void
     */
    public function set_updatedcallback($functionname)
    {
        
    }

    /**
     * Is setting related to query text - used when searching
     * @param string $query
     * @return bool
     */
    public function is_related($query)
    {

        return false;
    }

}

class morphing_admin_setting_header extends admin_setting
{

    public function get_setting()
    {
        return '';
    }

    public function write_setting($data)
    {
        
    }

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the fullname prefixed by the plugin
     * @return string
     */
    public function get_full_name()
    {
        return '';
    }

    /**
     * Returns the ID string based on plugin and name
     * @return string
     */
    public function get_id()
    {
        return '';
    }

    /**
     * @param bool $affectsmodinfo If true, changes to this setting will
     *   cause the course cache to be rebuilt
     */
    public function set_affects_modinfo($affectsmodinfo)
    {
        
    }

    /**
     * Returns the config if possible
     *
     * @return mixed returns config if successful else null
     */
    public function config_read($name)
    {
        return null;
    }

    /**
     * Used to set a config pair and log change
     *
     * @param string $name
     * @param mixed $value Gets converted to string if not null
     * @return bool Write setting to config table
     */
    public function config_write($name, $value)
    {
        return true; // BC only
    }

    /**
     * Returns default setting if exists
     * @return mixed array or string depending on instance; NULL means no default, user must supply
     */
    public function get_defaultsetting()
    {
        return '';
    }

    /**
     * Return part of form with setting
     * This function should always be overwritten
     *
     * @param mixed $data array or string depending on setting
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '')
    {
        return '<h3 class="morphing-setting-header">' . $this->name . '</h3>';
    }

    /**
     * Function called if setting updated - cleanup, cache reset, etc.
     * @param string $functionname Sets the function name
     * @return void
     */
    public function set_updatedcallback($functionname)
    {
        
    }

    /**
     * Is setting related to query text - used when searching
     * @param string $query
     * @return bool
     */
    public function is_related($query)
    {

        return false;
    }

}
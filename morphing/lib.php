<?php

require_once $CFG->dirroot . '/lib/adminlib.php';

function morphing_process_css($css, $theme)
{

    // Set the font reference size
    $fontsizereference = !empty($theme->settings->fontsizereference) ? $theme->settings->fontsizereference : '13';
    $css = str_replace('[[setting:fontsizereference]]', $fontsizereference . 'px', $css);
    
    //block title font size
    $bfs = !empty($theme->settings->blocktitlefontsize) ? $theme->settings->blocktitlefontsize : '13';
    $css = str_replace('[[setting:blocktitlefontsize]]', $bfs . 'px', $css);
    
    //breadcrumb font size
    $bfs = !empty($theme->settings->breadcrumbfontsize) ? $theme->settings->breadcrumbfontsize : '13';
    $css = str_replace('[[setting:breadcrumbfontsize]]', $bfs . 'px', $css);

    // default color
    $fontcolor = !empty($theme->settings->fontcolor) ? $theme->settings->fontcolor : '#000000'; //default
    $css = str_replace('[[setting:fontcolor]]', $fontcolor, $css);

    // Set the page header background color
    $headerbgc = !empty($theme->settings->headerbgc) ? $theme->settings->headerbgc : '#0A1F33'; // default 
    $css = str_replace('[[setting:headerbgc]]', $headerbgc, $css);

    //background color
    $bgc = !empty($theme->settings->backgroundcolor) ? $theme->settings->backgroundcolor : '#F7F6F1'; //default
    $css = str_replace('[[setting:backgroundcolor]]', $bgc, $css);

    // Set the region width
    $regionwidth = !empty($theme->settings->regionwidth) ? $theme->settings->regionwidth : '200';
    $css = morphing_set_regionwidth($css, $regionwidth);
    
    //set the block title alignement and offset
    $blocktitlealign = !empty($theme->settings->blocktitlealign) ? $theme->settings->blocktitlealign : 'left';
    $css = str_replace('[[setting:blocktitlealign]]', $blocktitlealign, $css);
    if ($blocktitlealign != 'right') { //if right alignment, there is no need for left padding
        $blocktitleleft = !empty($theme->settings->blocktitleleft) ? $theme->settings->blocktitleleft : 5;
        $css = str_replace('[[setting:blocktitleleft]]', $blocktitleleft . 'px', $css);
    }

    //set the header height
    $headerheight = (!empty($theme->settings->headerheight) && intval($theme->settings->headerheight) ? intval($theme->settings->headerheight) : 80) . 'px';
    $css = str_replace('[[setting:headerheight]]', $headerheight, $css);

    //set the logo position
    $logotop = (!empty($theme->settings->logooffsettop) && intval($theme->settings->logooffsettop) ? intval($theme->settings->logooffsettop) : 15) . 'px';
    $css = str_replace('[[setting:logotop]]', $logotop, $css);
    $logoleft = (!empty($theme->settings->logooffsetleft) && intval($theme->settings->logooffsetleft) ? intval($theme->settings->logooffsetleft) : 105) . 'px';
    $css = str_replace('[[setting:logoleft]]', $logoleft, $css);

    //breadcrumb height
    $navbarheight = (!empty($theme->settings->breadcrumbheight) && intval($theme->settings->breadcrumbheight) ? intval($theme->settings->breadcrumbheight) : 35) . 'px';
    $css = str_replace('[[setting:navheight]]', $navbarheight, $css);
    
    //breadcrumb left offset
    $left = (!empty($theme->settings->breadcrumbleft) && intval($theme->settings->breadcrumbleft) ? intval($theme->settings->breadcrumbleft) : 15) . 'px';
    $css = str_replace('[[setting:breadcrumbleft]]', $left, $css);
    
    //breadcrumb top offset
    $top = (!empty($theme->settings->breadcrumbtop) && intval($theme->settings->breadcrumbtop) ? intval($theme->settings->breadcrumbtop) : 0) . 'px';
    $css = str_replace('[[setting:breadcrumbtop]]', $top, $css);

    // Set the link color
    $linkcolor = !empty($theme->settings->linkcolor) ? $theme->settings->linkcolor : '#113759';
    $css = str_replace('[[setting:linkcolor]]', $linkcolor, $css);
    
    // Set the visited link color
    $visitedlinkcolor = !empty($theme->settings->visitedlinkcolor) ? $theme->settings->visitedlinkcolor : '#113759';
    $css = str_replace('[[setting:visitedlinkcolor]]', $visitedlinkcolor, $css);

    // Set the main color
    if (!empty($theme->settings->maincolor)) {
        $maincolor = $theme->settings->maincolor;
    } else {
        $maincolor = null;
    }
    $css = morphing_set_maincolor($css, $maincolor);
    
    //set the logged in user link color
    $loggedincolor = !empty($theme->settings->loggedincolor) ? $theme->settings->loggedincolor : '#00aeef';
    $css = str_replace('[[setting:loggedincolor]]', $loggedincolor, $css);

    // Set the custom CSS
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = morphing_set_customcss($css, $customcss);


    return $css;
}

function morphing_set_maincolor($css, $maincolor)
{
    $tag = '[[setting:maincolor]]';
    $replacement = $maincolor;
    if (is_null($replacement)) {
        $replacement = '#0a1f33';
    }
    $css = str_replace($tag, $replacement, $css);
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

/**
 * Sets the custom css variable in CSS
 *
 * @param string $css
 * @param mixed $customcss
 * @return string
 */
function morphing_set_customcss($css, $customcss)
{
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);
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
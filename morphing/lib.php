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
    $autoapply = array('mainbackgroundcolor', 'headerlinkcolor', 'blockheadercolor', 'blockbordercolor', 'fontcolor', 'headerbgc');
    
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
    $s->apply('fontsizereference', $css, 'intval', 'px')
            ->apply('blocktitlefontsize', $css, 'intval', 'px')
            ->apply('breadcrumbfontsize', $css, 'intval', 'px');

    
    // Set the page header background color
    $autoapply []= 'headerbgc';
    //background color
    $autoapply []= 'backgroundcolor';
    
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
    $s->apply('headerheight', $css, 'intval', 'px')
            ->apply('logooffsettop', $css, 'intval', 'px')
            ->apply('logooffsetleft', $css, 'intval', 'px')
            ->apply('secondlogooffsettop', $css, 'intval', 'px')
            ->apply('secondlogooffsetleft', $css, 'intval', 'px')
            ->apply('breadcrumbheight', $css, 'intval', 'px')
            ->apply('breadcrumbleft', $css, 'intval', 'px')
            ->apply('breadcrumbtop', $css, 'intval', 'px');

    // Set the link color
    $autoapply []= 'linkcolor';
    
    // Set the visited link color
    $autoapply []= 'visitedlinkcolor';

    // Set the main color
    $autoapply []= 'maincolor';
    
    //set the logged in user link color
    $autoapply []= 'loggedincolor';

    // Set the custom CSS
    $autoapply []= 'customcss';
    
    foreach($autoapply as $tag) {
        $s->apply($tag, $css);
    }
    
    //set the line-height 
    $lineheight = (intval($s->get('fontsizereference')) + 5) . 'px';
    $css = str_replace('[[setting:lineheightreference]]', $lineheight, $css);
    
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
 * just display a snippet of html code.
 * the file displayed is located in setting_html/{$name}.php
 */
class theme_morphing_admin_setting_confightml extends admin_setting
{
    public function get_setting()
    {
        return '';
    }

    /**
     * just do nothing
     * @param type $data
     */
    public function write_setting($data)
    {
        
    }

    public function __construct($name, $visiblename, $description, $defaultsetting)
    {
        $this->name = $name;
        $this->visiblename = $visiblename;
        $this->description = $description;
        $this->defaultsetting = $defaultsetting;
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
     * Return part of form with setting - includes the file setting_html/{$this->name}.php
     *
     * @param mixed $data array or string depending on setting
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '')
    {
        global $CFG;
        $contents = '';
        $phpname = basename($this->name);
        
        if (empty($phpname) || ! file_exists($CFG->dirroot . "/theme/morphing/setting_html/{$phpname}.php")) {
            return '';
        }
        
        ob_start();
        include $CFG->dirroot . '/theme/morphing/setting_html/' . $phpname . '.php';
        $contents = ob_get_contents();
        
        ob_end_clean();
        return $contents;
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
<?php

class Morphing_Theme_Settings
{
    const THEME = 'theme_morphing';
    
    protected $_settings = array();
    
    protected $theme = null;
    
    public function __construct($theme = null)
    {
        $this->_init();
        
        if (!is_null($theme)) {
            $this->theme = $theme;
        }
    }
    
    /**
     * wrapper (shortcut) function for get_string
     * @param string $tag the language tag to be returned
     */
    protected function _s($settingkey, $desc = false)
    {
        if (!isset($this->_settings[$settingkey])) {
            return get_string($settingkey, self::THEME);
        }
        
        if (!isset($this->_settings[$settingkey]['title'])) {
            $this->_settings[$settingkey]['title'] = $settingkey;
        }
        $tag = $this->_settings[$settingkey]['title'];
        if ($desc) {
            $tag .= 'desc';
        }
        return get_string($tag, self::THEME);
    }
    
    /**
     * get a new instance of adminsetting
     * @param type $tag
     */
    public function getAdminSetting($tag)
    {
        $s = $this->_settings[$tag];
        
        if (!empty($s['raw'])) {
            return $s['raw'];
        }
        
        if (empty($s['type'])) {
            $s['type'] = 'text';
        }
        $name = "theme_morphing/{$tag}";
        $title = $this->_s($tag);
        switch ($s['type']) {
            case 'html':
                $return = new morphing_admin_setting_confightml($name, $title, '', '');
                break;
            case 'select':
                $description = $this->_s($tag, true);
                $return = new admin_setting_configselect($name, $title, $description, $s['default'], $s['extra']);
                break;
            case 'colourpicker':
                $description = $this->_s($tag, true);
                $return = new admin_setting_configcolourpicker($name, $title, $description, $s['default'], $s['extra']);
                break;
            case 'checkbox':
                $description = $this->_s($tag, true);
                $return = new admin_setting_configcheckbox($name, $title, $description, $s['default']);
                break;
            case 'text':
                $description = $this->_s($tag, true);
                $param = PARAM_RAW;
                if (isset($s['extra'])) {
                    $param = $s['extra'];
                }
                if (!isset($s['default'])) {
                    $s['default'] = '';
                }
                $return = new admin_setting_configtext($name, $title, $description, $s['default'], $param);
                break;
            case 'htmleditor':
            case 'textarea':
                $description = $this->_s($tag, true);
                if (!isset($s['default'])) {
                    $s['default'] = '';
                }
                $class = "admin_setting_config{$s['type']}";
                $return = new $class($name, $title, $description, $s['default']);
                break;
        }
        
        return $return;
    }
    
    public function get($tag)
    {
        if (empty($this->theme)) {
            throw new Exception('Invalid theme specified for the morphing settings');
        }
        
        $s = $this->_settings[$tag];
        if (!isset($s['default'])) {
            $s['default'] = '';
            throw new Exception('Default not found for: ' . $tag);
        }
        
        if (isset($this->theme->settings->{$tag})) {
            return $this->theme->settings->{$tag};
        }
        
        return $s['default'];
    }
    
    public function apply($tag, $css)
    {
        $value = $this->get($tag);
        
        return str_replace("[[setting:{$tag}]]", $value, $css);
    }
    
    public function getSettingsSection($name)
    {
        $return = array(
            new morphing_admin_setting_header($this->_s($name))
        );
        
        foreach ($this->_settings as $k => $s) {
            if (isset($s['_section']) && $s['_section'] == $name) {
                $return []= $this->getAdminSetting($k);
            }
        }
        
        return $return;
    }
    
    protected function _init()
    {   
        $sizes = array();
        for ($i = 9; $i < 21; $i++) {
            $sizes[$i] = $i . 'px';
        }
        $this->_settings = array(
            'reset_everything' => array(
                'type' => 'html',
                'title' => 'resettitle'
            ),
            // font size reference
            'fontsizereference' => array(
                '_section' => 'general',
                'type' => 'select',
                'default' => '13',
                'extra' => array(11 => '11px', 12 => '12px', 13 => '13px', 14 => '14px', 15 => '15px', 16 => '16px')
            ),
            'fontcolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#000000',
                'extra' => array('selector' => 'html,body,.form-description', 'style' => 'color')
            ),
            'linkcolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#113759',
                'extra' => array('selector' => 'html a,body a', 'style' => 'color')
            ),
            'visitedlinkcolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#113759',
                'extra' => array('selector' => 'html a,body a', 'style' => 'color')
            ),
            'maincolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#1f465e',
                'extra' => array('selector' => 'div#jcontrols_button,#footerwrapper,.block div.header,#dock', 'style' => 'backgroundColor')
            ),
            'loggedincolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#00aeef',
                'extra' => array('selector' => 'a.logged-in-link', 'style' => 'color')
            ),
            'alwayslangmenu' => array(
                '_section' => 'general',
                'type' => 'checkbox',
                'default' => 1
            ),
            'layouttype' => array(
                '_section' => 'general',
                'type' => 'select',
                'default' => 'fluid',
                'extra' => array('fluid' => get_string('layouttypefluid', 'theme_morphing'), 'fixed' => get_string('layouttypefixed', 'theme_morphing'))
            ),
            'layoutfluidwidth' => array(
                '_section' => 'general',
                'default' => '100%'
            ),
            'layoutfixedwidth' => array(
                '_section' => 'general',
                'default' => '900px'
            ),
            'mainbackgroundcolor' => array(
                '_section' => 'general',
                'type' => 'colourpicker',
                'default' => '#E0E0E0',
                'extra' => array('selector' => 'html, body', 'style' => 'background')
            ),
            'mainbackgroundimage' => array(
                '_section' => 'general',
                'title' => 'backgroundimage',
                'extra' => PARAM_URL
            ),
            //header
            // header background color setting
            'headerbgc' => array(
                '_section' => 'header',
                'type' => 'colourpicker',
                'default' => '#1f465e',
                'extra' => array('selector' => '#headerwrap', 'style' => 'backgroundColor')
            ),
            'headerheight' => array(
                '_section' => 'header',
                'default' => 110,
                'extra' => PARAM_INT
            ),
            'headerlinkcolor' => array(
                '_section' => 'header',
                'type' => 'colourpicker',
                'default' => '#FFFFFF',
                'extra' => array('selector' => '#headerwrap a, #jcontrols_button a', 'style' => 'color')
            ),
            //end header
            //logo
            'logo' => array(
                '_section' => 'logo',
                'title' => 'logourl',
                'extra' => PARAM_URL
            ),
            'secondlogo' => array(
                '_section' => 'logo',
                'title' => 'headersecondimage',
                'extra' => PARAM_URL
            ),
            'logooffsetleft' => array(
                '_section' => 'logo',
                'default' => 105,
                'extra' => PARAM_INT
            ),
            'logooffsettop' => array(
                '_section' => 'logo',
                'default' => 15,
                'extra' => PARAM_INT
            ),
            'breadcrumbfontsize' => array(
                '_section' => 'logo',
                'default' => 12,
                'type' => 'select',
                'extra' => $sizes
            ),
            'breadcrumbheight' => array(
                '_section' => 'logo',
                'default' => 35,
                'extra' => PARAM_INT
            ),
            'breadcrumbleft' => array(
                '_section' => 'logo',
                'default' => 15,
                'extra' => PARAM_INT
            ),
            'breadcrumbtop' => array(
                '_section' => 'logo',
                'default' => 0,
                'extra' => PARAM_INT
            ),
            //end logo
            //block settings
            // block title font size
            'blocktitlefontsize' => array(
                '_section' => 'block',
                'default' => 12,
                'type' => 'select',
                'extra' => $sizes
            ),
            'regionwidth' => array(
                '_section' => 'block',
                'default' => 200,
                'extra' => array(150 => '150px', 170 => '170px', 200 => '200px', 240 => '240px', 290 => '290px', 350 => '350px', 420 => '420px'),
                'type' => 'select'
            ),
            'blocktitlealign' => array(
                '_section' => 'block',
                'default' => 'left',
                'type' => 'select',
                'extra' => array('left' => get_string('alignleft', 'theme_morphing'), 'center' => get_string('aligncenter', 'theme_morphing'), 'right' => get_string('alignright', 'theme_morphing'))
            ),
            'blocktitleleft' => array(
                '_section' => 'block',
                'default' => 5,
                'extra' => PARAM_INT
            ),
            'backgroundcolor' => array(
                '_section' => 'block',
                'type' => 'colourpicker',
                'default' => '#F7F6F1',
                'extra' => array('selector' => '.block .content', 'style' => 'backgroundColor')
            ),
            'blockheadercolor' => array(
                '_section' => 'block',
                'type' => 'colourpicker',
                'default' => '#1F465E',
                'extra' => array('selector' => '.block div.header', 'style' => 'backgroundColor')
            ),
            'blockbordercolor' => array(
                '_section' => 'block',
                'type' => 'colourpicker',
                'default' => '#CCCCCC',
                'extra' => array('selector' => '.block', 'style' => 'border')
            ),
            //end block settings
            //miscellaneous settings
            'footnote' => array(
                '_section' => 'miscellaneous',
                'type' => 'htmleditor'
            ),
            'customcss' => array(
                '_section' => 'miscellaneous',
                'type' => 'textarea',
                'default' => ''
            ),
            //end miscellaneous settings
            //custom menu settings
            'custommenudisplay' => array(
                '_section' => 'custommenu',
                'type' => 'select',
                'default' => 'none',
                'extra' => array(
                    'none' => $this->_s('none'), 
                    'front' => $this->_s('frontpage'),
                    'all' => $this->_s('allpages')
                )
            ),
            'custommenuheight' => array(
                '_section' => 'custommenu',
                'default' => 35,
                'extra' => PARAM_INT
            ),
            'custommenuitems' => array(
                '_section' => 'custommenu',
                'raw' => new admin_setting_configtextarea('custommenuitems', get_string('custommenuitemsdesc', 'theme_morphing') . '<br />' . new lang_string('custommenuitems', 'admin'), new lang_string('configcustommenuitems', 'admin'), '', PARAM_TEXT, '50', '10')
            ),
            'custommenualign' => array(
                '_section' => 'custommenu',
                'default' => 'left',
                'type' => 'select',
                'extra' => array('left' => get_string('alignleft', 'theme_morphing'), 'center' => get_string('aligncenter', 'theme_morphing'))
            )
            //end custom menu settings
        );
    }
}
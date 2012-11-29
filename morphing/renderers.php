<?php

class theme_morphing_core_renderer extends core_renderer
{
    /**
     * Returns the custom menu if one has been set
     *
     * A custom menu can be configured by browsing to
     *    Settings: Administration > Appearance > Themes > Morphing > Custom menu
     * and then configuring the custommenu config setting as described.
     *
     * @param string $custommenuitems - custom menuitems set by theme instead of global theme settings
     * @return string
     */
    public function morphing_custom_menu($custommenuitems = '') {
        
        global $PAGE;
        
        if (empty($custommenuitems) && !empty($PAGE->theme->settings->custommenuitems)) {
            $custommenuitems = $PAGE->theme->settings->custommenuitems;
        }
        
        if (empty($custommenuitems)) {
            return '';
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->morphing_render_custom_menu($custommenu);
    }
    
    /**
     * dev note: "copy-paste" from core:renderer, to avoid future php warnings, like: method "xxx" declaration does not correspond with ...
     * 
     * Renders a custom menu object (located in outputcomponents.php)
     *
     * The custom menu this method produces makes use of the YUI3 menunav widget
     * and requires very specific html elements and classes.
     *
     * @staticvar int $menucount
     * @param custom_menu $menu
     * @return string
     */
    protected function morphing_render_custom_menu(custom_menu $menu) {
        static $menucount = 0;
        // If the menu has no children return an empty string
        if (!$menu->has_children()) {
            return '';
        }
        // Increment the menu count. This is used for ID's that get worked with
        // in JavaScript as is essential
        $menucount++;
        // Initialise this custom menu (the custom menu object is contained in javascript-static
        $jscode = js_writer::function_call_with_Y('M.core_custom_menu.init', array('custom_menu_'.$menucount));
        $jscode = "(function(){{$jscode}})";
        $this->page->requires->yui_module('node-menunav', $jscode);
        // Build the root nodes as required by YUI
        $content = html_writer::start_tag('div', array('id'=>'custom_menu_'.$menucount, 'class'=>'yui3-menu yui3-menu-horizontal javascript-disabled'));
        $content .= html_writer::start_tag('div', array('class'=>'yui3-menu-content'));
        $content .= html_writer::start_tag('ul');
        // Render each child
        foreach ($menu->get_children() as $item) {
            $content .= $this->morphing_render_custom_menu_item($item);
        }
        // Close the open tags
        $content .= html_writer::end_tag('ul');
        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('div');
        // Return the custom menu
        return $content;
    }
    
    /**
     * dev note: "copy-paste" from core:renderer, to avoid future php warnings, like: method "xxx" declaration does not correspond with ...
     * Renders a custom menu node as part of a submenu
     * 
     *
     * The custom menu this method produces makes use of the YUI3 menunav widget
     * and requires very specific html elements and classes.
     *
     * @staticvar int $submenucount
     * @param custom_menu_item $menunode
     * @return string
     */
    public function morphing_render_custom_menu_item(custom_menu_item $menunode)
    {
        // Required to ensure we get unique trackable id's
        static $submenucount = 0;
        if ($menunode->has_children()) {
            // If the child has menus render it as a sub menu
            $submenucount++;
            $content = html_writer::start_tag('li');
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $content .= html_writer::link($url, $menunode->get_text(), array('class'=>'yui3-menu-label', 'title'=>$menunode->get_title(), 'target' => '_blank'));
            $content .= html_writer::start_tag('div', array('id'=>'cm_submenu_'.$submenucount, 'class'=>'yui3-menu custom_menu_submenu'));
            $content .= html_writer::start_tag('div', array('class'=>'yui3-menu-content'));
            $content .= html_writer::start_tag('ul');
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->morphing_render_custom_menu_item($menunode);
            }
            $content .= html_writer::end_tag('ul');
            $content .= html_writer::end_tag('div');
            $content .= html_writer::end_tag('div');
            $content .= html_writer::end_tag('li');
        } else {
            // The node doesn't have children so produce a final menuitem
            $content = html_writer::start_tag('li', array('class'=>'yui3-menuitem'));
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }
            $content .= html_writer::link($url, $menunode->get_text(), array('class'=>'yui3-menuitem-content', 'title'=>$menunode->get_title(), 'target' => '_blank'));
            $content .= html_writer::end_tag('li');
        }
        // Return the sub menu
        return $content;
    }
    
    /**
     * 
     * parse the html and add a class to the logged in link, so we can change its color
     * @param string $html the output of parent::login_info()
     * @return string the string containing class="logged-in-link" added to the link
     */
    public function morphing_loggedin_color($html)
    {
        global $USER;
        
        if (!empty($USER->morphing_loggedinas)) {
            return $USER->morphing_loggedinas;
        }

        $loggedinas = str_replace('{$a}', '', get_string('loggedinas', 'moodle'));
        $html = preg_replace('/' . $loggedinas . '<a([^>]+)>/', $loggedinas . '<a$1 class="logged-in-link">', $html);
        $USER->morphing_loggedinas = $html;
        return $html;
    }
}
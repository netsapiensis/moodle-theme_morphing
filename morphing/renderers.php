<?php

class theme_morphing_core_renderer extends core_renderer
{
    public function login_info()
    {
        global $USER, $CFG, $DB, $SESSION;

        if (during_initial_install()) {
            return '';
        }

        $loginpage = ((string)$this->page->url === get_login_url());
        $course = $this->page->course;

        if (session_is_loggedinas()) {
            $realuser = session_get_realuser();
            $fullname = fullname($realuser, true);
            $realuserinfo = " [<a class=\"logged-in-link\" href=\"$CFG->wwwroot/course/loginas.php?id=$course->id&amp;sesskey=".sesskey()."\">$fullname</a>] ";
        } else {
            $realuserinfo = '';
        }

        $loginurl = get_login_url();

        if (empty($course->id)) {
            // $course->id is not defined during installation
            return '';
        } else if (isloggedin()) {
            $context = get_context_instance(CONTEXT_COURSE, $course->id);

            $fullname = fullname($USER, true);
            // Since Moodle 2.0 this link always goes to the public profile page (not the course profile page)
            $username = "<a class=\"logged-in-link\" href=\"$CFG->wwwroot/user/profile.php?id=$USER->id\">$fullname</a>";
            if (is_mnet_remote_user($USER) and $idprovider = $DB->get_record('mnet_host', array('id'=>$USER->mnethostid))) {
                $username .= " from <a href=\"{$idprovider->wwwroot}\">{$idprovider->name}</a>";
            }
            if (isguestuser()) {
                $loggedinas = $realuserinfo.get_string('loggedinasguest');
                if (!$loginpage) {
                    $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
                }
            } else if (is_role_switched($course->id)) { // Has switched roles
                $rolename = '';
                if ($role = $DB->get_record('role', array('id'=>$USER->access['rsw'][$context->path]))) {
                    $rolename = ': '.format_string($role->name);
                }
                $loggedinas = get_string('loggedinas', 'moodle', $username).$rolename.
                          " (<a href=\"$CFG->wwwroot/course/view.php?id=$course->id&amp;switchrole=0&amp;sesskey=".sesskey()."\">".get_string('switchrolereturn').'</a>)';
            } else {
                $loggedinas = $realuserinfo.get_string('loggedinas', 'moodle', $username).' '.
                          " (<a href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\">".get_string('logout').'</a>)';
            }
        } else {
            $loggedinas = get_string('loggedinnot', 'moodle');
            if (!$loginpage) {
                $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
            }
        }

        $loggedinas = '<div class="logininfo">'.$loggedinas.'</div>';

        if (isset($SESSION->justloggedin)) {
            unset($SESSION->justloggedin);
            if (!empty($CFG->displayloginfailures)) {
                if (!isguestuser()) {
                    if ($count = count_login_failures($CFG->displayloginfailures, $USER->username, $USER->lastlogin)) {
                        $loggedinas .= '&nbsp;<div class="loginfailures">';
                        if (empty($count->accounts)) {
                            $loggedinas .= get_string('failedloginattempts', '', $count);
                        } else {
                            $loggedinas .= get_string('failedloginattemptsall', '', $count);
                        }
                        if (file_exists("$CFG->dirroot/report/log/index.php") and has_capability('report/log:view', get_context_instance(CONTEXT_SYSTEM))) {
                            $loggedinas .= ' (<a href="'.$CFG->wwwroot.'/report/log/index.php'.
                                                 '?chooselog=1&amp;id=1&amp;modid=site_errors">'.get_string('logs').'</a>)';
                        }
                        $loggedinas .= '</div>';
                    }
                }
            }
        }

        return $loggedinas;
    }
    
    public function render_custom_menu_item(custom_menu_item $menunode)
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
                $content .= $this->render_custom_menu_item($menunode);
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
     * Returns the custom menu if one has been set
     *
     * A custom menu can be configured by browsing to
     *    Settings: Administration > Appearance > Themes > Theme settings
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
        return $this->render_custom_menu($custommenu);
    }
}
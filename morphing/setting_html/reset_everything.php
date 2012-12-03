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

defined('MOODLE_INTERNAL') || die;

global $PAGE;

$url = clone $PAGE->url;
if ($url instanceof moodle_url) {
    $url->param('theme_morphing_reset_all', 1);
    $url->param('theme_morphing_settings_tab', 'reset');
}
$_url = $url->__toString();
?>
<div class="form-item clearfix" style="text-align: center">
    <a href="<?php echo $_url ?>" onclick="return confirm('<?php echo get_string('resetconfirm', 'theme_morphing') ?>');"><?php echo get_string('resettitle', 'theme_morphing') ?></a>
</div>

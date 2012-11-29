<?php
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

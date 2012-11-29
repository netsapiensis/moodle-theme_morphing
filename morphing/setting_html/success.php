<?php

defined('MOODLE_INTERNAL') || die;

global $OUTPUT;

echo $OUTPUT->notification(get_string('resetdone', 'theme_morphing'), 'notifysuccess');
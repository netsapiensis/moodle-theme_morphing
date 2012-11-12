<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

$custommenu = $OUTPUT->morphing_custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$showcustommenu = !empty($PAGE->theme->settings->custommenudisplay) ? $PAGE->theme->settings->custommenudisplay : 'none';
switch($showcustommenu) {
    case 'front':
        $hascustommenu = $PAGE->course->id == SITEID;
        break;
    case 'all':
        $hascustommenu = !empty($custommenu);
        break;
    case 'none':
    default:
        $hascustommenu = false;
        break;
}

$logo = (!empty($PAGE->theme->settings->logo) ? $PAGE->theme->settings->logo : $OUTPUT->pix_url('header_logo', 'theme'));
$secondlogo = (!empty($PAGE->theme->settings->secondlogo) ? $PAGE->theme->settings->secondlogo : $OUTPUT->pix_url('header_logo2', 'theme'));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
if (!empty($PAGE->theme->settings->footnote)) {
    $footnote = $PAGE->theme->settings->footnote;
} else {
    $footnote = '<!-- There was no custom footnote set -->';
}
echo $OUTPUT->doctype()
?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
    <head>
        <title><?php echo $PAGE->title ?></title>
        <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme') ?>" />
        <?php echo $OUTPUT->standard_head_html() ?>
    </head>
    <body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses . ' ' . join(' ', $bodyclasses) ?>">
        <?php echo $OUTPUT->standard_top_of_body_html() ?>

        <div id="page">	
            <?php if ($hasheading || $hasnavbar) { ?>
                <div id="headerwrap"><div id="page-header"></div>
                    <div id="headerinner">
                        <?php if ($logo || $secondlogo) echo '<div class="logo-container">' ?>
                        <?php
                        if ($logo)
                            echo html_writer::link(new moodle_url('/'), "<img src='" . $logo . "' alt='logo' id='logo' />", array('class' => 'logo-link'));
                        
                        if ($secondlogo) 
                            echo "<img src='{$secondlogo}' alt='' id='second_logo' />";
                        ?>
                        <?php if ($logo || $secondlogo) echo '</div>' ?>
                        <div class="clear"></div>
                        <div id="ebutton">
                            <?php //if ($hasnavbar) { echo $PAGE->button; }  ?>
                        </div>			
                    </div>
                </div>
                <?php if ($hascustommenu) { ?>
                    <div id="custommenu2"><?php echo $custommenu; ?></div>
                <?php } ?>
                <div id="jcontrols_button">
                    <?php if ($hasnavbar) { ?>
                        <div class="navbar clearfix" id="breadcrumb-container">
                            <div class="breadcrumb"> <?php echo $OUTPUT->navbar(); ?></div>
                        </div>
                    <?php } ?>
                    <div class="jcontrolsright">
                        <div class="navbutton"><?php echo $PAGE->button; ?></div>
                        <?php
                        if ($hasheading) {
                            if (!empty($PAGE->theme->settings->alwayslangmenu)) {
                                echo $OUTPUT->lang_menu();
                            }
                            echo $OUTPUT->login_info();
                            echo $PAGE->headingmenu;
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
            <div id="contentwrapper">	
                <!-- start OF moodle CONTENT -->
                <div id="page-content">
                    <div id="region-main-box">
                        <div id="region-post-box">

                            <div id="region-main-wrap">
                                <div id="region-main">
                                    <div class="region-content">
                                        <div id="mainpadder">
                                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($hassidepre) { ?>
                                <div id="region-pre" class="block-region">
                                    <div class="region-content">
                                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($hassidepost) { ?>
                                <div id="region-post" class="block-region">
                                    <div class="region-content">

                                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <!-- END OF CONTENT --> 
            </div>      

            <br style="clear: both;"> 
            <?php if ($hasfooter) { ?> 
                <div id="footerwrapper">
                    <div id="footerinner" style="text-align: center">
                        <div id="footer-fix">
                            <div id="new-footer">
                                <?php if ($hasfooter) : ?>
                                    <?php echo $OUTPUT->login_info(); ?>
                                    <?php /*
                                            echo $//OUTPUT->home_link();
                                            echo $OUTPUT->standard_footer_html();
                                    */ ?>
                                    <?php echo $footnote; ?>
                                <?php endif ?>
                            </div>
                            <?php 
                            /* <div class="johndocs"> 
                              <?php echo page_doc_link(get_string('moodledocslink')) ?>
                              <?php /*</div> 
                             */ ?>
                            <div class="clear"></div>
                        </div>
                    </div>		
                </div>
            <?php } ?>

        </div>    		

        <?php echo $OUTPUT->standard_end_of_body_html() ?>
    </body>
</html>
<?php

function morphing_process_css($css, $theme) {
    
    // Set the font reference size
    $fontsizereference = ! empty($theme->settings->fontsizereference) ? $theme->settings->fontsizereference : '13';
    $css = str_replace('[[setting:fontsizereference]]', $fontsizereference . 'px', $css);
    
    // default color
    $fontcolor = ! empty($theme->settings->fontcolour) ? $theme->settings->fontcolour : '#000000'; //default
    $css = str_replace('[[setting:fontcolour]]', $fontcolor, $css);
    
    // Set the page header background color
    $headerbgc = ! empty($theme->settings->headerbgc) ? $theme->settings->headerbgc : '#0A1F33'; // default 
    $css = str_replace('[[setting:headerbgc]]', $headerbgc, $css);
    
    if (!empty($theme->settings->backgroundcolor)) {
        $backgroundcolor = $theme->settings->backgroundcolor;
    } else {
        $backgroundcolor = null;
    }
    $css = morphing_set_backgroundcolor($css, $backgroundcolor);
    
    // Set the region width
    if (!empty($theme->settings->regionwidth)) {
        $regionwidth = $theme->settings->regionwidth;
    } else {
        $regionwidth = null;
    }
    $css = morphing_set_regionwidth($css, $regionwidth);
    
    //set the header height
    $headerheight = (! empty($theme->settings->headerheight) && intval($theme->settings->headerheight) ? intval($theme->settings->headerheight) : 80) . 'px';
    $css = str_replace('[[setting:headerheight]]', $headerheight, $css);
    
    
    //set the logo position
    $logotop = (! empty($theme->settings->logooffsettop) && intval($theme->settings->logooffsettop) ? intval($theme->settings->logooffsettop) : 15) . 'px';
    $css = str_replace('[[setting:logotop]]', $logotop, $css);
    $logoleft = (! empty($theme->settings->logooffsetleft) && intval($theme->settings->logooffsetleft) ? intval($theme->settings->logooffsetleft) : 105) . 'px';
    $css = str_replace('[[setting:logoleft]]', $logoleft, $css);
    
    //breadcrumb height
    $navbarheight = (! empty($theme->settings->breadcrumbheight) && intval($theme->settings->breadcrumbheight) ? intval($theme->settings->breadcrumbheight) : 35) . 'px';
    $css = morphing_set_navbar_height($css, $navbarheight);
    
    // Set the link color
    if (!empty($theme->settings->linkcolor)) {
        $linkcolor = $theme->settings->linkcolor;
    } else {
        $linkcolor = null;
    }
    $css = morphing_set_linkcolor($css, $linkcolor);
    
     // Set the main color
    if (!empty($theme->settings->maincolor)) {
        $maincolor = $theme->settings->maincolor;
    } else {
        $maincolor = null;
    }
    $css = morphing_set_maincolor($css, $maincolor);
    
    // Set the custom CSS
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = morphing_set_customcss($css, $customcss);
    
    
    return $css;
}

function morphing_set_linkcolor($css, $linkcolor) {
    $tag = '[[setting:linkcolor]]';
    $replacement = $linkcolor;
    if (is_null($replacement)) {
        $replacement = '#113759';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function morphing_set_maincolor($css, $maincolor) {
    $tag = '[[setting:maincolor]]';
    $replacement = $maincolor;
    if (is_null($replacement)) {
        $replacement = '#0a1f33';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}


/**
 * Sets the background colour variable in CSS
 *
 * @param string $css
 * @param mixed $backgroundcolor
 * @return string
 */
function morphing_set_backgroundcolor($css, $backgroundcolor) {
    $tag = '[[setting:backgroundcolor]]';
    $replacement = $backgroundcolor;
    if (is_null($replacement)) {
        $replacement = '#F7F6F1';
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
function morphing_set_regionwidth($css, $regionwidth) {
    $tag = '[[setting:regionwidth]]';
    $doubletag = '[[setting:regionwidthdouble]]';
    $replacement = $regionwidth;
    if (is_null($replacement)) {
        $replacement = 200;
    }
    $css = str_replace($tag, $replacement.'px', $css);
    $css = str_replace($doubletag, ($replacement*2).'px', $css);
    $css = str_replace($tag, ($replacement+10).'px', $css);
    return $css;
}


//navbar height = breadcrumb height
function morphing_set_navbar_height($css, $navbarheight)
{
    $tag = '[[setting:navheight]]';
    $css = str_replace($tag, $navbarheight, $css);
    
    return $css;
}


/**
 * Sets the custom css variable in CSS
 *
 * @param string $css
 * @param mixed $customcss
 * @return string
 */
function morphing_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

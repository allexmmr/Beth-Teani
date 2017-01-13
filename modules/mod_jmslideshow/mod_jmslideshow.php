<?php
/*
#------------------------------------------------------------------------
# Package - JoomlaMan JMSlideShow
# Version 1.0
# -----------------------------------------------------------------------
# Author - JoomlaMan http://www.joomlaman.com
# Copyright © 2012 - 2013 JoomlaMan.com. All Rights Reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
# Websites: http://www.JoomlaMan.com
#------------------------------------------------------------------------
*/
//-- No direct access
defined('_JEXEC') or die('Restricted access');
global $jquery_cycle_load;
if (!defined('DS'))
    define('DS', '/');
if (!defined('JM_SLIDESHOW_IMAGE_FOLDER')) {
    define('JM_SLIDESHOW_IMAGE_FOLDER', JPATH_SITE . DS . 'media' . DS . 'mod_jmslideshow');
}
if (!defined('JM_SLIDESHOW_IMAGE_PATH')) {
    define('JM_SLIDESHOW_IMAGE_PATH', JURI::base(true) . '/media/mod_jmslideshow');
}
if (!file_exists(JM_SLIDESHOW_IMAGE_FOLDER)) {
    @mkdir(JM_SLIDESHOW_IMAGE_FOLDER, 0755) or die('Please change the permission');
}
if (!class_exists('JMSlide')) {
    require_once JPATH_SITE . DS . 'modules' . DS . 'mod_jmslideshow' . DS . 'classes' . DS . 'slide.php';
}
// Include the syndicate functions only once
require_once (dirname(__file__) . DS . 'helper.php');
$module_id = $module->id;
$slides = modJmSlideshowHelper::getSlides($params);
$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$custom_css = JPATH_SITE . '/templates/' . modJmSlideshowHelper::getTemplate() . '/css/' . $module->module.'_'.$params->get('jmslideshow_layout', 'default') . '.css';
if (file_exists($custom_css)) {
    $doc->addStylesheet(JURI::base(true) . '/templates/' . modJmSlideshowHelper::getTemplate() . '/css/' . $module->module.'_'.$params->get('jmslideshow_layout', 'default') . '.css');
} else {
    $doc->addStylesheet(JURI::base(true) . '/modules/mod_jmslideshow/assets/css/mod_jmslideshow_'.$params->get('jmslideshow_layout', 'default').'.css');
}
if ($params->get('jmslideshow_include_jquery', 0) == 1) {
    $doc->addScript(JURI::base(true) . '/modules/mod_jmslideshow/assets/js/jquery.js');
}
global $jm_jquery_autoload;
if($params->get('jmslideshow_include_jquery')==2 && empty($jm_jquery_autoload)):?>
<script type="text/javascript">
var jQueryScriptOutputted = false;
function JMInitJQuery() {    
  if (typeof(jQuery) == 'undefined') {   
    if (! jQueryScriptOutputted) {
      jQueryScriptOutputted = true;
      document.write("<scr" + "ipt type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js\"></scr" + "ipt>");
    }
    setTimeout("JMInitJQuery()", 50);
  }         
}
JMInitJQuery();
</script>
<?php
$jm_jquery_autoload = 1;
endif;
require JModuleHelper::getLayoutPath('mod_jmslideshow', $params->get('jmslideshow_layout', 'default'));
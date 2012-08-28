<?php

/**
 *
 * offline view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;

$app = JFactory::getApplication();

$uri = JURI::getInstance();
jimport('joomla.factory');

// get necessary template parameters
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
$pageName = JFactory::getDocument()->getTitle();

// get logo configuration
$logo_type = $templateParams->get('logo_type');
$logo_image = $templateParams->get('logo_image');
$template_style = $templateParams->get('template_color');

if(($logo_image == '') || ($templateParams->get('logo_type') == 'css')) {
     $logo_image = JURI::base() . '../images/logo.png';
} else {
     $logo_image = JURI::base() . $logo_image;
}
$logo_text = $templateParams->get('logo_text', '');
$logo_slogan = $templateParams->get('logo_slogan', '');

// get Countdown date configuration
$onlinedate = $templateParams->get('countdown_date', '');
$endDate = date("M j, Y H:i:s", strtotime($onlinedate));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/offline.style<?php echo $template_style; ?>.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
jQuery(document).ready(function(e) {

	gkCountdown();

});
function gkCountdown() {
	var enddate = new Date("<?php echo $endDate?>");
	var now = new Date();
	var diff = enddate.getTime() - now.getTime();
	var d = Math.floor(diff / 1000);
	var l = Math.floor(d / 60);
	var b = Math.floor(l / 60);
	var u = Math.floor(b / 24);
	b %= 24; l %= 60; d %= 60;
		
	if(d < 0){ var d = 0}
	if(l < 0){ var l = 0}
	if(b < 0){ var b = 0}
	if(u < 0){ var u = 0}
		
	document.getElementById("gkDays").innerHTML = u;
	document.getElementById("gkHours").innerHTML = b;
	document.getElementById("gkMinutes").innerHTML = l;
	document.getElementById("gkSeconds").innerHTML = d;
	
	var timer = setTimeout('gkCountdown()',1000);
}
</script>
</head>
<body><jdoc:include type="message" />
	<div id="gkPage">		
		<div id="gkPageWrap">
			<h2><?php echo $app->getCfg('offline_message'); ?></h2>
			<div id="gkCounterWrap">
				<div class="countertext">
					<div class="numbers">
						<div class="datetext days"><?php echo JText::_('TPL_GK_LANG_COUNTDOWN_DAYS'); ?></div><div id="gkDays"></div>
					</div>
					<div class="numbers">
						<div class="datetext hours"><?php echo JText::_('TPL_GK_LANG_COUNTDOWN_HOURS'); ?></div><div id="gkHours"></div>
					</div>
					<div class="numbers">
						<div class="datetext minutes"><?php echo JText::_('TPL_GK_LANG_COUNTDOWN_MINUTES'); ?></div><div id="gkMinutes"></div>
					</div>
					<div class="numbers">
						<div class="datetext seconds"><?php echo JText::_('TPL_GK_LANG_COUNTDOWN_SECONDS'); ?></div><div id="gkSeconds"></div>
					</div>
				</div>
			</div>	
			<div id="message">
				<h2><?php echo JText::_('TPL_GK_LANG_COUNTDOWN_OFFLINE_MSG'); ?><?php echo $onlinedate; ?></h2>
			</div>			
			<div id="left">
				<?php if ($logo_type !== 'none' && !$app->getCfg('offline_image')): ?>
				<?php if($logo_type == 'css') : ?>
				<a href="./" id="gkLogo" class="cssLogo"></a>
				<?php elseif($logo_type =='text') : ?>
				<a href="./" class="gkLogo text"> <span><?php echo $logo_text; ?></span> <small class="gkLogoSlogan"><?php echo $logo_slogan; ?></small> </a>
				<?php elseif($logo_type =='image') : ?>
				<a href="./" id="gkLogo"> <img src="<?php echo $logo_image; ?>" alt="<?php echo $pageName; ?>" /> </a>
				<?php endif; ?>
				<?php else : ?>
				<?php if($app->getCfg('offline_image')) : ?>
				<a href="./" id="gkLogo"> <img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo $app->getCfg('sitename'); ?>" /> </a>
				<?php endif; ?>
				<?php endif; ?>
			</div>
			<div id="right">
				<form action="index.php" method="post" name="login" id="form-login">
					<fieldset class="input">
						<p id="username">
							<label for="username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
							<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME') ?>" size="53" />
						</p>
						<p id="password">
							<label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
							<input type="password" name="password" class="inputbox" size="53" alt="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" id="passwd" />
						</p>
						<p id="remember">
							<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" id="remember" />
							<label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
						</p>
						<div class="buttons">
							<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
						</div>
						<input type="hidden" name="option" value="com_users" />
						<input type="hidden" name="task" value="user.login" />
						<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
						<?php echo JHtml::_('form.token'); ?>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

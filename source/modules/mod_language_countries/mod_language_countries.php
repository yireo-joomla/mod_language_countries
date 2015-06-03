<?php
/**
 * Joomla! module - Language Countries module
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$helper = new ModLanguageCountriesHelper($params);

// Determine the layout
$layout = $params->get('layout', 'default');
$baseLayout = 'default';

if (empty($layout))
{
	$layout = 'default';
}

// Load CSS
$helper->addStylesheet($baseLayout . '.css');

// Load JavaScript
JHtml::_('jquery.framework');
$helper->addScript('js.cookie.js');
$helper->addScript($baseLayout . '.js');

// Other variables
$class_sfx = htmlspecialchars($params->get('class_sfx'));
$pretext = $params->get('pretext');
$showButton = (bool) $params->get('button', 1);
$redirectTime = (int) $params->get('redirect_time', 30);
$redirect = (bool) $params->get('redirect', 1);

// Load data
$languages = $helper->getLanguagesWithMapping();
$mapping = $helper->getMapping();
$matchedCountry = $helper->getMatchedCountry();
$matchedLanguageName = $helper->getMatchedLanguageName();
$matchedLanguageLink = $helper->matchedLanguageLink();
$isMatchedLanguageCurrent = $helper->isMatchedLanguageCurrent();

// Disable when cookie is there, or when the current language is the same
if ($isMatchedLanguageCurrent || $helper->hasCookieBypass())
{
	$showModal = false;
	$redirect = false;
}
else
{
	$showModal = true;
}

// If the toplevel is not empty, load the template
if (count($languages) > 1)
{
	require JModuleHelper::getLayoutPath('mod_language_countries', $layout);
}

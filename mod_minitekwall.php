<?php
/**
* @title		Minitek Wall
* @copyright	Copyright (C) 2011-2020 Minitek, All rights reserved.
* @license		GNU General Public License version 3 or later.
* @author url	https://www.minitek.gr/
* @developers	Minitek.gr
*/

defined('_JEXEC') or die;

use Joomla\Component\MinitekWall\Site\Controller\DisplayController;

// Abort if this is a content form page
$jinput = \JFactory::getApplication()->input;
if ($jinput->get('option') == 'com_content' && $jinput->get('view') == 'form' && $jinput->get('layout') == 'edit')
	return;

jimport( 'joomla.application.component.helper' );
$componentParams  = \JComponentHelper::getParams('com_minitekwall');

if ($componentParams->get('load_jquery'))
	\JHtml::_('jquery.framework');

if ($componentParams->get('load_fontawesome'))
{
	$document = \JFactory::getDocument();
	$document->addStyleSheet('https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css');
}

// Store original page vars
$option = $jinput->getCmd('option', NULL);
$view = $jinput->getCmd('view', NULL);
$layout = $jinput->getCmd('layout', NULL);
$task = $jinput->getCmd('task', NULL);

// Get widget id
$widget_id = $params->get('widget_id', 0, 'INT');

// Change to Minitek Wall view
$jinput->set('option', 'com_minitekwall');
$jinput->set('view', 'masonry');
$jinput->set('widget_id', $widget_id);
$jinput->set('layout', '');
$jinput->set('task', 'display');

// Load language
$lang = \JFactory::getLanguage();
$lang->load('com_minitekwall', JPATH_SITE);

// Load controller
$config = array(
	'base_path'		=> JPATH_SITE .'/components/com_minitekwall',
	'view_path'		=> JPATH_SITE .'/components/com_minitekwall/src/Module/views',
	'model_path'	=> JPATH_SITE .'/components/com_minitekwall/src/Module/models',
	'name'			=> 'Module', // view prefix
	'model_prefix'	=> 'ModuleModel', // model prefix
);
$controller = new DisplayController($config);
$controller->execute('display');

// Revert back to original page vars
if ($option != null)
{
	$jinput->set('option', $option);
}

if ($view != null)
{
	$jinput->set('view', $view);
}

if ($layout != null)
{
	$jinput->set('layout', $layout);
}

if ($task != null)
{
	$jinput->set('task', $task);
}

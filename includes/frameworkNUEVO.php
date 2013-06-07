<?php
/**
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

//
// Joomla system checks.
//
/*
comentario jagl
En primer lugar pone dos seteos o configuraciones de seguridad y de compatiblidad (zend y magic quotes)
*/
@ini_set('magic_quotes_runtime', 0);
@ini_set('zend.ze1_compatibility_mode', '0');

//
// Installation check, and check on removal of the install directory.
//
/*
 * jagl
 * Luego verifica si existe o no la carpeta "installation". Si la encuentra ejecuta la aplicación JInsta-ller. Si no la encuentra contínua...
 * 
 * */
 /*
  * jagl
  * veo que tambien verifica si extiste el archivo configuration.php
  * */
if (!file_exists(JPATH_CONFIGURATION.'/configuration.php') || (filesize(JPATH_CONFIGURATION.'/configuration.php') < 10) || file_exists(JPATH_INSTALLATION.'/index.php')) {
	//jagl pregunta si existe el archivo installation/index.php
	//si no existe sale imprime el mensaje de error en el else
	if (file_exists(JPATH_INSTALLATION.'/index.php')) {
		header('Location: '.substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'index.php')).'installation/index.php');
		exit();
	} else {
		//si no existe el archivo installation/index.php
		echo 'No configuration file found and no installation code available. Exiting...';
		exit();
	}
}

//
// Joomla system startup.
//

// System includes.
//Carga la librería import cuál es la encargada de dejar "utilizable" la Plataforma Joomla con sus funciones.
require_once JPATH_LIBRARIES.'/import.php';

// Force library to be in JError legacy mode
JError::$legacy = true;
JError::setErrorHandling(E_NOTICE, 'message');
JError::setErrorHandling(E_WARNING, 'message');
JError::setErrorHandling(E_ERROR, 'message', array('JError', 'customErrorPage'));

// Botstrap the CMS libraries.
/*
 * jagl
 * Carga la librería CMS que contiene la versión de la plataforma y registra rutas para las reglas de acceso y de los formularios*/
require_once JPATH_LIBRARIES.'/cms.php';

// Pre-Load configuration.
ob_start();
//jagl Luego toma los datos de configuración cuyo archivo se encuentra en la raíz del sitio (configura-tor.php).
require_once JPATH_CONFIGURATION.'/configuration.php';
ob_end_clean();

// System configuration.
$config = new JConfig();

// Set the error_reporting
switch ($config->error_reporting)
{
	case 'default':
	case '-1':
		break;

	case 'none':
	case '0':
		error_reporting(0);
		break;

	case 'simple':
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		ini_set('display_errors', 1);
		break;

	case 'maximum':
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		break;

	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	default:
		error_reporting($config->error_reporting);
		ini_set('display_errors', 1);
		break;
}
//jagl  Define JDEBUG (para dar salida de depuración en pantalla) si está configurado el CMS para depurar.
define('JDEBUG', $config->debug);

unset($config);

//
// Joomla framework loading.
//

// System profiler.
if (JDEBUG) {
	jimport('joomla.error.profiler');
	//jagl Si lo anterior es positivo, asimismo define el $_profiler (un sistema de depuración de errores)
	$_PROFILER = JProfiler::getInstance('Application');
}

//
// Joomla library imports.
//
//jagl Finalmente carga algunas librerías para manipular menús, url y otras utilidades.
jimport('joomla.application.menu');
jimport('joomla.environment.uri');
jimport('joomla.utilities.utility');
jimport('joomla.event.dispatcher');
jimport('joomla.utilities.arrayhelper');

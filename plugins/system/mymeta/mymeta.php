<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');
/** 
* Plugin "System" de ejemplo 
*/ 
class plgSystemMyMeta extends JPlugin
{
	/*
	 * cuando carga
	 * libraries/joomla/document/html/renderer/head.php
	 * dispara el evento onBeforeCompileHead
	 * asi que creo que recorre todos los plugin (como este)
	 * y al encontrar el evento que coincide onBeforeCompileHead
	 * se ejecutara las intrucciones contenidas dentro
	 * de esta funcion
	 *  */
	function onBeforeCompileHead() 
	{ 
		/*
		echo "<pre> <br />\n";
		var_dump(JFactory::getDocument());
		echo "</pre>";
		exit ();
		*/
		if ($this->params->get('revised')) { 
			$document = JFactory::getDocument(); 
			$headData = $document->getHeadData(); 
			$headData['metaTags']['standard']['revised'] = 
			$this->params->get('revised');
			$document->setHeadData($headData); 
		}
	}	
}

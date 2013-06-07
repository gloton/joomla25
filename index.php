<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
/**
 * los comentario los saque utilizando una pagina, la cual capture con evernote
 * url web 
 * http://juuntos.org/proyectos-juuntos/proyectos-de-documentaci%C3%B3n-y-tutoriales/introducci%C3%B3n-a-la-plataforma-joomla/277-cap-6-%E2%80%93-integraci%C3%B3n-de-la-plataforma-con-el-cms-joomla.html
 * url evernote
 * evernote:///view/1299324/s11/528211a0-1ce0-4a9e-990b-ef83570941dd/528211a0-1ce0-4a9e-990b-ef83570941dd/
 * 
 * */
// Set flag that this is a parent file.
/*
comentario jagl
"define" es función de PHP por la cual podemos definir una constante nominal.
En este caso decimos que la constante llamada "_JEXEC" tendrá como valor 1 (el dígito 1 es simbólico, a los efectos de cumplir la sintaxis, si ponemos 1000 es lo mismo).
Esta definición es el primer paso de seguridad para todo el CMS ya que autoriza o no la carga de cualquier script ubicado en cualquier parte.
Ejemplo de uso:
Supongamos que alguien quiere cargar el archivo index.php ubicado en la carpeta "root/templates/system/index.php".
Si observamos el código de ese archivo veremos que su primera línea de código es:
defined('_JEXEC') or die;
o
defined('_JEXEC') or die('Restricted access');
"defined" es otra función que evalúa si una constante está definida. Caso contrario terminará la ejecución de PHP, o en el segundo ejemplo, mostrará un mensaje de "Acceso restringido".
Es por ello que todos los scripts deben comenzar siempre con esta línea de código.
*/
define('_JEXEC', 1);
/*
comentario jagl
Esta otra definición establece que el término "DS" será el utilizado como separador de rutas. Se procede de esta forma para evitar el uso de /ó \, ya que según sea el sistema operativo donde se esté ejecutando Joomla tendrá un significado u otro (ejemplo: en Windows \ es un separador de directorios, pero en Linux no).
A partir de esta definición, podemos en otros script invocar un directorio de la forma: adminis-trator.'DS'.templates, por ejemplo, y funcionará bien tanto en Windows como en Linux.
*/
define('DS', DIRECTORY_SEPARATOR);

/*
comentario jagl
Estas líneas de código establecen las rutas iniciales por defecto. En las primeras se busca un archivo alternativo de definición en el directorio actual y si es encontrado se carga lo que está dentro (esto es utilizado por ejemplo para cambiar la ruta de "administrador", sin embargo no todas las extensiones usan luego las constantes de rutas definidas, por eso utilizar con cuidado).
En las líneas de más abajo, se verificaba que no hayan sido definidas las rutas y en caso de no existir se establece una ruta base "JPATH_BASE" y se carga el archivo de definición por defecto que está dentro de la carpeta "includes".
*/
if (file_exists(dirname(__FILE__) . '/defines.php')) {
	include_once dirname(__FILE__) . '/defines.php';
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname(__FILE__));
	require_once JPATH_BASE.'/includes/defines.php';
}

/*
comentario jagl
Esta línea es la encargada de cargar el archivo "framework"
*/
require_once JPATH_BASE.'/includes/framework.php';

// Mark afterLoad in the profiler.
/*jagl
 * Esta línea de código verifica si está configurado el CMS para depuración y de ser así 
da salida de los resultados en la pantalla de lo acontecido luego de la carga (mostrará 
errores de la carga de todo lo anterior).
*/
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
//jagl Aquí se crea la aplicación Site mediante un instanciamiento de la misma.
//includes/application.php
/*JAGL 11:03 16/11/2012

Esta linea $app = JFactory::getApplication('site');  perteneciente al archivo index llama 
a getApplication('site') perteneciente a libraries/joomla/factory.php

En este archivo este metodo llama getInstance:
self::$application = JApplication::getInstance($id, $config, $prefix); perteniciente al 
archivo libraries/joomla/application/application.php

A su ves getInstance incluye el archivo /includes/application.php

                  $path = $info-> path . '/includes/application.php' ;
                   if (file_exists($path))
                  {
                         include_once $path;

 */

$app = JFactory::getApplication('site');

// Initialise the application.
//jagl Se inicializa la aplicación y se establece qué editor se utilizará y el lenguaje del sitio.
//JAGL 12:29 12/11/2012 segun el libro la mas importante es averiguar el lenguaje que se necesita cargar

$app->initialise();

// Mark afterIntialise in the profiler.
/*jagl
 * Si está configurado el CMS para depurar, se verifican errores durante la inicialización 
 * de la aplicación "site".*/
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

// Route the application.
/* jagl Se establecen las URL de la aplicación, es decir, se examina el entorno de 
 * ejecución y se determina qué componente recibirá la solicitud y los parámetros 
 * opcionales del mismo.*/
$app->route();


// Mark afterRoute in the profiler.
/*jagl Si está configurado el CMS para depurar, se verifican errores durante el ruteo de 
 * la aplicación "site".*/
JDEBUG ? $_PROFILER->mark('afterRoute') : null;

// Dispatch the application.
/*jagl Establece el nombre del sitio, carga la metadescripción y carga 
 * el contenido del componente prin-cipal para luego ser renderizado.*/
$app->dispatch();

// Mark afterDispatch in the profiler.
/*jagl Si está configurado el CMS para depurar, se verifican errores durante 
 * la carga del sitio y sus contenidos.*/
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

// Render the application.
/*jagl
 * Carga los contenidos de todo el sitio en los espacios definidos en la plantilla 
 * trayendo los datos desde la base de datos. Además pone a disposición el buffers de 
 * variables de URL que luego se podrán utilizar con la API JRequest.*/
$app->render();

// Mark afterRender in the profiler.
/*jagl Si está configurado el CMS para depurar, se verifican errores durante el 
 * renderizado (aquí nor-malmente saltan los errores de plantillas, módulos, etc.)*/
JDEBUG ? $_PROFILER->mark('afterRender') : null;

// Return the response.
/*jagl
 * Muestra el sitio*/
echo "<h1>hola 1148</h1>";

// jagl $app = JFactory::getApplication('site');
//jagl echo $app->requestTime;
JFactory::getApplication()->requestTime;
echo $app;
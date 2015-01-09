<?php
/**
 * Html2Wiki extension - enables you to import HTML content into your wiki.
 *
 * @link http://mediawiki.org/wiki/Extension:Html2Wiki For more info 
 * (when available)
 *
 * @file
 * @ingroup Extensions
 * @author Greg Rundlett @link http://eQuality-Tech.com eQuality Technology
 * @license GNU General Public Licence 2.0 or later
 * @todo publish the extension upstream. first with the @link http://www.mediawiki.org/wiki/Template:Extension
 *
 * This file is part of the Html2Wiki Extension to MediaWiki
 * @link https://www.mediawiki.org/wiki/Extension:Html2Wiki
 * 
 * This is the setup file
 * This file will need to accomplish a number of tasks including
 * * register any media handler, parser function, special page, custom XML tag, 
 * and variable used by your extension.
 * * define and/or validate any configuration variables you have defined for 
 * your extension.
 * * prepare the classes used by your extension for autoloading
 * * determine what parts of your setup should be done immediately and what 
 * needs to be deferred until the MediaWiki core has been initialized and 
 * configured
 * * define any additional hooks needed by your extension
 * * create or check any new database tables required by your extension.
 * * setup localisation for your extension
 * @link https://www.mediawiki.org/wiki/Manual:Developing_extensions
 *
 * @section LICENSE
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
This file is an extension to the MediaWiki software and cannot be used on its own.

To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/Html2Wiki/Html2Wiki.php" );

EOT;
	die( 1 );
}

/**
 * Add in a version compatibility check
 * I'm unsure what version we will require, but this is how you do it
 */
if ( version_compare( $wgVersion, '1.21', '<' ) ) {
	die( "This extension requires MediaWiki 1.21+\n" );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Html2Wiki',
	'author' => array(
		'Greg Rundlett',
	),
	'version'  => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Html2Wiki',
	'descriptionmsg' => 'html2wiki-desc',
	'license-name' => 'GPL-2.0+', // GNU General Public License v2.0 or later
);

/* Setup */

// Register files
$dir = __DIR__;
$wgAutoloadClasses['Html2WikiHooks'] = "$dir/Html2Wiki.hooks.php";
$wgAutoloadClasses['SpecialHtml2Wiki'] = "$dir/specials/SpecialHtml2Wiki.php";

$wgMessagesDirs['Html2Wiki'] = "$dir/i18n";
$wgExtensionMessagesFiles['Html2WikiAlias'] = "$dir/Html2Wiki.i18n.alias.php";

// Register event handlers that attach to hooks in MW
// There are many hooks https://www.mediawiki.org/wiki/Manual:Hooks
// If all we want to do is add CSS or JS to our extension, that is better
// done by the ResourceModule
#$wgHooks['NameOfHook'][] = 'Html2WikiHooks::onNameOfHook';
# e.g. the 'BeforePageDisplay' hook Allows last minute changes to the output 
# page such as adding CSS or JavaScript by your extension.
# There are many acceptable syntaxes for registering the event handler.
# This one is a static method call
#$wgHooks['BeforePageDisplay'][] = 'Html2WikiHooks::onBeforePageDisplay';

// Register special pages
$wgSpecialPages['Html2Wiki'] = 'SpecialHtml2Wiki'; // the name of the subclass
// Set the group for our Special Page(s)
// deprecated but still works See getGroupName()
// $wgSpecialPageGroups['Html2Wiki'] = 'media';

// Register modules through the ResourceLoader
$wgResourceModules['ext.Html2Wiki'] = array(
	'scripts' => array('modules/ext.Html2Wiki.js'),
	'styles' => array('modules/ext.Html2Wiki.css'),
    // awk -F':' '/html2wiki/ {print $1","}' i18n/en.json | sort | tr -d '\t '
	'messages' => array(
        "html2wiki",
        "html2wiki-desc",
        "html2wiki-fieldset-legend",
        "html2wiki-filename",
        "html2wiki-i18n-welcome",
        "html2wiki-intro",
        "html2wiki-log-description",
        "html2wiki-log-name",
        "html2wiki-not-allowed",
        "html2wiki-summary",
        "html2wiki-text",
        "html2wiki-title",
        "html2wiki_uploaderror"
    ),
	'dependencies' => array(),
    'position' => 'bottom', // bottom or top
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Html2Wiki/',
);

/* Logging */
// By adding to wgLogTypes, we get an entry in the dropdown on Special:Log
// Several keys in the i18n file are used to provide messages
$wgLogTypes[] = 'html2wiki';
// set the keys for i18n instead of defaults "log-name-$type" "log-description-$type"
// this makes all our messages start with the extension prefix
$wgLogNames['html2wiki']= 'html2wiki-log-name';
$wgLogHeaders['html2wiki']= 'html2wiki-log-description';

/* Configuration */

// Enable Foo
#$wgHtml2WikiEnableFoo = true;

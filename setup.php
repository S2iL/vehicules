<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 Vehicules plugin for GLPI
 Copyright (C) 2003-2011 by the vehicules Development Team.

 https://forge.indepnet.net/projects/vehicules
 -------------------------------------------------------------------------

 LICENSE
		
 This file is part of vehicules.

 Vehicules is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Vehicules is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Vehicules. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// Init the hooks of the plugins -Needed
function plugin_init_vehicules() {
	global $PLUGIN_HOOKS;
   
   $PLUGIN_HOOKS['csrf_compliant']['vehicules'] = true;
	$PLUGIN_HOOKS['change_profile']['vehicules'] = array('PluginVehiculesProfile','changeProfile');
	$PLUGIN_HOOKS['assign_to_ticket']['vehicules'] = true;
  
	if (Session::getLoginUserID()) {
      
      Plugin::registerClass('PluginVehiculesVehicule', array(
         'linkuser_types' => true,
         'document_types' => true,
         'helpdesk_visible_types' => true,
         'ticket_types'         => true,
         'notificationtemplates_types' => true
      ));
   
      Plugin::registerClass('PluginVehiculesProfile',
                         array('addtabon' => 'Profile'));
      
      Plugin::registerClass('PluginVehiculesConfig',
                         array('addtabon' => 'CronTask'));
      
      if (class_exists('PluginResourcesResource')) {
         PluginResourcesResource::registerType('PluginVehiculesVehicule');
      }

		if (isset($_SESSION["glpi_plugin_environment_installed"]) 
                  && $_SESSION["glpi_plugin_environment_installed"]==1) {

		$_SESSION["glpi_plugin_environment_vehicules"] = 1;

			if (plugin_vehicules_haveRight("vehicules","r")) {
				$PLUGIN_HOOKS['submenu_entry']['environment']['options']['vehicules']['title'] = PluginVehiculesVehicule::getTypeName(2);
				$PLUGIN_HOOKS['submenu_entry']['environment']['options']['vehicules']['page'] = '/plugins/vehicules/front/vehicule.php';
				$PLUGIN_HOOKS['submenu_entry']['environment']['options']['vehicules']['links']['search'] = '/plugins/vehicules/front/vehicule.php';
			}

			if (plugin_vehicules_haveRight("vehicules","w")) {
				$PLUGIN_HOOKS['submenu_entry']['environment']['options']['vehicules']['links']['add'] = '/plugins/vehicules/front/vehicule.form.php';
			}
		} else {

			if (plugin_vehicules_haveRight("vehicules","r")) {
				$PLUGIN_HOOKS['menu_entry']['vehicules'] = 'front/vehicule.php';
				$PLUGIN_HOOKS['submenu_entry']['vehicules']['search'] = 'front/vehicule.php';
			}

			if (plugin_vehicules_haveRight("vehicules","w")) {
				$PLUGIN_HOOKS['submenu_entry']['vehicules']['add'] = 'front/vehicule.form.php?new=1';
			}
		}
		
      if (class_exists('PluginVehiculesVehicule')) { // only if plugin activated
         //Clean Plugin on Profile delete
         $PLUGIN_HOOKS['pre_item_purge']['vehicules'] = array('Profile
                                             '=>array('PluginVehiculesProfile', 'purgeProfiles'));
         $PLUGIN_HOOKS['plugin_datainjection_populate']['vehicules'] = 'plugin_datainjection_populate_vehicules';
      }
		// Import from Data_Injection plugin
		$PLUGIN_HOOKS['migratetypes']['vehicules'] = 'plugin_datainjection_migratetypes_vehicules';

	}
}

// Get the name and the version of the plugin - Needed

function plugin_version_vehicules() {

	return array (
		'name' => _n('Vehicule', 'Vehicules', 2, 'vehicules'),
		'version' => '1.9.0',
		'author'  => "<a href='http://www.s2il.fr/'>Philippe PASSIS</a>",
		'license' => 'GPLv2+',
		'homepage'=>'https://github.com/S2iL/vehicules',
		'minGlpiVersion' => '0.84',// For compatibility / no install in version < 0.80
	);
}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_vehicules_check_prerequisites() {
   if (version_compare(GLPI_VERSION,'0.84','lt') || version_compare(GLPI_VERSION,'0.85','ge')) {
      _e('This plugin requires GLPI >= 0.84', 'vehicules');
      return false;
   }
   return true;
}

// Uninstall process for plugin : need to return true if succeeded
//may display messages or add to message after redirect
function plugin_vehicules_check_config() {
	return true;
}

function plugin_vehicules_haveRight($module,$right) {
	$matches=array(
			""  => array("","r","w"), // ne doit pas arriver normalement
			"r" => array("r","w"),
			"w" => array("w"),
			"1" => array("1"),
			"0" => array("0","1"), // ne doit pas arriver non plus
		      );
	if (isset($_SESSION["glpi_plugin_vehicules_profile"][$module])
                  && in_array($_SESSION["glpi_plugin_vehicules_profile"][$module],$matches[$right]))
		return true;
	else return false;
}

function plugin_datainjection_migratetypes_vehicules($types) {
   $types[1600] = 'PluginVehiculesVehicule';
   return $types;
}

?>
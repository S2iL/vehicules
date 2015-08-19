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

function plugin_vehicules_install() {
   global $DB;
   
   include_once (GLPI_ROOT."/plugins/vehicules/inc/profile.class.php");
   
   $install=false;
  
   if (!TableExists("glpi_plugin_vehicules")) {
      $install=true;
      $DB->runFile(GLPI_ROOT ."/plugins/vehicules/sql/empty-1.9.0.sql");
   } 

   if ($install) {
      
      //Do on 0.78
      $query_id = "SELECT `id` FROM `glpi_notificationtemplates` WHERE `itemtype`='PluginVehiculesVehicule' AND `name` = 'Alert Vehicules'";
      $result = $DB->query($query_id) or die ($DB->error());
      $itemtype = $DB->result($result,0,'id');
      
      $query="INSERT INTO `glpi_notificationtemplatetranslations`
                                 VALUES(NULL, ".$itemtype.", '','##vehicule.action## : ##vehicule.entity##',
                        '##lang.vehicule.entity## :##vehicule.entity##
   ##FOREACHvehicules##
   ##lang.vehicule.name## : ##vehicule.name## - ##lang.vehicule.dateexpiration## : ##vehicule.dateexpiration####IFvehicule.serial## - ##lang.vehicule.serial## : ##vehicule.serial####ENDIFvehicule.serial####IFvehicule.users## - ##lang.vehicule.users## : ##vehicule.users####ENDIFvehicule.users##
   ##ENDFOREACHvehicules##',
                        '&lt;p&gt;##lang.vehicule.entity## :##vehicule.entity##&lt;br /&gt; &lt;br /&gt;
                        ##FOREACHvehicules##&lt;br /&gt;
                        ##lang.vehicule.name##  : ##vehicule.name## - ##lang.vehicule.dateexpiration## :  ##vehicule.dateexpiration####IFvehicule.serial## - ##lang.vehicule.serial## :  ##vehicule.serial####ENDIFvehicule.serial####IFvehicule.users## - ##lang.vehicule.users## :  ##vehicule.users####ENDIFvehicule.users##&lt;br /&gt; 
                        ##ENDFOREACHvehicules##&lt;/p&gt;');";
      $result=$DB->query($query);
      
      $query = "INSERT INTO `glpi_notifications`
                                   VALUES (NULL, 'Alert Expired Vehicules', 0, 'PluginVehiculesVehicule', 'ExpiredVehicules',
                                          'mail',".$itemtype.",
                                          '', 1, 1, '2010-02-17 22:36:46');";
      $result=$DB->query($query);
      $query = "INSERT INTO `glpi_notifications`
                                   VALUES (NULL, 'Alert Vehicules Which Expire', 0, 'PluginVehiculesVehicule', 'VehiculesWhichExpire',
                                          'mail',".$itemtype.",
                                          '', 1, 1, '2010-02-17 22:36:46');";

      $result=$DB->query($query);
   }
   
	CronTask::Register('PluginVehiculesVehicule', 'VehiculesAlert', DAY_TIMESTAMP);
	
   PluginVehiculesProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
   return true;
}

function plugin_vehicules_configure15() {
	global $DB;
	
	// ADD FK_users
	$query_old_items="SELECT `glpi_plugin_vehicules_users`.`FK_users`,`glpi_plugin_vehicules`.`ID` 
					FROM `glpi_plugin_vehicules_users`,`glpi_plugin_vehicules` WHERE `glpi_plugin_vehicules_users`.`FK_vehicules` = `glpi_plugin_vehicules`.`ID` ";
	$result_old_items=$DB->query($query_old_items);
	if ($DB->numrows($result_old_items)>0) {

		while ($data_old_items=$DB->fetch_array($result_old_items)) {
			if ($data_old_items["ID"]) { 
				$query = "UPDATE `glpi_plugin_vehicules` SET `FK_users` = '".$data_old_items["FK_users"]."' WHERE `ID` = '".$data_old_items["ID"]."' ";
				$DB->query($query);
			}
		}
	}
	
	$query = "DROP TABLE IF EXISTS `glpi_plugin_vehicules_users` ";
	$DB->query($query);
}

function plugin_vehicules_uninstall() {
	global $DB;

   $tables = array("glpi_plugin_vehicules_vehicules",
					"glpi_plugin_vehicules_vehiculetypes",
					"glpi_plugin_vehicules_vehiculecarburants",
					"glpi_plugin_vehicules_vehiculegenres",
					"glpi_plugin_vehicules_vehiculemarques",
					"glpi_plugin_vehicules_vehiculemodeles",
					"glpi_plugin_vehicules_profiles",
					"glpi_plugin_vehicules_configs",
					"glpi_plugin_vehicules_notificationstates");

	foreach($tables as $table)
		$DB->query("DROP TABLE IF EXISTS `$table`;");

	$notif = new Notification();
    $options = array('itemtype' => 'PluginVehiculesVehicule',
                    'event'    => 'ExpiredVehicules',
                    'FIELDS'   => 'id');
    foreach ($DB->request('glpi_notifications', $options) as $data) {
        $notif->delete($data);
    }

    $options = array('itemtype' => 'PluginVehiculesVehicule',
                    'event'    => 'VehiculesWhichExpire',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   
   //templates
   $template = new NotificationTemplate();
   $translation = new NotificationTemplateTranslation();
   $options = array('itemtype' => 'PluginVehiculesVehicule',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notificationtemplates', $options) as $data) {
      $options_template = array('notificationtemplates_id' => $data['id'],
                    'FIELDS'   => 'id');
   
         foreach ($DB->request('glpi_notificationtemplatetranslations', $options_template) as $data_template) {
            $translation->delete($data_template);
         }
      $template->delete($data);
   }
   $tables_glpi = array("glpi_displaypreferences",
					"glpi_documents_items",
					"glpi_bookmarks",
					"glpi_logs",
					"glpi_tickets");

	foreach($tables_glpi as $table_glpi)
		$DB->query("DELETE FROM `$table_glpi` WHERE `itemtype` = 'PluginVehiculesVehicule';");

	if (class_exists('PluginDatainjectionModel')) {
      PluginDatainjectionModel::clean(array('itemtype'=>'PluginVehiculesVehicule'));
   }

	return true;
}

function plugin_vehicules_AssignToTicket($types) {
	if (plugin_vehicules_haveRight("open_ticket","1"))
		$types['PluginVehiculesVehicule']= PluginVehiculesVehicule::getTypeName(2);
	return $types;
}

// Define dropdown relations
function plugin_vehicules_getDatabaseRelations() {

   $plugin = new Plugin();
   if ($plugin->isActivated("vehicules"))
      return array("glpi_plugin_vehicules_vehiculetypes"=>array("glpi_plugin_vehicules_vehicules"=>"plugin_vehicules_vehiculetypes_id"),
      "glpi_entities"=>array("glpi_plugin_vehicules_vehicules"=>"entities_id",
                              "glpi_plugin_vehicules_vehiculetypes"=>"entities_id"),
      "glpi_locations"=>array("glpi_plugin_vehicules_vehicules"=>"locations_id"),
      "glpi_states"=>array("glpi_plugin_vehicules_vehicules"=>"states_id",
                           "glpi_plugin_vehicules_mailingstates"=>"states_id"),
      "glpi_profiles" => array (
				"glpi_plugin_vehicules_profiles" => "profiles_id"
			),
      "glpi_users"=>array("glpi_plugin_vehicules_vehicules"=>"users_id"));
   else
      return array();
}

// Define Dropdown tables to be manage in GLPI :
function plugin_vehicules_getDropdown() {
	$plugin = new Plugin();
	if ($plugin->isActivated("vehicules"))
		return array("PluginVehiculesVehiculeType"=> PluginVehiculesVehiculeType::getTypeName(2));
	else
		return array();
}

function plugin_vehicules_displayConfigItem($type,$ID,$data,$num) {
	$searchopt=&Search::getOptions($type);
	$table=$searchopt[$ID]["table"];
	$field=$searchopt[$ID]["field"];
	
	switch ($table.'.'.$field) {
      case "glpi_plugin_vehicules_vehicules.date_expiration" :
         if ($data["ITEM_$num"] <= date('Y-m-d') && !empty($data["ITEM_$num"]))
            return " class=\"deleted\" ";
         break;
	}
	return "";
}

function plugin_datainjection_populate_vehicules() {
   global $INJECTABLE_TYPES;
   $INJECTABLE_TYPES['PluginVehiculesVehiculeInjection'] = 'vehicules';
}
?>
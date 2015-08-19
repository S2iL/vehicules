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

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

class PluginVehiculesVehicule extends CommonDBTM {
   
   public $dohistory=true;
   
   static function getTypeName($nb=0) {
      return _n('Vehicule', 'Vehicules', $nb, 'vehicules');
   }
   
   static function canCreate() {
      return plugin_vehicules_haveRight('vehicules', 'w');
   }

   static function canView() {
      return plugin_vehicules_haveRight('vehicules', 'r');
   }
  
   function getSearchOptions() {

      $tab                       = array();

      $tab['common']             = self::getTypeName(2);

      $tab[1]['table']           = $this->getTable();
      $tab[1]['field']           = 'name';
      $tab[1]['name']            = __('Name');
      $tab[1]['datatype']        = 'itemlink';
      $tab[1]['itemlink_type']   = $this->getType();
      
      $tab[2]['table']           = 'glpi_locations';
      $tab[2]['field']           = 'completename';
      $tab[2]['name']            = __('Location');
      $tab[2]['datatype']        = 'dropdown';
      
      $tab[3]['table']           = 'glpi_plugin_vehicules_vehiculetypes';
      $tab[3]['field']           = 'name';
      $tab[3]['name']            = __('Type');
      $tab[3]['datatype']        = 'dropdown';
      
      $tab[4]['table']           = $this->getTable();
      $tab[4]['field']           = 'nb_place';
      $tab[4]['name']            = __('Nb place assises (S1)');
  
      $tab[5]['table']           = $this->getTable();
      $tab[5]['field']           = 'num_immat';
      $tab[5]['name']            = __('Numéro Immat (A)');
      
      $tab[6]['table']           = 'glpi_plugin_vehicules_vehiculemarques';
      $tab[6]['field']           = 'name';
      $tab[6]['name']            = __('Marque (D1)');
      $tab[6]['datatype']        = 'dropdown';
      
      $tab[7]['table']           = 'glpi_plugin_vehicules_vehiculemodeles';
      $tab[7]['field']           = 'name';
      $tab[7]['name']            = __('Modele (D.2)');
      $tab[7]['datatype']        = 'dropdown';
      
      $tab[8]['table']           = $this->getTable();
      $tab[8]['field']           = 'denom_com';
      $tab[8]['name']            = __('Dénomination commerciale (D3)'); 
      
      $tab[9]['table']           = 'glpi_plugin_vehicules_vehiculegenres';
      $tab[9]['field']           = 'name';
      $tab[9]['name']            = __('Genre (J1)');
      $tab[9]['datatype']        = 'dropdown';
      
      $tab[10]['table']           = $this->getTable();
      $tab[10]['field']           = 'ptac';
      $tab[10]['name']            = __('PTAC (F2)'); 
        
      $tab[11]['table']           = $this->getTable();
      $tab[11]['field']           = 'date_expiration';
      $tab[11]['name']            = __('Visite avant le (X1)', 'vehicules');
      $tab[11]['datatype']        = 'date';
      
      $tab[12]['table']          = 'glpi_users';
      $tab[12]['field']          = 'name';
      $tab[12]['name']           = __('User');
      $tab[12]['datatype']       = 'dropdown';
      $tab[12]['right']          = 'all';
      
      $tab[13]['table']           = $this->getTable();
      $tab[13]['field']           = 'date_affectation';
      $tab[13]['name']            = __('Affectation date', 'vehicules');
      $tab[13]['datatype']        = 'date';
      
      $tab[14]['table']           = 'glpi_states';
      $tab[14]['field']           = 'completename';
      $tab[14]['name']            = __('Status');
      $tab[14]['datatype']        = 'dropdown';
      
      $tab[15]['table']           = $this->getTable();
      $tab[15]['field']           = 'is_helpdesk_visible';
      $tab[15]['name']            = __('Associable to a ticket');
      $tab[15]['datatype']        = 'bool';
      
      $tab[16]['table']           = $this->getTable();
      $tab[16]['field']           = 'date_immat';
      $tab[16]['name']            = __('Date 1er Immat (B)', 'vehicules');
      $tab[16]['datatype']        = 'date';    
      
      $tab[17]['table']           = $this->getTable();
      $tab[17]['field']           = 'code_ident';
      $tab[17]['name']            = __('Code Identification (D2.1)');  
      
      $tab[18]['table']           = $this->getTable();
      $tab[18]['field']           = 'num_ident';
      $tab[18]['name']            = __('Numéro identification (E)');   
      
      $tab[19]['table']           = 'glpi_plugin_vehicules_vehiculecarburants';
      $tab[19]['field']           = 'name';
      $tab[19]['name']            = __('Carburant (P3)');
      $tab[19]['datatype']        = 'dropdown';
      
      $tab[20]['table']           = $this->getTable();
      $tab[20]['field']           = 'puissance_admin';
      $tab[20]['name']            = __('Puissance Administrative (P6)');
      
      $tab[21]['table']          = $this->getTable();
      $tab[21]['field']          = 'date_mod';
      $tab[21]['name']           = __('Last update');
      $tab[21]['datatype']       = 'datetime';
      $tab[21]['massiveaction']  = false;
      
      $tab[22]['table']           = $this->getTable();
      $tab[22]['field']           = 'comment';
      $tab[22]['name']            = __('Comments');
      $tab[22]['datatype']        = 'text';
      
      $tab[30]['table']          = $this->getTable();
      $tab[30]['field']          = 'id';
      $tab[30]['name']           = __('ID');
      $tab[30]['datatype']       = 'number';

      $tab[80]['table']          = 'glpi_entities';
      $tab[80]['field']          = 'completename';
      $tab[80]['name']           = __('Entity');
      $tab[80]['datatype']       = 'dropdown';
      
      return $tab;
   }
   
   function defineTabs($options=array()) {

      $ong = array();
      $this->addStandardTab('Ticket', $ong, $options);
      $this->addStandardTab('Item_Problem', $ong, $options);
      $this->addStandardTab('Document_Item', $ong, $options);
      $this->addStandardTab('Note', $ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }

	function prepareInputForAdd($input) {

		if (isset($input['date_affectation']) && empty($input['date_affectation'])) 
         $input['date_affectation']='NULL';
		if (isset($input['date_expiration']) && empty($input['date_expiration'])) 
         $input['date_expiration']='NULL';
        if (isset($input['date_immat']) && empty($input['date_immat'])) 
         $input['date_immat']='NULL';

		return $input;
	}

	function prepareInputForUpdate($input) {

		if (isset($input['date_affectation']) && empty($input['date_affectation'])) 
         $input['date_affectation']='NULL';
		if (isset($input['date_expiration']) && empty($input['date_expiration'])) 
         $input['date_expiration']='NULL';
        if (isset($input['date_immat']) && empty($input['date_immat'])) 
         $input['date_immat']='NULL';

		return $input;
	}

	function showForm ($ID, $options=array()) {

      $this->initForm($ID, $options);
      $this->showTabs($options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Name') . "</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"name");
      echo "</td>";
      echo "<td>" . __('User') . "</td><td>";
      User::dropdown(array('value' => $this->fields["users_id"],
                           'entity' => $this->fields["entities_id"],
                           'right' => 'all'));
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Location') . "</td><td>";
      Location::dropdown(array('value'  => $this->fields["locations_id"],
                               'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "<td>" . __('Affectation date', 'vehicules')  . "</td>";
      echo "<td>";
      Html::showDateFormItem("date_affectation",$this->fields["date_affectation"],true,true);
      echo "</td>";
      echo "</tr>";
    
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Type') . "</td><td>";
      Dropdown::show('PluginVehiculesVehiculeType', array('name' => "plugin_vehicules_vehiculetypes_id",
                                                   'value' => $this->fields["plugin_vehicules_vehiculetypes_id"], 
                                                   'entity' => $this->fields["entities_id"]));
      echo "<td>" . __('Status') . "</td><td>";
      State::dropdown(array('value' => $this->fields["states_id"]));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>". __('Nb place assises (S1)') . "</td><td>";
       Html::autocompletionTextField($this,"nb_place");
      echo "</td>";
      echo "<td>" . __('Associable to a ticket') . "</td><td>";
      Dropdown::showYesNo('is_helpdesk_visible',$this->fields['is_helpdesk_visible']);
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      
      echo "<td>" . __('Numéro Immat (A)') . "</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"num_immat");
      echo "</td>";
      echo "<td>" . __('Date 1er Immat (B)') . "</td>";
      echo "<td>";
      Html::showDateFormItem("date_immat",$this->fields["date_immat"],true,true);
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Marque (D1)')  . "</td>";
      echo "<td>";
      Dropdown::show('PluginVehiculesVehiculeMarque', array('name' => "plugin_vehicules_vehiculemarques_id",
                                                   'value' => $this->fields["plugin_vehicules_vehiculemarques_id"], 
                                                   'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "<td colspan='2'>&nbsp;";
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Modele (D2)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Dropdown::show('PluginVehiculesVehiculeModele', array('name' => "plugin_vehicules_vehiculemodeles_id",
                                                   'value' => $this->fields["plugin_vehicules_vehiculemodeles_id"], 
                                                   'entity' => $this->fields["entities_id"]));
      echo "</td>";
      
      echo "<td>" . __('Code Identification (D2.1)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"code_ident");
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      
      echo "<td>" . __('Dénomination commerciale (D3)') ."&nbsp;";
      echo "</td>";
      
      echo "<td>";
      Html::autocompletionTextField($this,"denom_com");
      echo "</td>";
      
      echo "<td>" . __('Numéro identification (E)') ."&nbsp;";
      echo "</td>";
      
      echo "<td>";
      Html::autocompletionTextField($this,"num_ident");
      echo "</td>";
      
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Genre (J1)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Dropdown::show('PluginVehiculesVehiculeGenre', array('name' => "plugin_vehicules_vehiculegenres_id",
                                                   'value' => $this->fields["plugin_vehicules_vehiculegenres_id"], 
                                                   'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "<td>" . __('Carburant (P3)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Dropdown::show('PluginVehiculesVehiculeCarburant', array('name' => "plugin_vehicules_vehiculecarburants_id",
                                                   'value' => $this->fields["plugin_vehicules_vehiculecarburants_id"], 
                                                   'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('PTAC (F2)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"ptac");
      echo "</td>";
      
      echo "<td>" . __('Puissance Administrative (P6)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
            Html::autocompletionTextField($this,"puissance_admin");
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Visite avant le (X1)') ."&nbsp;";
      echo "</td>";
      echo "<td>";
      Html::showDateFormItem("date_expiration",$this->fields["date_expiration"],true,true);
      echo "</td>";
      echo "<td colspan='2'>";
      printf(__('Last update on %s'), Html::convDateTime($this->fields["date_mod"]));
      echo "</td>";
      echo "</tr>";
      echo "<tr class='tab_bg_1'>";
      
      echo "<td>" . __('Comments') . "</td>";
      echo "<td class='center' colspan='3'><textarea cols='115' rows='5' name='comment' >".
               $this->fields["comment"]."</textarea>";

      echo "</td>";
      echo "</tr>";

      $this->showFormButtons($options);
      $this->addDivForTabs();

      return true;
	}
   
   //for search engine
   static function getSpecificValueToDisplay($field, $values, array $options=array()) {
      
      if (!is_array($values)) {
         $values = array($field => $values);
      }
      switch ($field) {
         case 'date_expiration' :
            
            if (empty($values[$field]))
               return __('infinite');
            else
               return Html::convdate($values[$field]);
         break;
      }
      return parent::getSpecificValueToDisplay($field, $values, $options);
   }
   
   //Massive Action
   function getSpecificMassiveActions($checkitem=NULL) {
      $isadmin = static::canUpdate();
      $actions = parent::getSpecificMassiveActions($checkitem);
      
      if (Session::haveRight('transfer','r')
            && Session::isMultiEntitiesMode()
            && $isadmin) {
         $actions['Transfert'] = __('Transfer');
      }
      return $actions;
   }  

   function showSpecificMassiveActionsParameters($input = array()) {

      switch ($input['action']) {
         case "Transfert" :
            Dropdown::show('Entity');
            echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value='".
                        __s('Post')."'>";
            return true;
         break;
         
         default :
            return parent::showSpecificMassiveActionsParameters($input);
            break;

      }
      return false;
   }
   
   function doSpecificMassiveActions($input = array()) {
      
      $res = array('ok'      => 0,
                   'ko'      => 0,
                   'noright' => 0);
                   
      switch ($input['action']) {
         case "Transfert":
         if ($input['itemtype']=='PluginVehiculesVehicule') {
            
            foreach ($input["item"] as $key => $val) {
               if ($val==1) {
                  $vehicule=new PluginVehiculesVehicule();
                  $vehicule->getFromDB($key);
                  $type = PluginVehiculesVehiculeType::transfer($vehicule->fields["plugin_vehicules_vehiculetypes_id"],$input['entities_id']);
                  if ($type > 0) {
                     $values["id"] = $key;
                     $values["plugin_vehicules_vehiculetypes_id"] = $type;

                     if ($vehicule->update($values)) {
                        $res['ok']++;
                     } else {
                        $res['ko']++;
                     }
                  }
                  
                  unset($values);
                  $values["id"] = $key;
                  $values["entities_id"] = $input['entities_id'];

                  if ($vehicule->update($values)) {
                     $res['ok']++;
                  } else {
                     $res['ko']++;
                  }
               }
            }
         }
         break;

         default :
            return parent::doSpecificMassiveActions($input);
      }
      return $res;
   }
   
   // Cron action
   static function cronInfo($name) {

      switch ($name) {
         case 'VehiculesAlert':
            return array (
               'description' => __('Vehicules which expires', 'vehicules'));   // Optional
            break;
      }
      return array();
   }
   
   static function queryExpiredVehicules() {

      $config=new PluginVehiculesConfig();
      $notif= new PluginVehiculesNotificationState();
      
      $config->getFromDB('1');
      $delay=$config->fields["delay_expired"];

      $query = "SELECT * 
         FROM `glpi_plugin_vehicules_vehicules`
         WHERE `date_expiration` IS NOT NULL
         AND `is_deleted` = '0'
         AND DATEDIFF(CURDATE(),`date_expiration`) > $delay 
         AND DATEDIFF(CURDATE(),`date_expiration`) > 0 ";
      $query.= "AND `states_id` NOT IN (999999";
      $query.= $notif->findStates();
      $query.= ") ";

      return $query;
   }
   
   static function queryVehiculesWhichExpire() {

      $config=new PluginVehiculesConfig();
      $notif= new PluginVehiculesNotificationState();
      
      $config->getFromDB('1');
      $delay=$config->fields["delay_whichexpire"];
      
      $query = "SELECT *
         FROM `glpi_plugin_vehicules_vehicules`
         WHERE `date_expiration` IS NOT NULL
         AND `is_deleted` = '0'
         AND DATEDIFF(CURDATE(),`date_expiration`) > -$delay 
         AND DATEDIFF(CURDATE(),`date_expiration`) < 0 ";
      $query.= "AND `states_id` NOT IN (999999";
      $query.= $notif->findStates();
      $query.= ") ";

      return $query;
   }
   /**
    * Cron action on vehicules : ExpiredVehicules or VehiculesWhichExpire
    *
    * @param $task for log, if NULL display
    *
    **/
   static function cronVehiculesAlert($task=NULL) {
      global $DB,$CFG_GLPI;
      
      if (!$CFG_GLPI["use_mailing"]) {
         return 0;
      }

      $message=array();
      $cron_status = 0;
      
      $query_expired = self::queryExpiredVehicules();
      $query_whichexpire = self::queryVehiculesWhichExpire();
      
      $querys = array(Alert::NOTICE=>$query_whichexpire, Alert::END=>$query_expired);
      
      $vehicule_infos = array();
      $vehicule_messages = array();

      foreach ($querys as $type => $query) {
         $vehicule_infos[$type] = array();
         foreach ($DB->request($query) as $data) {
            $entity = $data['entities_id'];
            $message = $data["name"].": ".
                        Html::convdate($data["date_expiration"])."<br>\n";
            $vehicule_infos[$type][$entity][] = $data;

            if (!isset($vehicules_infos[$type][$entity])) {
               $vehicule_messages[$type][$entity] = __('Vehicules at the end of the validity', 'vehicules') ."<br />";
            }
            $vehicule_messages[$type][$entity] .= $message;
         }
      }
      
      foreach ($querys as $type => $query) {
      
         foreach ($vehicule_infos[$type] as $entity => $vehicules) {
            Plugin::loadLang('vehicules');

            if (NotificationEvent::raiseEvent(($type==Alert::NOTICE?"VehiculesWhichExpire":"ExpiredVehicules"),
                                              new PluginVehiculesVehicule(),
                                              array('entities_id'=>$entity,
                                                    'vehicules'=>$vehicules))) {
               $message = $vehicule_messages[$type][$entity];
               $cron_status = 1;
               if ($task) {
                  $task->log(Dropdown::getDropdownName("glpi_entities",
                                                       $entity).":  $message\n");
                  $task->addVolume(1);
               } else {
                  Session::addMessageAfterRedirect(Dropdown::getDropdownName("glpi_entities",
                                                                    $entity).":  $message");
               }

            } else {
               if ($task) {
                  $task->log(Dropdown::getDropdownName("glpi_entities",$entity).
                             ":  Send vehicules alert failed\n");
               } else {
                  Session::addMessageAfterRedirect(Dropdown::getDropdownName("glpi_entities",$entity).
                                          ":  Send vehicules alert failed",false,ERROR);
               }
            }
         }
      }
      
      return $cron_status;
   }
   
   static function configCron($target) {

      $notif=new PluginVehiculesNotificationState();
      $config=new PluginVehiculesConfig();

      $config->showForm($target,1);
      $notif->showForm($target);
      $notif->showAddForm($target);
    
   }
}

?>
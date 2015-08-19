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

if (!defined('GLPI_ROOT')){
   die("Sorry. You can't access directly to this file");
}

// Class NotificationTarget
class PluginVehiculesNotificationTargetVehicule extends NotificationTarget {

   function getEvents() {
      return array ('ExpiredVehicules' => __('Vehicules at the end of the validity', 'vehicules'),
                     'VehiculesWhichExpire' => __('Vehicules which expires', 'vehicules'));
   }

   function getDatasForTemplate($event,$options=array()) {

      $this->datas['##vehicule.entity##'] =
                        Dropdown::getDropdownName('glpi_entities',
                                                  $options['entities_id']);
      $this->datas['##lang.vehicule.entity##'] = __('Entity');
      $this->datas['##vehicule.action##'] = ($event=="ExpiredVehicules"?__('Vehicules at the end of the validity', 'vehicules'):
         __('Vehicules which expires', 'vehicules'));
      
      $this->datas['##lang.vehicule.name##'] = __('Name');
      $this->datas['##lang.vehicule.dateexpiration##'] = __('Date of end of validity', 'vehicules');
      $this->datas['##lang.vehicule.serial##'] = __('Serial number');
      $this->datas['##lang.vehicule.users##'] = __('Allotted to', 'vehicules');

      foreach($options['vehicules'] as $id => $vehicule) {
         $tmp = array();

         $tmp['##vehicule.name##'] = $vehicule['name'];
         $tmp['##vehicule.serial##'] = $vehicule['serial'];
         $tmp['##vehicule.users##'] = Html::clean(getUserName($vehicule["users_id"]));
         $tmp['##vehicule.dateexpiration##'] = Html::convDate($vehicule['date_expiration']);

         $this->datas['vehicules'][] = $tmp;
      }
   }
   
   function getTags() {

      $tags = array('vehicule.name'             => __('Name'),
                   'vehicule.serial'            => __('Serial number'),
                   'vehicule.dateexpiration'    => __('Date of end of validity', 'vehicules'),
                   'vehicule.users'             => __('Allotted to', 'vehicules'));
      foreach ($tags as $tag => $label) {
         $this->addTagToList(array('tag'=>$tag,'label'=>$label,
                                   'value'=>true));
      }
      
      $this->addTagToList(array('tag'=>'vehicules',
                                'label'=> __('Vehicules expired or vehicules which expires', 'vehicules'),
                                'value'=>false,
                                'foreach'=>true,
                                'events'=>array('VehiculesWhichExpire','ExpiredVehicules')));

      asort($this->tag_descriptions);
   }
}

?>
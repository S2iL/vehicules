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

include ('../../../inc/includes.php');

if (!isset($_GET["id"])) $_GET["id"] = "";
if (!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";

$vehicule=new PluginVehiculesVehicule();

if (isset($_POST["add"])) {

	$vehicule->check(-1,'w',$_POST);
   $newID=$vehicule->add($_POST);
	Html::back();
	
} else if (isset($_POST["delete"])) {

	$vehicule->check($_POST['id'],'w');
   $vehicule->delete($_POST);
	$vehicule->redirectToList();
	
} else if (isset($_POST["restore"])) {

	$vehicule->check($_POST['id'],'w');
   $vehicule->restore($_POST);
	$vehicule->redirectToList();
	
} else if (isset($_POST["purge"])) {

	$vehicule->check($_POST['id'],'w');
   $vehicule->delete($_POST,1);
	$vehicule->redirectToList();
	
} else if (isset($_POST["update"])) {

	$vehicule->check($_POST['id'],'w');
   $vehicule->update($_POST);
	Html::back();
	
} else {
   
   $vehicule->checkGlobal("r");

	$plugin = new Plugin();
	if ($plugin->isActivated("environment"))
		Html::header(PluginVehiculesVehicule::getTypeName(2),'',"plugins","environment","vehicules");
	else
		Html::header(PluginVehiculesVehicule::getTypeName(2),'',"plugins","vehicules");

	$vehicule->showForm($_GET["id"]);

	Html::footer();
}

?>
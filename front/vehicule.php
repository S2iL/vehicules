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

$plugin = new Plugin();
$vehicule=new PluginVehiculesVehicule();

if ($plugin->isActivated("environment"))
	Html::header(PluginVehiculesVehicule::getTypeName(),'',"plugins","environment","vehicules");
else
	Html::header(PluginVehiculesVehicule::getTypeName(),'',"plugins","vehicules");

if ($vehicule->canView() || Session::haveRight("config","w")) {

	Search::show("PluginVehiculesVehicule");

} else {
	Html::displayRightError();
}

Html::footer();

?>
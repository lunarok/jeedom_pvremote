<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */
require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";

if (init('apikey') != config::byKey('api') || config::byKey('api') == '') {
	connection::failed();
	echo 'Clef API non valide, vous n\'etes pas autorisé à effectuer cette action (jeeApi)';
	die();
}

$notify = init('notify');
$id = init('id');
$episode = init('episode');

$elogic = pvremote::byId($id);
if (!is_object($elogic)) {
	echo json_encode(array('text' => __('Id inconnu : ', __FILE__) . init('id')));
	die();
}

$cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($elogic->getId(),'notify_type');
if (!is_object($cmdlogic)) {
	echo json_encode(array('text' => __('Cmd inconnu', __FILE__)));
	die();
}
$cmdlogic->setConfiguration('value',$notify);
$cmdlogic->event($notify);
$cmdlogic->save();

$cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($elogic->getId(),'notify_episode');
if (!is_object($cmdlogic)) {
	echo json_encode(array('text' => __('Cmd inconnu', __FILE__)));
	die();
}
$cmdlogic->setConfiguration('value',$episode);
$cmdlogic->event($episode);
$cmdlogic->save();

return true;
?>

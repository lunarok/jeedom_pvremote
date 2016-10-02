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

$elogic = pvremote::byLogicalId($ip, 'pvremote');
if (!is_object($elogic)) {
	if (config::byKey('include_mode','pvremote') != 1) {
		return false;
	}
	$elogic = new pvremote();
	$elogic->setEqType_name('pvremote');
	$elogic->setLogicalId($ip);
	$elogic->setName($device);
	$elogic->setIsEnable(true);
	$elogic->setConfiguration('ip',$ip);
	$elogic->setConfiguration('device',$device);
	$elogic->save();
	event::add('pvremote::includeDevice',
	array(
		'state' => 1
	)
);
} else {
	if ($device != $elogic->getConfiguration('device')) {
		$elogic->setConfiguration('device',$device);
		$elogic->save();
	}
}

$cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($elogic->getId(),$cmd);
if (!is_object($cmdlogic)) {
	$cmdlogic = new pvremoteCmd();
	$cmdlogic->setLogicalId($cmd);
	$cmdlogic->setName($cmd);
	$cmdlogic->setType('info');
	$cmdlogic->setSubType('numeric');
	$cmdlogic->setEqLogic_id($elogic->getId());
	$cmdlogic->setConfiguration('taskid',$taskid);
	$cmdlogic->setConfiguration('cmd',$cmd);
}
$cmdlogic->setConfiguration('value',$value);
$cmdlogic->event($value);
$cmdlogic->save();

return true;
?>

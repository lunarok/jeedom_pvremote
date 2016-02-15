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
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

if (init('id') == '') {
    throw new Exception('{{L\'id de l\'équipement ne peut etre vide : }}' . init('op_id'));
}

$id = init('id');
$pvremote = pvremote::byId($id);
  if (!is_object($pvremote)) {
  	throw new Exception(__('Aucun equipement ne  correspond : Il faut (re)-enregistrer l\'équipement ', __FILE__) . init('action'));
  }

$url = $pvremote->getConfiguration('url');

?>

<iframe src="<?php echo $url; ?>" height="100%" width="100%">You need a Frames Capable browser to view this content.</iframe>

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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class pvremote extends eqLogic {

  public static $_widgetPossibility = array('custom' => true);

  public static function cronHourly() {
    foreach (eqLogic::byType('pvremote', true) as $pvremote) {
      log::add('pvremote', 'debug', 'pull cron');
    }

  }

  public function preUpdate() {
          if ($this->getConfiguration('addr') == '') {
              throw new Exception(__('L\adresse ne peut être vide',__FILE__));
          }
          if ($this->getConfiguration('key') == '') {
              throw new Exception(__('La clef API ne peut être vide',__FILE__));
          }
       }

  public function preSave() {
$this->setLogicalId($this->getConfiguration('addr'));
}

  public function postUpdate() {
    foreach (eqLogic::byType('pvremote') as $pvremote) {
      if ($pvremote->getConfiguration('type') == 'sickbeard') {
      $cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'playlist');
      if (!is_object($cmdlogic)) {
        log::add('pvremote', 'debug', 'Création playlist');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Playlist', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('playlist');
        $pvremoteCmd->setConfiguration('data', 'playlist');
        $pvremoteCmd->setType('info');
        $pvremoteCmd->setSubType('string');
        $pvremoteCmd->save();
      }
      $pvremoteCmd = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'clearhist');
      if (!is_object($pvremoteCmd)) {
        log::add('pvremote', 'debug', 'Création clearhist');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Nettoyer l\'historique', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('clearhist');
      }
      $pvremoteCmd->setConfiguration('data', 'clearhist');
      $pvremoteCmd->setConfiguration('request', 'clearhist');
      $pvremoteCmd->setType('action');
      $pvremoteCmd->setSubType('other');
      $pvremoteCmd->save();
      $cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'coming');
      if (!is_object($cmdlogic)) {
        log::add('pvremote', 'debug', 'Création coming');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Coming', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('coming');
        $pvremoteCmd->setConfiguration('data', 'coming');
        $pvremoteCmd->setType('info');
        $pvremoteCmd->setSubType('string');
        $pvremoteCmd->save();
      }
      $cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'missed');
      if (!is_object($cmdlogic)) {
        log::add('pvremote', 'debug', 'Création missed');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Missed', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('missed');
        $pvremoteCmd->setConfiguration('data', 'missed');
        $pvremoteCmd->setType('info');
        $pvremoteCmd->setSubType('string');
        $pvremoteCmd->save();
      }
      $pvremoteCmd = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'getmissed');
      if (!is_object($pvremoteCmd)) {
        log::add('pvremote', 'debug', 'Création getmissed');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Relancer les missed', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('getmissed');
      }
      $pvremoteCmd->setConfiguration('data', 'getmissed');
      $pvremoteCmd->setConfiguration('request', 'getmissed');
      $pvremoteCmd->setType('action');
      $pvremoteCmd->setSubType('other');
      $pvremoteCmd->save();

    } else {
      //couchpotato
      $pvremoteCmd = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'update');
      if (!is_object($pvremoteCmd)) {
        log::add('pvremote', 'debug', 'Création update');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Mettre à jour la médiathèque', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('update');
      }
      $pvremoteCmd->setConfiguration('data', 'update');
      $pvremoteCmd->setConfiguration('request', 'update');
      $pvremoteCmd->setType('action');
      $pvremoteCmd->setSubType('other');
      $pvremoteCmd->save();
      $cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'wanted');
      if (!is_object($cmdlogic)) {
        log::add('pvremote', 'debug', 'Création wanted');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Wanted', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('wanted');
        $pvremoteCmd->setConfiguration('data', 'wanted');
        $pvremoteCmd->setType('info');
        $pvremoteCmd->setSubType('string');
        $pvremoteCmd->save();
      }
      $cmdlogic = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'snatched');
      if (!is_object($cmdlogic)) {
        log::add('pvremote', 'debug', 'Création snatched');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Snatched', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('snatched');
        $pvremoteCmd->setConfiguration('data', 'snatched');
        $pvremoteCmd->setType('info');
        $pvremoteCmd->setSubType('string');
        $pvremoteCmd->save();
      }
      $pvremoteCmd = pvremoteCmd::byEqLogicIdAndLogicalId($pvremote->getId(),'search');
      if (!is_object($pvremoteCmd)) {
        log::add('pvremote', 'debug', 'Création search');
        $pvremoteCmd = new pvremoteCmd();
        $pvremoteCmd->setName(__('Relancer la recherche', __FILE__));
        $pvremoteCmd->setEqLogic_id($pvremote->getId());
        $pvremoteCmd->setEqType('pvremote');
        $pvremoteCmd->setLogicalId('search');
      }
      $pvremoteCmd->setConfiguration('data', 'search');
      $pvremoteCmd->setConfiguration('request', 'search');
      $pvremoteCmd->setType('action');
      $pvremoteCmd->setSubType('other');
      $pvremoteCmd->save();
    }
    $pvremote->getInformations();
    }
  }

  public function getInformations() {
    $addr = $this->getConfiguration('addr');
    $key = $this->getConfiguration('key');
    log::add('pvremote', 'info', 'Get Informations ' . $addr);

    $sbAddr = 'http://' . $addr . '/api/' . $key . '/';

    if ($this->getConfiguration('type') == 'sickbeard') {
    //On récupère et sauvegarde les épisodes à venir
    $sbFuture = $sbAddr . '?cmd=future&sort=date&type=today';
    $tabFuture = file_get_contents($sbFuture);
    $getFuture = json_decode($tabFuture, true);
    $finalFuture = $getFuture['data']['today'];
    /* Avalaible for each episode :
    "airdate": "2015-08-21",
                "airs": "vendredi 8:00 ",
                "ep_name": "The Awakening",
                "ep_plot": "Nolan, Amanda and Irisa search for a way to stop invulnerable Kindzi from waking and transporting more Omec to Earth; Datak seeks escape from a deadly compound; and Stahma implores Alak for forgiveness before it's too late.",
                "episode": 12,
                "indexerid": 255326,
                "network": "Syfy",
                "paused": 0,
                "quality": "HD",
                "season": 3,
                "show_name": "Defiance",
                "show_status": "Continuing",
                "tvdbid": 255326,
                "weekday": 5
    */
    $recordEp = '[';
    $virgule = 0;
    $coming = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'coming');
    foreach($finalFuture as $episode) {
      if ($virgule == 0) {
        $virgule = 1;
      } else {
        $recordEp = $recordEp . ',';
      }
      $recordEp = $recordEp . '{"show_name":"' . $episode['show_name'] . '","season":"' . $episode['season'] . '","episode":"' . $episode['episode'] . '","tvdbid":"' . $episode['tvdbid'] . '"}';
    }
    $recordEp = $recordEp . ']';
    //log::add('pvremote', 'debug', 'Dump : ' . $recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));
    $coming->setConfiguration('value', $recordEp);
		$coming->save();
		$coming->event($recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));

    //On récupère et sauvegarde les épisodes à venir
    $sbMissed = $sbAddr . '?cmd=future&sort=date&type=missed';
    $tabMissed = file_get_contents($sbMissed);
    $getMissed = json_decode($tabMissed, true);
    $finalMissed = $getMissed['data']['missed'];
    /* Avalaible for each episode :
    "airdate": "2015-08-21",
                "airs": "vendredi 8:00 ",
                "ep_name": "The Awakening",
                "ep_plot": "Nolan, Amanda and Irisa search for a way to stop invulnerable Kindzi from waking and transporting more Omec to Earth; Datak seeks escape from a deadly compound; and Stahma implores Alak for forgiveness before it's too late.",
                "episode": 12,
                "indexerid": 255326,
                "network": "Syfy",
                "paused": 0,
                "quality": "HD",
                "season": 3,
                "show_name": "Defiance",
                "show_status": "Continuing",
                "tvdbid": 255326,
                "weekday": 5
    */
    $recordEp = '[';
    $virgule = 0;
    $coming = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'missed');
    foreach($finalMissed as $episode) {
      if ($virgule == 0) {
        $virgule = 1;
      } else {
        $recordEp = $recordEp . ',';
      }
      $recordEp = $recordEp . '{"show_name":"' . $episode['show_name'] . '","season":"' . $episode['season'] . '","episode":"' . $episode['episode'] . '","tvdbid":"' . $episode['tvdbid'] . '"}';
    }
    $recordEp = $recordEp . ']';
    //log::add('pvremote', 'debug', 'Dump : ' . $recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));
    $coming->setConfiguration('value', $recordEp);
		$coming->save();
		$coming->event($recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));

    // On récupère et sauvegarde les épisodes récupérés
    $sbPlaylist = $sbAddr . '?cmd=history&type=downloaded';
    $tabPlaylist = file_get_contents($sbPlaylist);
    $getPlaylist = json_decode($tabPlaylist, true);
    $finalPlaylist = $getPlaylist['data'];
    /* Avalaible for each episode :
    "date": "2015-08-21 06:13",
    "episode": 7,
    "indexerid": 277462,
    "provider": "KILLERS",
    "quality": "HDTV",
    "resource": "Dominion.S02E07.720p.HDTV.x264-KILLERS.mkv",
    "resource_path": "/share/Series/Sickbeard/Dominion.S02E07.720p.HDTV.x264-KILLERS[brassetv]",
    "season": 2,
    "show_name": "Dominion",
    "status": "Downloaded",
    "tvdbid": 277462,
    "version": -1
    */
    $recordEp = '[';
    $virgule = 0;
    $playlist = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'playlist');
    foreach($finalPlaylist as $episode) {
        if ($virgule == 0) {
          $virgule = 1;
        } else {
          $recordEp = $recordEp . ',';
        }
        $recordEp = $recordEp . '{"show_name":"' . $episode['show_name'] . '","season":"' . $episode['season'] . '","episode":"' . $episode['episode'] . '","resource":"' . $episode['resource'] . '","tvdbid":"' . $episode['tvdbid'] . '"}';
    }
    $recordEp = $recordEp . ']';
    //slog::add('pvremote', 'debug', 'Dump : ' . $recordEp);
    //log::add('pvremote', 'debug', print_r($playlist,true));
    $playlist->setConfiguration('value', $recordEp);
		$playlist->save();
		$playlist->event($recordEp);
    //log::add('pvremote', 'debug', print_r($playlist,true));
  } else {
    //On récupère et sauvegarde les épisodes à venir
    $sbWanted = $sbAddr . 'media.list/?status=active';
    $tabWanted = file_get_contents($sbWanted);
    $getWanted = json_decode($tabWanted, true);
    $finalWanted = $getWanted['movies'];
    $recordEp = '[';
    $virgule = 0;
    $wanted = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'wanted');
    foreach($finalWanted as $episode) {
      //log::add('pvremote', 'debug', print_r($episode,true));
      if ($virgule == 0) {
        $virgule = 1;
      } else {
        $recordEp = $recordEp . ',';
      }
      $recordEp = $recordEp . '{"movie_name":"' . $episode['info']['original_title'] . '","tmdbid":"' . $episode['info']['tmdb_id'] . '"}';
    }
    $recordEp = $recordEp . ']';
    //log::add('pvremote', 'debug', 'Dump : ' . $recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));
    $wanted->setConfiguration('value', $recordEp);
		$wanted->save();
		$wanted->event($recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));

    $sbWanted = $sbAddr . 'media.list/?release_status=snatched,available';
    $tabWanted = file_get_contents($sbWanted);
    $getWanted = json_decode($tabWanted, true);
    $finalWanted = $getWanted['movies'];
    $recordEp = '[';
    $virgule = 0;
    $wanted = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'snatched');
    foreach($finalWanted as $episode) {
      //log::add('pvremote', 'debug', print_r($episode,true));
      if ($virgule == 0) {
        $virgule = 1;
      } else {
        $recordEp = $recordEp . ',';
      }
      $recordEp = $recordEp . '{"movie_name":"' . $episode['info']['original_title'] . '","tmdbid":"' . $episode['info']['tmdb_id'] . '"}';
    }
    $recordEp = $recordEp . ']';
    //log::add('pvremote', 'debug', 'Dump : ' . $recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));
    $wanted->setConfiguration('value', $recordEp);
		$wanted->save();
		$wanted->event($recordEp);
    //log::add('pvremote', 'debug', print_r($coming,true));
  }
  }

  public function sendCommand($server,$request) {
    $pvr = self::byLogicalId($server, 'pvremote');
    log::add('pvremote', 'info', 'Call ' . $server . ' ' . $request);
    $addr = $pvr->getConfiguration('addr');
    $key = $pvr->getConfiguration('key');

    $sbAddr = 'http://' . $addr . '/api/' . $key . '/';

    switch ($request) {
      case 'getmissed' :
      $missed = pvremoteCmd::byEqLogicIdAndLogicalId($pvr->getId(),'missed');
      $misElts = json_decode($missed->getConfiguration('value'),1);
      foreach($misElts as $cmd){
        $sbMissed = $sbAddr . '?cmd=episode.search&tvdbid=' . $cmd['tvdbid'] . '&season=' . $cmd['season'] . '&episode=' . $cmd['episode'];
        $result = file_get_contents($sbMissed);
        log::add('pvremote', 'info', 'Call ' . $sbMissed);
      }
      break;

      case 'clearhist' :
      $sbClear = $sbAddr . '?cmd=history.clear';
      $result = file_get_contents($sbClear);
      log::add('pvremote', 'info', 'Call ' . $sbClear);
      break;

      case 'update' :
      $sbClear = $sbAddr . 'manage.update/';
      $result = file_get_contents($sbClear);
      log::add('pvremote', 'info', 'Call ' . $sbClear);
      break;

      case 'search' :
      $sbClear = $sbAddr . 'search/';
      $result = file_get_contents($sbClear);
      log::add('pvremote', 'info', 'Call ' . $sbClear);
      break;
    }
  }

  public function toHtml($_version = 'dashboard') {
    $replace = $this->preToHtml($_version);
    if (!is_array($replace)) {
      return $replace;
    }
    $version = jeedom::versionAlias($_version);
    if ($this->getDisplay('hideOn' . $version) == 1) {
      return '';
    }

    if ($this->getConfiguration('type') == 'sickbeard') {
  $playlist = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'playlist');
  $playElts = json_decode($playlist->getConfiguration('value'),1);
  $coming = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'coming');
  $comElts = json_decode($coming->getConfiguration('value'),1);
  $missed = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'missed');
  $misElts = json_decode($missed->getConfiguration('value'),1);
  $playlistList = '<a href="#" class="list-group-item disabled">Disponible</a>';
  $comingList = '<a href="#" class="list-group-item disabled">Aujourd\'hui</a>';
  $missedList = '<a href="#" class="list-group-item disabled">Manqués</a>';

  foreach($playElts as $cmd){
    $playlistList .= '<span class="list-group-item" style="background-color:transparent;cursor:pointer;font-size : 0.9em;">' . $cmd['show_name'] . ' ' . $cmd['season'] . 'x' . $cmd['episode'] . '</span>';
  }

  foreach($comElts as $cmd){
    $comingList .= '<span class="list-group-item" style="background-color:transparent;cursor:pointer;font-size : 0.9em;">' . $cmd['show_name'] . ' ' . $cmd['season'] . 'x' . $cmd['episode'] . '</span>';
  }

  foreach($misElts as $cmd){
    $missedList .= '<span class="list-group-item" style="background-color:transparent;cursor:pointer;font-size : 0.9em;">' . $cmd['show_name'] . ' ' . $cmd['season'] . 'x' . $cmd['episode'] . '</span>';
  }
  $pvr = $playlistList . ' <br/> ' .  $comingList . '<br/>' . $missedList;

  $clearcmd = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'clearhist');
  $missedcmd = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'getmissed');
    $replace['#pvr#'] = $pvr;
    $replace['#idclear#'] = $clearcmd->getId();
    $replace['#txtclear#'] = 'Purge de l\'historique';
    $replace['#idmissed#'] = $missedcmd->getId();
    $replace['#txtmissed#'] = 'Relancer les missed';
} else {

  $coming = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'wanted');
  $comElts = json_decode($coming->getConfiguration('value'),1);
  $missed = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'snatched');
  $misElts = json_decode($missed->getConfiguration('value'),1);
  $comingList = '<a href="#" class="list-group-item disabled">Voulus</a>';
  $missedList = '<a href="#" class="list-group-item disabled">Récupérables</a>';

  foreach($comElts as $cmd){
    $comingList .= '<span class="list-group-item" style="background-color:transparent;cursor:pointer;font-size : 0.9em;">' . $cmd['movie_name'] . '</span>';
  }

  foreach($misElts as $cmd){
    $missedList .= '<span class="list-group-item" style="background-color:transparent;cursor:pointer;font-size : 0.9em;">' . $cmd['movie_name'] . '</span>';
  }
  $pvr = $comingList . '<br/>' . $missedList;


  $clearcmd = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'update');
  $missedcmd = pvremoteCmd::byEqLogicIdAndLogicalId($this->getId(),'search');
    $replace['#pvr#'] = $pvr;
    $replace['#idclear#'] = $clearcmd->getId();
    $replace['#txtclear#'] = 'Scan de la vidéothèque';
    $replace['#idmissed#'] = $missedcmd->getId();
    $replace['#txtmissed#'] = 'Lancer une recherche';
}

      $html = template_replace($replace, getTemplate('core', jeedom::versionAlias($_version), 'pvremote', 'pvremote'));
      cache::set('pvremoteWidget' . $_version . $this->getId(), $html, 0);
      return $html;
  }


}

class pvremoteCmd extends cmd {
  public function execute($_options = null) {
    switch ($this->getType()) {
      case 'info' :
      return $this->getConfiguration('value');
      break;

      case 'action' :
      $eqLogic = $this->getEqLogic();
      pvremote::sendCommand($eqLogic->getConfiguration('addr'),$this->getConfiguration('request'));
      return true;
    }

  }
}

?>

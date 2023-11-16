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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function Monitoring_install() {
    $cron = cron::byClassAndFunction('Monitoring', 'pull');
    if (!is_object($cron)) {
      $cron = new cron();
      $cron->setClass('Monitoring');
      $cron->setFunction('pull');
      $cron->setEnable(1);
      $cron->setDeamon(0);
      $cron->setSchedule('*/15 * * * *');
      $cron->setTimeout(30);
      $cron->save();
    }
}

function Monitoring_update() {
    $cron = cron::byClassAndFunction('Monitoring', 'pull');
    if (!is_object($cron)) {
      $cron = new cron();
      $cron->setClass('Monitoring');
      $cron->setFunction('pull');
      $cron->setEnable(1);
      $cron->setDeamon(0);
      $cron->setSchedule('*/15 * * * *');
      $cron->setTimeout(30);
      $cron->save();
    }

    /* Ménage dans les répertoires du plugin suite au changement de nom du répertoire "resources" */
    try {
      $dirToDelete = __DIR__ . '/../ressources';
      log::add('Monitoring', 'debug', '[DEL_OLDDIR_CHECK] Vérification de la présence du répertoire "ressources" - Plugin Monitoring :: ' . $dirToDelete);
      if (file_exists($dirToDelete)) {
        shell_exec('sudo rm -rf ' . $dirToDelete);
        log::add('Monitoring', 'debug', '[DEL_OLDDIR_OK] Le répertoire "ressources" a bien été effacé. Path = ' . $dirToDelete);
      }
      else {
        log::add('Monitoring', 'debug', '[DEL_OLDDIR_NA] Le répertoire "ressources" non trouvé. Aucune action requise.');
      }
    } catch (Exception $e) {
      log::add('Monitoring', 'debug', '[DEL_OLDDIR_KO] WARNING :: Exception levée (check du répertoire "ressources") :: '. $e->getMessage());
    }
}

function Monitoring_remove() {
    $cron = cron::byClassAndFunction('Monitoring', 'pull');
    if (is_object($cron)) {
        $cron->remove();
    }
}
?>

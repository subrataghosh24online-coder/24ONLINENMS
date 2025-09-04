<?php

/*
 * Secureplatform.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @package    twentyfouronline
 * @link       https://www.twentyfouronline.org
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace twentyfouronline\OS;

use twentyfouronline\Interfaces\Data\DataStorageInterface;
use twentyfouronline\Interfaces\Polling\OSPolling;
use twentyfouronline\RRD\RrdDefinition;

class Secureplatform extends \twentyfouronline\OS implements OSPolling
{
    public function pollOS(DataStorageInterface $datastore): void
    {
        $connections = snmp_get($this->getDeviceArray(), 'fwNumConn.0', '-OQv', 'CHECKPOINT-MIB');

        if (is_numeric($connections)) {
            $rrd_def = RrdDefinition::make()->addDataset('NumConn', 'GAUGE', 0);

            $fields = [
                'NumConn' => $connections,
            ];

            $tags = ['rrd_def' => $rrd_def];
            $datastore->put($this->getDeviceArray(), 'secureplatform_sessions', $tags, $fields);
            $this->enableGraph('secureplatform_sessions');
        }
    }
}





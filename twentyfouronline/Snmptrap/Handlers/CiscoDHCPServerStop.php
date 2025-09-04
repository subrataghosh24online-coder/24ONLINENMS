<?php

/**
 * CiscoDHCPServerStop.php
 *
 * Logs a twentyfouronline event message when a Cisco device running dhcp-server stops.
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
 * @link       https://www.twentyfouronline.org
 *
 * @copyright  2022 Josh Silvas
 * @author     Josh Silvas <josh@jsilvas.com>
 */

namespace twentyfouronline\Snmptrap\Handlers;

use App\Models\Device;
use twentyfouronline\Enum\Severity;
use twentyfouronline\Interfaces\SnmptrapHandler;
use twentyfouronline\Snmptrap\Trap;

class CiscoDHCPServerStop implements SnmptrapHandler
{
    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param  Device  $device
     * @param  Trap  $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $trap->log('SNMP Trap: Device DHCP service stopped.', Severity::Error);
    }
}





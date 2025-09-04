<?php

/**
 * VmwVmSuspended.php
 *
 * -Description-
 *
 * VMWare guest was suspended.
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
 * @copyright  2019 KanREN, Inc.
 * @author     Heath Barnhart <hbarnhart@kanren.net>
 */

namespace twentyfouronline\Snmptrap\Handlers;

use App\Models\Device;
use twentyfouronline\Enum\PowerState;
use twentyfouronline\Interfaces\SnmptrapHandler;
use twentyfouronline\Snmptrap\Trap;

class VmwVmSuspended implements SnmptrapHandler
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
        $vmGuestName = VmwTrapUtil::getGuestName($trap);

        $vminfo = $device->vminfo()->where('vmwVmDisplayName', $vmGuestName)->first();
        $vminfo->vmwVmState = PowerState::SUSPENDED;

        $trap->log("Guest $vmGuestName has been suspended");

        $vminfo->save();
    }
}





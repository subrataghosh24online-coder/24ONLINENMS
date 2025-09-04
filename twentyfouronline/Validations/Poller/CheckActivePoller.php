<?php

/**
 * CheckActivePoller.php
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
 * @link       https://www.twentyfouronline.org
 *
 * @copyright  2022 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace twentyfouronline\Validations\Poller;

use App\Models\Device;
use App\Models\Poller;
use App\Models\PollerCluster;
use twentyfouronline\DB\Eloquent;
use twentyfouronline\ValidationResult;

class CheckActivePoller implements \twentyfouronline\Interfaces\Validation
{
    /**
     * @inheritDoc
     */
    public function validate(): ValidationResult
    {
        $dispatcher_exists = PollerCluster::isActive()->exists();
        $wrapper_exists = Poller::isActive()->exists();
        if (! $dispatcher_exists && ! $wrapper_exists) {
            $interval = (int) \App\Facades\twentyfouronlineConfig::get('rrd.step');

            return ValidationResult::fail(trans('validation.validations.poller.CheckActivePoller.fail', ['interval' => $interval]));
        }

        if ($dispatcher_exists && $wrapper_exists) {
            return ValidationResult::fail(trans('validation.validations.poller.CheckActivePoller.both_fail'));
        }

        return ValidationResult::ok(trans('validation.validations.poller.CheckActivePoller.ok'));
    }

    /**
     * @inheritDoc
     */
    public function enabled(): bool
    {
        return Eloquent::isConnected() && Device::exists();
    }
}





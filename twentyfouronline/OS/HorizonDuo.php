<?php

namespace twentyfouronline\OS;

use twentyfouronline\Device\WirelessSensor;
use twentyfouronline\Interfaces\Discovery\Sensors\WirelessErrorsDiscovery;
use twentyfouronline\Interfaces\Discovery\Sensors\WirelessPowerDiscovery;
use twentyfouronline\Interfaces\Discovery\Sensors\WirelessRssiDiscovery;
use twentyfouronline\Interfaces\Discovery\Sensors\WirelessSnrDiscovery;
use twentyfouronline\OS;

class HorizonDuo extends OS implements WirelessSnrDiscovery, WirelessPowerDiscovery, WirelessRssiDiscovery, WirelessErrorsDiscovery
{
    public function discoverWirelessSnr()
    {
        $oid = '.1.3.6.1.4.1.7262.2.3.5.2.2.1.9.1';

        return [
            new WirelessSensor('snr', $this->getDeviceId(), $oid, 'horizon-duo', 0, 'SNR', null, 1, 10),
        ];
    }

    public function discoverWirelessPower()
    {
        $oid = '.1.3.6.1.4.1.7262.2.3.5.4.1.1.10.1';

        return [
            new WirelessSensor('power', $this->getDeviceId(), $oid, 'horizon-duo', 0, 'Tx Power', null, 1, 10),
        ];
    }

    public function discoverWirelessRssi()
    {
        $oid = '.1.3.6.1.4.1.7262.2.3.5.2.2.1.4.1';

        return [
            new WirelessSensor('rssi', $this->getDeviceId(), $oid, 'horizon-duo', 0, 'RSL', null, 1, 10),
        ];
    }

    public function discoverWirelessErrors()
    {
        $oid = '.1.3.6.1.4.1.7262.2.3.5.2.3.1.4.1';

        return [
            new WirelessSensor('errors', $this->getDeviceId(), $oid, 'horizon-duo', 0, 'Rx Errors'),
        ];
    }
}





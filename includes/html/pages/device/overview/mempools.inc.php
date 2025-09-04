<?php

use Illuminate\Support\Arr;
use twentyfouronline\Util\Color;
use twentyfouronline\Util\Html;
use twentyfouronline\Util\Number;
use twentyfouronline\Util\Url;

$graph_type = 'mempool_usage';

$mempools = \DeviceCache::getPrimary()->mempools;

function print_mempool_percent_bar($mempool)
{
}

if ($mempools->isNotEmpty()) {
    $mempools_url = url('device') . '/device=' . DeviceCache::getPrimary()->device_id . '/tab=health/metric=mempool/';
    echo '
        <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default panel-condensed">
        <div class="panel-heading">
        ';
    echo '<a href="' . $mempools_url . '">';
    echo '<i class="fas fa-memory fa-lg icon-theme" aria-hidden="true"></i> <strong>Memory</strong></a>';
    echo '
        </div>
        <table class="table table-hover table-condensed table-striped">
        ';

    echo '<tr>
              <td colspan="4">';
    $graph = \App\Http\Controllers\Device\Tabs\OverviewController::setGraphWidth([
        'device' => DeviceCache::getPrimary()->device_id,
        'type' => 'device_mempool',
        'from' => \App\Facades\twentyfouronlineConfig::get('time.day'),
        'legend' => 'no',
        'popup_title' => DeviceCache::getPrimary()->hostname . ' - Memory Usage',
    ]);
    echo \twentyfouronline\Util\Url::graphPopup($graph, \twentyfouronline\Util\Url::lazyGraphTag($graph), $mempools_url);
    echo '  </td>
            </tr>';

    // percentage line items
    foreach ($mempools as $mempool) {
        $available_used_all = null;
        $percent_text = $mempool->mempool_perc;
        if ($mempool->mempool_class == 'system' && $mempools->count() > 1) {
            // calculate available RAM instead of Free
            $buffers = $mempools->firstWhere('mempool_class', '=', 'buffers')->mempool_used ?? 0;
            $cached = $mempools->firstWhere('mempool_class', '=', 'cached')->mempool_used ?? 0;

            $available_used_all = Number::calculatePercent($mempool->mempool_used + $buffers + $cached, $mempool->mempool_total, 0);
        }

        $total = Number::formatBi($mempool->mempool_total);
        $used = Number::formatBi($mempool->mempool_used);
        $free = Number::formatBi($mempool->mempool_free);
        $percent_colors = Color::percentage($mempool->mempool_perc, $mempool->mempool_perc_warn ?: null);

        $graph_array = [
            'type' => 'mempool_usage',
            'id' => $mempool->mempool_id,
            'height' => 100,
            'width' => 210,
            'from' => \App\Facades\twentyfouronlineConfig::get('time.day'),
            'to' => \App\Facades\twentyfouronlineConfig::get('time.now'),
            'legend' => 'no',
        ];

        $link = Url::generate(['page' => 'graphs'], Arr::only($graph_array, ['id', 'type', 'from']));
        $overlib_content = generate_overlib_content($graph_array, DeviceCache::getPrimary()->hostname . ' - ' . $mempool->mempool_descr);

        $graph_array['width'] = 80;
        $graph_array['height'] = 20;
        $graph_array['bg'] = 'ffffff00';
        // the 00 at the end makes the area transparent.
        $minigraph = \twentyfouronline\Util\Url::lazyGraphTag($graph_array);

        switch ($mempool->mempool_class) {
            case 'system':
                $percentageBar = Html::percentageBar(400, 20, $mempool->mempool_perc, "$used / $total ($mempool->mempool_perc%)", $free, $mempool->mempool_perc_warn, $available_used_all);
                break;
            case 'virtual':
            case 'swap':
                $percentageBar = Html::percentageBar(400, 20, $mempool->mempool_perc, "$used / $total ($mempool->mempool_perc%)", $free, $mempool->mempool_perc_warn);
                break;
            default:
                $percentageBar = Html::percentageBar(400, 20, $mempool->mempool_perc, "$used ($mempool->mempool_perc%)", '', $mempool->mempool_perc_warn);
                break;
        }

        echo '<tr>
            <td class="col-md-4">' . \twentyfouronline\Util\Url::overlibLink($link, $mempool->mempool_descr, $overlib_content) . '</td>
            <td class="col-md-4">' . \twentyfouronline\Util\Url::overlibLink($link, $minigraph, $overlib_content) . '</td>
            <td class="col-md-4">' . \twentyfouronline\Util\Url::overlibLink($link, $percentageBar, $overlib_content) . '
            </a></td>
            </tr>';
    }//end foreach

    echo '</table>
        </div>
        </div>
        </div>';
}//end if





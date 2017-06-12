<?php

namespace Encore\Admin\Widgets\Chart;

use Illuminate\Support\Arr;

class Bar extends Chart
{
    protected $labels = [];
    protected $horizontal;

    public function __construct($labels = [], $data = [], $horizontal = false)
    {
        $this->horizontal = $horizontal;

        $this->data['labels'] = $labels;
        $this->data['datasets'] = [];

        $this->add($data);
    }

    public function add($label, $data = [], $fillColor = '')
    {
        if (is_array($label)) {
            if (Arr::isAssoc($label)) {
                $this->data[] = $label;
            } else {
                foreach ($label as $item) {
                    call_user_func_array([$this, 'add'], $item);
                }
            }

            return $this;
        }

        $this->data['datasets'][] = [
            'label'         => $label,
            'data'          => $data,
            'fillColor'     => $fillColor,
        ];

        return $this;
    }

    protected $defaultColors = [
        'rgb(221,75,57)',   'rgb(0,166,90)',    'rgb(243,156,18)',
        'rgb(0,192,239)',   'rgb(60,141,188)',  'rgb(0,115,183)',
        'rgb(57,204,204)',  'rgb(255,133,27)',  'rgb(1,255,112)',
        'rgb(96,92,168)',   'rgb(240,18,190)',  'rgb(119,119,119)',
        'rgb(0,31,63)',     'rgb(210,214,222)',
    ];

    protected function fillColor($data)
    {
        foreach ($data['datasets'] as &$item) {
            if (empty($item['borderColor'])) {
                $item['borderColor'] = array_shift($this->defaultColors);
                $item['backgroundColor'] = 'rgba'.substr($item['borderColor'], 3, -1).', 0.1)';
                $item['borderWidth'] = 1;
            }
        }

        return $data;
    }

    public function script()
    {
        $data = $this->fillColor($this->data);

        $data = json_encode($data);

        $options = json_encode($this->options + ['responsive' => true, 'maintainAspectRatio' => false]);

        $chartType = $this->horizontal ? '"horizontalBar"' : '"bar"';

        return <<<EOT

(function() {

    var canvas = $("#{$this->elementId}").get(0).getContext("2d");
    var chart = new Chart(canvas, {
        type: $chartType,
        data: $data,
        options: $options
    });

})();
EOT;
    }
}

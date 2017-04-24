<?php

namespace Encore\Admin\Form\Field;

class DateTimePersian extends DatePersian
{
    protected static $css = [
        '/packages/admin/admin-lte/plugins/persian-datepicker/dist/css/persian-datepicker.min.css',
    ];
    protected static $js = [
        '/packages/admin/admin-lte/plugins/persian-date/dist/persian-date.min.js',
        '/packages/admin/admin-lte/plugins/persian-datepicker/dist/js/persian-datepicker.min.js',
    ];
    protected static $options = '{
        format: "YYYY-MM-DD HH:mm",
        timePicker: {
            enabled: true,
            showSeconds: false,
        }
        formatter: function(t) {
            return (new Date(t)).toISOString().slice(0, 10);
        }
    }';

    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function render()
    {
        $this->prepend('<i class="fa fa-calendar"></i>')
            ->defaultAttribute('data-pdatepicker', 'pdatepicker');

        $this->script = <<<EOT
$('{$this->getElementClassSelector()}:not(.initialized)')
    .addClass('initialized')
    .pDatepicker($options);
EOT;

        return parent::render();
    }
}

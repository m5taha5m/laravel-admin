<?php

namespace Encore\Admin\Form\Field;

class DatePersian extends Text
{
    protected static $css = [
        '/packages/admin/admin-lte/plugins/persian-datepicker/dist/css/persian-datepicker.min.css',
    ];
    protected static $js = [
        '/packages/admin/admin-lte/plugins/persian-date/dist/persian-date.min.js',
        '/packages/admin/admin-lte/plugins/persian-datepicker/dist/js/persian-datepicker.min.js',
    ];

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
    .pDatepicker({
        format: 'YYYY-MM-DD',
        formatter: function(t) {
            return (new Date(t)).toISOString().slice(0, 10);
        }
    });
EOT;

        return parent::render();
    }
}

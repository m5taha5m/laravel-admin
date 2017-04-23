<?php

namespace Encore\Admin\Form\Field;

class Date extends Text
{
    protected static $css = [
        '/packages/admin/admin-lte/plugins/datepicker/datepicker3.css',
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
            ->defaultAttribute('data-provide', 'datepicker')
            ->defaultAttribute('data-date-format', 'YYYY-MM-DD');

        return parent::render();
    }
}

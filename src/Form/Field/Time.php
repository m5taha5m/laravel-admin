<?php

namespace Encore\Admin\Form\Field;

class Time extends Date
{
    protected $format = 'HH:mm:ss';

    public function render()
    {
        $this->prepend('<i class="fa fa-clock-o"></i>');

        return parent::render();
    }
}

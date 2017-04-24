<?php

namespace Encore\Admin\Form\Field;

class Datetime extends Date
{
    protected $format = 'yyyy-mm-dd HH:mm:ss';

    public function render()
    {
        return parent::render();
    }
}

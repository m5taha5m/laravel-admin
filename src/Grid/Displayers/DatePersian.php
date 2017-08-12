<?php

namespace Encore\Admin\Grid\Displayers;

class DatePersian extends AbstractDisplayer
{
    public function display()
    {
        return is_null($this->value) || $this->value == 0 ? '-' : jdate($this->value)->format('%e %B %Y');
    }
}

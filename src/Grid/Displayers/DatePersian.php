<?php

namespace Encore\Admin\Grid\Displayers;

class DatePersian extends AbstractDisplayer
{
    public function display()
    {
        return is_null($this->value) ? '-' : jdate($this->value)->format('%e %B %Y');
    }
}

<?php

namespace Encore\Admin\Grid\Displayers;

class DatePersian extends AbstractDisplayer
{
    public function display()
    {
        return jdate($this->value)->format('date');
    }
}

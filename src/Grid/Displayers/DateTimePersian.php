<?php

namespace Encore\Admin\Grid\Displayers;

class DateTimePersian extends AbstractDisplayer
{
    public function display()
    {
        return jdate($this->value)->format('%e %B %Y (%H:%M)');
    }
}

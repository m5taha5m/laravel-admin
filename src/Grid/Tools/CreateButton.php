<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Grid;

class CreateButton extends AbstractTool
{
    /**
     * Create a new CreateButton instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Render CreateButton.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->allowCreation()) {
            return '';
        }

        $new = trans('admin::lang.new');
        $marginStyle = config('app.locale') == 'fa' ? 'margin-left: 10px' : 'margin-right: 10px';

        return <<<EOT

<div class="btn-group pull-right" style="$marginStyle">
    <a href="{$this->grid->resource()}/create" class="btn btn-sm btn-success">
        <i class="fa fa-save"></i>&nbsp;&nbsp;{$new}
    </a>
</div>

EOT;
    }
}

<?php

namespace Encore\Admin\Form\Field;

class Decimal extends Text
{
    protected static $js = [
        '/packages/admin/admin-lte/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'alias'      => 'decimal',
        'rightAlign' => true,
    ];

    public function render()
    {
        $options = json_encode($this->options);

        $this->script = "$('{$this->getElementClassSelector()}').inputmask($options);";

        $this->prepend('<i class="fa fa-terminal"></i>');

        return parent::render();
    }
}

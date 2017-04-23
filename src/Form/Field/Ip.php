<?php

namespace Encore\Admin\Form\Field;

class Ip extends Text
{
    protected $rules = 'ip';

    protected static $js = [
        '/packages/admin/admin-lte/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js',
    ];

    /**
     * @see https://github.com/RobinHerbots/Inputmask#options
     *
     * @var array
     */
    protected $options = [
        'alias' => 'ip',
    ];

    public function render()
    {
        $options = json_encode($this->options);

        $this->script = <<<EOT

$('{$this->getElementClassSelector()}').inputmask($options);
EOT;

        $this->prepend('<i class="fa fa-laptop"></i>');

        return parent::render();
    }
}

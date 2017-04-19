<?php

namespace Encore\Admin\Form;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Tools implements Renderable
{
    /**
     * @var Builder
     */
    protected $form;

    /**
     * Collection of tools.
     *
     * @var Collection
     */
    protected $tools;

    /**
     * @var array
     */
    protected $options = [
        'enableListButton'   => true,
        'enableBackButton'   => true,
        'enableDeleteButton' => false,
    ];

    /**
     * Create a new Tools instance.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->form = $builder;

        $this->tools = new Collection();
    }

    /**
     * @return string
     */
    protected function backButton()
    {
        $script = <<<'EOT'
$('.form-history-back').on('click', function () {
    event.preventDefault();
    history.back(1);
});
EOT;

        Admin::script($script);

        $text = trans('admin::lang.back');

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;$text</a>
</div>
EOT;
    }

    public function listButton()
    {
        $slice = Str::contains($this->form->getResource(0), '/edit') ? null : -1;
        $resource = $this->form->getResource($slice);

        $text = trans('admin::lang.list');

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="$resource" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;$text</a>
</div>
EOT;
    }

    /**
     * Built delete button.
     *
     * @return string
     */
    protected function deleteButton()
    {
        $slice = Str::contains($this->form->getResource(0), '/edit') ? null : -1;
        $resource = $this->form->getResource($slice);

        $confirm = trans('admin::lang.delete_confirm');
        $text = trans('admin::lang.delete');

        $script = <<<SCRIPT

$('.form-delete-btn').unbind('click').click(function() {
    if(confirm("{$confirm}")) {
        $.ajax({
            method: 'post',
            url: '{$resource}/' + $(this).data('id'),
            data: {
                _method:'delete',
                _token:LA.token,
            },
            success: function (data) {
                window.location = '{$resource}';
            }
        });
    }
});

SCRIPT;

        Admin::script($script);

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="javascript:void(0);" data-id="{$this->form->getResourceId()}" class="btn btn-sm btn-danger form-delete-btn">
        <i class="fa fa-trash"></i>&nbsp;$text
    </a>
</div>
EOT;
    }

    /**
     * Prepend a tool.
     *
     * @param string $tool
     *
     * @return $this
     */
    public function add($tool)
    {
        $this->tools->push($tool);

        return $this;
    }

    /**
     * Disable back button.
     *
     * @return $this
     */
    public function disableBackButton()
    {
        $this->options['enableBackButton'] = false;

        return $this;
    }

    /**
     * Disable list button.
     *
     * @return $this
     */
    public function disableListButton()
    {
        $this->options['enableListButton'] = false;

        return $this;
    }

    /**
     * Enable delete button.
     *
     * @return $this
     */
    public function enableDeleteButton()
    {
        $this->options['enableDeleteButton'] = true;

        return $this;
    }

    /**
     * Render header tools bar.
     *
     * @return string
     */
    public function render()
    {
        if ($this->options['enableDeleteButton']) {
            $this->add($this->deleteButton());
        }

        if ($this->options['enableListButton']) {
            $this->add($this->listButton());
        }

        if ($this->options['enableBackButton']) {
            $this->add($this->backButton());
        }

        return $this->tools->map(function ($tool) {
            if ($tool instanceof Renderable) {
                return $tool->render();
            }

            if ($tool instanceof Htmlable) {
                return $tool->toHtml();
            }

            return (string) $tool;
        })->implode(' ');
    }
}

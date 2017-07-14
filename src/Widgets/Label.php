<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class Label extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'admin::widgets.label';

    /**
     * @var string
     */
    protected $content = 'here is the label content.';

    /**
     * @var string
     */
    protected $style = 'label-default';

    /**
     * Label constructor.
     *
     * @param string $content
     * @param string|array $style
     */
    public function __construct($content = '', $style = '')
    {
        if ($content) {
            $this->content($content);
        }

        if ($style) {
            $this->style($style);
        }

        $this->class('label');
    }

    /**
     * Set label content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        if ($content instanceof Renderable) {
            $this->content = $content->render();
        } else {
            $this->content = (string) $content;
        }

        return $this;
    }

    /**
     * Set box style.
     *
     * @param string $styles
     *
     * @return $this|Label
     */
    public function style($styles)
    {
        if (is_string($styles)) {
            return $this->style([$styles]);
        }

        $styles = array_map(function ($style) {
            return 'label-'.$style;
        }, $styles);

        $this->class = $this->class.' '.implode(' ', $styles);

        return $this;
    }

    /**
     * Variables in view.
     *
     * @return array
     */
    protected function variables()
    {
        return [
            'content'       => $this->content,
            'attributes'    => $this->formatAttributes(),
        ];
    }

    /**
     * Render box.
     *
     * @return string
     */
    public function render()
    {
        return view($this->view, $this->variables())->render();
    }
}

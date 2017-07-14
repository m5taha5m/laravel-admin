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
     * Label constructor.
     *
     * @param string $content
     * @param string|array $style
     */
    public function __construct($content = '', $style = 'default')
    {
        if ($content) {
            $this->content($content);
        }

        $this->class('label');
        $this->style($style);
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
     * Set label style.
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
     * Render label.
     *
     * @return string
     */
    public function render()
    {
        return view($this->view, $this->variables())->render();
    }
}

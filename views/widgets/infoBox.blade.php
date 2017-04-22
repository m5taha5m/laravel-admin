<div {!! $attributes !!}>
    <div class="inner">
        <h3>{{ $info }}</h3>

        <p>{{ $name }}</p>
    </div>
    <div class="icon">
        <i class="fa fa-{{ $icon }}"></i>
    </div>
    <a href="{{ $link }}" class="small-box-footer">
        {{ trans('admin::lang.more') }}&nbsp;
        <i class="fa fa-arrow-circle-{{config('app.locale') == 'fa' ? 'left' : 'right'}}"></i>
    </a>
</div>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Admin::title() }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/plugins/bootstrap/dist/css/bootstrap.min.css") }}">
    <!-- Bootstrap RTL -->
    @if (config('app.locale') == 'fa')
    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/plugins/bootstrap-rtl/dist/css/bootstrap-rtl.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/dist/css/bootstrap-rtl.css") }}">
    @endif
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("/packages/admin/font-awesome/css/font-awesome.min.css") }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/dist/css/skins/" . config('admin.skin') .".min.css") }}">

    {!! Admin::css() !!}
    <link rel="stylesheet" href="{{ asset("/packages/admin/nestable/nestable.css") }}">
    <link rel="stylesheet" href="{{ asset("/packages/admin/toastr/build/toastr.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/packages/admin/bootstrap3-editable/css/bootstrap-editable.css") }}">
    <link rel="stylesheet" href="{{ asset("/packages/admin/google-fonts/fonts.css") }}">
    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/dist/css/AdminLTE.min.css") }}">
    @if (config('app.locale') == 'fa')
    <link rel="stylesheet" href="{{ asset("/packages/admin/admin-lte/dist/css/adminlte-rtl.css") }}">
    @endif

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ asset ("/packages/admin/admin-lte/plugins/jquery/dist/jquery.min.js") }}"></script>
    <script src="{{ asset ("/packages/admin/admin-lte/plugins/bootstrap/dist/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset ("/packages/admin/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
    <script src="{{ asset ("/packages/admin/admin-lte/dist/js/app.min.js") }}"></script>
    <script src="{{ asset ("/packages/admin/jquery-pjax/jquery.pjax.js") }}"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}" {!!config('app.locale') == 'fa' ? 'dir="rtl"' : ''!!}>
<div class="wrapper">

    @include('admin::partials.header')

    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        @yield('content')
        {!! Admin::script() !!}
    </div>

    @include('admin::partials.footer')

</div>

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset ("/packages/admin/jquery-migrate-3.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/admin-lte/plugins/chartjs/Chart.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/nestable/jquery.nestable.js") }}"></script>
<script src="{{ asset ("/packages/admin/toastr/build/toastr.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/bootstrap3-editable/js/bootstrap-editable.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/clipboard/clipboard.min.js") }}"></script>

{!! Admin::js() !!}

<script>

    function LA() {}
    LA.token = "{{ csrf_token() }}";

    $.fn.editable.defaults.params = function (params) {
        params._token = '{{ csrf_token() }}';
        params._editable = 1;
        params._method = 'PUT';
        return params;
    };

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000
    };

    $.pjax.defaults.timeout = 5000;
    $.pjax.defaults.maxCacheLength = 0;
    $(document).pjax('a:not(a[target="_blank"])', {
        container: '#pjax-container'
    });

    $(document).on('submit', 'form[pjax-container]', function(event) {
        $.pjax.submit(event, '#pjax-container')
    });

    $(document).on("pjax:popstate", function() {

        $(document).one("pjax:end", function(event) {
            $(event.target).find("script[data-exec-on-popstate]").each(function() {
                $.globalEval(this.text || this.textContent || this.innerHTML || '');
            });
        });
    });
    
    $(document).on('pjax:send', function(xhr) {
        if(xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
            $submit_btn = $('form[pjax-container] :submit');
            if($submit_btn) {
                $submit_btn.button('loading')
            }
        }
    })
    
    $(document).on('pjax:complete', function(xhr) {
        if(xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
            $submit_btn = $('form[pjax-container] :submit');
            if($submit_btn) {
                $submit_btn.button('reset')
            }
        }
    })

    $(function(){
        $('.sidebar-menu li:not(.treeview) > a').on('click', function(){
            var $parent = $(this).parent().addClass('active');
            $parent.siblings('.treeview.active').find('> a').trigger('click');
            $parent.siblings().removeClass('active').find('li').removeClass('active');
        });
    });

</script>

</body>
</html>

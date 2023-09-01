<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"{!! theme()->printHtmlAttributes('html') !!} {{ theme()->printHtmlClasses('html') }}>
{{-- begin::Head --}}
<head>
    <meta charset="utf-8"/>
    <title>Laravel Starter Pro</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}"/>
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}"/>
    <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ asset(theme()->getMediaUrlPath() . 'logos/light_logo.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link type="text/css" rel="stylesheet" href="{{ asset('js/custom/datatables/datatables.bundle.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/custom/phoneInt/intlTelInput.css') }}">
    {{-- https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js --}}
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js --}}
    <script type="text/javascript" src="{{ asset('select2/js/select2.min.js') }}"></script>
    {{-- "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css --}}
    <link type="text/css" rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('notification/snackbar/snackbar.min.css') }}">
    <!--for autocomplete search--->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        ::-webkit-input-placeholder { /* WebKit browsers */
            text-transform: none;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            text-transform: none;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            text-transform: none;
        }
        :-ms-input-placeholder { /* Internet Explorer 10+ */
            text-transform: none;
        }


    </style>

    {{-- begin::Fonts --}}
    {{ theme()->includeFonts() }}
    {{-- end::Fonts --}}

    @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/vendors/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
    @endif

    @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (array_unique(theme()->getOption('page', 'assets/custom/css')) as $file)
            {!! preloadCss(assetCustom($file)) !!}
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
    @endif

    @if (theme()->hasOption('assets', 'css'))
        {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
        @foreach (array_unique(theme()->getOption('assets', 'css')) as $file)
            @if (strpos($file, 'plugins') !== false)
                {!! preloadCss(assetCustom($file)) !!}
            @else
                <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css"/>
            @endif
        @endforeach
        {{-- end::Global Stylesheets Bundle --}}
    @endif

    @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-general') }}
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-head') }}
    @endif
    @stack('livewire_styles')
    <style>
        .custom-table-css > tbody > tr > td{
            border: 1px solid rgb(226, 221, 221);
            vertical-align: top !important;
            padding: 15px !important;
        }
        .custom-table-css > tbody > tr:hover{
            background-color: #F8FAFB;
            cursor: pointer;
        }
        .custom-table-css ,.custom-table-css > thead > tr,.custom-table-css > thead > tr > th{
            border: 1px solid rgb(226, 221, 221);
            padding:15px !important;
        }
        .select2-results__option--highlighted {
            background: #0095E8 !important;
            color: #fff !important;
        }

        .modalCustom-table-css > tbody > tr > td{
            border: 1px solid rgb(226, 221, 221);
            padding:5px !important;

        }
        .modalCustom-table-css > tbody > tr:hover{
            /* background-color: #F8FAFB; */
            cursor: pointer;
        }
        .modalCustom-table-css ,.modalCustom-table-css > thead > tr,.modalCustom-table-css > thead > tr > th{
            border: 1px solid rgb(226, 221, 221);
            padding:5px !important;
        }
        .custom_location_ul{
            list-style: none;
            padding-left: 0px;
            border: 1px solid #d5d0d0;
            width: 46%;
            max-height :120px;
            overflow-x : auto;
            overflow-y : scroll;
        }
        .location_li {
            padding: 0.75rem 3rem 0.75rem 1rem;
            -moz-padding-start: calc(1rem - 3px);
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 0.5;
            color: #181C32;
            background-color: #ffffff;
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .location_li:hover {
            background-color: #c7cbcd;
            cursor: pointer;
        }

        .loc_active {
            background-color: #c7cbcd !important;
        }

        .select2-selection--multiple {
            height: 41px !important;
        }

        .inactiveLink {
            pointer-events: none;
            cursor: move;
        }

        #toast-container > div {
            opacity: 1;
        }

        .cursor-block {
            cursor: not-allowed;
        }

        .disable{
            pointer-events: none;
            cursor: not-allowed;
        }


    </style>
    @yield('styles')
</head>
{{-- end::Head --}}

{{-- begin::Body --}}
<body {!! theme()->printHtmlAttributes('body') !!} {!! theme()->printHtmlClasses('body') !!} {!! theme()->printCssVariables('body') !!}>
{{-- Page Loader:start --}}
<div id="loading" style=" position: fixed;display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;top: 0;left: 0;opacity: 1;background-color: #fff;z-index: 99;">
    <img style=" position: absolute;z-index: 100;" id="loading-image" width="20%" src="{{asset('/images/loader.gif')}}" alt="Loading..." />
</div>
{{-- Page Loader:end --}}


@if (theme()->getOption('layout', 'loader/display') === true)
    {{ theme()->getView('layout/_loader') }}
@endif

@yield('content')

{{-- begin::Javascript --}}
@if (theme()->hasOption('assets', 'js'))
    {{-- begin::Global Javascript Bundle(used by all pages) --}}
    @foreach (array_unique(theme()->getOption('assets', 'js')) as $file)
        <script src="{{ asset($file) }}"></script>
    @endforeach
    {{-- end::Global Javascript Bundle --}}
@endif

@stack('livewire_scripts')
@stack('livewire_scripts_before')
@if (theme()->hasOption('page', 'assets/vendors/js'))
    {{-- begin::Page Vendors Javascript(used by this page) --}}
    @foreach (array_unique(theme()->getOption('page', 'assets/vendors/js')) as $file)
        <script src="{{ asset($file) }}"></script>
    @endforeach
    {{-- end::Page Vendors Javascript --}}
@endif

@if (theme()->hasOption('page', 'assets/custom/js'))
    {{-- begin::Page Custom Javascript(used by this page) --}}
    @foreach (array_unique(theme()->getOption('page', 'assets/custom/js')) as $file)
        <script src="{{ asset($file) }}"></script>
    @endforeach
    {{-- end::Page Custom Javascript --}}
@endif
{{-- end::Javascript --}}

@if (theme()->getViewMode() === 'preview')
    {{ theme()->getView('partials/trackers/_ga-tag-manager-for-body') }}
@endif

@include('layout.alert')
<script src="{{ asset('notification/snackbar/snackbar.min.js') }}"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //PAGE LOADER
    $(window).on('load', function () {
        $('#loading').hide();
    });
</script>


    <script type="text/javascript" src="{{ asset('js/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- https://cdn.amcharts.com/lib/5/index.js --}}
    {{-- https://cdn.amcharts.com/lib/5/map.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/worldLow.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/continentsLow.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/usaLow.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/Animated.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/xy.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/percent.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/radar.js --}}
    {{-- https://cdn.amcharts.com/lib/5/geodata/jquery-ui.js --}}
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/worldLow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/continentsLow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/usaLow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/worldTimeZonesLow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/worldTimeZoneAreasLow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Animated.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/xy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/percent.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/radar.js') }}"></script>



    <!--For auto complete search--->
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>

@include('custom.init_js')

@include('custom.partdashboardScript')

@yield('scripts')

@include('custom.datatable')

{{--<script>--}}
{{--    $(document).ready( function () {--}}
{{--        $('.datatable').DataTable();--}}
{{--    } );--}}
{{--</script>--}}
@stack('livewire_scripts_after')
</body>
{{-- end::Body --}}

</html>

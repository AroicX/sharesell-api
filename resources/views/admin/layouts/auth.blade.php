
<!DOCTYPE html>
<html lang="zxx">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ config('app.name', 'Sharesell') }}</title>

    <link rel="icon" href="img/mini_logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="{{asset('vendors/themefy_icon/themify-icons.css') }}" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="{{asset('vendors/niceselect/css/nice-select.css') }}" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{asset('vendors/owl_carousel/css/owl.carousel.css') }}" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="{{asset('vendors/gijgo/gijgo.min.css') }}" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{asset('vendors/tagsinput/tagsinput.css') }}" />

    <!-- date picker -->
     <link rel="stylesheet" href="{{asset('vendors/datepicker/date-picker.css') }}" />

     <link rel="stylesheet" href="{{asset('vendors/vectormap-home/vectormap-2.0.2.css') }}" />
     
     <!-- scrollabe  -->
     <link rel="stylesheet" href="{{asset('vendors/scroll/scrollable.css') }}" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{asset('vendors/datatable/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{asset('vendors/datatable/css/responsive.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{asset('vendors/datatable/css/buttons.dataTables.min.css') }}" />
    <!-- text editor css -->
    <link rel="stylesheet" href="{{asset('vendors/text_editor/summernote-bs4.css') }}" />
    <!-- morris css -->
    <link rel="stylesheet" href="{{asset('vendors/morris/morris.css') }}">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="{{asset('vendors/material_icon/material-icons.css') }}" />

    <!-- menu css  -->
    <link rel="stylesheet" href="{{asset('css/metisMenu.css') }}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{asset('css/colors/default.css') }}" id="colorSkinCSS">
</head>
<body class="crm_body_bg">
    
{{-- @include('admin.layouts.sidebar') --}}

<section class="  ">
  {{-- @include('admin.layouts.menu') --}}
  @yield('content')
</section>
<!-- main content part end -->




<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="ti-angle-up"></i>
    </a>
</div>
{{-- @include('admin.layouts.footer') --}}

</body>
</html>

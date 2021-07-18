
<!DOCTYPE html>
<html lang="zxx">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ config('app.name', 'Sharesell') }}</title>

@include('admin.layouts.headers')
</head>
<body class="crm_body_bg">
    
@include('admin.layouts.sidebar')

<section class="main_content dashboard_part large_header_bg">
  @include('admin.layouts.menu')
  @yield('content')
</section>
<!-- main content part end -->




<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="ti-angle-up"></i>
    </a>
</div>
@include('admin.layouts.footer')

</body>
</html>

<!-- Title -->
<title> @yield('title') </title>
<!-- Favicon -->
@livewireStyles

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/x-icon" />
<!-- Icons css -->
<link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css ') }}" rel="stylesheet">
@if (app()->getLocale() == 'en')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/sidemenu.css') }}">
@else
    <link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/sidemenu.css') }}">
@endif

<!-- Sidemenu css -->
@yield('css')
<!--- Style css -->

<!-- Title -->
<title> @yield('title') </title>
<!-- Favicon -->
@livewireStyles
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="icon" href="{{ URL::asset('assets/img/logo-3.png') }}" type="image/x-icon" />
<!-- Icons css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
 
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->

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

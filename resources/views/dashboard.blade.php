@extends('layouts.master')
@section('title')
    {{ __('admin.home') }}
@stop
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('admin.welcome') }}</h2>
                <p class="mg-b-0">{{ __('admin.mond') }}</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">{{ __('admin.rate') }}</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>

        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    @if (session()->has('success'))
        <script>
            toastr.success("{{ __('admin.update_successfully') }}")
        </script>
    @endif
    @if (session()->has('noti'))
        <script>
            toastr.success("{{ __('admin.noti') }}")
        </script>
    @endif
    @if (session()->has('login'))
        <script>
            toastr.success("{{ __('admin.login') }}")
        </script>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('admin.TODAY_ORDERS') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $todayCount->count() }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">{{__('admin.comar-day')  }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                @if ($todayCount->count() > $yesterdayCount->count())
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                @else
                                    <i class="fas fa-arrow-circle-down text-warning"></i>
                                @endif
                                <span class="text-white op-7">{{ $orderDifference }}</span>
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('admin.TODAY_EARNINGS') }} </h6>

                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    ${{ number_format($todayCount->sum('total_cost')) }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{__('admin.comar-day')  }}</p>

                            </div>
                            <span class="float-right my-auto mr-auto">
                                @if ($todayCount->sum('total_cost') > $yesterdayCount->count('total_cost'))
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                @else
                                    <i class="fas fa-arrow-circle-down text-warning"></i>
                                @endif <span class="text-white op-7">{{ $orderDifference1 }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('admin.total_earning') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    ${{ number_format($totalIncomeThisWeek) }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">{{ __('admin.compar-week') }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                @if ($totalIncomeThisWeek > $totalIncomeLastWeek)
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                @else
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                @endif
                                <span class="text-white op-7"> {{ number_format($incomeDifference) }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ __('admin.Product_sold') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    ${{ number_format(App\Models\Order::sum('total_cost')) }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{ __('admin.compar-week') }}</p>
                                </div>
                            <span class="float-right my-auto mr-auto">
                                @if ($totalIncomeThisWeek > $totalIncomeLastWeek)
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                @else
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                @endif
                                <span class="text-white op-7"> {{ number_format($incomeDifference) }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">{{ __('admin.order-status') }}</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="total-revenue">
                        <div>
                            <h4>{{ App\Models\Order::where('status','done')->count() }}</h4>
                            <label><span class="bg-primary"></span>{{ __('admin.done') }}</label>
                        </div>
                        <div>
                            <h4>{{ App\Models\Order::where('status','pending')->count() }}</h4>
                            <label><span class="bg-warning"></span>{{ __('admin.pending') }}</label>
                        </div>
                        <div>
                            <h4>{{ App\Models\Order::where('status','cancelled')->count() }}</h4>
                            <label><span class="bg-danger"></span>{{ __('admin.cancelled') }}</label>
                        </div>
                    </div>
                    <div  class="sales-bar mt-5">  {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5 ">
            <div class="card card-dashboard-map-one " style="height: 480px;">
                <label class="main-content-label">{{ __('admin.order-status') }} </label>
                <span class="d-block mg-b-20 text-muted tx-12">Pie Chart</span>
                <div class="">
                    <div class="vmap-wrapper ht-200"  > {!! $chartjs_2->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm row-deck">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="card card-dashboard-eight pb-2">
                <div class="card">
                    <div class="card-header pb-0">
                        <h3 class="card-title mb-2">Recent Orders</h3>
                    </div>
                    <div class="card-body sales-info ot-0 pt-0 pb-0">
                        <div id="chart" class="ht-150"></div>
                        <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                            <div class="col-md-6 col">
                                <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>{{ __('admin.done') }}</p>
                                <h3 class="mb-1">{{ App\Models\Order::where('status','done')->count() }}</h3>
                                <div class="d-flex">
                                    <p class="text-muted ">Last 6 months</p>
                                </div>
                            </div>
                            <div class="col-md-6 col">
                                <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>{{ __('admin.cancelled') }}</p>
                                <h3 class="mb-1">{{ App\Models\Order::where('status','cancelled')->count() }}</h3>
                                <div class="d-flex">
                                    <p class="text-muted">Last 6 months</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{ __('admin.total_sales') }}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">{{ number_format(App\Models\Order::count()) }}</h4>
                                <div class="progress progress-style progress-sm">
                                    <div class="progress-bar bg-primary-gradient wd-80p" role="progressbar"
                                        aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{ __('admin.active_users') }}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">{{ number_format(App\Models\Client::count()) }}</h4>
                                <div class="progress progress-style progress-sm">
                                    <div class="progress-bar bg-danger-gradient wd-75" role="progressbar" aria-valuenow="45"
                                        aria-valuemin="0" aria-valuemax="45"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 col-xl-8">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">{{ __('admin.recenr-er') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <span class="tx-12 tx-muted mb-3 "></span>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">{{ __('admin.date') }}</th>
                                <th class="wd-lg-25p tx-right">{{ __('admin.Sales-Count') }}</th>
                                <th class="wd-lg-25p tx-right">{{ __('admin.TODAY_EARNINGS') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderat as $item )
                            <tr>
                                <td>{{ $item->date }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $item->count }}</td>
                                <td class="tx-right tx-medium tx-inverse">${{number_format($item->total_cost) }}</td>                 </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    <!-- row opened -->

    <!-- row close -->


    <!-- row opened -->

   
    <!-- Container closed -->
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Moment js -->
<script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
<!--Internal  Flot js-->
<script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
<script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
<script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
<!--Internal Apexchart js-->
<script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
<!-- Internal Map -->
<script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
<!--Internal  index js -->
<script src="{{ URL::asset('assets/js/index.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection

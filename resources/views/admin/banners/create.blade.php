@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('admin.complaining') }}
@stop


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.complaining') }}
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    {{ __('admin.complaining') }}
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    <div class="page-wrapper">

        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.add') }}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3 ">
                                        <label class="form-label">{{ __('admin.banner') }}</label>
                                        <div class="form-group mb-3">
                                            <input name="banner" type="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary">{{ __('admin.confirm') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>


        {{-- delete one user script --}}
        @include('dashboard.shared.deleteOne')
        {{-- delete one user script --}}
    @endsection

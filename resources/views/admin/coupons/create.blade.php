@extends('layouts.master')

@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
@endsection
@section('title')
    {{ __('admin.add_coupon') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.coupons') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.add') }}
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">

        <div class="col-lg-12 col-md-12">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">

                <div class="card-body">
                    <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="code">{{ __('admin.code') }}</label>
                                <input type="text" name="code" id="code" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="discount">{{ __('admin.discount') }}</label>
                                <input type="text" name="discount" id="discount" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="maximum_usage">{{ __('admin.maximum_usage') }}</label>
                                <input type="number" name="maximum_usage" id="maximum_usage" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="owner">{{ __('admin.owner') }}</label>
                                <input type="text" name="owner" id="owner" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="owner_ratio">{{ __('admin.owner_ratio') }}</label>
                                <input type="text" name="owner_ratio" id="owner_ratio" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date">{{ __('admin.start_date') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date">{{ __('admin.end_date') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('js')

@endsection

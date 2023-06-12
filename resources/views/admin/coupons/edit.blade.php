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
@endsection
@section('title')
    {{ __('admin.update') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.coupons') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.update') }}
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="page-wrapper">
        <div class="container-xl py-3">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.edit') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupon.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="code">{{ __('admin.code') }}</label>
                                <input type="text" name="code" id="code" class="form-control"
                                    value="{{ $coupon->code }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="discount">{{ __('admin.discount') }}</label>
                                <input type="text" name="discount" id="discount" class="form-control"
                                    value="{{ $coupon->discount }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="maximum_usage">{{ __('admin.maximum_usage') }}</label>
                                <input type="number" name="maximum_usage" id="maximum_usage" class="form-control"
                                    value="{{ $coupon->maximum_usage }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="owner">{{ __('admin.owner') }}</label>
                                <input type="text" name="owner" id="owner" class="form-control"
                                    value="{{ $coupon->owner }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="owner_ratio">{{ __('admin.owner_ratio') }}</label>
                                <input type="text" name="owner_ratio" id="owner_ratio" class="form-control"
                                    value="{{ $coupon->owner_ratio }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date">{{ __('admin.start_date') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $coupon->start_date }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date">{{ __('admin.end_date') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $coupon->end_date }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('admin.confirm') }}</button>
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
            $("#input-b1").fileinput({
                rtl: true,
                dropZoneEnabled: false,
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        });
    </script>
@endsection

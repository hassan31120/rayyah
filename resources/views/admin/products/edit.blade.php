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
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    {{ __('admin.update') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.users') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.updat') }}
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
                    <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.name') }}</label>
                            <input class="form-control" name="name" type="text" required value="{{ $user->name }}"
                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.phone_number') }}</label>
                            <input class="form-control" name="number" type="text" required value="{{ $user->number }}"
                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.email') }}</label>
                            <input class="form-control" name="email" type="email" value="{{ $user->email }}">
                        </div>

                        <div class="mb-3 ">
                            <label class="form-label">{{ __('admin.image') }}</label>
                            @isset($user->attachmentRelation[0])
                                <div class="row">
                                    <div class="form-group mb-3 col-6">
                                        <input name="image" type="file" class="form-control">
                                    </div>
                                    <div class="col-6"> <img src="{{ asset($user->attachmentRelation[0]->path) }}"
                                        alt="avatar" height="60"></div>
                                </div>
                            @else
                                <div class="form-group mb-3">
                                    <input name="image" type="file" class="form-control">
                                </div>
                            @endisset

                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">{{ __('admin.confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

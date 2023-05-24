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
                <h4 class="content-title mb-0 my-auto">{{ __('admin.services') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
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
                    <form action="{{ route('services.update', $service->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
            
                            @foreach (languages() as $lang)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label class="form-label" for="account-name">{{ __('site.title_' . $lang) }} </label>
                                            <input class="form-control"  value="{{ $service->getTranslations('name')[$lang] }}" name="name[{{ $lang }}]" id=""
                                                placeholder="{{ __('site.write') . __('site.title_' . $lang) }}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">
            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
            
                            </div>
                        </div>
            
                        <div class="mb-3">
                            <div class="row">
                            @foreach (languages() as $lang)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="account-name" class="form-label">{{ __('site.description_' . $lang) }} </label>
                                            <input class="form-control"  value="{{ $service->getTranslations('description')[$lang] }}" name="description[{{ $lang }}]" id=""
                                                cols="30" rows="10"
                                                placeholder="{{ __('site.write') . __('site.description_' . $lang) }}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                     
                    
                        <div class="mb-3 ">
                            <label class="form-label">{{ __('admin.image') }}</label>
                            @isset($service->attachmentRelation[0])
                                <div class="row">
                                    <div class="form-group mb-3 col-12">
                                        <input id="input-b1" name="attachment" type="file">
                                    </div>
                                    <div class="col-md-12"> <img src="{{ asset($service->attachmentRelation[0]->path) }}"
                                        alt="avatar" height="60"></div>
                                </div>
                            @else
                                <div class="form-group mb-3">
                                    <input id="input-b1" name="attachment" type="file">
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

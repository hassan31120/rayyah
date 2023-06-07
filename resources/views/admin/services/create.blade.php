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
    {{ __('admin.add-place') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.services') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.add-place') }}
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

    <div class="card">
   
      <div class="card-body">
        <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <div class="row">

                   
                @foreach (languages() as $lang)
                    <div class="col-6">
                        <div class="form-group">
                            <div class="controls">
                                <label class="form-label" for="account-name">{{ __('site.title_' . $lang) }} </label>
                                <input class="form-control" name="name[{{ $lang }}]" id=""
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
                                <input class="form-control" name="description[{{ $lang }}]" id=""
                                    cols="30" rows="10"
                                    placeholder="{{ __('site.write') . __('site.description_' . $lang) }}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
         
        
       <div class="mb-3">
        <input type="file" class="dropify" name="attachment" data-height="200" />
    </div>
       

            <button type="submit" class="btn btn-primary">Submit</button>

             
        </div>

           
        

      
         
        </form>
        
      </div>
    </div>
</div>
  
@endsection
@section('js')



@endsection
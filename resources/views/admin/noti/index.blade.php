@extends('layouts.master')

@section('css')

@endsection
@section('title')
    {{ __('admin.send_notification') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.notifications') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.send_notification') }}
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
                    <form action="{{ route('send_noti') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="title">{{ __('admin.title') }}</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="body">{{ __('admin.body') }}</label>
                                <input type="text" name="body" id="body" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-group">
                                <label for="image">{{ __('admin.image') }}</label>
                                <input id="input-b3" name="image" type="file">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $("#input-b3").fileinput({
            rtl: true,
            dropZoneEnabled: false,
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    });
    </script>
    
@endsection

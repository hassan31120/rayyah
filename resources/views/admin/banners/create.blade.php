@extends('layouts.master')
@section('css')
<!-- include libraries(jQuery, bootstrap) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

   
@endsection
@section('title')
    {{ __('admin.banner') }}
@stop


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.banner') }}
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    {{ __('admin.add') }}
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
                                        <label class="form-label">{{ __('admin.banner_ar') }}</label>
                                        <div class="form-group mb-3">
                                            <div>
                                                <input type="file" class="dropify" name="banner_ar" data-height="200" />
                                            </div>                                
                                                </div>
                                    </div>

                                    <div class="mb-3 ">
                                        <label class="form-label">{{ __('admin.banner_en') }}</label>
                                        <div class="form-group mb-3">
                                            <input type="file" class="dropify" name="banner_en" data-height="200" />
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
    </div>
</div>
</div>
</div>

    @endsection

    @section('js')

   

        {{-- delete one user script --}}
        @include('dashboard.shared.deleteOne')
        {{-- delete one user script --}}
    @endsection

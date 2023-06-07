@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@endsection
@section('title')
    {{ __('admin.edit_settings') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.settings') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.edit') }}
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('edit'))
        <script>
            toastr.success("{{ __('admin.update_successfullay') }}")
        </script>
    @endif
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        @foreach (languages() as $lang)
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="terms[{{ $lang }}]">{{ __('site.terms_' . $lang) }}</label>
                                    <textarea class="form-control" name="terms[{{ $lang }}]" id="terms_{{ $lang }}">{{ $settings->getTranslations('terms')[$lang] }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        $('#terms_ar').summernote({
            height: 400
        });
        $('#terms_en').summernote({
            height: 400
        });
        $('#terms_de').summernote({
            height: 400
        });
        $('#terms_fr').summernote({
            height: 400
        });
    </script>
@endsection

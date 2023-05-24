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
    {{ __('admin.banners') }}
@stop


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.banners') }}
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                    {{ __('admin.banners') }}
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('delete'))
        <script>
            toastr.error("{{ __('admin.delete_successfully') }}")
        </script>
    @endif

    @if (session()->has('Add'))
        <script>
            toastr.success("{{ __('admin.added_successfully') }}")
        </script>
    @endif


    <div class="page-wrapper">

        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href={{ url('banner/create') }} class="modal-effect btn btn-sm btn-primary"
                                    style="color:white"><i class="fas fa-plus"></i>&nbsp; {{ __('admin.add') }}</a>
                            </div>
                            <div class="card-body border-bottom py-3">
                                <div class="table-responsive text-center">
                                    <table class="table table-hover mb-0 text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">{{ __('admin.banner') }}</th>
                                                <th style="text-align:center">{{ __('admin.control') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($banners as $item)
                                                <tr class="align-self-center">
                                                    <td class="text-center">

                                                        <img src="{{ asset($item->banner) }}" width="200" height="100" style="border-radius:20px;  object-fit: cover">

                                                    </td>
                                                    <td>
                                                        <span class=" btn round btn-outline-danger delete-row text-danger"
                                                            data-url="{{ url('banner/delete/' . $item->id) }}">
                                                            <i class="fa-solid fa-trash"></i></span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7">{{ __('admin.there_is_no_data_at_the_moment') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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

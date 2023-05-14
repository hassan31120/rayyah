


@extends('tabler::layouts.app')

@push('css_libs_before')
<style>
    .th{
        text-align: center
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
      <!-- Page title -->
      <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
              Tables
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="row row-cards">
        
      
    
     
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoices</h3>
              </div>
        <div class="card-body">
         
            <table id="example" class=" table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">{{ __('admin.sender') }}</th>
                        <th class="text-center">{{ __('admin.reciver') }}</th>
                        <th class="text-center">{{ __('admin.date') }}</th>

                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $i = 0; ?>
@foreach ($trans as $item )
<tr>
    <td>{{$i++  }}</td>
    <td>{{ $item->sender->name }}</td>
    <td>{{ $item->reciver->name }}</td>
    <td>{{ Carbon\carbon::parse($item->created_at)->format('Y-m-d g:i:s') }}</td>

</tr>
@endforeach
                    
     
                </tbody>
             
            </table>
  
        </div>
    
    
              </div>

            </div>
          </div>
        </div>
      </div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#example').DataTable({
        paging: true,
        ordering: false,
        info: false,
    });
});
</script>
@endpush

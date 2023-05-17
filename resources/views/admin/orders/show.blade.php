@extends('layouts.master')
@section('css')
@endsection

@section('title')
{{ __('admin.invoice') }}
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('admin.orders') }}</h4></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.invoice') }}</span>
						</div>
					</div>
                </div>
				<!-- breadcrumb -->
@endsection
@section('content')

				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">{{ __('admin.invoice') }}</h1>
										<div class="billed-from">
											<h6>{{ __('admin.ray') }}, Inc.</h6>
											<p>{{ $order->address->title }}<br>
											Tel No: {{ $order->client->number }}<br>
											Email: {{ $order->client->email ?? 'example@gmail.com' }}</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6>{{ $order->client->name }}</h6>
												<p>{{ $order->address->title }}<br>
												Tel No: {{ $order->client->number }}<br>
												Email: {{ $order->client->email ?? 'example@gmail.com' }}</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">Invoice Information</label>
                                            <p class="invoice-info-row"><span>Delivery Name</span> <span>{{ $order->delivery->name }}</span></p>

											<p class="invoice-info-row"><span>Invoice No</span> <span>{{ $order->ref_number }}</span></p>
											<p class="invoice-info-row"><span>Due Date:</span> <span>{{ Carbon\carbon::parse($order->created_at)->format('Y-m-d') }}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">Service</th>
													<th class="wd-40p">Description</th>

													<th class="tx-center">Service Price</th>
													<th class="tx-right">delivery Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{ $order->service->name }}</td>
													<td class="tx-12">{{ $order->description }}</td>

													<td class="tx-center">${{ $order->total_service_price ?? 0.0 }}</td>
													<td class="tx-right">${{ $order->total_del_price }}</td>
												</tr>
										
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														
													</td>
													<td class="tx-right">Sub-Total</td>
													<td class="tx-right" colspan="2">${{   $order->total_cost  }}</td>
												</tr>
												
												<tr>
													<td class="tx-right">Discount</td>
													<td class="tx-right" colspan="2">$0.0</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">${{ $order->total_cost }}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
								
                                    <button onclick="display()" id="hiddpr" rel="noopener" target="_blank" class="btn btn-danger float-left mt-3 mr-2">
                                        <i class="mdi mdi-printer ml-1"></i>Print
                                    </button>
            
									{{-- <a href="{{ url('invoice/' . $order->id . '/generate') }}" class="btn btn-success float-left mt-3">
										<i class="mdi mdi-telegram ml-1"></i> Export
									</a> --}}
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script>
    function display() {

        document.getElementById("hiddpr").style.display = 'none';
        window.print();
    }
</script>
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endsection
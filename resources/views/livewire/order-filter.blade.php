<div class="row">
    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
             
                <input type="search"  wire:model="search" class="form-control float-end mx-10" placeholder="Search..."
                style="width: 230px; margin-bottom:10px; margin-right:10px; float: right;" />
                   
                <select wire:model="searchh" class="form-control text-center  mx-10"
                style="width: 230px; margin-bottom:10px; float: left;">
                <option hidden>{{__('admin.all')}}</option>
                <option value="all">{{ __('admin.all') }}</option>
                <option value="pending">{{ __('admin.pending') }}</option>
                <option value="on_delivery">{{ __('admin.recent') }}</option>
                <option value="done">{{ __('admin.done') }}</option>
                <option value="cancelled">{{ __('admin.cancelled') }}</option>

            </select>
    
          
            </div>
            <div class="card-body">
                <div class="table-responsive">
                        <!-- Filtered orders will be dynamically loaded here -->
                    
                    <table id="examp" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                        <thead>
                            <tr class="align-self-center">
                                <th class="border-bottom-0">#</th>
  
                                <th class="border-bottom-0">{{ __('admin.name') }}</th>
                                <th class="border-bottom-0">{{ __('admin.phone') }}</th>
                                <th class="border-bottom-0"> {{ __('admin.status') }}</th>

                                <th class="border-bottom-0">{{ __('admin.control') }}</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($orders as $item)
                                @php
                                $i++
                                @endphp
                                <tr>
                                   <td>{{ $i }}</td>
                                    <td>{{ $item->client->name }} </td>
                                    <td>{{ $item->client->number }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                        <span class="badge  badge-warning">{{ __('admin.pending') }}</span>
                                        @elseif($item->status == 'on_delivery')
                                        <span class="badge badge-primary">{{ __('admin.recent') }}</span>
                                        @elseif($item->status == 'done')
                                        <span class="badge badge-success">{{ __('admin.done') }}</span>
                                        @elseif($item->status == 'cancelled')
                                        <span class="badge badge-danger">{{ __('admin.cancelled') }}</span>

                                        @endif
                                    </td>

  
                                  
                              
                                    <td>
                                     
  
                                      
                                      <a  href="{{ route('show.orders' , $item->id) }}" class="btn round btn-outline-primary">
                                        <i
                                         class="fa-solid fa fa-eye"></i>
                                    </a>
                                   
                                    </td>
                                </tr>
                            @endforeach
  
                        </tbody>
                    </table>

                    <div>
                        {{ $orders->links() }}
                    </div>
            
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
  </div>
</div>
</div>

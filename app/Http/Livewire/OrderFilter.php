<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderFilter extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public $searchh;
    public $search = '';

    public function render()
    {
        $search = $this->search;
        if($this->searchh == 'all'){
            $orders = Order::
            where(function ($q) use ($search) {
            $q->whereHas('client', function ($query) use ($search) {
    
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('number', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
    
            });
        })->orderBy('id', 'DESC')->paginate(5);   
             return view('livewire.order-filter' , ['orders'=>$orders]);
        
        }
        $orders = Order::Where('status', 'LIKE', '%' . $this->searchh . '%')->
        where(function ($q) use ($search) {
        $q->whereHas('client', function ($query) use ($search) {

            $query->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('number', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%');

        });
    })->orderBy('id', 'DESC')->paginate(5);   
         return view('livewire.order-filter' , ['orders'=>$orders]);
    }
}

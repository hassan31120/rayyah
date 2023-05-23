<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        // Get today's date
        $today = Carbon::today()->toDateString();

        // Get the order count for yesterday
        $yesterdayCount = DB::table('orders')
            ->where('status', '!=', 'pending')
            ->whereDate('created_at', $yesterday)
            ->get();

        // Get the order count for today
        $todayCount = DB::table('orders')
            ->where('status', '!=', 'pending')
            ->whereDate('created_at', $today)
            ->get();

        // Calculate the difference between the two counts
        $orderDifference = $todayCount->count() - $yesterdayCount->count();
        $orderDifference1 =
            $todayCount->sum('total_cost') - $yesterdayCount->sum('total_cost');

        $startOfWeek = Carbon::now()
            ->startOfWeek()
            ->toDateString();
        $endOfWeek = Carbon::now()
            ->endOfWeek()
            ->toDateString();

        // Get the start and end dates for the previous week
        $startOfLastWeek = Carbon::now()
            ->subWeek()
            ->startOfWeek()
            ->toDateString();
        $endOfLastWeek = Carbon::now()
            ->subWeek()
            ->endOfWeek()
            ->toDateString();

        // Get the total income for the current week
        $totalIncomeThisWeek = DB::table('orders')->where('status', '!=', 'pending')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_cost');

        // Get the total income for the previous week
        $totalIncomeLastWeek = DB::table('orders')->where('status', '!=', 'pending')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('total_cost');

            if($totalIncomeLastWeek == 0){
                $totalIncomeLastWeek = 1;
                $incomeDifference = ($totalIncomeThisWeek / $totalIncomeLastWeek) * 100;

            }else{
                $incomeDifference = ($totalIncomeThisWeek / $totalIncomeLastWeek) * 100;

            }


            

        // Calculate the difference in total income between the two weeks

        $count_all = Order::count();
        $count_pending = Order::where('status', 'pending')->count();
        if ($count_all != 0) {
            $pendingorders = $count_pending;

        } else {
            $pendingorders = 0;
        }

        $count_accepted = Order::where('status', 'cancelled')->count();
        if ($count_all != 0) {
            $cancelledorders = $count_accepted;

        } else {
            $cancelledorders = 0;
        }

      
        
         $count_finished = Order::where('status', 'done')->count();

        if ($count_all != 0) {
            $finishedOrders = $count_finished;

        } else {
            $finishedOrders = 0;
        }

        $chartjs = app()
            ->chartjs->name('lineChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels([__('admin.pending'), __('admin.cancelled'),__('admin.done')])
            ->datasets([
                [
                    'label' => __('admin.pending'),
                    'backgroundColor' => '#FBBC0B',
                    'borderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => [$pendingorders],
                ],
                [
                    'label' => __('admin.cancelled'),
                    'backgroundColor' => '#EE335E',
                    'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => [0, $cancelledorders],
                ],
              
                 [
                    'label' => __('admin.done'),
                    'backgroundColor' => '#277AEC',
                    'borderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => [0,0, $finishedOrders],
                ],
            ])
            ->options([]);

        ////////////////////////////////

        // example.blade.php
        $chartjs_2 = app()
            ->chartjs->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 350, 'height' => 293])
            ->labels([__('admin.pending'), __('admin.cancelled'),__('admin.done')])
            ->datasets([
                [
                    'backgroundColor' => ['#FBBC0B', '#EE335E','#277AEC'],
                    'data' => [$pendingorders, $cancelledorders,$finishedOrders],
                ],
            ])
            ->options([]);


          $orderat =   DB::table('orders')->where('status', 'done')
      ->select(DB::raw('DATE(created_at) as date') , DB::raw('count(*) as count') , DB::raw('SUM(total_cost) as total_cost'))
      ->groupBy('date')
      ->get();


        return view(
            'dashboard',
            compact(
                
                'todayCount',
                'orderDifference',
                'orderDifference1',
                'yesterdayCount',
                'totalIncomeThisWeek',
                'incomeDifference',
                'totalIncomeLastWeek',
                'chartjs',
                'chartjs_2',
                'orderat'
            )
        );
    }

    public function index($id)
    {
        if (view()->exists($id)) {
            return view($id);
        } else {
            return view('404');
        }

        //   return view($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = auth()->user()->id;
        $admin = User::where('id', $id)->first();
        if ($admin) {
            return view('admin.profile.edit', compact('admin'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
        ]);
        $input = $request->except('password');
        $admin = User::where('id', $id)->first();

        if ($request->password) {
            if (!empty($user->password)) {
                $user->password = Hash::make($request->password);
            } else {
                $input = Arr::except($input, ['password']);
            }
        }
        $admin->update($input);
        return redirect()->back()
            ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    public function getAllMonths()
    {
        $month_array = [];
        $months = Order::orderBy('created_at', 'ASC')->pluck('created_at');
        $months = json_decode($months);
        if (!empty($months)) {
            foreach ($months as $unformatted_month) {
                $date = new \DateTime($unformatted_month);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    public function getMonthlyOrderCount($months)
    {
        $monthly_order_count = Order::whereMonth('created_at', $months)
            ->get()
            ->count();
        return $monthly_order_count;
    }
    public function getMonthlyOrderData()
    {
        $monthly_order_data_array = [];
        $monthly_order_count_array = [];
        $month_name_array = [];
        $month_array = $this->getAllMonths();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_order_count = $this->getMonthlyOrderCount($month_no);
                array_push($monthly_order_count_array, $monthly_order_count);
                array_push($month_name_array, $month_name);
            }
        }
        $max_no = max($monthly_order_count_array);
        $max = round(($max_no + 10 / 2) / 10) * 10;

        $monthly_order_data_array = [
            'months' => $month_name_array,
            'order_count_data' => $monthly_order_count_array,
            'max' => $max,
        ];

        return $monthly_order_data_array;
    }}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
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
        $totalIncomeThisWeek = DB::table('orders')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_cost');

        // Get the total income for the previous week
        $totalIncomeLastWeek = DB::table('orders')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('total_cost');

            if($totalIncomeLastWeek == 0){
                $totalIncomeLastWeek = 1;
                $incomeDifference = ($totalIncomeThisWeek / $totalIncomeLastWeek) * 100;

            }else{
                $incomeDifference = ($totalIncomeThisWeek / $totalIncomeLastWeek) * 100;

            }
        

        // Calculate the difference in total income between the two weeks

        return view(
            'dashboard',
            compact(
                'todayCount',
                'orderDifference',
                'orderDifference1',
                'yesterdayCount',
                'totalIncomeThisWeek',
                'incomeDifference',
                'totalIncomeLastWeek'
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
    public function destroy($id)
    {
        //
    }
}

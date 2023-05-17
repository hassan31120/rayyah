<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $orders = Order::query();
    
        if ($status) {
            $orders->where('status', $status);
        }
    
        $filteredOrders = $orders->get();        
        return view('admin.orders.index',compact('filteredOrders'));
    }

    public function show($id)
    {
        $order = Order::find($id);

        $notification = auth()->user()->notifications()->where('data->id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return view('admin.orders.show',compact('order'));

    }

    public function generateInvoice(int $orderId)
    {
       $order = Order::findOrFail($orderId);
        $data = ['order' => $order];
        $dompdf = new Dompdf();
        $dompdf = Pdf::loadView('admin.orders.print', $data);
        $dompdf->setPaper('A4', 'landscape');
        $todayDate = Carbon::now()->format('d-m-Y');
        return $dompdf->download('invoices123456789' . $order->id . '-' . $todayDate . '.pdf');
        return view('admin.orders.print', compact('order'));

        // $pdf = Pdf::loadView('admin.orders.print', compact('order'), [], [
        //     'format' => 'A4-P',
        //     'orientation' => 'P',
        // ]);

        return $pdf->stream('invoice' . $order->id . '-' . $todayDate . '.pdf');

    }


    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }

    }

    public function unreadNotifications_count()
    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()
    {
        foreach (auth()->user()->unreadNotifications as $notification) {

            return $notification->data['title'];

        }

    }

    public function markNotificationAsRead($notificationId)
{
    $user = Auth::user();
    $notification = $user->notifications()->findOrFail($notificationId);
    $notification->markAsRead();

    return response()->json(['success' => true]);
}

   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Midtrans\Transaction;
use Ramsey\Uuid\Type\Decimal;

class MidtransController extends Controller
{
    
public function pay($id)
{
    $order = Order::findOrFail($id);
    // dd($order);
    $midtrans_order_id = 'ORDER-' . $order->id . '-' . time();
    $order->update(['midtrans_order_id' => $midtrans_order_id]);

    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Data pelanggan default
    $customer_details = [
        'first_name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'phone' => '081234567890',
    ];

    // Data transaksi tanpa item details
    $transaction = [
        'transaction_details' => [
            'order_id' => $midtrans_order_id,
            'gross_amount' => (int) number_format($order->total, 0, '', ''), // Total tanpa item details
        ],
        'customer_details' => $customer_details,
        'callbacks' => [
            'finish' => route('orders.finish', ['id' => $order->id]),
        ],
    ];
    // dd($transaction);
    // $snapTransaction = Snap::createTransaction($transaction);
    // dd($snapTransaction);

    try {
        $snapTransaction = Snap::createTransaction($transaction);
        // dd($snapTransaction); // Debugging: Cek isi response dari Midtrans
        return redirect()->away($snapTransaction->redirect_url);
    } catch (\Exception $e) {
        Log::error('Midtrans Payment Error: ' . $e->getMessage());
        return redirect()->route('home.index')->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
    }
    
}

// ini kehapus ya bro sory cek lagi aja di drive

// public function finish($id)
// {
//     $order = Order::findOrFail($id);
//     $transaction_status = request()->get('transaction_status');
//     Log::info('Transaction Status: ' . $transaction_status);

//     if (!$transaction_status) {
//         Log::error('Status transaksi tidak ditemukan untuk order ID: ' . $id);
//         return redirect()->route('orders.index')->with('error', 'Status transaksi tidak ditemukan.');
//     }

//     try {
//         switch ($transaction_status) {
//             case 'settlement':
//                 $order->payment_status = 'paid';

//                 // Jika status pembayaran berhasil 'paid', beri 10 poin ke pengguna
//                 if ($order->payment_status == 'paid') {
//                     $user = $order->user; // Ambil data user yang terkait dengan order

//                     // Tambahkan 10 poin ke pengguna
//                     $user->points += 10;

//                     // Simpan perubahan data user
//                     $user->save();
//                     Log::info('Berhasil menambahkan 10 poin ke pengguna ID: ' . $user->user_id);
//                 }
//                 break;

//             case 'pending':
//                 $order->payment_status = 'pending';
//                 break;

//             case 'failed':
//                 $order->payment_status = 'failed';
//                 break;

//             default:
//                 $order->payment_status = 'cancelled';
//                 break;
//         }

//         // Simpan perubahan status pembayaran
//         if (!$order->save()) {
//             Log::error('Gagal memperbarui status pembayaran untuk order ID: ' . $id);
//             return redirect()->route('cart.index')->with('error', 'Gagal memperbarui status pembayaran.');
//         }

//         // Jika berhasil memperbarui
//         Log::info('Status pembayaran berhasil diperbarui untuk order ID: ' . $id);
//         return redirect()->route('cart.index')->with('success', 'Pembayaran diproses dengan status: ' . $transaction_status);

//     } catch (\Exception $e) {
//         Log::error('Error saat memperbarui status pembayaran untuk order ID: ' . $id . ' - ' . $e->getMessage());
//         return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memperbarui status pembayaran.');
//     }
// }


// Fungsi finish yang sudah ada
public function finish($id)
{
    $order = Order::findOrFail($id);
    $transaction_status = request()->get('transaction_status');
    Log::info('Transaction Status: ' . $transaction_status);

    if (!$transaction_status) {
        Log::error('Status transaksi tidak ditemukan untuk order ID: ' . $id);
        return redirect()->route('orders.index')->with('error', 'Status transaksi tidak ditemukan.');
    }

    try {
        switch ($transaction_status) {
            case 'settlement':
                $order->payment_status = 'paid';
                if ($order->payment_status == 'paid') {
                    $user = $order->user;
                    $user->points += 10;
                    $user->save();
                    Log::info('Berhasil menambahkan 10 poin ke pengguna ID: ' . $user->user_id);
                }
                break;

            case 'pending':
                $order->payment_status = 'pending';
                break;

            case 'failed':
                $order->payment_status = 'failed';
                break;

            default:
                $order->payment_status = 'cancelled';
                break;
        }

        if (!$order->save()) {
            Log::error('Gagal memperbarui status pembayaran untuk order ID: ' . $id);
            return redirect()->route('cart.index')->with('error', 'Gagal memperbarui status pembayaran.');
        }

        Log::info('Status pembayaran berhasil diperbarui untuk order ID: ' . $id);
        return redirect()->route('orders.details', $id)->with('success', 'Pembayaran diproses dengan status: ' . $transaction_status);

    } catch (\Exception $e) {
        Log::error('Error saat memperbarui status pembayaran untuk order ID: ' . $id . ' - ' . $e->getMessage());
        return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memperbarui status pembayaran.');
    }
}




// OrderController.php


}
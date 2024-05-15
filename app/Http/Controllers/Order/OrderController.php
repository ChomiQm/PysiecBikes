<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $user = Auth::user();
        $query = Order::where('user_id', $user->id);

        // Sprawdzanie, czy użytkownik coś wprowadził w pole wyszukiwania
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('orderItems', function($q) use ($request) {
                        $q->whereHas('bike', function($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%');
                        });
                    });
            });
        }

        $orders = $query->with(['orderItems.bike'])->paginate(10);

        return view('user.order', compact('orders'));
    }

    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Nieautoryzowany dostęp'], 401);
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->id = Str::uuid();
            $order->user_id = $user->id;
            $order->order_number = rand();
            $order->quantity = array_sum(array_column($request->input('cartItems'), 'quantity'));
            $order->save();

            foreach ($request->input('cartItems') as $item) {
                Log::debug('Cart item data:', [
                    'bike_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity']
                ]);

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->bike_id = $item['id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->total_price = (float)($item['price'] * $item['quantity']);
                Log::debug('OrderItem data:', $orderItem->attributesToArray());
                $orderItem->save();


            }

            DB::listen(function ($query) {
                Log::info($query->sql, $query->bindings);
            });

            DB::commit();
            return response()->json(['message' => 'Zamówienie zostało pomyślnie złożone!']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Błąd przy składaniu zamówienia: ' . $e->getMessage()], 500);
        }
    }
}

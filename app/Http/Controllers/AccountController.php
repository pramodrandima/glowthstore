<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with(['items.product.previews', 'items.product.files', 'downloadEvents'])
            ->latest()
            ->paginate(10);

        return view('account.dashboard', compact('orders'));
    }

    public function order(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['items.product.files', 'downloadEvents']);

        return view('account.order', compact('order'));
    }
}

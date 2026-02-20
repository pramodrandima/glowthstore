<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $orders = auth()->user()
            ->orders()
            ->where('status', OrderStatus::PAID->value)
            ->with(['items.product.previews', 'items.product.files', 'downloadEvents'])
            ->latest()
            ->paginate(10);

        return view('account.dashboard', compact('orders'));
    }

    public function order(Order $order): View
    {
        $this->authorize('view', $order);

        if (! auth()->user()->isAdmin() && ! $order->isPaid()) {
            abort(404);
        }

        $order->load(['items.product.files', 'downloadEvents']);

        return view('account.order', compact('order'));
    }
}

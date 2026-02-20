<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportRequest;
use App\Mail\SupportMessageMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function create(): View
    {
        return view('static.support');
    }

    public function store(SupportRequest $request): RedirectResponse
    {
        Mail::to(config('store.support_email'))->send(new SupportMessageMail($request->validated()));

        return back()->with('status', 'Support request sent successfully.');
    }
}

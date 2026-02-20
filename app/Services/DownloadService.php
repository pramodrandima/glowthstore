<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\DownloadEvent;
use App\Models\Order;
use App\Models\ProductFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadService
{
    public function handleDownload(User $user, Order $order, ProductFile $file, Request $request): StreamedResponse
    {
        if ($order->status !== OrderStatus::PAID || $order->downloads_disabled) {
            abort(403, 'Downloads are not available for this order.');
        }

        $hasFileInOrder = $order->items()
            ->where('product_id', $file->product_id)
            ->exists();

        if (! $hasFileInOrder) {
            abort(403, 'File is not part of this order.');
        }

        $downloadLimit = config('store.download_limit');

        if ($downloadLimit > 0) {
            $count = DownloadEvent::query()
                ->where('user_id', $user->id)
                ->where('order_id', $order->id)
                ->where('product_file_id', $file->id)
                ->count();

            if ($count >= $downloadLimit) {
                abort(429, 'Download limit reached for this file.');
            }
        }

        DownloadEvent::query()->create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_file_id' => $file->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return Storage::disk($file->storage_disk)->download($file->storage_path, $file->display_name);
    }
}

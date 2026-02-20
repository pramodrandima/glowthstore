<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductFile;
use App\Services\DownloadService;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function __invoke(Request $request, Order $order, ProductFile $productFile, DownloadService $downloadService)
    {
        $this->authorize('download', $order);

        return $downloadService->handleDownload($request->user(), $order, $productFile, $request);
    }
}

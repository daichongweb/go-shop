<?php

namespace App\Http\Controllers;

use App\Http\Response\Rsp;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return Rsp::success(Product::query()->where('status', 1)->get());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function generateQr($id)
    {
        $product = Product::findOrFail($id);

        // Generate QR code pointing to verification page
        $qr = QrCode::size(200)->generate(route('products.verify', $product->product_id));

        // Optionally mark QR as generated
        $product->qr_generated = true;
        $product->save();

        return view('qr', compact('product', 'qr'));
    }

    public function viewQr($id)
    {
        $product = Product::findOrFail($id);

        // QR code showing product page or verification (choose as needed)
        $qr = QrCode::size(200)->generate(route('products.verify', $product->product_id));

        return view('qr', compact('product', 'qr'));
    }

    public function verify($id)
    {
        $product = Product::findOrFail($id);
        return view('products.verify', compact('product'));
    }
}

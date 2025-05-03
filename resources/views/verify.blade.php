@extends('layouts.app')

@section('content')
<div class="text-center mt-10">
    <h1 class="text-3xl font-bold text-green-600">✅ Product Verified</h1>
    <p class="mt-4 text-xl">This product (Code: <strong>{{ $product->product_code }}</strong>) is confirmed to be legitimate and verified by <strong>PakbetTV</strong>.</p>
</div>
@endsection

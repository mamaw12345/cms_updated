@extends('layouts.app')

@section('title', 'Product List')

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .export-btn {
            background-color: #FFD700;
            color: #8B0000;
            border: none;
            padding: 8px 12px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        .dataTables_filter {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .dataTables_filter label {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .dataTables_filter input {
            width: 100%;
            max-width: 250px;
            min-width: 150px;
            padding: 5px;
        }

        @media (max-width: 768px) {
            .dataTables_filter {
                justify-content: center;
            }

            .btn-group-mobile {
                flex-direction: column;
                gap: 5px;
                align-items: center;
            }
        }
    </style>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-3">Generate QR</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #A2201A;">
                                <h3 class="card-title text-white">Products List</h3>
                            </div>                        
                            <div class="table-responsive mt-3">
                                <table id="productTable" class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Code</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->product_id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->product_code }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($product->qr_generated) bg-success
                                                        @else bg-secondary @endif">
                                                        {{ $product->qr_generated ? 'QR Generated' : 'Not Generated' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.generateQr', $product->product_id) }}" class="btn btn-outline-dark btn-sm" title="Generate QR">
                                                        Generate QR
                                                    </a>
                                                    @if($product->qr_generated)
            <a href="{{ route('products.viewQr', $product->product_id) }}" class="btn btn-outline-primary btn-sm" title="View QR">
                View QR
            </a>
        @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#productTable').DataTable({
                "paging": false,  // Disable pagination
                "order": [[1, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [4] } // The Actions column is non-orderable
                ]
            });

            $('#exportExcel').on('click', function () {
                var wb = XLSX.utils.table_to_book(document.getElementById('productTable'), { sheet: "Products" });
                XLSX.writeFile(wb, 'products.xlsx');
            });
        });
    </script>
@endsection

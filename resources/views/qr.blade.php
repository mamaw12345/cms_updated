<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan QR Code</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #FF6B6B, #F7A8B8);
      min-height: 100vh;
    }
  </style>
</head>
<body class="flex items-center justify-center p-6">
  <div class="bg-white rounded-3xl shadow-lg max-w-lg w-full p-8 sm:p-12 flex flex-col items-center">
    <!-- Header Section -->
    <div class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Scan the QR Code</h1>
      <p class="text-lg text-gray-600 mb-4">Verify the authenticity of the product</p>
      <p class="text-sm text-gray-500">Product Code: <span class="font-semibold">{{ $product->product_code }}</span></p>
    </div>

    <!-- QR Code Section -->
    <div class="w-full max-w-xs mx-auto mb-8">
      <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
        <div class="flex justify-center mb-6">
          {!! $qr !!}
        </div>
        <p class="text-center text-gray-700 text-sm">Scan the QR code above to verify the product.</p>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="w-full flex gap-6 justify-center mt-8">
      <a href="{{ route('products.index') }}" class="bg-gray-800 text-white rounded-full px-8 py-3 text-lg font-medium hover:bg-gray-700 transition duration-200 w-full sm:w-auto text-center">Back to Products</a>
      <a href="javascript:void(0);" onclick="downloadPDF()" class="bg-blue-600 text-white rounded-full px-8 py-3 text-lg font-medium hover:bg-blue-500 transition duration-200 w-full sm:w-auto text-center">Download PDF</a>
    </div>
  </div>

  <script>
    function downloadPDF() {
      const element = document.querySelector('.bg-white');
      const opt = {
        margin:       0.5,
        filename:     'qr-code-{{ $product->name }}.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(element).save();
    }
  </script>

</body>
</html>

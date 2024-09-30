<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 0 10px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 150px;
            height: auto;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        /* Details */
        .details,
        .products,
        .card {
            margin-bottom: 10px;
        }

        .details table,
        .products table {
            width: 100%;
            border-collapse: collapse;
        }

        .details table th,
        .products table th,
        .details table td,
        .products table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .details table th,
        .products table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .details table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Products */
        .products table th:last-child,
        .products table td:last-child {
            text-align: right;
        }

        /* Cards */
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-content {
            font-size: 14px;
        }

        .highlighted-card {
            display: flex;
            justify-content: flex-end;
        }

        .highlighted-card .card {
            min-width: 250px;
            padding: 0 10px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 10px;
        }

        /* Print Styles */
        .note-text {
            font-size: 12px;
        }

        .d-flex {
            display: flex !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .justify-content-start {
            justify-content: flex-start !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .brand {
            font-size: 2rem !important;
        }

        .save-button {
            text-align: center;
        }

        .save-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
    <div class="container" id="invoice">
        <div class="save-button">
            <button id="download-invoice">Download Invoice as JPG</button>
        </div>
        @yield('content')

        <div class="footer" style="display:flex; justify-content: space-between">
            <p>Thank you for your business!</p>
            <p style="font-size: 11px; text-align: center; align-self:flex-end">Design and Developed by:
                <a href="https://asanwebs.com" target="_blank" class="opacity-75">ASANWEBS</a>
            </p>
        </div>

    </div>
    </div>
    <script>
        document.getElementById('download-invoice').addEventListener('click', function() {
            // hide this button
            document.getElementById('download-invoice').style.display = 'none';
            html2canvas(document.getElementById('invoice')).then(function(canvas) {
                // Convert canvas to a base64 image and download
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/jpeg');
                link.download = 'invoice.jpg';
                link.click();
            }).catch(function(error) {
                console.error('Error generating canvas:', error);
            });

            document.getElementById('download-invoice').style.display = 'inline';
        });
    </script>
</body>

</html>

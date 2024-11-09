<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=50mm, initial-scale=1.0">
    <title>Thermal Invoice</title>
    <style>
        @media print {

            /* Hide the header, footer, and other non-essential content */
            body * {
                visibility: hidden;
            }

            #printable-content,
            #printable-content * {
                visibility: visible;
            }

            #printable-content {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            width: 50mm;
        }

        .header,
        .details,
        .products,
        .totals,
        .footer {
            margin: 5px 0;
            padding: 0 5px;
        }

        .products table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .products table th,
        .products table td {
            border: 1px solid #ddd;
            padding: 2px 0;
            text-align: left;
        }

        .totals p,
        .details p {
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <div class="container" id="printable-content">
        @yield('content')
    </div>
    <script>
        // Function to automatically open the print dialog
        function autoPrint() {
            window.print();
        }

        // Automatically call the print function on page load
        window.onload = autoPrint;
    </script>
</body>

</html>

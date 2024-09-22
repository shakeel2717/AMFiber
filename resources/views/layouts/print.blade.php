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
            max-width: 900px;
            /* Increased width to suit landscape */
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        @media print {
            @page {
                size: A4;
                /* Set the page to landscape */
                margin: 10mm;
                /* Adjust margins as needed */
            }

            .container {
                max-width: 100%;
                /* Use full width in print */
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }

            /* Hide any elements not needed in print */
            .header img {
                display: none;
            }

            .footer {
                margin-top: 10mm;
            }

            .card-content p {
                font-size: 12px;
                /* Adjust font size for print */
            }

            table {
                font-size: 12px;
                /* Ensure table fits within landscape layout */
            }

        }

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
    </style>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>

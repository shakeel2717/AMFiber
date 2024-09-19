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
                size: A4 landscape;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="text-primary">{{ config('app.name') }}</h1>
            <div class="labelandtime">
                <h1>Quotation</h1>
                <h5>Date: {{ $quotation->created_at->format('d-m-Y') }}</h5>
            </div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Customer Name:</th>
                    <td>{{ $quotation->party->name }}</td>
                </tr>
                <tr>
                    <th>Customer Address:</th>
                    <td>{{ $quotation->party->address }}</td>
                </tr>
                <tr>
                    <th>Customer Phone:</th>
                    <td>{{ $quotation->party->phone }}</td>
                </tr>
                <tr>
                    <th>Quotation Number:</th>
                    <td>{{ $quotation->id }}</td>
                </tr>
            </table>
        </div>

        <div class="products">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Details</th>
                        <th scope="col">Value</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->quotation_items as $item)
                        <tr>
                            <th>Size</th>
                            <td style="text-align: right; font-weight: bold">{{ $item->width }}x{{ $item->height }}
                            </td>
                            <td rowspan="6" class="align-middle">Rs: {{ number_format($item->price, 2) }}</td>
                            <td rowspan="6" class="align-middle">Rs: {{ number_format($quotation->total_amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Specification</th>
                            <td>{{ $item->specification }}</td>
                        </tr>
                        <tr>
                            <th>Piller Pipe</th>
                            <td>{{ $item->piller }}</td>
                        </tr>
                        <tr>
                            <th>Shed Pipe</th>
                            <td>{{ $item->shed }}</td>
                        </tr>
                        <tr>
                            <th>Truss Pipe</th>
                            <td>{{ $item->truss }}</td>
                        </tr>
                        <tr>
                            <th>Thickness in mm</th>
                            <td>{{ $item->thickness }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <div class="highlighted-card">
            <div class="card">
                <div class="card-content">
                    <h3 class="">Total Amount:
                        Rs: {{ number_format($quotation->total_amount - $quotation->paid_amount, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Terms and Conditions</div>
            <div class="card-content">
                <p>1. All quotations are valid for 30 days from the date of issue.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Note</div>
            <p class="note-text">Please review the quotation carefully. If you have any questions or need further
                clarification, feel
                free to contact us.</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>

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
            max-width: 700px;
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
            margin-bottom: 20px;
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
            margin-bottom: 20px;
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
            width: 200px;
            padding: 0 15px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
        }

        /* Print Styles */
        @media print {
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="text-primary">{{ config('app.name') }}</h1>
            <h1>Quotation</h1>
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
                <tr>
                    <th>Total Amount:</th>
                    <td>Rs: {{ number_format($quotation->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="products">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Width</th>
                        <th>Height</th>
                        <th>Quantity</th>
                        <th>Price per Unit</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->quotation_products as $product)
                        <tr>
                            <td>{{ $product->product->name }}</td>
                            <td>{{ $product->width }}</td>
                            <td>{{ $product->height }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>Rs: {{ number_format($product->price, 2) }}</td>
                            <td>Rs: {{ number_format($product->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="highlighted-card">
            <div class="card">
                <div class="card-content">
                    <p class="">Total Due Amount: </p>
                    <h3 class="">
                        Rs: {{ number_format($quotation->total_amount - $quotation->paid_amount, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Terms and Conditions</div>
            <div class="card-content">
                <p>1. All quotations are valid for 30 days from the date of issue.</p>
                <p>2. Payment terms are 50% advance and 50% upon completion.</p>
                <p>3. Any changes to the quotation must be made in writing.</p>
                <p>4. The company is not responsible for any delays caused by external factors.</p>
                <!-- Add more terms as needed -->
            </div>
        </div>

        <div class="card">
            <div class="card-title">Note</div>
            <div class="card-content">
                <p>Please review the quotation carefully. If you have any questions or need further clarification, feel
                    free to contact us.</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>

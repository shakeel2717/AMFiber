<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=58mm, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thermal Invoice</title>
    <style>
        @page {
            size: 80mm 210mm;
            margin: 0;
        }

        @media print {

            html,
            body {
                font-family: 'Arial Black', 'Arial', sans-serif;
                font-size: 13px;
                margin: 0;
                padding: 0;
                width: 80mm;
                line-height: 1.3;
                font-weight: 900;
                color: #000;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

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
                width: 80mm;
                margin: 0;
                padding: 0;
            }

            .save-button {
                display: none !important;
            }
        }

        body {
            font-family: 'Arial Black', 'Arial', sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            width: 80mm;
            line-height: 1.3;
            font-weight: 900;
        }

        .container {
            width: 80mm;
            max-height: 210mm;
            margin: 0;
            padding: 2mm;
            box-sizing: border-box;
        }

        .header,
        .details,
        .products,
        .totals,
        .footer {
            margin: 1.5mm 0;
            padding: 0;
        }

        .header h3 {
            margin: 0;
            font-size: 13px;
            text-align: center;
            font-weight: 900;
        }

        .products table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 2mm 0;
            font-weight: 900;
        }

        .products table th,
        .products table td {
            border: none;
            border-bottom: 1px dashed #000;
            padding: 1.5px 3px;
            text-align: left;
            font-weight: 900;
        }

        .products table th {
            font-weight: 900;
            border-bottom: 2px solid #000;
            font-size: 13px;
        }

        .totals p,
        .details p {
            margin: 1.5px 0;
            font-size: 13px;
            font-weight: 900;
        }

        .footer {
            text-align: center;
            margin-top: 4mm;
            border-top: 1px dashed #000;
            padding-top: 2mm;
            font-size: 13px;
            font-weight: 900;
        }

        .save-button {
            margin-bottom: 5px;
        }

        .save-button button {
            padding: 6px 12px;
            font-size: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: 900;
        }

        .thermal-header {
            text-align: center;
            margin-bottom: 4mm;
        }

        .logo-section {
            margin-bottom: 2mm;
        }

        .thermal-logo {
            max-width: 40mm;
            max-height: 15mm;
            height: auto;
            width: auto;
        }

        .company-name h1 {
            font-size: 15px;
            font-weight: 900;
            margin: 1mm 0;
            line-height: 1.2;
        }

        .thermal-line {
            border-bottom: 1px dashed #000;
            margin: 2mm 0;
            width: 100%;
        }

        .payments-section {
            font-size: 12px;
            margin-top: 2mm;
            border-top: 1px dashed #000;
            padding-top: 1mm;
        }

        .payments-section p {
            font-size: 12px;
            margin: 1px 0;
            font-weight: 900;
        }

        /* Enhanced bold styling for thermal printer */
        * {
            font-weight: 900 !important;
            color: #000 !important;
        }

        p,
        td,
        th,
        span,
        div,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 900 !important;
            
        }

        b,
        strong {
            font-weight: 900 !important;
            
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
    <div class="container" id="printable-content">
        <div class="save-button">
            <button id="download-invoice">Download as JPG</button>
            <button id="print-invoice" onclick="window.print()">Print</button>
        </div>
        @yield('content')
    </div>

    <script>
        // Auto-fit content height
        window.addEventListener('load', function() {
            const content = document.getElementById('printable-content');
            const contentHeight = content.scrollHeight;
            document.body.style.height = contentHeight + 'px';
        });

        document.getElementById('download-invoice').addEventListener('click', function() {
            // Hide buttons
            document.querySelector('.save-button').style.display = 'none';

            html2canvas(document.getElementById('printable-content'), {
                width: 220, // 58mm = ~220px
                height: document.getElementById('printable-content').scrollHeight,
                scale: 2
            }).then(function(canvas) {
                var imageData = canvas.toDataURL('image/jpeg');

                fetch('/save-image', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            image: imageData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        var downloadLink = document.createElement('a');
                        downloadLink.href = data.downloadUrl;
                        downloadLink.download = data.fileName;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    })
                    .catch(error => {
                        console.error('Error saving image:', error);
                    });

                // Show buttons again
                document.querySelector('.save-button').style.display = 'block';
            });
        });
    </script>
</body>

</html>

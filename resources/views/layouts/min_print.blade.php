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
                font-family: 'Courier New', monospace;
                font-size: 9px;
                margin: 0;
                padding: 0;
                width: 80mm;
                line-height: 1.2;
                font-weight: bold;
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
            font-family: 'Courier New', monospace;
            font-size: 9px;
            margin: 0;
            padding: 0;
            width: 80mm;
            line-height: 1.2;
        }

        .container {
            width: 80mm;
            max-height: 210mm;
            margin: 0;
            padding: 2mm;
            box-sizing: border-box;
        }

        /* Rest of your styles remain the same */
        .header,
        .details,
        .products,
        .totals,
        .footer {
            margin: 1mm 0;
            padding: 0;
        }

        .header h3 {
            margin: 0;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }

        .products table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin: 2mm 0;
        }

        .products table th,
        .products table td {
            border: none;
            border-bottom: 1px dashed #000;
            padding: 1px 2px;
            text-align: left;
        }

        .products table th {
            font-weight: bold;
            border-bottom: 1px solid #000;
        }

        .totals p,
        .details p {
            margin: 1px 0;
            font-size: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;
            border-top: 1px dashed #000;
            padding-top: 2mm;
        }

        .container::after {
            content: "";
            display: block;
            height: 0;
            clear: both;
        }

        .save-button {
            margin-bottom: 5px;
        }

        .save-button button {
            padding: 5px 10px;
            font-size: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .thermal-line {
            border-bottom: 1px dashed #000;
            margin: 2px 0;
            padding-bottom: 2px;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .thermal-header {
            text-align: center;
            margin-bottom: 3mm;
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
            font-size: 10px;
            font-weight: bold;
            margin: 1mm 0;
            line-height: 1.1;
        }

        .thermal-line {
            border-bottom: 1px dashed #000;
            margin: 2mm 0;
            width: 100%;
        }

        /* Make all text bold and darker for thermal printer */
        * {
            font-weight: bold !important;
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
            font-weight: bold !important;
            text-shadow: 0.5px 0.5px 0 #000;
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

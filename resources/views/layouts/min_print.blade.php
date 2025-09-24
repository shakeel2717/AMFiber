<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=58mm, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thermal Invoice</title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: 58mm auto;
                /* Auto height based on content */
            }

            body {
                margin: 0;
                padding: 0;
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
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* Hide download button in print */
            .save-button {
                display: none !important;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            /* Better for thermal printers */
            font-size: 9px;
            margin: 0;
            padding: 0;
            width: 58mm;
            line-height: 1.2;
        }

        .container {
            width: 58mm;
            margin: 0;
            padding: 2mm;
            box-sizing: border-box;
        }

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

        /* Ensure no extra space at bottom */
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

        /* Thermal printer specific styles */
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

        @media print {
            .thermal-logo {
                max-width: 35mm;
                max-height: 12mm;
            }

            .company-name h1 {
                font-size: 9px;
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

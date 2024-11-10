<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=50mm, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
    <div class="container" id="printable-content">
        <div class="save-button">
            <button id="download-invoice">Download as JPG</button>
        </div>
        @yield('content')
    </div>
    <script>
        // // Function to automatically open the print dialog
        // function autoPrint() {
        //     window.print();
        // }

        // // Automatically call the print function on page load
        // window.onload = autoPrint;
    </script>
    <script>
        document.getElementById('download-invoice').addEventListener('click', function() {
            // Hide this button
            document.getElementById('download-invoice').style.display = 'none';
            
            html2canvas(document.getElementById('printable-content')).then(function(canvas) {
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
                    .then(response => response
                        .json()) // Change to response.json() to parse the JSON response
                    .then(data => {
                        // Create a download link using the URL returned by the server
                        var downloadLink = document.createElement('a');
                        downloadLink.href = data.downloadUrl; // Use the URL from the response
                        downloadLink.download = data.fileName; // Set a default filename
                        document.body.appendChild(downloadLink);
                        downloadLink.click(); // Trigger the download
                        document.body.removeChild(downloadLink); // Clean up
                    })
                    .catch(error => {
                        console.error('Error saving image:', error);
                    });

                // Show the button again after processing
                document.getElementById('download-invoice').style.display = 'inline';
            });
        });
    </script>
</body>

</html>

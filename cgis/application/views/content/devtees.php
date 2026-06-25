<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Fetch Example</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const requestOptions = {
                method: "POST",
                redirect: "follow"
            };

            fetch("https://ibs-unicorn.pelindo.co.id/api/ApiBupot/ValidasiNpwpV3?NPWP=021066204093000", requestOptions)
                .then(response => response.text())
                .then(result => {
                    document.getElementById("api-result").innerText = result;
                })
                .catch(error => {
                    document.getElementById("api-result").innerText = `Error: ${error}`;
                });
        });
    </script>
</head>
<body>
    <h1>API Fetch Example</h1>
    <div id="api-result">Loading...</div>
</body>
</html>

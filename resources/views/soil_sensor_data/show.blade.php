<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Moisture Sensor Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>Soil Moisture Sensor Data</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Moisture</th>
        <th>Timestamp</th>
    </tr>
    </thead>
    <tbody id="soil-data">
    <!-- Data will be inserted here -->
    </tbody>
</table>

<div id="error-message" class="error"></div>

<script>
    function fetchSoilData() {
        $.ajax({
            url: '/SensorDataCollector/public/api/get_latest_soil_data',
            method: 'GET',
            success: function(response) {
                $('#error-message').hide();
                $('#soil-data').html(
                    response.map(item =>
                        `<tr>
                            <td>${item.id}</td>
                            <td>${item.moisture}%</td>
                            <td>${item.created_at}</td>
                        </tr>`
                    ).join('')
                );
            },
            error: function(xhr, status, error) {
                $('#soil-data').empty();
                $('#error-message').text('Error fetching soil data: ' + error).show();
            }
        });
    }

    // Update data every 10 seconds
    setInterval(fetchSoilData, 10000);

    // Fetch data when the page loads
    $(document).ready(fetchSoilData);
</script>
</body>
</html>

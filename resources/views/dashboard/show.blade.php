@extends('dashboard.app')

@section('title', 'Temperature and Humidity Dashboard')

@section('content')
<div id="dashboard">
    <h1 class="text-center my-4">Temperature and Humidity Dashboard</h1>

    <div id="charts">
        <div id="chartTempDiv" class="chart-container"></div>
        <div id="chartHumidityDiv" class="chart-container"></div>
    </div>

    <div class="table-wrapper mt-4">
        <table class="table table-hover table-striped">
            <thead>
                <tr class="table-primary">
                    <th>ID</th>
                    <th>Humidity (%)</th>
                    <th>Temperature (°C)</th>
                    <th class="timestamp-column">Timestamp</th>
                </tr>
            </thead>
            <tbody id="temperature-data">
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>

    <div id="error-message" class="error mt-3"></div>
</div>
@endsection

@push('styles')
<style>
    body, html {
        background: linear-gradient(135deg, #0D47A1, #1976D2, #2196F3, #64B5F6);
        color: #eee;
        margin: 0;
        padding: 0;
        font-family: 'Trebuchet MS', sans-serif;
    }

    h1 {
        color: #fff;
    }

    #charts {
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
    }

    .chart-container {
        flex: 1;
        min-width: 100%;
        max-width: 100%;
        height: 300px;
        background-color: #1E88E5;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 10px;
    }

    @media (min-width: 768px) {
        #charts {
            flex-direction: row;
        }
        .chart-container {
            min-width: 45%;
            max-width: 45%;
        }
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        background-color: #0D47A1;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: #fff;
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 12px;
        text-align: left;
        white-space: nowrap; /* Prevents text from wrapping */
        word-wrap: break-word; /* Allows long words to break */
    }

    th {
        background-color: #1565C0;
        font-weight: bold;
    }

    .timestamp-column {
        min-width: 200px; /* Ensure enough space for long timestamps */
        max-width: 300px;
    }

    tr:nth-child(even) {
        background-color: #1976D2;
    }

    tr:nth-child(odd) {
        background-color: #1E88E5;
    }

    tr:hover {
        background-color: #0D47A1;
    }

    .error {
        color: #D32F2F;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Mobile-first styling */
    @media (max-width: 767px) {
        th, td {
            padding: 8px;
            font-size: 14px; /* Smaller font size for mobile */
        }

        .timestamp-column {
            min-width: 150px; /* Adjust as needed */
            max-width: 200px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        th {
            font-size: 6px; /* Larger font size for mobile */
            padding: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        var chartTemp = JSC.Chart('chartTempDiv', {
            type: 'line',
            series: [{ points: [] }],
            title_label_text: 'Temperature Distribution',
            xAxis: {
                defaultTick: { label_text: '' }
            },
            defaultTooltip: {
                template: '%seriesName: %value'
            }
        });

        var chartHumidity = JSC.Chart('chartHumidityDiv', {
            type: 'line',
            series: [{ points: [] }],
            title_label_text: 'Humidity Distribution',
            xAxis: {
                defaultTick: { label_text: '' }
            },
            defaultTooltip: {
                template: '%seriesName: %value'
            }
        });

        function fetchTemperatureData() {
            $.ajax({
                url: '{{ route("api.get_latest_temp_data") }}',
                method: 'GET',
                success: function(response) {
                    $('#error-message').hide();
                    var tempData = [];
                    var humidityData = [];
                    $('#temperature-data').html(
                        response.map(item => {
                            tempData.push({ name: item.id.toString(), y: item.temperature });
                            humidityData.push({ name: item.id.toString(), y: item.humidity });
                            return `<tr>
                                <td>${item.id}</td>
                                <td>${item.humidity}%</td>
                                <td>${item.temperature}°C</td>
                                <td>${formatDateTime(item.created_at)}</td>
                            </tr>`;
                        }).join('')
                    );

                    chartTemp.series(0).options({ points: tempData });
                    chartHumidity.series(0).options({ points: humidityData });
                },
                error: function(xhr, status, error) {
                    $('#temperature-data').empty();
                    $('#error-message').text('Error fetching temperature data: ' + error).show();
                }
            });
        }

        setInterval(fetchTemperatureData, 10000);
        fetchTemperatureData();
    });

    function formatDateTime(dateTimeString) {
            // Create a Date object from the ISO string
            var date = new Date(dateTimeString);

            // Format the date and time
            var options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };

            return date.toLocaleString('en-GB', options).replace(',', '');
        }
</script>
@endpush

@extends('dashboard.app')

@section('title', 'Temperature and Humidity Dashboard')

@section('content')
<div id="dashboard">
    <h1>Temperature and Humidity Dashboard</h1>

    <div id="charts">
        <div id="chartTempDiv"></div>
        <div id="chartHumidityDiv"></div>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Humidity (%)</th>
            <th>Temperature (°C)</th>
            <th>Timestamp</th>
        </tr>
        </thead>
        <tbody id="temperature-data">
        <!-- Data will be inserted here -->
        </tbody>
    </table>

    <div id="error-message" class="error"></div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var chartTemp = JSC.Chart('chartTempDiv', {
            type: 'line',
            series: [{ points: [] }],
            title_label_text: 'Temperature Distribution',
            xAxis: {
                defaultTick: { label_text: '' } // Remove tick labels
            },
            defaultTooltip: {
                template: '%seriesName: %value' // Show only the value in the tooltip
            }
        });

        var chartHumidity = JSC.Chart('chartHumidityDiv', {
            type: 'line',
            series: [{ points: [] }],
            title_label_text: 'Humidity Distribution',
            xAxis: {
                defaultTick: { label_text: '' } // Remove tick labels
            },
            defaultTooltip: {
                template: '%seriesName: %value' // Show only the value in the tooltip
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
                                <td>${item.created_at}</td>
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

        // Update data every 10 seconds
        setInterval(fetchTemperatureData, 10000);

        // Fetch data when the page loads
        fetchTemperatureData();
    });
</script>
@endpush

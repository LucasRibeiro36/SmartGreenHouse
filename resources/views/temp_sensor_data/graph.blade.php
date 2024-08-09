<!DOCTYPE html>
<html>
<head>
    <title>Chart</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jscharting.com/2.9.0/jscharting.js"></script>
</head>
<body>
<div id="chartTempDiv" style="width:100%; height:300px; margin:0 auto;"></div>
<div id="chartHumidityDiv" style="width:100%; height:300px; margin:0 auto;"></div>
<script>
    $(document).ready(function () {
        var chartTemp = JSC.Chart('chartTempDiv', {
            type: 'line',
            series: [
                {
                    points: []
                }
            ],
            title_label_text: 'Temperature Distribution',
            xAxis: {
                defaultTick: {
                    label_text: '' // Remove tick labels
                }
            },
            defaultTooltip: {
                template: '%seriesName: %value' // Show only the value in the tooltip
            }
        });

        var chartHumidity = JSC.Chart('chartHumidityDiv', {
            type: 'line',
            series: [
                {
                    points: []
                }
            ],
            title_label_text: 'Humidity Distribution',
            xAxis: {
                defaultTick: {
                    label_text: '' // Remove tick labels
                }
            },
            defaultTooltip: {
                template: '%seriesName: %value' // Show only the value in the tooltip
            }
        });

        function updateChart() {
            $.getJSON("/SensorDataCollector/public/api/get_latest_temp_data", function (org_data) {
                var tempData = [];
                var humidityData = [];
                $.each(org_data, function (key, val) {
                    tempData.push({ name: val.id.toString(), y: val.temperature_celsius });
                    humidityData.push({ name: val.id.toString(), y: val.humidity });
                });

                chartTemp.series(0).options({
                    points: tempData
                });
                chartHumidity.series(0).options({
                    points: humidityData
                });
            });
        }

        // Initial chart update
        updateChart();

        setInterval(updateChart, 10000);
    });
</script>
</body>
</html>

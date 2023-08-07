<script>
    "use strict";


    window.chartColors = {
        green: "#75c181",
        blue: "#5b99ea",
        gray: "#a9b5c9",
        red: "#ff6c60",
        text: "#252930",
        border: "#e7e9ed",
    };

    var doughnutChartConfig = {
        type: "doughnut",
        data: {
            datasets: [{
                data: [
                    @foreach ($patientsByDay as $patient)
                        "{{ $patient->total_patients }}",
                    @endforeach
                ],
                backgroundColor: [
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.gray,
                    window.chartColors.red,
                ],
                label: "Сумма",
            }, ],
            labels: [
                @foreach ($patientsByDay as $patient)
                    "{{ $patient->register_date }}",
                @endforeach
            ],
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: "bottom",
                align: "center",
            },

            tooltips: {
                titleMarginBottom: 10,
                bodySpacing: 10,
                xPadding: 16,
                yPadding: 16,
                borderColor: window.chartColors.border,
                borderWidth: 1,
                backgroundColor: "#fff",
                bodyFontColor: window.chartColors.text,
                titleFontColor: window.chartColors.text,

                animation: {
                    animateScale: true,
                    animateRotate: true,
                },

                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(
                            previousValue,
                            currentValue,
                            currentIndex,
                            array
                        ) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        return currentValue + " пациентов";
                    },
                },
            },
        },
    };

    window.addEventListener("load", function() {
        var doughnutChart = document
            .getElementById("chart-doughnut")
            .getContext("2d");
        window.myDoughnut = new Chart(doughnutChart, doughnutChartConfig);
    });
</script>

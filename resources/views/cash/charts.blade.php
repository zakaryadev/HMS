<script>
    "use strict";


    window.chartColors = {
        green: "#75c181",
        blue: "#5b99ea",
        gray: "#a9b5c9",
        red: "#ff6c60",
        yellow: "#f8d347",
        pink: "#f78db8",
        magenta: "#e84c8a",
        text: "#252930",
        border: "#e7e9ed",
    };

    var lineChartConfig = {
        type: "line",

        data: {
            labels: [
                @foreach ($ordersByDay as $order)
                    "{{ $order->order_date }}",
                @endforeach
            ],

            datasets: [{
                label: "Количество услуг",
                backgroundColor: "rgba(117,193,129,0.2)",
                borderColor: "rgba(117,193,129, 0.8)",
                data: [
                    @foreach ($ordersByDay as $order)
                        "{{ $order->total_orders }}",
                    @endforeach
                ],
            }, ],
        },
        options: {
            responsive: true,

            legend: {
                display: true,
                position: "bottom",
                align: "end",
            },
            tooltips: {
                mode: "index",
                intersect: false,
                titleMarginBottom: 10,
                bodySpacing: 10,
                xPadding: 16,
                yPadding: 16,
                borderColor: window.chartColors.border,
                borderWidth: 1,
                backgroundColor: "#fff",
                bodyFontColor: window.chartColors.text,
                titleFontColor: window.chartColors.text,
                callbacks: {
                    label: function(tooltipItem, data) {
                        return tooltipItem.value;
                    },
                },
            },
            hover: {
                mode: "nearest",
                intersect: true,
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,
                    },
                }, ],
                yAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(value, index, values) {
                            return value.toLocaleString() + "%";
                        },
                    },
                }, ],
            },
        },
    };

    var lineChartConfig2 = {
        type: "line",

        data: {
            labels: [
                @foreach ($canceledOrdersByDay as $order)
                    "{{ $order->order_date }}",
                @endforeach
            ],

            datasets: [{
                label: "Количество услуг",
                backgroundColor: "rgba(117,193,129,0.2)",
                borderColor: "rgba(117,193,129, 0.8)",
                data: [
                    @foreach ($canceledOrdersByDay as $order)
                        "{{ $order->total_orders }}",
                    @endforeach
                ],
            }, ],
        },
        options: {
            responsive: true,

            legend: {
                display: true,
                position: "bottom",
                align: "end",
            },

            tooltips: {
                mode: "index",
                intersect: false,
                titleMarginBottom: 10,
                bodySpacing: 10,
                xPadding: 16,
                yPadding: 16,
                borderColor: window.chartColors.border,
                borderWidth: 1,
                backgroundColor: "#fff",
                bodyFontColor: window.chartColors.text,
                titleFontColor: window.chartColors.text,
                callbacks: {
                    label: function(tooltipItem, data) {
                        return tooltipItem.value;
                    },
                },
            },
            hover: {
                mode: "nearest",
                intersect: true,
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,
                    },
                }, ],
                yAxes: [{
                    display: true,
                    gridLines: {
                        drawBorder: false,
                        color: window.chartColors.border,
                    },
                    scaleLabel: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        userCallback: function(value, index, values) {
                            return value.toLocaleString() + "%";
                        },
                    },
                }, ],
            },
        },
    };

    var doughnutChartConfig = {
        type: "doughnut",
        data: {
            datasets: [{
                data: [
                    @foreach ($ordersByDay as $order)
                        "{{ $order->total_amount_received }}",
                    @endforeach
                ],
                backgroundColor: [
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.gray,
                    window.chartColors.red,
                    window.chartColors.yellow,
                    window.chartColors.pink,
                    window.chartColors.magenta,
                ],
                label: "Сумма",
            }, ],
            labels: [
                @foreach ($ordersByDay as $order)
                    "{{ $order->order_date }}",
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
                        return currentValue + " сум";
                    },
                },
            },
        },
    };

    var doughnutChartConfig2 = {
        type: "doughnut",
        data: {
            datasets: [{
                data: [
                    {{ $returned_sum }},
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.gray,
                    window.chartColors.yellow,
                    window.chartColors.pink,
                    window.chartColors.magenta,
                ],
                label: "Сумма",
            }, ],
            labels: [
                "Возвращенная сумма",
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
                        return currentValue + " сум";
                    },
                },
            },
        },
    };

    window.addEventListener("load", function() {
        var lineChart = document.getElementById("chart-line").getContext("2d");
        window.myLine = new Chart(lineChart, lineChartConfig);
        var lineChart = document.getElementById("chart-line-2").getContext("2d");
        window.myLine = new Chart(lineChart, lineChartConfig2);
        var doughnutChart = document
            .getElementById("chart-doughnut")
            .getContext("2d");
        window.myDoughnut = new Chart(doughnutChart, doughnutChartConfig);
        var doughnutChart = document
            .getElementById("chart-doughnut-2")
            .getContext("2d");
        window.myDoughnut = new Chart(doughnutChart, doughnutChartConfig2);
    });
</script>

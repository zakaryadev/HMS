<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чек</title>
    <style>
        tr td:first-child {
            width: 40%;
        }

        tr td:second-child {
            width: 60%;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .table-bordered {
            border: 1px solid #000;
        }

        .table-bordered td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    Ф.И.О:
                                </td>
                                <td>
                                    {{ $patient->first_name . ' ' . $patient->last_name . ' ' . $patient->sur_name }}
                                </td>
                            </tr>
                            @if (count($orders) >= 1)
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}. Услуга
                                        </td>
                                        <td>
                                            {{ $order->service->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Сумма услуга
                                        </td>
                                        <td>
                                            {{ $order->price }} сум
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Регистратор
                                        </td>
                                        <td>
                                            {{ $order->registrar->user->first_name . ' ' . $order->registrar->user->last_name . ' ' . $order->registrar->user->sur_name }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (count($orders) > 1)
                                <tr>
                                    <td>
                                        Дата выдачи
                                    </td>
                                    <td>
                                        {{ date('d.m.Y | H:i') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Кассир
                                    </td>
                                    <td>
                                        {{ $order->cashier->user->first_name . ' ' . $order->cashier->user->last_name . ' ' . $order->cashier->user->sur_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Общая сумма
                                    </td>
                                    <td>
                                        {{ $total_price }} сум
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(() => {
                window.reload();
                console.log('reload');
            }, 1000);
        });
    </script>
</body>

</html>

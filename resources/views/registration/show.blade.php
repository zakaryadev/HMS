<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/portal.css" />
    <title>Карта пациента</title>
    <style>
        tr td:first-child {
            width: 40%;
        }

        tr td:second-child {
            width: 60%;
        }
    </style>
</head>

<body>
    <div class="container-lg">
        <button type="button" class="btn btn-label-brand btn-bold" onclick="window.print();">Печать</button>
        <div class="row">
            <div class="col">
                <h3 class="text-center mb-3">КАРТА ПАЦИЕНТА-{{ $patient->id }}</h3>
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
                            <tr>
                                <td>
                                    Дата рождения:
                                </td>
                                <td>
                                    {{ $patient->date_birth }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Дата регистраций:
                                </td>
                                <td>
                                    {{ $patient->created_at->format('d.m.Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Телефон:
                                </td>
                                <td>
                                    {{ $patient->phone_number }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Пол:
                                </td>
                                <td>
                                    {{ $patient->sex->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h3 class="text-center mb-3">ИСТОРИЯ ЗАБОЛЕВАНИЙ</h3>
                @if ($patient->orders->count() > 0)
                    @foreach ($patient->orders as $order)
                        @if ($order->doctor_id != null)
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Услуга</td>
                                        <td>
                                            {{ $order->service->name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Врач</td>
                                        <td>
                                            @if ($order->doctor)
                                                {{ $order->doctor->user->first_name . ' ' . $order->doctor->user->last_name . ' ' . $order->doctor->user->sur_name }}
                                            @else
                                                <span class="badge bg-danger">Услуга не оказано</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Назначение</td>
                                        <td>
                                            @if ($order->destination)
                                                {{ $order->destination }}
                                            @else
                                                <span class="badge bg-danger">Ничего не назначено</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Дата</td>
                                        <td>
                                            {{ $order->updated_at->format('d.m.Y | H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Сумма услуга</td>
                                        <td>
                                            <p>
                                                {{ $order->price }}
                                                <span class="badge bg-primary">сум</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Статус платежа</td>
                                        <td>
                                            <span
                                                class="badge {{ $order->paid_status_id == 2 || $order->paid_status_id == 3 ? 'bg-danger' : 'bg-primary' }}">
                                                {{ $order->paid_status->name }}
                                            </span>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @endforeach
                @else
                    <p>Нет записей</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>

<table class="table table-bordered order_table">
    <thead>
        <tr>
            <th width="2%">№</th>
            <th width="15%">Пациент</th>
            <th width="15%">Врач</th>
            <th width="10%">Услуга</th>
            <th width="5%">Сумма</th>
            <th width="12%">Статус платежа</th>
            <th width="15%">Тип платежа</th>
            <th width="15%">Время регистраций</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders)
            @foreach ($orders as $order)
                <tr>
                    <td scope="row">{{ $loop->index + 1 }}</td>
                    <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                    <td>{{ $order->doctor->user->first_name . ' ' . $order->doctor->user->last_name }}</td>
                    <td>{{ $order->service->name }}</td>
                    <td>{{ $order->price }}</td>
                    <td>
                        <span class="badge {{ badgeStatus($order) }}">
                            {{ $order->paid_status->name }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            {{ $order->payment_method->name }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d.m.Y | H:i') }}</td>
                </tr>
            @endforeach
            @if ($doctor_id == null)
                <tr>
                    <td>*</td>
                    <td>ИТОГ</td>
                    <td>Колво услуг {{ $orders->count() }}</td>
                    <td>Наличный {{ $paper_money }} сум</td>
                    <td>*</td>
                    <td>Карта {{ $card }} сум</td>
                    <td>*</td>
                    <td>Обшая {{ $orders->sum('price') }} сум</td>
                </tr>
            @else
                <tr>
                    <td>*</td>
                    <td>Наличный {{ $paper_money }} сум</td>
                    <td>*</td>
                    <td>Карта {{ $card }} сум</td>
                    <td>*</td>
                    <td>Обшая {{ $orders->sum('price') }} сум</td>
                    <td>*</td>
                    <td>Доля врача {{ $doctors_money }} сум</td>
                </tr>
            @endif
        @endif
    </tbody>
</table>

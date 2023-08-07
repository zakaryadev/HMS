@extends('layouts.registration')

@section('title', 'Направление на обследование')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="app-card p-3">
                <form action="{{ route('registration.send_doc_store', ['registration' => $patient->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Ф.И.О</label>
                        <input type="text" class="form-control mb-3" disabled
                            value="{{ $patient->first_name . ' ' . $patient->last_name . ' ' . $patient->sur_name }}">
                        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                        <input type="hidden" value="1" name="registrar_id">
                    </div>
                    <div class="mb-3">
                        <h4 class="mb-3">Сервисы</h4>
                        <table class="table table-bordered patient_table">
                            <thead>
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">Наименование</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">
                                        <label class="d-flex">
                                            <input type="checkbox" class="p-5 check-all">
                                            Выбрать все
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($positions as $position)
                                    @foreach ($position->services as $service)
                                        <tr>
                                            <td>
                                                <strong>
                                                    {{ $loop->index + 1 }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <h5>{{ $position->name }}</h5>
                                            </td>
                                            <td>
                                                <strong>
                                                    {{-- {{ $position->services->sum('price') }} --}}
                                                </strong>
                                            </td>
                                            <td>
                                                {{ $position->services->count() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td width="70%">
                                                <label class="d-flex">{{ $service->name }}</label>
                                            </td>
                                            <td width="10%">
                                                {{ $service->price }} сум
                                            </td>
                                            <td class="text-right">
                                                <input type="checkbox" class="p-5 checkbox" name="directions[]"
                                                    value="{{ $service->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('registration.index') }}" class="btn btn-secondary text-white"
                                style="width:200px;">Отмена</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary text-white"
                                style="width:200px;">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const checkAll = document.querySelector('.check-all');
        const checkbox = document.querySelectorAll('.checkbox');

        checkAll.addEventListener('change', function() {
            if (this.checked) {
                checkbox.forEach((item) => {
                    item.checked = true;
                })
            } else {
                checkbox.forEach((item) => {
                    item.checked = false;
                })
            }
        })
    </script>
@endsection

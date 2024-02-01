@extends('app.my-layout')
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        window.location.href = data.paymentUrl.checkout_url;
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        alert('Ошибка при обработке платежа.');
                    });
            });
        });
    </script>
@endsection
@section('content')
    <h1>Форма оплаты</h1>
    <form id="paymentForm" action="{{ route('payment.fondy.processPayment') }}" method="POST">
        @csrf
        <label for="amount">Сумма платежа (в центах):</label><br>
        <input type="text" id="amount" name="amount" required><br><br>
        <input type="submit" value="Оплатить">
    </form>
@endsection

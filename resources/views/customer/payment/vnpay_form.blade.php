<form method="POST" action="{{ route('vnpay.payment') }}">
    @csrf
    <label>Số tiền (VND)</label>
    <input type="number" name="amount" value="100000" min="1000" required>
    <button type="submit">Thanh toán VNPay (Test)</button>
</form>
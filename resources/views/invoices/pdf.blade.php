<!DOCTYPE html>
<html>

<head>
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .receipt {
            width: 210mm;
            max-width: 100%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-header h1 {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            color: #0056b3;
        }

        .receipt-header p {
            margin: 4px 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .divider {
            border-top: 2px solid #0056b3;
            margin: 20px 0;
        }

        .receipt-info {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .receipt-info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
            font-weight: bold;
            color: #0056b3;
        }

        td {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        .footer p {
            margin: 4px 0;
            font-weight: bold;
            color: #333;
        }

        .footer p.amount-due {
            font-size: 20px;
            color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Satya Graha Hotel</h1>
            <p>Invoice</p>
            <p><strong>Order Code:</strong> {{ $invoice->reservation->order_code }}</p>
            <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="divider"></div>

        <div class="receipt-info">
            <p><strong>Customer:</strong> {{ $invoice->reservation->customer->name }}</p>
            <p><strong>Agency:</strong> {{ $invoice->reservation->customer->agency }}</p>
            <p><strong>Reservation Category:</strong> {{ $invoice->reservation->resCategory->name }}</p>
            <p><strong>Number of Pax:</strong> {{ $invoice->reservation->pax }}</p>
            <p><strong>Rate per Pax:</strong> {{ number_format($invoice->reservation->rate, 0, '.', '.') }}</p>
        </div>

        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->reservation->resCategory->name }}</td>
                    <td>{{ number_format($invoice->reservation->rate, 0, '.', '.') }}</td>
                    <td>{{ $invoice->reservation->pax }}</td>
                    <td>{{ number_format($invoice->reservation->rate * $invoice->reservation->pax, 0, '.', '.') }}</td>
                </tr>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->rate, 0, '.', '.') }}</td>
                    <td>{{ $item->pax }}</td>
                    <td>{{ number_format($item->rate * $item->pax, 0, '.', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total:</td>
                    <td>{{ number_format($invoice->items->sum(fn($item) => $item->rate * $item->pax) + ($invoice->reservation->rate * $invoice->reservation->pax), 0, '.', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h2>Payments</h2>
        @if($invoice->payments->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments as $payment)
                <tr>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->transaction_id }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>{{ number_format($payment->transaction->nominal, 0, '.', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No payments recorded.</p>
        @endif

        <div class="footer">
            <p class="amount-due"><strong>Amount Due:</strong> Rp. {{ number_format(($invoice->items->sum(fn($item) => $item->rate * $item->pax) + ($invoice->reservation->rate * $invoice->reservation->pax)) - $invoice->payments->sum('transaction.nominal'), 0, '.', '.') }}</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>
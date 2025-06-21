<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { background: #fff; padding: 24px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        .btn { background: #198754; color: #000 !important; padding: 10px 18px; border-radius: 5px; text-decoration: none; }
        .table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        .table th, .table td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
        .table th { background: #f1f1f1; }
        .total-row td { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank you for your order!</h2>
        <p>Dear {{ $order->user->name }},</p>
        <p>We appreciate you choosing Wedding Management System for your special day. Here are your order details:</p>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Price (AED)</th>
                    <th>Quantity</th>
                    <th>Subtotal (AED)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order->items as $item)
                    @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->service->name ?? 'N/A' }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;">Total</td>
                    <td>{{ number_format($total, 2) }} AED</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 24px;">
            <a href="http://weddinginuae.com/services" class="btn">Explore More Services</a>
        </p>
        <p style="margin-top: 24px;">Thank you again for trusting us. We wish you a wonderful celebration!</p>
        <p style="color: #888;">&mdash; Wedding Management System Team</p>
    </div>
</body>
</html>

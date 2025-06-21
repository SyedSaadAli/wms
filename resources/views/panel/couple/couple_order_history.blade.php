<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Couple Profile - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #f0f0f0;
            padding: 20px;
            height: 100vh;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
        }
        .sidebar a:hover {
            color: #007bff;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 sidebar">
                <ul>
                    <li><a href="{{ route('couple.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('couple.profile.view') }}">Profile</a></li>
                    <li><a href="{{ route('couple.booking.details') }}">Booking Details</a></li>
                    <li><a href="{{ route('couple.order.history') }}">Order History</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="text-decoration: none; color: inherit;">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 content">
                <h2>Order history</h2>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($orders->isEmpty())
                    <div class="alert alert-info">You have no orders yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order Date</th>
                                    <th>Items</th>
                                    <th>Total Price (AED)</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <ul class="mb-0">
                                                @foreach($order->items as $item)
                                                    <li>
                                                        {{ $item->service->name ?? 'N/A' }} (x{{ $item->quantity }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modals for order details -->
                    @foreach($orders as $order)
                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order #{{ $order->id }} Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
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
                                                <tr class="table-secondary">
                                                    <td colspan="4" class="text-end fw-bold">Total</td>
                                                    <td class="fw-bold">{{ number_format($total, 2) }} AED</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@extends('../../panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Orders</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('../../panel._message')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">All Orders</h5>
                            </div>

                        </div>
                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Total Price (AED)</th>
                                    <th>Order Date</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>{{ $order->user->email ?? 'N/A' }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                View Order
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        <!-- Modals (place after the table) -->
                        @foreach($orders as $order)
                            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order #{{ $order->id }} Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>User:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? 'N/A' }})</p>
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

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

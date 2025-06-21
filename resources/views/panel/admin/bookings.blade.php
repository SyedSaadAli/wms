@extends('../../panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Bookings</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('../../panel._message')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">All Bookings</h5>
                            </div>

                        </div>
                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Booked By</th>
                                    <th scope="col">Venue Name</th>
                                    <th scope="col">Venue Image</th>
                                    <th scope="col">Booking Date</th>
                                    <th scope="col">Guest Count</th>
                                    <th scope="col">Event Start Time</th>
                                    <th scope="col">Event End Time</th>
                                    <th scope="col">Special Requests</th>
                                    <th scope="col">Booked On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $value)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $value->user->name ?? 'N/A' }}</td>
                                        <td>{{ $value->venue->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($value->venue && $value->venue->image_name)
                                                <img src="{{ asset('venue_images/' . $value->venue->image_name) }}"
                                                    alt="Venue Image" width="80" height="80"
                                                    style="object-fit:cover;">
                                            @else
                                                <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image"
                                                    width="80" height="80" style="object-fit:cover;">
                                            @endif
                                        </td>
                                        <td>{{ $value->booking_date }}</td>
                                        <td>{{ $value->guest_count }}</td>
                                        <td>{{ $value->event_start_time }}</td>
                                        <td>{{ $value->event_end_time }}</td>
                                        <td>{{ $value->special_requests ?? 'None' }}</td>
                                         <td>{{ $value->created_at ? $value->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

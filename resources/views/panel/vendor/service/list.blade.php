@extends('panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Venues</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('panel._message')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Venue List</h5>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{ url('panel/vendor/venue/add') }}" class="btn btn-primary" style="margin-top: 10px;">Add Venue</a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Event Type</th>
                                    <th scope="col">Ambience</th>
                                    <th scope="col">Guest Capacity</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venues as $value)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <img src="{{ asset('venue_images/' . $value->image_name) }}" alt="Venue Image" style="width: 100px; height: 100px; object-fit: cover;">
                                        </td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>{{ number_format($value->price, 0) }}</td>
                                        <td>{{ $value->address }}</td>
                                        <td>{{ $value->event_type }}</td>
                                        <td>{{ $value->ambience }}</td>
                                        <td>{{ $value->guest_capacity }}</td>
                                        <td>{{ $value->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ url('panel/vendor/venue/edit/' . $value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ url('panel/vendor/venue/delete/' . $value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
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

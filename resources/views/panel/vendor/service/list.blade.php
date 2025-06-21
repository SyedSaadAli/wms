@extends('panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Services</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('panel._message')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Service List</h5>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{ url('panel/vendor/service/add') }}" class="btn btn-primary"
                                    style="margin-top: 10px;">Add Service</a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $value)
                                        <tr>
                                            <th scope="row" class="text-wrap"
                                                style="max-width: 80px; word-break: break-word;">{{ $loop->iteration }}
                                            </th>
                                            <td>
                                                <img src="{{ asset('service_images/' . $value->image) }}"
                                                    alt="Service Image"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            </td>
                                            <td class="text-wrap" style="max-width: 200px; word-break: break-word;">
                                                {{ $value->name }}
                                            </td>
                                            <td class="text-wrap" style="max-width: 250px; word-break: break-word;">
                                                {{ $value->description }}
                                            </td>
                                            <td class="text-wrap" style="max-width: 120px; word-break: break-word;">
                                                {{ number_format($value->price, 0) }}
                                            </td>
                                            <td class="text-wrap" style="max-width: 180px; word-break: break-word;">
                                                {{ $value->location }}
                                            </td>
                                            <td class="text-wrap" style="max-width: 160px; word-break: break-word;">
                                                {{ $value->created_at->format('d M, Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="{{ url('panel/vendor/service/edit/' . $value->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{ url('panel/vendor/service/delete/' . $value->id) }}"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

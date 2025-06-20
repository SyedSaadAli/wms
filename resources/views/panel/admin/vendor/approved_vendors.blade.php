@extends('panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Vendors</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('panel._message')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Approved Vendors</h5>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Vendor Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Profile Name</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $vendor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $vendor->name }}</td>
                                        <td>
                                            @if ($vendor->profile && $vendor->profile->image_name)
                                                <img src="{{ asset('profile_images/' . $vendor->profile->image_name) }}"
                                                    alt="Profile Image" width="120" height="120"
                                                    style="object-fit:cover; border-radius:0;">
                                            @else
                                                <img src="https://via.placeholder.com/50x50?text=No+Image" alt="No Image"
                                                    width="50" height="50"
                                                    style="object-fit:cover; border-radius:50%;">
                                            @endif
                                        </td>
                                        <td>{{ $vendor->profile->name ?? 'N/A' }}</td>
                                        <td>{{ $vendor->profile->description ?? 'N/A' }}</td>
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

@extends('../../panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Vendors</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('../../panel._message')

                <div class="card">
                    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                        <h5 class="card-title">Vendors List</h5>
            </div>

                    </div>
                        <!-- Table with stripped rows -->
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            @if($value->is_approved == 'approved')
                                                Approved
                                            @elseif ($value->is_approved == 'rejected')
                                                Rejected
                                            @else
                                            <a href="{{ url('panel/admin/vendor/approve/' . $value->id) }}"
                                                class="btn btn-primary btn-sm">Approve</a>
                                            <a href="{{ url('panel/admin/vendor/reject/' . $value->id) }}"
                                                class="btn btn-danger btn-sm">Reject</a>
                                            @endif
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

@extends('panel.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Business Profile</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                @include('panel._message')


                @if (!$profile)
                    <div class="col-md-6" style="text-align: right;">
                        <a href="{{ url('panel/vendor/profile/add') }}" class="btn btn-primary" style="margin-top: 10px;">Add
                            Profile</a>
                    </div>
                @else
                    <div class="card">
                        <div class="col-md-6 text-end">
                            <a href="{{ url('panel/vendor/profile/edit/' . $profile->id) }}" class="btn btn-primary" style="margin-top: 10px;">
                                <i class="fas fa-pencil-alt"></i>Edit Profile
                            </a>
                        </div>
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="{{ asset('profile_images/' . $profile->image_name) }}" alt="Profile" class="rounded-circle"style="width: 150px; height: 150px; object-fit: cover;">
                            <h2>{{ $profile->name }}</h2>
                            <h3>{{ $profile->description }}</h3>

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection

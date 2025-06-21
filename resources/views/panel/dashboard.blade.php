@extends('panel.layouts.app')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
</div><!-- End Page Title -->

<section class="section dashboard" style="min-height:80vh;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            @if($role_id == 1)
                <!-- Admin: Vendors -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Vendors</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalVendors }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Total Vendors</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Admin: Bookings -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Bookings</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalBookings }}</h6>
                                    <span class="text-muted small pt-2 ps-1">Total Bookings</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Venues Card (Admin & Vendor) -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Venues</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info text-white">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalVenues }}</h6>
                                <span class="text-muted small pt-2 ps-1">Total Venues</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Services Card (Admin & Vendor) -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Services</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalServices }}</h6>
                                <span class="text-muted small pt-2 ps-1">Total Services</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Orders Card (Admin & Vendor) -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                <i class="bi bi-bag"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalOrders }}</h6>
                                <span class="text-muted small pt-2 ps-1">Total Orders</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

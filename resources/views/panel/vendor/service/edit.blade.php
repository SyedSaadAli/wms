@extends('panel.layouts.app')
@section('content')

    <div class="pagetitle">
      <h1>Edit New Role</h1>
    </div>

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Edit New Role</h5>

                <!-- Add New Role -->
                <form method="post" action="{{ url('panel/vendor/venue/edit/'.$getRecord->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="image" class="col-sm-12 col-form-label">Image</label>
                            <div class="col-sm-12">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            @if ($getRecord->image_name)
                            <img src="{{ asset('venue_images/' . $getRecord->image_name) }}" alt="Profile" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        @endif
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="col-sm-12 col-form-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" name="name" id="name" value="{{ $getRecord->name }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea name="description" id="description" class="form-control">{{ $getRecord->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="col-sm-12 col-form-label">Price</label>
                            <div class="col-sm-12">
                                <input type="number" name="price" id="price" value="{{ $getRecord->price }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="col-sm-12 col-form-label">Address</label>
                            <div class="col-sm-12">
                                <textarea name="address" id="address" class="form-control">{{ $getRecord->address }}</textarea>
                            </div>
                        </div>
                        <!-- New Fields -->
                        <div class="col-md-6">
                            <label for="event_type" class="col-sm-12 col-form-label">Event Type</label>
                            <div class="col-sm-12">
                                <select name="event_type" id="event_type" class="form-control">
                                    <option value="Birthday Party" {{ $getRecord->event_type == 'Birthday Party' ? 'selected' : '' }}>Birthday Party</option>
                                    <option value="Wedding" {{ $getRecord->event_type == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                                    <option value="Corporate Event" {{ $getRecord->event_type == 'Corporate Event' ? 'selected' : '' }}>Corporate Event</option>
                                    <option value="Anniversary" {{ $getRecord->event_type == 'Anniversary' ? 'selected' : '' }}>Anniversary</option>
                                    <option value="Other" {{ $getRecord->event_type == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="ambience" class="col-sm-12 col-form-label">Ambience</label>
                            <div class="col-sm-12">
                                <select name="ambience" id="ambience" class="form-control">
                                    <option value="Luxury" {{ $getRecord->ambience == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                                    <option value="Classic" {{ $getRecord->ambience == 'Classic' ? 'selected' : '' }}>Classic</option>
                                    <option value="Elegant" {{ $getRecord->ambience == 'Elegant' ? 'selected' : '' }}>Elegant</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="guest_capacity" class="col-sm-12 col-form-label">Guest Capacity</label>
                            <div class="col-sm-12">
                                <input type="number" name="guest_capacity" id="guest_capacity" value="{{ $getRecord->guest_capacity }}" class="form-control">
                            </div>
                        </div>
                    </div><br>

                  <div class="row mb-3">
                    <div class="col-sm-12" >
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>

                </form><!-- End General Form Elements -->

              </div>
            </div>

          </div>
        </div>
      </section>


@endsection

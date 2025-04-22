
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
                <form method="post" action="{{ url('panel/vendor/profile/edit/'.$getRecord->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-6">
                        <label for="image" class="col-sm-12 col-form-label">Image</label>
                        <div class="col-sm-12">
                            <input type="file" name="image" id="image" class="form-control">
                            @if ($getRecord->image_name)
                                <img src="{{ asset('profile_images/' . $getRecord->image_name) }}" alt="Profile" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                    <label for="name" class="col-sm-12 col-form-label">Name</label>
                    <div class="col-sm-12">
                      <input type="text" name="name" id="name" value="{{ $getRecord->name }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="description" class="col-sm-12 col-form-label">Description</label>
                    <div class="col-sm-12">
                      <textarea name="description" id="description" class="form-control">{{ $getRecord->description }}</textarea>
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

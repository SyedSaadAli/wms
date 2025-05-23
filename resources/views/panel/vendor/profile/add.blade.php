@extends('panel.layouts.app')
@section('content')

    <div class="pagetitle">
      <h1>Add New Venue</h1>
    </div>

    <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Profile</h5>

                <!-- Add Business Profile -->
                <form method="post" action="{{ url('panel/vendor/profile/add') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-6">
                        <label for="image" class="col-sm-12 col-form-label">Image</label>
                        <div class="col-sm-12">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <label for="name" class="col-sm-12 col-form-label">Name</label>
                    <div class="col-sm-12">
                      <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="description" class="col-sm-12 col-form-label">Description</label>
                    <div class="col-sm-12">
                      <textarea name="description" id="description" value="{{ old('description') }}" class="form-control"></textarea>
                    </div>
                  </div>

                  </div><br>
                  <div class="row mb-3">
                    <div class="col-sm-12" >
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>

                </form><!-- End General Form Elements -->

              </div>
            </div>

          </div>
        </div>
      </section>


@endsection

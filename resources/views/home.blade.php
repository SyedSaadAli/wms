<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Wedding Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/venues') }}">Venues</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/vendors') }}">Vendors</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ url('/couple/dashboard') }}">Dashboard</a></li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            @endif
                        @endauth
                @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            <h1>Your Dream Wedding, Simplified.</h1>
            <p class="lead">Discover the perfect venues, vendors, and tools to plan your unforgettable day.</p>
            <a href="{{ url('/register') }}" class="btn btn-primary btn-lg">Start Planning Now</a>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <h2>About Wedding Management System</h2>
            <p>Welcome to Wedding Management System, your one-stop solution for planning the perfect wedding. We understand that planning a wedding can be overwhelming, which is why we've created a platform that simplifies every aspect of the process. From finding the ideal venue to connecting with trusted vendors, our system empowers you to create the wedding of your dreams with ease. Our AI-driven recommendations and real-time availability updates ensure a seamless and stress-free experience, allowing you to focus on what truly matters: celebrating your love.</p>
            <div class="row mt-5">
                <div class="col-md-6">
                    <img src="images/venue.jpg" class="img-fluid" alt="Wedding Venue">
                </div>
                <div class="col-md-6">
                    <p>Our platform offers a curated selection of stunning venues, catering to a variety of styles and budgets. Whether you envision a grand ballroom affair or an intimate garden ceremony, we have the perfect setting for your special day. Our comprehensive vendor directory connects you with experienced professionals, including photographers, florists, and entertainers, ensuring that every detail of your wedding is executed flawlessly.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-light">
        <div class="container">
            <h2>Key Features for Couples</h2>
            <div class="row">
                <div class="col-md-4 feature">
                    <i class="fas fa-search"></i>
                    <h3>Venue Discovery</h3>
                    <p>Explore a curated selection of venues with detailed descriptions and images.</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Real-Time Booking</h3>
                    <p>Check availability and book venues and services instantly.</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-comments"></i>
                    <h3>Vendor Communication</h3>
                    <p>Connect and communicate directly with vendors for seamless planning.</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 feature">
                    <i class="fas fa-robot"></i>
                    <h3>AI Recommendations</h3>
                    <p>Receive personalized suggestions based on your preferences and budget.</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-bell"></i>
                    <h3>Automated Reminders</h3>
                    <p>Stay on track with timely notifications and reminders.</p>
                </div>
                <div class="col-md-4 feature">
                    <i class="fas fa-star-half-alt"></i>
                    <h3>Reviews & Ratings</h3>
                    <p>Make informed decisions with user reviews and ratings.</p>
                </div>
            </div>
        </div>
    </section>
    @auth
    <div id="chat-box" style="...">
        <div id="messages">
            <p>Sample message</p>
        </div>
        <form id="chat-form">
            <input type="text" id="message-input">
            <button type="submit">Send</button>
        </form>
    </div>

      @endauth
    @if(isset($showSurvey) && $showSurvey)
    <!-- Survey Modal -->
    <div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('survey.submit') }}">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="surveyModalLabel">Tell us about your preferences</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label>What kind of event are you planning?</label>
                <input type="text" class="form-control" name="event_type" required>
              </div>
              <div class="mb-3">
                <label>How many guests are you expecting?</label>
                <input type="number" class="form-control" name="guest_capacity" required>
              </div>
              <div class="mb-3">
                <label>Preferred ambience?</label>
                <input type="text" class="form-control" name="ambience" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Wedding Management System</p>
    </footer>
    <script>
      window.onload = function () {
        $('#surveyModal').modal('show');
      };
    </script>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

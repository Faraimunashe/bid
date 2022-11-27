<x-app-layout>
    <div class="pagetitle">
        <h1>Vehicles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Vehicles</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @foreach ($vehicles as $vehicle)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{$vehicle->make}} {{$vehicle->model}} <code>-{{$vehicle->condition}}</code></h5>
                            <!-- Slides only carousel -->
                            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item">
                                        <img src="{{asset('images')}}/{{$vehicle->file}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{asset('images')}}/{{$vehicle->file}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item active">
                                        <img src="{{asset('images')}}/{{$vehicle->file}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div><!-- End Slides only carousel-->
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-dark mb-2">
                                Minimum <span class="badge bg-white text-dark">${{$vehicle->price}}</span>
                            </button>
                            <button type="button" class="btn btn-dark mb-2">
                                Highest <span class="badge bg-white text-danger">${{get_highest_bid($vehicle->d)}}</span>
                            </button>
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#largeModal{{$vehicle->id}}">
                                <i class="bi bi-briefcase"></i>
                                Bid
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="largeModal{{$vehicle->id}}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('user-place-bid') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Bid this Vehicle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}" required>
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Amount: </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="amount" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Place Bid</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End Large Modal-->
            @endforeach
        </div>
    </section>
</x-app-layout>

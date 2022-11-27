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
            <!-- Left side columns -->
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
            <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h5 class="card-title">Vehicles</h5>
                                    </div>
                                    <div class="col-md-2 mt-3 justify-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#largeModal">Add New</button>
                                    </div>
                                </div>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Vehicle</th>
                                            <th scope="col">Condition</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($vehicles as $vehicle)
                                            <tr>
                                                <th scope="row">
                                                    <a href="#">
                                                        @php
                                                            $count++;
                                                            echo $count;
                                                        @endphp
                                                    </a>
                                                </th>
                                                <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                                                <td>{{ $vehicle->condition }}</td>
                                                <td>{{ $vehicle->price }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $vehicle->id }}">Change</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#smallModal{{ $vehicle->id }}">Remove</button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="smallModal{{ $vehicle->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin-delete-product') }}">
                                                            @csrf
                                                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Vehicles</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete {{ $vehicle->name }} from vehicle?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Yes delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Delete Modal-->
                                            <div class="modal fade" id="editModal{{ $vehicle->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin-update-product') }}">
                                                            @csrf
                                                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Category</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Make: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="make" value="{{$vehicle->make}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Model: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="model" value="{{$vehicle->model}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Condition: </label>
                                                                    <div class="col-sm-10">
                                                                        <select name="condition" class="form-control" required>
                                                                            <option value="New">New</option>
                                                                            <option value="Second Hand">Second Hand</option>
                                                                            <option value="Old">Old</option>
                                                                            <option value="Damaged">Damaged</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="price" value="{{$vehicle->price}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Image: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="file" name="image" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Edit Modal-->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
    <div class="modal fade" id="largeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-add-product') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Make: </label>
                            <div class="col-sm-10">
                                <input type="text" name="make" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Model: </label>
                            <div class="col-sm-10">
                                <input type="text" name="model" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Condition: </label>
                            <div class="col-sm-10">
                                <select name="condition" class="form-control" required>
                                    <option value="New">New</option>
                                    <option value="Second Hand">Second Hand</option>
                                    <option value="Old">Old</option>
                                    <option value="Damaged">Damaged</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Price: </label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Image: </label>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
</x-app-layout>

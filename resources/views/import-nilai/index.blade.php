@extends('layouts.main-layout.app')
@section('title', 'Home')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">

                    <form class="row g-3" method="post" action="{{ route('import-nilai.upload') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 col-md-12">
                            <label class="form-label">Import File</label>
                            <input type="file" class="form-control" name="crypt_file" accept=".crypt" required />
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection

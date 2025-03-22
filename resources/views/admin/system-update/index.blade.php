@extends('admin.layouts.main')
@section('title')
    {{ __('SYSTEM_UPDATE') }}
@endsection
@section('pre-title')
    {{ __('SYSTEM_UPDATE') }}
@endsection
@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                <a href="{{ url('admin/dashboard') }}">Home/</a>
                <a href="{{ url('admin/settings') }}">Settings/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
    </div>
@endsection
@section('content')
    <section class="section">

        <div class="alert alert-primary alert-dismissible" role="alert">
            {{-- Add this to tags --}}
            Clear your browser cache by pressing <kbd> CTRL+F5 </kbd> after updating the system.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card">

            <form class="create-form" action="{{ route('system-update.update') }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}

                <h4 class="card-header">
                    <div class="card-title">
                        <span class=" text-primary"> Current Version
                            <span class="badge bg-danger-lt">
                                {{ $system_version->version ?? '1.0.0' }}
                            </span>
                        </span>
                    </div>
                </h4>

                <div class="card-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <input name="update_file" hidden id="update-file" type="file" class="zip-pond">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center d-flex justify-content-center align-items-center">
                    {{-- Language update --}}
                    <button type="submit" name="btnAdd1" value="btnAd" class="btn btn-primary w-25 col-form-label">
                        Update the system
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

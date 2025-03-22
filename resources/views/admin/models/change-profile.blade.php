<!-- Change Profile Model Ends -->
@extends('admin.layouts.main'){{-- Update the path to where `main.blade.php` is located --}}

@section('title', __('Change Profile'))

@section('page-title')
    <h2>{{ __('Change Profile') }}</h2>
@endsection

@section('content')
    <!-- Change Profile Form -->
    <div class="container">
        <form action="{{ route('change-profile.update') }}" class="form-horizontal" id="changeProfileForm"
            enctype="multipart/form-data" method="POST" data-parsley-validate>
            @csrf
            <div class="card">
                {{-- <div class="card-header">
                    <h5 class="card-title">{{ __('PROFILE_DETAILS') }}</h5>
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="name" class="form-label">{{ __('NAME') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Please enter channel name" value="{{ auth()->user()->name ?? '' }}"
                                        required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="email" class="form-label">{{ __('EMAIL') }}</label>
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="Please enter Email" value="{{ auth()->user()->email ?? ''}}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="change-profile" class="form-label">{{ __('PROFILE') }}</label>
                                    <input type="file" name="profile" id="change-profile" class="form-control">
                                    <div class="mt-3 mb-3">
                                        <img id="change-profile-privew" src="{{ auth()->user()->profile ?? asset('assets/images/faces/2.jpg') }}" alt="Logo Preview" class="img-privew">
                                        @if ($errors->has('profile'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('profile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit"  class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
    
@endsection

@section('css')
    <!-- Additional CSS if needed -->
@endsection

@section('js')
    <!-- Additional JavaScript if needed -->
@endsection

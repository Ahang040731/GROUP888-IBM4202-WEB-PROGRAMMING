@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container py-5" style="background-color: #f2f4f8; min-height: 90vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-success text-black text-center">
                    <h2 class="mb-0">👤 User Profile</h2>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Username -->
                        <div class="row mb-4 justify-content-center align-items-center">
                            <label class="col-4 col-form-label fw-bold text-end">Username</label>
                            <div class="col-6">
                                <input type="text" name="username" class="form-control text-center border border-secondary" value="{{ $user->username }}">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row mb-4 justify-content-center align-items-center">
                            <label class="col-4 col-form-label fw-bold text-end">Phone</label>
                            <div class="col-6">
                                <input type="text" name="phone" class="form-control text-center border border-secondary" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mb-4 justify-content-center align-items-center">
                            <label class="col-4 col-form-label fw-bold text-end">Address</label>
                            <div class="col-6">
                                <input type="text" name="address" class="form-control text-center border border-secondary" value="{{ $user->address }}">
                            </div>
                        </div>

                        <!-- Photo -->
                        <div class="row mb-4 justify-content-center align-items-center">
                            <label class="col-4 col-form-label fw-bold text-end">Photo</label>
                            <div class="col-6">
                                <input type="file" name="photo" class="form-control border border-secondary">
                                @if($user->photo)
                                    <img src="{{ asset('storage/'.$user->photo) }}" width="120" class="mt-2 rounded-circle shadow-sm d-block mx-auto">
                                @endif
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success w-100 btn-lg">Update Profile</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

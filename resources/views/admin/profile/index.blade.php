@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="container mt-5">
    <h2 class="mb-5 text-center">👤 Admin Profile</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mx-auto" style="max-width: 600px; background-color: #f8f9fa; padding: 30px; border-radius: 10px;">
            
            <!-- Username -->
            <div class="row mb-4 justify-content-center align-items-center">
                <label class="col-4 col-form-label fw-bold text-end">Username</label>
                <div class="col-6">
                    <input type="text" name="username" class="form-control text-center border border-secondary" value="{{ $admin->username }}">
                </div>
            </div>

            <!-- Phone -->
            <div class="row mb-4 justify-content-center align-items-center">
                <label class="col-4 col-form-label fw-bold text-end">Phone</label>
                <div class="col-6">
                    <input type="text" name="phone" class="form-control text-center border border-secondary" value="{{ $admin->phone }}">
                </div>
            </div>

            <!-- Address -->
            <div class="row mb-4 justify-content-center align-items-center">
                <label class="col-4 col-form-label fw-bold text-end">Address</label>
                <div class="col-6">
                    <input type="text" name="address" class="form-control text-center border border-secondary" value="{{ $admin->address }}">
                </div>
            </div>

            <!-- Photo -->
            <div class="row mb-4 justify-content-center align-items-center">
                <label class="col-4 col-form-label fw-bold text-end">Photo</label>
                <div class="col-6">
                    <input type="file" name="photo" class="form-control">
                    @if($admin->photo)
                        <img src="{{ asset('storage/'.$admin->photo) }}" class="mt-2 d-block mx-auto" style="width: 100px; border-radius: 5px;">
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <button type="submit" class="btn btn-primary px-5">Update Profile</button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

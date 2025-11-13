@extends('layouts.admin') {{-- ✅ 改成 admin layout --}}

@section('title', 'Admin Profile')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg rounded-4 p-5" style="max-width: 600px; width: 100%;">
        <h3 class="text-center mb-4 text-primary">👤 Admin Profile</h3>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Username -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" value="{{ $admin->username }}" class="form-control" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" value="{{ $admin->phone }}" class="form-control">
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Address</label>
                <input type="text" name="address" value="{{ $admin->address }}" class="form-control">
            </div>

            <!-- Photo -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Photo</label>
                <input type="file" name="photo" class="form-control">
                @if($admin->photo)
                    <div class="text-center mt-3">
                        <img src="{{ asset('storage/'.$admin->photo) }}" class="rounded shadow" width="100" height="100" style="object-fit:cover;">
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                <a href="{{ route('admin.homepage') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

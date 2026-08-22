@extends('themes.default.layouts.master')

@section('title', 'My Profile | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Profile Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 fs-14 mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 fs-14 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Personal Info --}}
                    <div class="card border-light-subtle shadow-sm rounded-4 bg-white mb-4">
                        <div class="card-header bg-white border-bottom px-4 py-3 rounded-top-4">
                            <h5 class="mb-0 fw-bold fs-16 text-dark"><i class="bi bi-person me-2 text-primary"></i>Personal Information</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Profile Picture --}}
                            <div class="d-flex align-items-center gap-4 mb-4">
                                <div id="picPreviewWrap">
                                    @if($customer->pic)
                                        <img src="{{ getImageUrl($customer->pic) }}" id="picPreview"
                                            class="rounded-circle border border-primary p-1"
                                            style="width: 80px; height: 80px; object-fit: cover;" alt="Avatar">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white fs-4"
                                            style="width:80px;height:80px;background:linear-gradient(135deg, #0066CC, #004499);">
                                            {{ strtoupper(substr($customer->firstname, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="pic" class="btn btn-outline-secondary rounded-2 fs-13 fw-semibold mb-1">
                                        <i class="bi bi-camera me-1"></i> Change Photo
                                    </label>
                                    <input type="file" name="pic" id="pic" class="d-none" accept="image/*"
                                        onchange="previewPic(this)">
                                    <p class="text-muted fs-12 mb-0">JPG, PNG or GIF • Max 2 MB</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fs-13 fw-semibold text-dark">First Name *</label>
                                    <input type="text" name="firstname" value="{{ old('firstname', $customer->firstname) }}"
                                        class="form-control shadow-none fs-14 @error('firstname') is-invalid @enderror" required>
                                    @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fs-13 fw-semibold text-dark">Last Name *</label>
                                    <input type="text" name="lastname" value="{{ old('lastname', $customer->lastname) }}"
                                        class="form-control shadow-none fs-14 @error('lastname') is-invalid @enderror" required>
                                    @error('lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fs-13 fw-semibold text-dark">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                        class="form-control shadow-none fs-14 @error('email') is-invalid @enderror" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fs-13 fw-semibold text-dark">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                        class="form-control shadow-none fs-14">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Change Password --}}
                    <div class="card border-light-subtle shadow-sm rounded-4 bg-white mb-4">
                        <div class="card-header bg-white border-bottom px-4 py-3 rounded-top-4">
                            <h5 class="mb-0 fw-bold fs-16 text-dark"><i class="bi bi-shield-lock me-2 text-primary"></i>Security & Password <span class="fs-13 text-muted fw-normal">(leave blank to keep current)</span></h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label class="form-label fs-13 fw-semibold text-dark">Current Password</label>
                                    <input type="password" name="current_password"
                                        class="form-control shadow-none fs-14 @error('current_password') is-invalid @enderror">
                                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label fs-13 fw-semibold text-dark">New Password</label>
                                    <input type="password" name="new_password"
                                        class="form-control shadow-none fs-14 @error('new_password') is-invalid @enderror">
                                    @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label fs-13 fw-semibold text-dark">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation"
                                        class="form-control shadow-none fs-14">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary rounded-2 fw-semibold px-4 fs-14">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-2 fw-semibold px-5 fs-14">
                            <i class="bi bi-check2 me-1"></i> Save Profile Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function previewPic(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('picPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

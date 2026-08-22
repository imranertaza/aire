@extends('themes.default.layouts.master')

@section('title', 'Documentation & Resources | Aire')

@section('content')
<div class="container main-container py-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 rounded-3 sticky-top" style="top: 90px;">
                <h6 class="fw-bold text-uppercase text-muted fs-12 mb-3">Documentation</h6>
                <nav class="nav flex-column gap-1 fs-14">
                    <a class="nav-link text-primary fw-bold p-1" href="#getting-started">Getting Started</a>
                    <a class="nav-link text-secondary p-1" href="#installation">Installation Guide</a>
                    <a class="nav-link text-secondary p-1" href="#maintenance">Filter Maintenance</a>
                    <a class="nav-link text-secondary p-1" href="#api">Smart API Reference</a>
                </nav>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h2 id="getting-started" class="fw-bold h4 mb-3">Getting Started with AIRE Systems</h2>
                <p class="text-secondary fs-15 mb-4">
                    Welcome to the AIRE technical documentation library. Here you will find installation manuals, maintenance schedules, filter replacement guides, and smart IoT API specifications.
                </p>
                <hr>
                <h3 id="installation" class="fw-bold h5 mt-4 mb-3">Filter Replacement Schedule</h3>
                <p class="text-secondary fs-15">
                    HEPA-14 filters should be inspected every 6 months and replaced every 12-18 months depending on continuous operating hours and air quality indexes.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

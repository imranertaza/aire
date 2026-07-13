@extends('layouts.master')

@section('title', $pageTitle)
@section('breadcrumb', $pageTitle)
@section('content')

  <section class="container position-relative profile-section mt-minus-100">
    <h2 class="visually-hidden">Player Details Profiles</h2>
    <div class="d-flex justify-content-center">
        <div class="player-details-card top d-inline-block">
            <div class="card-body bg-white border">

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs justify-content-center" id="playerTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                            role="tab">Player Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="personal-tab" data-bs-toggle="tab" href="#personal"
                            role="tab">Personal Info</a>
                    </li>
                    <div class="hr-bottom"></div>
                </ul>

                <!-- Constant Layout -->
                <div class="row justify-content-between mt-3">
                    <!-- Left column: constant image + sport -->
                    <div class="d-flex justify-content-center align-items-center col-md-4">
                        <div class="profile-card text-center">
                            <img draggable="false" class="rounded-circle" width="128" height="128"
                                src="{{ getImageCacheUrl($player->image, 262, 225) }}" alt="{{ $player->name }}">
                            <div class="card-body">
                                <p class="mb-0 name content-text">{{ $player->name }}</p>
                                <p class="profession content-text">{{ $player->sport }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right column: tabbed tables -->
                    <div class="col-md-8">
                        <div class="tab-content" id="playerTabContent">

                            <!-- Profile Tab -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table align-middle table-striped">
                                        <tbody>
                                            <tr>
                                                <td><div class="d-flex justify-content-between"><p>Name</p><p>:</p></div></td>
                                                <th>{{ $player->name }}</th>
                                            </tr>
                                            <tr>
                                                <td><div class="d-flex justify-content-between"><p>Country</p><p>:</p></div></td>
                                                <th>{{ $player->country ?? 'N/A' }}</th>
                                            </tr>
                                            <tr>
                                                <td><div class="d-flex justify-content-between"><p>Sport</p><p>:</p></div></td>
                                                <th>{{ $player->sport }}</th>
                                            </tr>
                                            <tr>
                                                <td><div class="d-flex justify-content-between"><p>Asian Ranking</p><p>:</p></div></td>
                                                <th>{{ $player->asian_ranking ?? '-' }}</th>
                                            </tr>
                                            <tr>
                                                <td><div class="d-flex justify-content-between"><p>National Ranking</p><p>:</p></div></td>
                                                <th>{{ $player->national_ranking ?? '-' }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Personal Info Tab -->
                            <div class="tab-pane fade" id="personal" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table align-middle table-striped">
                                        <tbody>
                                            <tr><td><div class="d-flex justify-content-between"><p>Birthdate</p><p>:</p></div></td><th>{{ formatDate($player->birthdate) ?? '-' }}</th></tr>
                                            <tr><td><div class="d-flex justify-content-between"><p>Age</p><p>:</p></div></td><th>{{ $player->age ?? '-' }}</th></tr>
                                            <tr><td><div class="d-flex justify-content-between"><p>Height</p><p>:</p></div></td><th>{{ $player->height ?? '-' }}</th></tr>
                                            <tr><td><div class="d-flex justify-content-between"><p>Weight</p><p>:</p></div></td><th>{{ $player->weight ?? '-' }}</th></tr>
                                            <tr><td><div class="d-flex justify-content-between"><p>Hometown</p><p>:</p></div></td><th>{{ $player->hometown ?? '-' }}</th></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


    @push('styles')
        <style>
            :root {
                --bs-table-striped-bg: #F1F5F9 !important;
            }

            .profile-card.top {
                margin-top: -8%;
            }

            .profile-card .card-body {
                padding-top: 12px !important;
                background-color: var(--common-white);
            }

            .profile-card {
                width: 265px;
                padding: 0px !important;
            }



            .nav-link::after {
                display: none !important;
                height: 4px;
                width: auto;
                bottom: -3px;
                background-color: var(--common-color) !important;
            }


            .profile-card .card-body {
                text-align: center;
                padding-top: 24px;
                padding-bottom: 16px;

            }

            .profile-card .profession {
                color: var(--common-color);
            }

            @media screen and (max-width: 768px) {
                .profile-card.top {
                    margin-top: -12%;
                }
            }

            @media screen and (max-width: 575px) {
                .profile-card.top {
                    margin-top: -20%;
                }
            }


            /* Tab navigation styling */
            .nav-tabs {
                position: relative;
                border-bottom: none;
                /* border-bottom: 4px solid #dee2e6; */
            }

            .nav-link::after {
                height: 4px;
            }

            .nav-tabs .nav-link {
                border: none;
                border-bottom: 4px solid transparent;
                color: #6c757d;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .nav-tabs .nav-link:hover {
                color: #495057;
                border-color: transparent;
            }

            .nav-tabs .nav-link.active {
                /* Bootstrap primary color */
                border-color: var(--common-color);
                background-color: transparent;
                z-index: 1;
            }

            /* Tab content area */
            .tab-content {
                border: none !important;
                border-top: none;
                padding: 1rem;
                background: #fff;
                border-radius: 0 0 0.5rem 0.5rem;
            }

            /* Optional: add subtle shadow for card effect */
            .tab-content {
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .player-details-card {
                width: 100%;
                padding: 0px !important;
            }

            .player-details-card .tab-content {
                padding: 6% 0px;
            }


            #playerTab .nav-link {
                padding-top: 24px;
                padding-bottom: 24px;
            }

            .hr-bottom {
                position: absolute;
                bottom: -1px;
                left: 0;
                width: 100%;
                height: 4px;
                background-color: #D9D9D9;
            }

            .profession {
                color: #717171 !important;
            }

            .name {
                font-weight: 500 !important;
                color: #1D1D1D !important;
                font-size: 18px !important;
                line-height: 22px !important;
            }

            .player-info-tr {
                padding: 25px 14px;
                width: 75%;
            }

            .player-info-tr p {
                margin: 0;
            }

            .player-info-tr .name {
                color: #3D3D3D !important;
            }

            .mt-minus-100 {
                margin-top: -60px;
                padding-bottom: 120px;
            }

            table p {
                margin: 0;
            }

            .table>:not(caption)>*>* {
                padding: 14px 25px;
                border: none;
            }

            .table-striped>tbody>tr:nth-of-type(odd) {
                --bs-table-striped-bg: #F1F5F9 !important;
            }

            .table th {
                font-weight: 500 !important;
            }

            /* Default: full width */
            .table-responsive table {
                width: 100%;
            }

            /* Up to 1200px: restrict to 75% */
            @media (min-width: 1200px) {

                .table-responsive table {
                    width: 75%;
                    /* center the table */
                }
            }
        </style>
    @endpush
    <!-- Players section End -->
@endsection

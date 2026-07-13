@extends('layouts.master')

@section('title', 'Committee Members')
@section('breadcrumb', 'Committee Members Details')
@section('content')
    <section class="container position-relative profile-section">
        <h2 class="visually-hidden">Executive Committee Profiles</h2>
        <div class="text-center">
            @if ($member)
                <div class="profile-card top d-inline-block">
                    <img draggable="false" src="{{ getImageCacheUrl($member->image, 265, 379) }}" alt="{{ $member->name }}">
                    <div class="card-body">
                        <p class="mb-0 name content-text"><a
                                href="{{ route('committee-members-details', $member->slug) }}">{{ $member->name }}</a></p>
                        <p class="profession content-text">{{ $member->designation }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="">
            <div class="mb-5 pb-3 page-description">
                {!! $member->description !!}
            </div>
        </div>
    </section>
    @push('styles')
        <style>
        .page-description img {
                max-width: 100% !important;
                height: auto !important;
            }
            .profile-card.top {
                margin-top: -8%;
            }


            .profile-card {
                width: 265px;
                padding: 0px !important;
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
        </style>
    @endpush
@endsection

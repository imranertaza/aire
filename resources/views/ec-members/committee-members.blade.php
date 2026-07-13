@extends('layouts.master')

@section('title', 'Committee Members')
@section('breadcrumb', 'Committee Members')
@section('content')
    <section class="container position-relative profile-section">
        <h2 class="visually-hidden">Executive Committee Profiles</h2>
        <div class="text-center">
            @php
                $member1 = count($members) > 0 ? $members[0] : null;
            @endphp
            @if ($member1)
                <div class="profile-card top d-inline-block">
                    <img draggable="false" src="{{ getImageCacheUrl($member1->image, 265, 379) }}" alt="{{ $member1->name }}">
                    <div class="card-body">
                        <p class="mb-0 name content-text"><a
                                href="{{ route('committee-members-details', $member1->slug) }}">{{ $member1->name }}</a></p>
                        <p class="profession content-text">{{ $member1->designation }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 g-4 justify-content-evenly mt-md-5 pb-100">
            @forelse ($members as $key => $member)
                @if ($key == 0)
                    @continue
                @endif
                <div>
                    <div class="profile-card">
                        <img draggable="false" src="{{ getImageCacheUrl($member->image, 265, 379) }}"
                            alt="{{ $member->name }}">
                        <div class="card-body">
                            <p class="mb-0 name content-text"><a href="{{ route('committee-members-details', $member->slug) }}">{{ $member->name }}</a></p>
                            <p class="profession content-text">{{ $member->designation }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center content-text">No committee members found.</p>
                </div>
            @endforelse

        </div>
    </section>
    @push('styles')
        <style>
            .profile-card.top {
                margin-top: -8%;
            }


            .profile-card {
                width: 265px;
                padding: 0px !important;
            }
            .profile-card .image {
            height: 379px;
            width: 265px;
            overflow: hidden;
            border: 2px solid #ddd;
            text-align:center;
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

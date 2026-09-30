@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    <section class="container position-relative profile-section">
        <h2 class="visually-hidden">Executive Committee Profiles</h2>
        <div class="text-center">
            @php
                $members = \App\Models\CommitteeMember::where('status', 1)->orderBy('order')->get();

                // first one
                $president = $members->get(0);
                // @dd($president);
                // skip 1, take 2 (this gives members 2 and 3)
                $vicePresidents = $members->slice(1, 2);

                // skip 3, take 1 (this gives member 4)
                $secretaryGenerals = $members->slice(3, 3);
                // skip first 6, take all remaining
                $remainingMembers = $members->slice(6, $members->count());
                // @dd($remainingMembers);
            @endphp

            @if ($president)
                <div class="profile-card top d-inline-block">
                    <div class="image">
                    <img draggable="false" src="{{ getImageCacheUrl($president->image, 265, 379) }}"
                        alt="{{ $president->name }}">
                    </div>
                    <div class="card-body">
                        <p class="mb-0 name content-text"><a
                                href="{{ route('committee-members-details', $president->slug) }}">{{ $president->name }}</a>
                        </p>
                        <p class="profession content-text">{{ $president->designation }}</p>
                    </div>
                </div>
            @endif
        </div>
        <div class="mt-md-3">
            <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 justify-content-center">
                @forelse ($vicePresidents as $key => $vicePresident)
                    <div>
                        <div class="profile-card mx-auto">
                             <div class="image">
                            <img draggable="false" src="{{ getImageCacheUrl($vicePresident->image, 265, 379) }}"
                                alt="{{ $vicePresident->name }}">
                                  </div>
                            <div class="card-body">
                                <p class="mb-0 name content-text"><a
                                        href="{{ route('committee-members-details', $vicePresident->slug) }}">{{ $vicePresident->name }}</a>
                                </p>
                                <p class="profession content-text">{{ $vicePresident->designation }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2  justify-content-center">
                @forelse ($secretaryGenerals as $key => $secretaryGeneral)
                    <div>
                        <div class="profile-card mx-auto">
                            <div class="image">
                            <img draggable="false" src="{{ getImageCacheUrl($secretaryGeneral->image, 265, 379) }}"
                                alt="{{ $secretaryGeneral->name }}">
                            </div>
                            <div class="card-body">
                                <p class="mb-0 name content-text"><a
                                        href="{{ route('committee-members-details', $secretaryGeneral->slug) }}">{{ $secretaryGeneral->name }}</a>
                                </p>
                                <p class="profession content-text">{{ $secretaryGeneral->designation }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2  justify-content-center">
                @forelse ($remainingMembers as $key => $remainingMember)
                    <div>
                        <div class="profile-card mx-auto">
                             <div class="image">
                            <img draggable="false" src="{{ getImageCacheUrl($remainingMember->image, 265, 379) }}"
                                alt="{{ $remainingMember->name }}">
                                </div>
                            <div class="card-body">
                                <p class="mb-0 name content-text"><a
                                        href="{{ route('committee-members-details', $remainingMember->slug) }}">{{ $remainingMember->name }}</a>
                                </p>
                                <p class="profession content-text">{{ $remainingMember->designation }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="mb-5 pb-3 pb-100 page-content">
            @yield('page-content')
        </div>
    </section>
    @push('styles')
        <style>
            .page-content img {
                max-width: 100%;
                height: auto;
            }

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
                border: 2px solid #EAEAEA;
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

@extends('layouts.app')

@section('page_title', 'Profile')
@section('content')
    <div class="card shadow">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-body">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 justify-content-center">
                    <div class="col">
                        <div class="profile-wrap mx-auto">
                            <img src="{{ asset('avatar/' . $profile->avatar) }}" alt="avatar">
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <h3 class="font-bold text-capitalize mt-sm-0 mt-3">
                                {{ $profile->name }}
                            </h3>
                            <p>{{ $profile->email }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="fas fa-id-card-alt  fa-fw"></i>
                                {{ is_null($profile->nip) ? '-' : $profile->nip }}</li>
                            <li class="list-group-item"><i class="fas fa-user-tie fa-fw"></i>
                                {{ is_null($profile->group) ? '-' : $profile->group }}</li>
                            <li class="list-group-item"><i class="fas fa-users-cog   fa-fw"></i> {{ $profile->position }}
                            </li>
                            <li class="list-group-item"><i class="fas fa-phone-alt fa-fw"></i> {{ $profile->contact }}
                            </li>
                            <li class="list-group-item"><i class="fas fa-puzzle-piece   fa-fw"></i>
                                {{ is_null($profile->field) ? '-' : $profile->field->name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid col-sm-2 col-12 mt-5 mx-auto">
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection

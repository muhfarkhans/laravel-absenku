@extends('admin.layout')

@section('css')
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profile</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ubah data profile</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if (session('message'))
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form form-horizontal" action="{{ route('admin.profile.update') }}" method="post">
                            @csrf
                            <div class="form-body">
                                <div class="mt-3">
                                    <label for="validationCustom01" class="form-label">Nama</label>
                                    <input name="name" type="text" class="form-control" value="{{ $user->name }}"
                                        required>
                                </div>

                                <div class="mt-3">
                                    <label for="validationCustom01" class="form-label">Email</label>
                                    <input name="email" type="text" class="form-control" value="{{ $user->email }}"
                                        required>
                                </div>

                                <div class="mt-3">
                                    <label for="validationCustom01" class="form-label">Password</label>
                                    <input name="password" type="text" class="form-control">
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush

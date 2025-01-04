@extends('admin-panel.layouts.main')

@section('title', 'Profile')

@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('admin/vendor') }}/izitoast/dist/css/iziToast.min.css">
@endpush

@push('css')
    <style>
        .profile-user-img {
            /* border: 3px solid #a6caf2; */
            border: 3px solid #99b2cd;
            margin: 0 auto;
            padding: 3px;
            width: 100px
        }

        .profile-username {
            font-size: 21px;
            margin-top: 15px
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Profile</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Profile Image -->
                <div class="card card-primary card-outline irounded-1 shadow">
                    <div class="card-body box-profile" id="profile">
                        <div class="text-center mt-3">
                            <img class="profile-user-img rounded-circle"
                                src="{{ asset('admin') }}/assets/img/avatar/avatar-1.png" alt="User Profile picture">
                        </div>

                        <h3 class="profile-username text-center">Nama Pengguna</h3> <br>

                        <form id="FormProfile" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="profileID">
                            <div class="form-group row">
                                <div class="input-group">
                                    <label class="col-sm-2 col-form-label" for="nameProfile">Nama Lengkap</label>
                                    <div class="input-group col-sm-10">
                                        <input type="text" class="form-control" name="nameProfile" id="nameProfile"
                                            autocomplete="off">
                                        <div class="invalid-feedback msg-nameProfile"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group">
                                    <label class="col-sm-2 col-form-label" for="emailProfile">Email</label>
                                    <div class="input-group col-sm-10">
                                        <input type="email" class="form-control" name="emailProfile" id="emailProfile"
                                            autocomplete="off">
                                        <div class="invalid-feedback msg-emailProfile"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group">
                                    <label class="col-sm-2 col-form-label" for="passwordProfile">Password</label>
                                    <div class="input-group col-sm-10">
                                        <input type="password" class="form-control password" name="passwordProfile"
                                            id="passwordProfile">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-eye"
                                                    id="togglePassword"></i></span>
                                        </div>
                                        <div class="invalid-feedback msg-passwordProfile"></div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block mb-3"
                                id="simpanProfile"><b></b></button>
                        </form>
                    </div>
                </div>
                <!-- End Profile Image -->
            </div>
        </div>
    </section>
@endsection

@push('js_vendor')
    <script src="{{ asset('admin/vendor') }}/izitoast/dist/js/iziToast.min.js"></script>
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/profile/role13/main.js') }}"></script>
@endpush

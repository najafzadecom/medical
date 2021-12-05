<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Medical - Giriş</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('admin/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script src="{{ asset('admin/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script src="{{ asset('admin/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js')}}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}?time={{time()}}"></script>
    <script src="{{ asset('admin/global_assets/js/demo_pages/login.js')}}"></script>
    <!-- /theme JS files -->
</head>
<body>
<!-- Page content -->
<div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">
            <!-- Login card -->
            <div class="card">
                <form class="login-form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-{{ session('type') }} border-0 alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" placeholder="E-mail"
                                   autocomplete="chrome-off">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="Şifrə" autocomplete="new-password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            {!! captcha_img() !!}
                            <input type="text" class="form-control @error('captcha') is-invalid @enderror" name="captcha" placeholder="Təhlükəsizlik kodu" autocomplete="new-captcha">
                            @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <div class="form-check mb-0">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" name="remember" id="remember"
                                           class="form-input-styled" checked
                                           data-fouc {{ old('remember') ? 'checked' : '' }}>
                                    Məni xatırla
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Daxil ol <i class="icon-circle-right2 ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /login card -->
        </div>
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
</body>
</html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sewa Cosplay</title>

    <!-- Bootstrap -->

    <link href={{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }} rel="stylesheet">
    <!-- Font Awesome -->
    <link href={{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }} rel="stylesheet">
    <!-- NProgress -->
    <link href={{ asset('assets/vendors/nprogress/nprogress.css') }} rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href={{ asset('assets/build/css/custom.min.css') }} rel="stylesheet">
</head>
</head>
<style>
    .input-group {
        position: relative;
    }

    .input-group .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }
</style>

<body class="login">
    @include('sweetalert::alert')
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form id="resetPasswordForm" action="{{ route('resetpassword') }}" method="post">
                        @csrf
                        <h1>Reset Password Form</h1>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password baru" required />
                            <span class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></span>
                        </div>
                        <div class="input-group" style="margin-top: 10px;">
                            <input type="password" class="form-control" id="confirmPassword" name="konfirmasipassword"
                                placeholder="Konfirmasi password" required />
                            <span class="fa fa-eye toggle-password"
                                onclick="togglePassword('confirmPassword', this)"></span>
                        </div>
                        <input type="hidden" value="{{ $tokenn }}" name="token">
                        <div>
                            <button type="submit" class="btn btn-primary submit">kirim</button>
                            <a class="reset_pass" href="{{ route('login') }}">kembali login</a>
                        </div>

                        <div class="clearfix"></div>



                        <div class="clearfix"></div>
                        <br />


            </div>
            </form>
            </section>
        </div>


    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(fieldId, toggleIcon) {
            var inputField = document.getElementById(fieldId);
            if (inputField.type === "password") {
                inputField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                inputField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                e.preventDefault(); // Mencegah form dari submit
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Password dan konfirmasi password tidak cocok!'
                });
            }
        });
    </script>
</body>

</html>

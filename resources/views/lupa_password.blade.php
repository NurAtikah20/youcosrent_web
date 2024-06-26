<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sewa Cosplay</title>

    <!-- Bootstrap -->
 
    <link href={{ asset("assets/vendors/bootstrap/dist/css/bootstrap.min.css") }} rel="stylesheet">
    <!-- Font Awesome -->
    <link href={{ asset("assets/vendors/font-awesome/css/font-awesome.min.css") }} rel="stylesheet">
    <!-- NProgress -->
    <link href={{ asset("assets/vendors/nprogress/nprogress.css") }} rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href={{ asset("assets/build/css/custom.min.css") }} rel="stylesheet">
</head>
  </head>

  <body class="login">
    @include('sweetalert::alert')
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="{{ route('actlupapassword') }}" method="post">
                @csrf
              <h1>Lupa Password</h1>
              <div>
                <input type="email" class="form-control" name="email" placeholder="email" required />
              </div>
            
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
  </body>
</html>

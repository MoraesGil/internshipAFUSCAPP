
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SantaClub </title>

  <link href="{{asset('css/vendor.css')}}" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form role="form" method="POST"  action="{{ url('/login') }}">
            {{ csrf_field() }}
            <h1>Autenticação</h1>
            <div>
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
            </div>
            <div>
              <input id="password" type="password" class="form-control" name="password" required placeholder="Senha">
            </div>
            <div>

              <button type="submit" class="btn btn-default btn-block">
              Entrar
              </button>
              {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              {{-- <p class="change_link">New to site?
                <a href="#signup" class="to_register"> Create Account </a>
              </p> --}}

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-users"></i> SantaClub</h1>
                <p>@include('layouts.parts.direitos')</p>
              </div>
            </div>
          </form>
        </section>
      </div>

      {{-- <div id="register" class="animate form registration_form">
        <section class="login_content">
          <form>
            <h1>Create Account</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="#signin" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
              </div>
            </div>
          </form>
        </section>
      </div> --}}
    </div>
  </div>
</body>
</html>

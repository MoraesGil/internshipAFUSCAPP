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

  @stack('css')
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-cubes"></i> <span>SantaClub</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile hidden">
            <div class="profile_pic ">
              {{-- <img src="http://bit.ly/2voFeiI" alt="..." class="img-circle profile_img"> --}}
            </div>
            <div class="profile_info">
              <span>Bem vindo,</span>
              <h2>  {{ Auth::user()->name }}</h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          @include('layouts.parts.menu')
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->

          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  {{ Auth::user()->name }}
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;">Ajuda</a></li>
                  <li><a href="{{ route('logout2') }}"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                </ul>
              </li>
             </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      @yield('content')
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          @include('layouts.parts.direitos')
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>



  <!-- Custom Theme Scripts -->
  <script src="{{asset('js/vendor.js')}}"></script>
  @stack('js')
</body>
</html>

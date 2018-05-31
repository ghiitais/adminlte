
<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Intranet | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  
  <!--  -->
  @yield('vuejs')
 
  
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/ADMINLTE/dist/css/skins/_all-skins.min.css') }}">
  @yield('style')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="app">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>I</b>neoxia</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> <img src="neoxia.png" height="40" width="40"> <b>Intra</b>neoxia </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/uploads/avatars/{{Auth::user()->avatar}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/uploads/avatars/{{Auth::user()->avatar}}" class="img-circle" alt="User Image">

                <p>
                {{ Auth::user()->name }}
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Body -->
    
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">Profile <i class="fa fa-user" aria-hidden="true"></i></a>
                </div>
                <div class="pull-right">
                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        Se déconnecter <i class="fa fa-sign-out" aria-hidden="true"></i> </a>


                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div>
              </li>
            </ul>
          </li>
         
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/uploads/avatars/{{Auth::user()->avatar}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        @auth
        <li>
          <a href="{{url('/actualites')}}">
            <i class="fa fa-newspaper-o"></i> <span>Actualités</span>
          </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Annuaire</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/services')}}"><i class="fa fa-building"></i> Services</a></li>
            <li><a href="{{url('/collaborateurs')}}"><i class="fa fa-users"></i> Collaborateurs</a></li>
          </ul>
        </li>
        
        @if(\Auth::user()->is_admin == 1 )
        <li>
          <a href="{{url('admin/demandes')}}">
            <i class="fa fa-files-o"></i> <span>Demandes</span>
          </a>
        </li>
        @elseif(\Auth::user()->is_manager == 1)
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Demandes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/mes_demandes')}}"><i class="fa fa-edit"></i>Mes demandes</a></li>
            <li><a href="{{url('manager/demandes')}}"><i class="fa fa-files-o"></i>Demandes des collaborateurs</a></li>
          </ul>
        </li>
        @elseif(\Auth::user()->is_assistante == 1)
            <li>
            <a href="{{url('assistante/demandes_active')}}">
                <i class="fa fa-files-o"></i> <span>Demandes</span>
            </a>
            </li>
        @else
            <li>
                <a href="{{url('mes_demandes')}}">
                    <i class="fa fa-edit"></i> <span>Demandes</span>
                </a>
            </li>
        @endif

        <li>
            <a href="#">
                <i class="fa fa-calendar"></i> <span>Evènements</span>
            </a>
        </li>

        @if(\Illuminate\Support\Facades\Auth::user()-> is_admin == 1)
        <li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Configurations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/ajouter_managers')}}"><i class="fa fa-circle-o"></i> Managers</a></li>
            <li><a href="{{url('/home')}}"><i class="fa fa-circle-o"></i> Types de demandes</a></li>
          </ul>
        </li>
        
        @endif

        <li>
            <a href="{{url('ticketsShow')}}">
                <i class="fa fa-tags"></i> <span>Tickets</span>
            </a>
        </li>


          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>Documents</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{url('file')}}"><i class="fa fa-share"></i> Partager </a></li>
              <li><a href="{{url('all_files')}}"><i class="fa fa-files-o"></i> Consulter</a></li>
            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-shopping-cart"></i> <span>Marketplace</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{url('multiuploads')}}"><i class="fa fa-share"></i> Partager </a></li>
              <li><a href="{{ route('itemsview.index') }}"><i class="fa  fa-eye"></i> Consulter</a></li>
            </ul>
          </li>
        
        @endauth
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        @yield('content') 
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <div class="control-sidebar-bg"></div>

</div>
</div>
<script src="{{ asset('/ADMINLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('/ADMINLTE/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('/ADMINLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('/ADMINLTE/bower_components/chart.js/Chart.js') }}"></script>
<script src="{{ asset('/ADMINLTE/dist/js/pages/dashboard2.js') }}"></script>
<script src="{{ asset('/ADMINLTE/dist/js/demo.js') }}"></script>
@yield('script')
</body>

</html>

@section('sidebar')
<?php
$session = unserialize (\Crypt::decryptString(Session::get('session_login')));
$user = $session['user'];
$sector_menu = $session['sector_menu'];
$sector_category = $session['sector_category'];
if(isset($menu))
    $menu = strtolower($menu);

$sb = "";
if(isset($sub_menu)){
  $sb = $sub_menu;
}
$category_hawasbid = ["Kepaniteraan","Kesekretariatan"];

$rm = "";
if(isset($root_menu)) 
   $rm =  $root_menu;
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/home')}}">
    <div class="sidebar-brand-icon">
      <!-- <i class="fas fa-laugh-wink"></i> -->
      <img src='{{asset("assets/img/small_icon.png")}}'>
    </div>
    <div class="sidebar-brand-text mx-3" style="text-align:left">Panel Admin</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php if($menu == "dashboard") echo 'active'?>">
    <a class="nav-link" href="{{url('/home')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item <?php if($menu == "akun_saya") echo 'active'?>">
    <a class="nav-link" href="{{url('/akun-saya')}}">
      <i class="fa fa-user-circle" aria-hidden="true"></i>
      <span>Akun Saya</span></a>
  </li>


  @if($user->user_level_id == 1)
    <li class="nav-item ">

    </li>
  @endif

  @if($user->user_level_id == 1 || $user->user_level_id == 2 || $user->user_level_id == 3)
    <li class="nav-item {{($menu == "master")?'active': ''}}">

      <a class="nav-link {{($menu == "master")?'': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseHawasbid" aria-expanded="true" aria-controls="collapseHawasbid">
        <!-- <i class="fa fa-user-circle" aria-hidden="true"></i> -->
        <span>Master</span>
      </a>

      <div id="collapseHawasbid" class="collapse <?php if($menu == "master") echo 'show'?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?php if($sb == "users") echo 'active'?>" href="{{url('/users')}}">Pengguna</a>
          <a class="collapse-item <?php if($sb == "hawasbid_indikator") echo 'active'?>" href="{{url('/hawasbid_indikator')}}">Indikator</a>
          <a class="collapse-item <?php if($sb == "hawasbid_bidang") echo 'active'?>" href="{{url('/sector_hawasbid')}}">B. Penanggung Jawab</a>
          <a class="collapse-item <?php if($sb == "generate_indikator") echo 'active'?>" href="{{url('/generate_indikator')}}">Generate Indikator</a>
          <a class="collapse-item <?php if($sb == "performa_hawasbid") echo 'active'?>" href="{{url('/performa-hawasbid')}}">Performa Hawasbid</a>
          <a class="collapse-item <?php if($sb == "setting_time_hawasbid") echo 'active'?>" href="{{url('/setting_time_hawasbid')}}">Setting Periode</a>
          <a class="collapse-item <?php if($sb == "lingkup-pengawasan") echo 'active'?>" href="{{url('pr/lingkup-pengawasan')}}">L. Pengawasan</a>
          <a class="collapse-item <?php if($sb == "lingkup-pengawasan-bidang") echo 'active'?>" href="{{url('pr/lingkup-pengawasan-bidang')}}">L. Pengawasan Bidang</a>
          <a class="collapse-item <?php if($sb == "variables") echo 'active'?>" href="{{url('/variables')}}">Variabel</a>
        </div>
      </div>
    </li>
  @endif

  <!-- Divider -->
  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Pengawasan APM
  </div>

  @if($user->user_level_id == 1 || $user->user_level_id == 10 || $user->user_level_id == 3  || $user->user_level_id == 2 || $user->user_level_id == 6 || $user->user_level_id == 7 )
  
  <li class="nav-item">
    <a class="nav-link {{($rm == 'pengawas_bidang')? '': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePB" aria-expanded="true" aria-controls="collapsePB">
      <span>Pengawas Bidang</span></a>
    <ul  id="collapsePB" class="collapse {{($rm == 'pengawas_bidang')? 'show': ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      @foreach($category_hawasbid as $row_cat)
        @if(in_array($row_cat, $sector_category) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2 )
        <?php
        ?>
        <li class="nav-item {{($menu == ($row_cat) && $rm == 'pengawas_bidang')? 'active' : '' }} ">
          <a class="nav-link {{ ($menu == strtolower($row_cat) && $rm == 'pengawas_bidang') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapsePB{{$row_cat}}" aria-expanded="true" aria-controls="collapsePB{{$row_cat}}">
            <span>{{$row_cat}}</span>
          </a>

          <div id="collapsePB{{$row_cat}}" class="collapse {{ ($menu == strtolower($row_cat) && $rm == 'pengawas_bidang') ? 'show' : '' }}" >
            <div class="bg-white py-2 collapse-inner rounded">
              @foreach($menu_sectors as $val)
                @if($val->category == $row_cat && ( in_array($val->alias, $sector_menu) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2))

                <?php
                  $link_name = $val->alias;
                ?>
                <a class="collapse-item {{ ($sb == $link_name && $rm == 'pengawas_bidang')? 'active' : '' }}" href="{{url('/pengawas-bidang/'.strtolower($val->category).'/'.$link_name)}}">{!! $val->nama !!}</a>

                @endif
              @endforeach

            </div>
          </div>
        </li>
        @endif

      @endforeach
    </ul>

  </li>

  @endif


  @if($user->user_level_id == 1 || $user->user_level_id == 4 || $user->user_level_id == 5 || $user->user_level_id == 3  || $user->user_level_id == 2)
  
  <li class="nav-item">
    <a class="nav-link {{($rm == 'tindak_lanjut')? '': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTL" aria-expanded="true" aria-controls="collapseTL"><span>Tindak Lanjut</span></a>
    <ul  id="collapseTL" class="collapse {{($rm == 'tindak_lanjut') ? 'show': ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      @foreach($category_hawasbid as $row_cat)
        @if(in_array($row_cat, $sector_category) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2)
        <?php
        ?>
        <li class="nav-item {{ ($menu == strtolower($row_cat) && $rm == 'tindak_lanjut') ? 'active' : '' }}">
          <a class="nav-link {{ ($menu == strtolower($row_cat) && $rm == 'tindak_lanjut') ? '' : 'collapsed' }} " href="#" data-toggle="collapse" data-target="#collapseTL{{$row_cat}}" aria-expanded="true" aria-controls="collapsePB{{$row_cat}}">
            <span>{{$row_cat}}</span>
          </a>

          <div id="collapseTL{{$row_cat}}" class="collapse {{ ($menu == strtolower($row_cat) && $rm == 'tindak_lanjut') ? 'show' : '' }}" >
            <div class="bg-white py-2 collapse-inner rounded">
              @foreach($menu_sectors as $val)
                @if($val->category == $row_cat && ( in_array($val->alias, $sector_menu) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2))

                <?php
                  $link_name = $val->alias;
                ?>
                <a class="collapse-item {{ ($sb == $link_name && $rm == 'tindak_lanjut')? 'active' : '' }} " href="{{url('/tindak-lanjutan/'.strtolower($val->category).'/'.$link_name)}}">{!! $val->nama !!}</a>
                @endif
              @endforeach

            </div>
          </div>
        </li>
        @endif

      @endforeach
    </ul>

  </li>

  @endif

  
  <hr class="sidebar-divider d-none d-md-block">

  <div class="sidebar-heading">
    Pengawasan Reguler
  </div>


  @if($user->user_level_id == 1 || $user->user_level_id == 10 || $user->user_level_id == 3  || $user->user_level_id == 2 || $user->user_level_id == 6 || $user->user_level_id == 7 )
  
  <li class="nav-item">
    <a class="nav-link {{($rm == 'pr_pengawas_bidang')? '': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePRegulerPB" aria-expanded="true" aria-controls="collapsePB">
      <span>Pengawas Bidang</span></a>
    <ul  id="collapsePRegulerPB" class="collapse {{($rm == 'pr_pengawas_bidang')? 'show': ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      @foreach($category_hawasbid as $row_cat)
        @if(in_array($row_cat, $sector_category) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2 )
        <?php
        ?>
        <li class="nav-item {{($menu == strtolower($row_cat) && $rm == 'pr_pengawas_bidang')? 'active' : '' }} ">
          <a class="nav-link {{ ($menu == strtolower($row_cat) && $rm == 'pr_pengawas_bidang') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapsePRegulerPB{{$row_cat}}" aria-expanded="true" aria-controls="collapsePB{{$row_cat}}">
            <span>{{$row_cat}}</span>
          </a>

          <div id="collapsePRegulerPB{{$row_cat}}" class="collapse {{ ($menu == strtolower($row_cat) && $rm == 'pr_pengawas_bidang') ? 'show' : '' }}" >
            <div class="bg-white py-2 collapse-inner rounded ">
              @foreach($menu_sectors as $val)
                @if($val->category == $row_cat && ( in_array($val->alias, $sector_menu) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2))

                <?php
                  $link_name = $val->alias;
                ?>
                <a class="collapse-item {{ ($sb == $link_name && $rm == 'pr_pengawas_bidang')? 'active' : '' }}" href="{{url('pr/pengawasan-bidang/'.strtolower($val->category).'/'.$link_name)}}">{!! $val->nama !!}</a>

                @endif
              @endforeach

            </div>
          </div>
        </li>
        @endif

      @endforeach
    </ul>

  </li>

  @endif


  @if($user->user_level_id == 1 || $user->user_level_id == 4 || $user->user_level_id == 5 || $user->user_level_id == 3  || $user->user_level_id == 2)
  <li class="nav-item">
    <a class="nav-link {{($rm == 'pr_tindak_lanjut')? '': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsePRegulerTL" aria-expanded="true" aria-controls="collapsePRegulerTL"><span>Tindak Lanjut</span></a>
    <ul  id="collapsePRegulerTL" class="collapse {{($rm == 'pr_tindak_lanjut')? 'show': ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      @foreach($category_hawasbid as $row_cat)
        @if(in_array($row_cat, $sector_category) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2)
        <?php
        ?>
        <li class="nav-item {{ ($menu == $row_cat && $rm == 'pr_tindak_lanjut') ? 'active' : '' }}">
          <a class="nav-link {{ ($menu == strtolower($row_cat) && $rm == 'pr_tindak_lanjut') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapsePRegulerTL{{$row_cat}}" aria-expanded="true" aria-controls="collapsePB{{$row_cat}}">
            <span>{{$row_cat}}</span>
          </a>

          <div id="collapsePRegulerTL{{$row_cat}}" class="collapse {{ ($menu == strtolower($row_cat) && $rm == 'pr_tindak_lanjut') ? 'show' : '' }}" >
            <div class="bg-white py-2 collapse-inner rounded">
              @foreach($menu_sectors as $val)
                @if($val->category == $row_cat && ( in_array($val->alias, $sector_menu) || $user->user_level_id == 1 || $user->user_level_id == 3  || $user->user_level_id == 2))

                <?php
                  $link_name = $val->alias;
                ?>
                <a class="collapse-item {{ ($sb == $link_name && $rm == 'pr_tindak_lanjut')? 'active' : '' }} " href="{{url('pr/tindak-lanjutan/'.strtolower($val->category).'/'.$link_name)}}">{!! $val->nama !!}</a>
                @endif
              @endforeach

            </div>
          </div>
        </li>
        @endif

      @endforeach
    </ul>

  </li>
  @endif

  <hr class="sidebar-divider d-none d-md-block">
  <li class="nav-item {{($menu == "cetak_laporan")?'active': ''}}">
    <a class="nav-link {{($menu == "cetak_laporan")?'': 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseCetakLaporan" aria-expanded="true" aria-controls="collapseCetakLaporan">
      <!-- <i class="fa fa-user-circle" aria-hidden="true"></i> -->
      <span>Cetak Laporan</span>
    </a>
    @if($user->user_level_id == 1 || $user->user_level_id == 10 || $user->user_level_id == 4 || $user->user_level_id == 5 || $user->user_level_id == 6 || $user->user_level_id == 7 || $user->user_level_id == 3  || $user->user_level_id == 2)
    <div id="collapseCetakLaporan" class="collapse <?php if($menu == "cetak_laporan") echo 'show'?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item <?php if($sb == "hawasbid") echo 'active'?>" href="{{url('/laporan/hawasbid')}}">Hawasbid</a>
      </div>
    </div>
    @endif
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

   <li class="nav-item">
    <a class="nav-link " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fa fa-sign-out" aria-hidden="true"></i>
      <span>Keluar</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </li>

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
@endsection
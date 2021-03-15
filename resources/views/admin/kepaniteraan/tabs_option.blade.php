<div class="bd-example">
  <ul class="nav nav-tabs" >
    <li class="nav-item"> <a class="nav-link {{($tab_select == 1) ? 'active': ''}}" href="{{url(session('role').'/pengawas-bidang/'.strtolower($menu).'/'.$sub_menu)}}">Indikator</a></li>
    <li class="nav-item"> <a class="nav-link {{($tab_select == 2) ? 'active': ''}}" href="{{url(session('role').'/pengawas-bidang/'.strtolower($sector->category).'/'.$sub_menu.'/dokumentasi_rapat')}}">Dokumentasi Rapat</a></li>
  </ul>
</div>
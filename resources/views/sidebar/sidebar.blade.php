        @if(auth()->user()->tipo=="admin")
        <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
            <!-- Sidebar user panel -->      
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">              
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-graduation-cap"></i>
                  <span>Alumnos</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#" @click="menu=1"><i class="fa fa-circle-o"></i> Alumnos</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-user"></i>
                  <span>Mestros</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li @click="menu=2"><a href="#"><i class="fa fa-circle-o"></i> Maestros</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Extra clases</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li @click="menu=3"><a href="#"><i class="fa fa-circle-o"></i>Extra clases</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-user"></i>
                  <span>Chat</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li @click="menu=4"><a href="#"><i class="fa fa-circle-o"></i> Chat</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Carreras</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li @click="menu=5"><a href="#"><i class="fa fa-circle-o"></i>Carreras  </a></li>
                  <li @click="menu=6"><a href="#"><i class="fa fa-circle-o"></i>Grupos</a></li>
                </ul>
              </li>
               <li>
                <a href="#">
                  <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                  <small class="label pull-right bg-red">PDF</small>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                  <small class="label pull-right bg-yellow">JG</small>
                </a>
              </li>       
            </ul>
          </section>
        <!-- /.sidebar -->
        </aside>
      @endif
      @if(auth()->user()->tipo=="maestro")
        <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
            <!-- Sidebar user panel -->      
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
              
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-graduation-cap"></i>
                  <span>Asistencia</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#" @click="menu=1"><i class="fa fa-circle-o"></i> Pase de lista</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Portafolio</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li @click="menu=5"><a href="#"><i class="fa fa-circle-o"></i>Evidencias  </a></li>
                </ul>
              </li>
               <li>
                <a href="#">
                  <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                  <small class="label pull-right bg-red">PDF</small>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                  <small class="label pull-right bg-yellow">JG</small>
                </a>
              </li>       
            </ul>
          </section>
        <!-- /.sidebar -->
        </aside>
      @endif
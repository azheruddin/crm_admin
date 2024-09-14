<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="dashboard">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category"><hr></li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Employees</span>
                <i class="menu-arrow"></i>
              </a>
                    
              <div class="collapse" id="ui-basic"> 
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/add_employee">Add Employee</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/show_employee">Show Employee</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="#">Typography</a></li> -->                                               
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Calls</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/call_history">All Calls</a></li>
                </ul>

                <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/call_history_today">Today Calls</a></li>
                </ul>
               

                <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/show_call">Highest Calls</a></li>
                </ul>


               
                <!-- <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="#">Call History By Employee</a></li>
                </ul>
              </div>
            </li> -->
             <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Leads</span>
                <i class="menu-arrow"></i>
              </a>

              <!-- <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/add_leads">Add Leads</a></li>
                </ul>
              </div>
             -->

             <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/add_leads">Add Leads</a></li>
                </ul>
              </div>

              <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href='/assign_leads'>Assign Leads</a></li>
                </ul>
              </div>
            </li> 

              <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/leads_feedback">Leads Feedback</a></li>
                </ul>
              </div>

              <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/today_leads">Today Leads</a></li>
                </ul>
              </div>

              
              <!--  <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">Leadfeedback By Employee</a></li>
                </ul>
              </div> -->
               <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="upload">Upload Leads</a></li>
                </ul> 
              </div>
             

            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="leads_delete">Deleted Leads</a></li>
                </ul>
              </div>

              <!-- <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/leads_count{stateId}">Leads Count</a></li>
                </ul>
              </div> -->
                    
                    <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="collapse" href="#sales" aria-expanded="false" aria-controls="charts">
                     <i class="menu-icon mdi mdi-cash"></i>
                     <span class="menu-title">Sales</span>
                    <i class="menu-arrow"></i>
                      </a>  
                        </li>

              
              <div class="collapse" id="sales">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/all_sale">All Sales</a></li>
                </ul>
              </div>

              <div class="collapse" id="sales">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/today_sales">Today Sales</a></li>
                </ul>
              </div>
            
              <div class="collapse" id="sales">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/show_sale">Highest Sales</a></li>
                </ul>
              </div>

            <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#message" aria-expanded="false" aria-controls="charts">
            <i class="menu-icon mdi mdi-comment-text"></i>
            <span class="menu-title">Messages</span>
             <i class="menu-arrow"></i>
             </a>
             </li>

              
              <div class="collapse" id="message">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/add_message">Add Message</a></li>
                </ul>
              </div>

              <div class="collapse" id="message">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/show_message">Show Message</a></li>
                </ul>
              </div>
             



            
          <!-- <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                </ul>
              </div>
            </li> -->
            <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
 
                <a class="nav-link" :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                  <i class="menu-icon mdi mdi-file-document"></i>
                  <span class="menu-title">Logout</span>
                </a>

                <!-- <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                          this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link> -->
            </form>
              <!-- <a class="nav-link" href="/">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Logout</span>
              </a> -->
            </li>
          </ul>
        </nav>
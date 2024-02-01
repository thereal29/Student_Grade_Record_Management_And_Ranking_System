<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="{{set_active(['admin/dashboard'])}}">
                    <a class="linkmenu" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{set_active(['admin/profile'])}}">
                    <a class="linkmenu" href="{{ route('admin.profile') }}">
                    <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="submenu {{set_active(['admin/modules/student', 'admin/modules/student/profile', 'admin/modules/student/record', 'admin/modules/student/view=record'])}} {{ (request()->is('admin/modules/student')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/profile')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/record')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                    <li><a href="{{ route('admin/student_list') }}"  class="{{set_active(['admin/modules/student', 'admin/modules/student/profile'])}}">Student List</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active(['admin/modules/student/record', 'admin/modules/student/view=record'])}}">Student Records</a></li>
                        <li><a href="#" class="">Student Subjects</a></li>
                        <li><a href="#" class="">Student Adviser</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active([])}} {{ (request()->is()) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span>Faculty</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([])}}">Faculty List</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([])}}">Advisers</a></li>
                        <li><a href="#" class="">Subject Teacher</a></li>
                    </ul>
                </li>
                <li class="{{set_active(['admin/modules/subject'])}}">
                    <a class="linkmenu" href="{{ route('admin/subject') }}">
                    <i class="fas fa-book"></i>
                        <span>Subject List</span>
                    </a>
                </li>
                <li class="submenu {{set_active([''])}} {{ (request()->is('admin/modules/student_record')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-clipboard"></i>
                        <span>Reports & Results</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([])}}">Honor Roll Reports</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([])}}">Promotion Candidates</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([])}}">Co Curricular Activity</a></li>
                        <li><a href="#" class="">Character Evaluation</a></li>
                    </ul>
                </li>
                
                <li class="submenu {{set_active([''])}} {{ (request()->is('')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-file-signature"></i>
                        <span>Validation</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Student Grades</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Co Curricular Activity</a></li>
                    </ul>
                </li>
                <li class="">
                    <a class="text-muted"type="button" data-bs-toggle="modal" data-bs-target="#changeSY">
                    <i class='fas fa-calendar'></i>
                    <span>Change School Year</span>
                    </a>
                </li>
                <li class="menu-title">
                    <span>Management</span>
                </li>
                <li class="submenu {{set_active([''])}} {{ (request()->is('')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-shield-alt"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Students</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Faculty</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Staff</a></li>
                    </ul>
                </li>
                <li class="{{set_active(['admin/dashboard'])}}">
                    <a class="linkmenu" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                        <span>School Year</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
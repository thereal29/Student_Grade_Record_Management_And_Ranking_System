<div class="sidebar" id="sidebar" style="box-shadow: 0 10px 10px 0 #05300e;" >
    <img style="max-width:100%;" class="img-fluid pb-2" src="{{ URL::to('assets/img/pangasugan.png') }}" alt="Logo">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu pb-5">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                @if(auth()->user()->role == 'Administrator' || auth()->user()->role == 'Super Administrator')
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
                <li class="submenu {{set_active(['admin/modules/student', 'admin/modules/student/profile', 'admin/modules/student/record', 'admin/modules/student/view=record', 'admin/modules/student/subject', 'admin/modules/student/view=subject'])}} {{ (request()->is('admin/modules/student')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/profile')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/record')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/record')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/view=subject')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                    <li><a href="{{ route('admin/student_list') }}"  class="{{set_active(['admin/modules/student', 'admin/modules/student/profile'])}}">Student List</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active(['admin/modules/student/record', 'admin/modules/student/view=record'])}}">Student Records</a></li>
                        <li><a href="{{ route('admin/student_subject') }}" class="{{set_active(['admin/modules/student/subject','admin/modules/student/view=subject'])}}">Student Subjects</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active(['admin/modules/faculty', 'admin/modules/view=faculty', 'admin/modules/faculty/view=class'])}} {{ (request()->is('admin/modules/faculty')) ? 'active' : '' }} {{ (request()->is('admin/modules/view_faculty')) ? 'active' : '' }} {{ (request()->is('admin/modules/faculty/view=class')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span>Faculty</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/faculty') }}"  class="{{set_active(['admin/modules/faculty', 'admin/modules/view=faculty'])}}">Faculty List</a></li>
                        <li><a class="{{set_active(['admin/modules/faculty/view=class'])}}">Classes Hadled</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active(['admin/modules/classes'])}}">
                    <a class="linkmenu" href="#">
                    <i class="fas fa-book"></i>
                        <span>Other Master List</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/class_list') }}"  class="{{set_active(['admin/modules/class'])}}">Class</a></li>
                        <li><a href="{{ route('admin/class_advisory_list') }}"  class="{{set_active(['admin/modules/class_advisory'])}}">Class Advisory</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active([''])}}">
                    <a class="linkmenu" href="#"><i class="fas fa-clipboard"></i>
                        <span>Reports & Results</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Honor Roll Reports</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Promotion Candidates</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active([''])}}">Co Curricular Activity</a></li>
                        <li><a href="#" class="">Character Evaluation</a></li>
                    </ul>
                </li>
                <li class="submenu {{set_active([''])}}">
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
                    <i class='fas fa-calendar-check'></i>
                    <span>Change School Year</span>
                    </a>
                </li>
                <li class="menu-title">
                    <span>Management</span>
                </li>
                @if(auth()->user()->role == 'Administrator')
                <li class="submenu {{set_active(['admin/modules/users/student', 'admin/modules/users/student/view=add', 'admin/modules/users/faculty','admin/modules/users/faculty/view=add', 'admin/modules/users/staff', 'admin/modules/users/staff/view=add'])}} pb-3">
                    <a class="linkmenu" href="#"><i class="fas fa-users"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin.student-user') }}"  class="{{set_active(['admin/modules/users/student', 'admin/modules/users/student/view=add'])}}">Students</a></li>
                        <li><a href="{{ route('admin.faculty-user') }}"  class="{{set_active(['admin/modules/users/faculty','admin/modules/users/faculty/view=add'])}}">Faculty</a></li>
                        <li><a href="{{ route('admin.staff-user') }}"  class="{{set_active(['admin/modules/users/staff', 'admin/modules/users/staff/view=add'])}}">Staff</a></li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->role == 'Super Administrator')
                <li class="submenu {{set_active(['admin/modules/users/student', 'admin/modules/users/student/view=add', 'admin/modules/users/faculty','admin/modules/users/faculty/view=add', 'admin/modules/users/staff', 'admin/modules/users/staff/view=add'])}}">
                    <a class="linkmenu" href="#"><i class="fas fa-users"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('admin.student-user') }}"  class="{{set_active(['admin/modules/users/student', 'admin/modules/users/student/view=add'])}}">Students</a></li>
                        <li><a href="{{ route('admin.faculty-user') }}"  class="{{set_active(['admin/modules/users/faculty','admin/modules/users/faculty/view=add'])}}">Faculty</a></li>
                        <li><a href="{{ route('admin.staff-user') }}"  class="{{set_active(['admin/modules/users/staff', 'admin/modules/users/staff/view=add'])}}">Staff</a></li>
                    </ul>
                </li>
                <li class="{{set_active(['admin/modules/school_year/index'])}} pb-3">
                    <a class="linkmenu" href="{{ route('admin.school_year') }}">
                    <i class="fas fa-calendar"></i>
                        <span>School Year</span>
                    </a>
                </li>
                @endif
                @endif
                @if(auth()->user()->role == 'Faculty')
                <li class="{{set_active(['faculty/dashboard'])}}">
                    <a class="linkmenu" href="{{ route('faculty.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{set_active(['faculty/profile'])}}">
                    <a class="linkmenu" href="{{ route('faculty.profile') }}">
                    <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="submenu {{set_active(['admin/modules/student', 'admin/modules/student/profile', 'admin/modules/student/record', 'admin/modules/student/view=record', 'admin/modules/student/subject', 'admin/modules/student/view=subject'])}} {{ (request()->is('admin/modules/student')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/profile')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/record')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/record')) ? 'active' : '' }} {{ (request()->is('admin/modules/student/view=subject')) ? 'active' : '' }}">
                    <a class="linkmenu" href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Teacher's Portal</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                    <li><a href="{{ route('admin/student_list') }}"  class="{{set_active(['admin/modules/student', 'admin/modules/student/profile'])}}">Student Advisory</a></li>
                        <li><a href="{{ route('admin/student_record') }}"  class="{{set_active(['admin/modules/student/record', 'admin/modules/student/view=record'])}}">Student Records</a></li>
                        <li><a href="{{ route('admin/student_subject') }}" class="{{set_active(['admin/modules/student/subject','admin/modules/student/view=subject'])}}">Classes Handled</a></li>
                    </ul>
                </li>
                @if(Session::get('role') == 'Adviser')
                <li class="{{set_active(['admin/modules/subject'])}}">
                    <a class="linkmenu" href="#">
                    <i class="fas fa-award"></i>
                        <span>Honor Roll Ranking</span>
                    </a>
                </li>
                @endif
                <li class="">
                    <a class="text-muted"type="button" data-bs-toggle="modal" data-bs-target="#changeSY">
                    <i class='fas fa-calendar-check'></i>
                    <span>Change School Year</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->role == 'Junior High School Student' || auth()->user()->role == 'Senior High School Student')
                <li class="{{set_active(['student/dashboard'])}}">
                    <a class="linkmenu" href="{{ route('student.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{set_active(['student/profile'])}}">
                    <a class="linkmenu" href="{{ route('student.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{set_active(['student/modules/grades'])}}">
                    <a class="linkmenu" href="{{ route('student.grades')}}">
                    <i class="fas fa-star"></i>
                        <span>Grades</span>
                    </a>
                </li>
                @if(Session::get('grade_level') == 'Grade 10' || Session::get('grade_level') == 'Grade 12')
                <li class="{{set_active([''])}}">
                    <a class="linkmenu" href="#">
                    <i class="fas fa-award"></i>
                        <span>Honor Roll Ranking</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->role == 'Junior High School Student')
                <li class="{{set_active(['student/modules/co_curricular_activity'])}}">
                    <a class="linkmenu" href="{{ route('student.co_curricular_activity') }}">
                    <i class="fas fa-shapes"></i>
                        <span>Co Curricular Activity</span>
                    </a>
                </li>
                @if(Session::get('grade_level') == 'Grade 10')
                <li class="{{set_active(['student/modules/character_evaluation'])}}">
                    <a class="linkmenu" href="{{ route('student.co_curricular_activity') }}">
                    <i class="fas fa-clipboard"></i>
                        <span>Character Evaluation</span>
                    </a>
                </li>
                @endif
                @endif
                @endif
            </ul>
        </div>
    </div>
</div>
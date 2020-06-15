<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <img src="{{ asset('img/logo.png') }}" style="width: 50%;" class="mx-auto my-3" />

    <!-- Divider -->
    <hr class="sidebar-divider my-3">

    @if(auth()->guard('teacher')->check())
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @elseif(auth()->guard('student')->check())
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('student.home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @else
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @endif

    @if(auth()->check())
        @can('institution-show')
            <!-- Nav Item - Users -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('institution.show') }}">
                        <i class="fas fa-fw fa-school"></i>
                        <span>@lang('messages.institution')</span>
                    </a>
                </li>
        @endcan

        @can('user-list')
            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>@lang('messages.users')</span>
                </a>
            </li>
        @endcan

        @can('role-list')
            <!-- Nav Item - Users -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('role.index') }}">
                        <i class="fas fa-fw fa-users-cog"></i>
                        <span>@lang('messages.userRoles')</span>
                    </a>
                </li>
        @endcan

        @can('teacher-list')
            <!-- Nav Item - Teachers -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teacher.index') }}">
                        <i class="fas fa-fw fa-chalkboard-teacher"></i>
                        <span>@lang('messages.teachers')</span>
                    </a>
                </li>
        @endcan

        @can('student-list')
            <!-- Nav Item - Teachers -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.index') }}">
                        <i class="fas fa-fw fa-user-graduate"></i>
                        <span>@lang('messages.students')</span>
                    </a>
                </li>
        @endcan

        @can('course-type-list')
            <!-- Nav Item - Teachers -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('courseType.index') }}">
                    <i class="fas fa-fw fa-university"></i>
                    <span>@lang('messages.courseTypes')</span>
                </a>
            </li>
        @endcan

        @can('course-list')
            <!-- Nav Item - Teachers -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('course.index') }}">
                    <i class="fas fa-fw fa-university"></i>
                    <span>@lang('messages.courses')</span>
                </a>
            </li>
        @endcan

        @can('study-subject-list')
            <!-- Nav Item - Teachers -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('studySubject.index') }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>@lang('messages.studySubjects')</span>
                    </a>
                </li>
        @endcan
    @endif

    @if(auth()->guard('teacher')->check())
        <!-- Nav Item - Teachers -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('course.index') }}">
                <i class="fas fa-fw fa-university"></i>
                <span>@lang('messages.courses')</span>
            </a>
        </li>
    @endif

    @if(auth()->guard('student')->check())
        <!-- Nav Item - Teachers -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('course.index') }}">
                <i class="fas fa-fw fa-university"></i>
                <span>@lang('messages.courses')</span>
            </a>
        </li>
    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

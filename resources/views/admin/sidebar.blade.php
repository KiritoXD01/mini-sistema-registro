<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @can('user-list')
    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>@lang('messages.users')</span>
        </a>
    </li>
    @endif

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

</ul>
<!-- End of Sidebar -->

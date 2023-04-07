<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="{{route('leave_application.home')}}" class="brand-link">
        <span class="h3 brand-text font-weight-light">Leave Application</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include("leaveapplication::layouts.menu")
            </ul>
        </nav>
    </div>

</aside>

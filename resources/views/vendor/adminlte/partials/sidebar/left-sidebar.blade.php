<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if (config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">
                <li class="nav-header ">
                    MENÚ PRINCIPAL
                </li>

                <li class="nav-item has-treeview">
                    <a class="nav-link" href="">
                        <i class="fas fa-tag"></i>
                        <p>Entidades principales<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('listHotels') }}">
                                <i class="fas fa-city"></i>
                                <p>Gestión de Hoteles</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>


</aside>

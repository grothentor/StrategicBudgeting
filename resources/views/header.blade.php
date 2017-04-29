<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name') }}
        </a>
    </div>
    <ul class="nav navbar-nav">
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Вход</a></li>
        @else
            <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                Выход
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <li><a href="{{ URL::to('subdivisions') }}">Подразделения</a></li>
            <li><a href="{{ URL::to('kpis') }}">Показатели эффективности</a></li>
            <li><a href="{{ URL::to('budgets-idicators') }}">Показатели бюджетов</a></li>
        @yield('extra-links')
        @endif
    </ul>
</nav>
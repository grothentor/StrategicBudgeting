<nav class="navbar navbar-inverse">
    <!--<div class="navbar-header">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
    </div>-->
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            @if (!auth()->guest())
                <li><a href="{{ URL::to('experiments') }}">Експерименты</a></li>
                <li><a href="{{ URL::to('subdivisions') }}">Подразделения</a></li>
                <li><a href="{{ URL::to('kpis') }}">Показатели эффективности</a></li>
                <li><a href="{{ URL::to('budget-indicators') }}">Показатели бюджетов</a></li>
            @yield('extra-links')
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (auth()->guest())
                <li><a href="{{ route('login') }}">Вход</a></li>
            @else
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
                @endif
            </li>
        </ul>
    </div>
</nav>
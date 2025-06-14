<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sm/layout.css') }}">
    @stack('styles')
    <link rel="icon" href="{{ asset('logoku.png') }}" type="image/png">
    <title>@yield('title', 'Dashboard')</title>
</head>

<body>
    <nav id="navbar">
        <div class="nav-header">
            <h1 id="nama"><i class="fas fa-car-side mr-2"></i> Kendaraan</h1>
        </div>

        <ul id="poin_navbar">
            <li>
                <a href="{{ route('sm.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sm.persetujuan.index') }}">
                    <i class="fas fa-circle-check"></i>
                    <span>Persetujuan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sm.servis.index') }}">
                    <i class="fas fa-tools"></i>
                    <span>Riwayat Servis</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sm.bbm.index') }}">
                    <i class="fas fa-gas-pump"></i>
                    <span>Riwayat BBM</span>
                </a>
            </li>
        </ul>

        <div class="nav-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div id="content">
        @yield('content')
    </div>

    <script>
        window.onload = function () {
            const links = document.querySelectorAll('#poin_navbar a');
            links.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add('active');
                }
            });
        };
    </script>

    @stack('scripts')
</body>

</html>
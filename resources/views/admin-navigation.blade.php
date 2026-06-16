<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/">Navbar - Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/add-weather') ? 'active' : '' }}" href="/admin/add-weather">Add Weather</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/weather') ? 'active' : '' }}" href="/admin/weather">Weather</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

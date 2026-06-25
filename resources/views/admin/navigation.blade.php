<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/admin/weather">Navbar - Admin</a>
        <div class="collapse navbar-collapse justify-content-lg-center" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/add-weather') ? 'active' : '' }}" href="/admin/add-weather">Add Weather</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/weather') ? 'active' : '' }}" href="/admin/weather">Weather</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/add-forecast') ? 'active' : '' }}"
                       href="/admin/add-forecast">Add Forecast</a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label for="themeSwitch" class="m-0">
                    <i id="themeIcon" class="bi bi-sun-fill fs-5"></i>
            </label>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="themeSwitch">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

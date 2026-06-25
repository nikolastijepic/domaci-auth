<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/">Navbar</a>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('weather') ? 'active' : '' }}" href="/weather">Weather</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('forecasts') ? 'active' : '' }}" href="/forecasts">Forecasts</a>
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

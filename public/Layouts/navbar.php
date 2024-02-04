<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <!-- Logo on the left with some margin to push it to the right -->
        <a class="navbar-brand ms-3" href="/"> <!-- ms-3 for margin start -->
            <img src="/images/bullet.png" alt="Logo" style="height: 35px;"> <!-- Adjust logo size as needed -->
        </a>
        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu items -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
         <!-- ms-auto class pushes the form to the right -->
        <div class="d-flex ms-auto">
            <form action="/search" method="GET" class="d-flex" required>
                <input type="text" name="query" class="form-control me-2" placeholder="Search...">
                <button type="submit" class="btn btn-outline-success me-2">Search</button>
            </form>
        </div>
        </nav>
    </header>


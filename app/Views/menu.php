<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white"
    style="width: 250px; height: 100vh; position: fixed;">
    <a href="<?= base_url(); ?>"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">MyApp</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('/home/dashboard'); ?>" class="nav-link text-white active" aria-current="page">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('/home/user'); ?>" class="nav-link text-white">
                <i class="bi bi-people"></i> User
            </a>
        </li>
        <li>
            <a href="<?= base_url('/home/absen'); ?>" class="nav-link text-white">
                <i class="bi bi-shield-lock"></i> Absen
            </a>
        </li>
        <li>
            <a href="<?= base_url('/home/setting'); ?>" class="nav-link text-white">
                <i class="bi bi-gear"></i> Settings
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://via.placeholder.com/32" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Admin</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>
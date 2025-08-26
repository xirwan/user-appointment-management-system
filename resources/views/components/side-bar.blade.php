<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Appointment</div>
            <a class="nav-link" href="{{ route('appointments.create') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></i></div>
                Create Appointment
            </a>
            <a class="nav-link" href="{{ route('appointments.index') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-eye"></i></i></div>
                View Appointments
            </a>
        </div>
    </div>
</nav>
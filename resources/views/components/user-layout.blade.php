<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" >
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />

</head>
<body class="sb-nav-fixed">
    
    <x-nav-bar />

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <x-side-bar />

        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    {{ $slot }}

                </div>
            </main>

            <x-footer />

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 3000);
            }
        });

        if (document.getElementById('current-time')) {
            const userTimezone = "{{ Auth::user()->preferred_timezone }}";

            function updateDateTime() {
                const now = new Date();

                const timeFormatter = new Intl.DateTimeFormat('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    timeZone: userTimezone,
                    hour12: false
                });

                const dateFormatter = new Intl.DateTimeFormat('en-GB', {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    timeZone: userTimezone
                });

                const currentTime = timeFormatter.format(now);
                const currentDate = dateFormatter.format(now);

                if (document.getElementById('current-time') && document.getElementById('current-date')) {
                    document.getElementById('current-time').textContent = currentTime;
                    document.getElementById('current-date').textContent = currentDate;
                }
            }

                updateDateTime();
                setInterval(updateDateTime, 1000);
        }
        
        flatpickr("#start_time_picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y at h:i K",
            minDate: "today"
        });

        flatpickr("#end_time_picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y at h:i K",
            minDate: "today"
        });

        $(document).ready(function() {
            $('#participants-select').select2({
                theme: 'bootstrap-5',
                placeholder: 'Type to search for users...',
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('users.search') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                }
            });

            $('#preferred_timezone').select2({
                theme: 'bootstrap-5'
            });
        }); 
    </script>
</body>
</html>
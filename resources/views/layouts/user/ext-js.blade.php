<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Libs JS -->
<script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js?1684106062') }}" defer></script>
<script src="{{ asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') }}" defer></script>
<script src="{{ asset('dist/libs/jsvectormap/dist/maps/world.js?1684106062') }}" defer></script>
<script src="{{ asset('dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062') }}" defer></script>
<!-- Tabler Core -->
<script src="{{ asset('dist/js/tabler.min.js?1684106062') }}" defer></script>
<script src="{{ asset('dist/js/demo.min.js?1684106062') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });

    @if (session('success'))
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{!! session('success') !!}',
            showConfirmButton: false,
            timer: 3000,
            toast: true
        })
    @endif

    $('body').on('click', '#logout', function() {
        Swal.fire({
            title: 'Apakah kamu yakin akan keluar',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'Tidak',
            cancelButtonColor: '#FF0000',
        }).then(function(result) {
            if (result.value) {
                $('#logout-form').submit();
            }
        })
    })

    function formatDate(dateString) {
        let months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        let date = new Date(dateString);
        let day = date.getDate();
        let monthIndex = date.getMonth();
        let year = date.getFullYear();
        return day + ' ' + months[monthIndex] + ' ' + year;
    }

    function formatTime(timeString) {
        let timeParts = timeString.split(':');

        let hours = timeParts[0];
        let minutes = timeParts[1];

        if (hours.length === 1) {
            hours = '0' + hours;
        }
        if (minutes.length === 1) {
            minutes = '0' + minutes;
        }

        return hours + ':' + minutes;
    }

    $(document).ready(function() {
        // Fungsi untuk memanggil endpoint Laravel saat halaman dimuat
        $.ajax({
            url: "{{ route('check') }}",
            method: "GET",
            success: function(response) {
                // Lakukan sesuatu dengan respons dari server
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika ada
                console.error(error);
            }
        });
    });
</script>

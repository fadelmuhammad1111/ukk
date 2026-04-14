<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background: #1e293b;
            color: white;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 8px;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .brand {
            font-weight: bold;
            font-size: 20px;
        }

        .menu-title {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar p-3" style="width:250px;">

        <div class="brand mb-3">Inventory</div>
        <hr>

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}">Dashboard</a>

        {{-- ================= ADMIN ================= --}}
        @if(auth()->user()->role == 'admin')

            <div class="menu-title">Admin Menu</div>

            <a href="{{ route('categories.index') }}">Kategori</a>
            <a href="{{ route('items.index') }}">Items</a>
            <a href="{{ route('users.index') }}">Users</a>

        @endif

        {{-- ================= STAFF ================= --}}
        @if(auth()->user()->role == 'staff')

            <div class="menu-title">Staff Menu</div>

            <a href="{{ route('items.index') }}">Items</a>
            <a href="{{ route('borrowings.index') }}">Peminjaman</a>
            <a href="{{ route('users.index') }}">Users</a>

        @endif

        <hr>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>

    </div>

    <!-- CONTENT -->
    <div class="p-4 w-100">

        {{-- 🔥 TOASTR MESSAGE --}}
        @if(session('success'))
            <script>
                window.onload = () => {
                    toastr.success("{{ session('success') }}");
                }
            </script>
        @endif

        @if(session('error'))
            <script>
                window.onload = () => {
                    toastr.error("{{ session('error') }}");
                }
            </script>
        @endif

        {{-- 🔥 VALIDATION ERROR --}}
        @if($errors->any())
            <script>
                window.onload = () => {
                    @foreach($errors->all() as $error)
                        toastr.error("{{ $error }}");
                    @endforeach
                }
            </script>
        @endif

        @yield('content')

    </div>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- 🔥 TOASTR CONFIG --}}
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
</script>

{{-- 🔥 SWEET ALERT DELETE --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</body>
</html>
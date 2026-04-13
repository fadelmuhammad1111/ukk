@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Dashboard</h3>
    </div>

    <!-- CARDS -->
    <div class="row g-3">

        <!-- TOTAL ITEM -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Item</h6>
                    <h3 class="fw-bold">{{ \App\Models\Item::count() }}</h3>
                </div>
            </div>
        </div>

        <!-- KATEGORI -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Kategori</h6>
                    <h3 class="fw-bold">{{ \App\Models\Category::count() }}</h3>
                </div>
            </div>
        </div>

        <!-- DIPINJAM -->
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Dipinjam</h6>
                    <h3 class="fw-bold">{{ \App\Models\Item::sum('total_borrowed') }}</h3>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

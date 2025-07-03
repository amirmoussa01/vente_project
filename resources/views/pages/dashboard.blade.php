{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.bootstrap')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
        </nav>
    </div>
    <div class="container-fluid px-4 mt-4">
    <h1 class="mt-4 mb-4 text-purple-emphasis">Tableau de bord</h1>

    <div class="row">

        <!-- Card Produits achetés -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-5 fw-semibold">Produits achetés</div>
                        <div class="display-4 fw-bold">{{ $produitsAchatCount }}</div>
                    </div>
                    <div>
                        <i class="bi bi-bag-check-fill fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('pages.produits.index')}}" class="small text-white stretched-link">Voir les détails</a>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

        <!-- Card Paniers commandés -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-white mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-5 fw-semibold">Paniers commandés</div>
                        <div class="display-4 fw-bold">{{ $paniersCommandesCount }}</div>
                    </div>
                    <div>
                        <i class="bi bi-cart-check-fill fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('pages.paniers.index')}}" class="small text-white stretched-link">Voir les détails</a>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

        <!-- Card Commandes en cours -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-5 fw-semibold">Commandes en cours</div>
                        <div class="display-4 fw-bold">{{ $commandesEnCoursCount }}</div>
                    </div>
                    <div>
                        <i class="bi bi-clock-history fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('pages.commandes.index')}}" class="small text-white stretched-link">Voir les détails</a>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <i class="bi bi-bar-chart-fill me-2"></i>
            Statistiques d'achat mensuelles ({{ \Carbon\Carbon::now()->year }})
        </div>
        <div class="card-body">
            <canvas id="chartAchatMensuel" height="100"></canvas>
        </div>
    </div>
</div>

{{-- Bootstrap Icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartAchatMensuel').getContext('2d');
    const data = @json(array_values($statsMoisComplets));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Achats',
                data: data,
                backgroundColor: 'rgba(111, 66, 193, 0.7)',
                borderColor: 'rgba(111, 66, 193, 1)',
                borderWidth: 1,
                borderRadius: 4,
                hoverBackgroundColor: 'rgba(111, 66, 193, 0.9)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 10 }
                }
            },
            plugins: {
                legend: { labels: { color: '#4c1d95' } }
            }
        }
    });
</script>
@endsection
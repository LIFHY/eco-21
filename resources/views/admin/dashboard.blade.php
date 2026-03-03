@extends('admin.layout')

@section('title','Dashboard')

@section('content')
    <div class="dashboard-header">
        <div>
            <h2>Dashboard</h2>
            <p class="breadcrumb">Home > Dashboard</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.products.create') }}" class="btn-primary-admin">
                <span>➕</span> Produk Baru
            </a>
            <a href="{{ route('admin.content.index') }}" class="btn-primary-admin">
                <span>📝</span> Kelola Konten
            </a>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card-admin">
            <div class="stat-icon products">📦</div>
            <div class="stat-content">
                <h3>Total Produk</h3>
                <p class="stat-number">{{ \App\Models\Product::count() }}</p>
            </div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>Pengunjung</h3>
                <p class="stat-number">10,249</p>
            </div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-icon">⭐</div>
            <div class="stat-content">
                <h3>Rating</h3>
                <p class="stat-number">4.8/5.0</p>
            </div>
        </div>

        <div class="stat-card-admin">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3>Status</h3>
                <p class="stat-number" style="color: #059669;">Aktif</p>
            </div>
        </div>
    </div>
@endsection

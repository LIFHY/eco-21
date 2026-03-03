<nav class="navbar">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <div class="navbar-logo">GE</div>
            <span>Galeri Eco 21</span>
        </a>
        
        <ul class="navbar-menu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#produk">Produk</a></li>
            <li><a href="#testimoni">Testimoni</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
        
        <a href="{{ route('admin.login') }}" class="btn-login">Log In</a>
    </div>
</nav>
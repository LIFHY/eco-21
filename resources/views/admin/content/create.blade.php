@extends('admin.layout')

@section('title', 'Tambah Konten Baru')

@section('content')
<div class="create-header">
    <h1>Tambah Konten Baru</h1>
    <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="key">Key (Identifier Unik)</label>
            <input type="text" id="key" name="key" value="{{ old('key') }}" class="form-control" required>
            <small>Contoh: hero_title, about_description, product_advantage_1</small>
        </div>

        <div class="form-group">
            <label for="content_type">Tipe Konten</label>
            <select id="content_type" name="content_type" class="form-control" required onchange="updateFormFields()">
                <option value="">Pilih tipe konten</option>
                <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text (Satu baris)</option>
                <option value="textarea" {{ old('content_type') == 'textarea' ? 'selected' : '' }}>Textarea (Multi-baris)</option>
                <option value="number" {{ old('content_type') == 'number' ? 'selected' : '' }}>Angka</option>
                <option value="image" {{ old('content_type') == 'image' ? 'selected' : '' }}>Gambar</option>
            </select>
        </div>

        <div class="form-group" id="content-field-group">
            <label for="content">Konten</label>
            <input type="text" id="content" name="content" value="{{ old('content') }}" class="form-control">
        </div>

        <div class="form-group" id="image-field-group" style="display: none;">
            <label for="image">Upload Gambar</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <small>Format: JPG, PNG. Ukuran maksimal: 2MB</small>
        </div>

        <div class="form-group">
            <label for="section">Bagian (Section)</label>
            <select id="section" name="section" class="form-control" required>
                <option value="">Pilih bagian</option>
                <option value="hero" {{ old('section') == 'hero' ? 'selected' : '' }}>Hero</option>
                <option value="about" {{ old('section') == 'about' ? 'selected' : '' }}>Tentang Kami</option>
                <option value="stats" {{ old('section') == 'stats' ? 'selected' : '' }}>Statistik</option>
                <option value="products" {{ old('section') == 'products' ? 'selected' : '' }}>Produk</option>
                <option value="advantages" {{ old('section') == 'advantages' ? 'selected' : '' }}>Keunggulan Produk</option>
                <option value="testimonial" {{ old('section') == 'testimonial' ? 'selected' : '' }}>Testimoni</option>
                <option value="cta" {{ old('section') == 'cta' ? 'selected' : '' }}>Call to Action</option>
                <option value="other" {{ old('section') == 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="order">Urutan</label>
            <input type="number" id="order" name="order" value="{{ old('order', 0) }}" class="form-control" min="0">
            <small>Untuk konten dengan beberapa item, tentukan urutan tampilan</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Konten</button>
            <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function updateFormFields() {
    const contentType = document.getElementById('content_type').value;
    const contentField = document.getElementById('content-field-group');
    const imageField = document.getElementById('image-field-group');
    const contentInput = document.getElementById('content');
    const imageInput = document.getElementById('image');

    if (contentType === 'image') {
        contentField.style.display = 'none';
        imageField.style.display = 'block';
        contentInput.removeAttribute('required');
        imageInput.setAttribute('required', 'required');
    } else {
        contentField.style.display = 'block';
        imageField.style.display = 'none';
        imageInput.removeAttribute('required');
        
        if (contentType === 'textarea') {
            contentInput.parentElement.innerHTML = `<label for="content">Konten</label><textarea id="content" name="content" class="form-control" rows="6" required>${contentInput.value}</textarea>`;
        } else {
            contentInput.setAttribute('required', 'required');
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateFormFields);
</script>

<style>
    .create-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .form-container {
        background-color: #fff;
        padding: 2rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        font-family: inherit;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #545b62;
    }

    .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .alert-danger li {
        margin-bottom: 0.5rem;
    }

    small {
        display: block;
        margin-top: 0.25rem;
        color: #6c757d;
        font-size: 0.875rem;
    }
</style>

@endsection

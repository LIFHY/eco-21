@extends('layouts.app')

@section('content')
<div class="container">
    <div class="product-page">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="back-button">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    <!-- Main Product Container -->
    <div class="product-detail">
        <!-- Product Image Gallery Section -->
        <div class="product-gallery">
            <div class="main-image">
                @php
                    $imgUrl = $product->image ? asset($product->image) : 'https://placehold.co/600x700/CD853F/white?text='.urlencode($product->name);
                @endphp
                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" id="mainImage">
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="product-info">
            <!-- Header -->
            <div class="breadcrumb">
                <a href="/">Beranda</a>
                <span>/</span>
                <a href="/#produk">Produk</a>
                <span>/</span>
                <span>{{ $product->name }}</span>
            </div>
            
            <div class="product-category-badge">Produk Unggulan</div>
            
            <h1 class="product-title">{{ $product->name }}</h1>

            <!-- Price Section -->
            <div class="price-section">
                <div class="price-wrapper">
                    <span class="current-price">Rp{{ number_format($product->price,0,',','.') }}</span>
                    <span class="member-save">Harga dari produsen ✓</span>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="description-section">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            <!-- Features -->
            <div class="description-section">
                <h3>Keunggulan Produk</h3>
                <ul style="list-style: none; padding-left: 0; margin: 0;">
                    <li style="color: #4b5563; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #059669; font-weight: bold;">✓</span> Dibuat oleh UMKM lokal Banyumas terpercaya
                    </li>
                    <li style="color: #4b5563; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #059669; font-weight: bold;">✓</span> Bahan berkualitas tinggi dan alami
                    </li>
                    <li style="color: #4b5563; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #059669; font-weight: bold;">✓</span> Cita rasa autentik yang lezat
                    </li>
                    <li style="color: #4b5563; margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #059669; font-weight: bold;">✓</span> Dikemas dengan rapi dan higienis
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="https://wa.me/{{ env('WHATSAPP_NUMBER','6281234567890') }}?text={{ urlencode('Halo, saya tertarik dengan produk ' . $product->name . ' (Rp' . number_format($product->price,0,',','.') . ')') }}" target="_blank" class="btn-wa">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-1.56.934-2.846 2.271-3.694 3.782C1.896 10.56 1.59 12.446 2.476 14.232c.886 1.787 2.474 3.285 4.399 4.155a9.84 9.84 0 004.844 1.245h.005c.838 0 1.666-.063 2.468-.187 2.041-.314 3.869-1.188 5.115-2.674 1.246-1.486 1.872-3.35 1.872-5.322 0-1.415-.274-2.74-.814-3.961-.54-1.22-1.31-2.3-2.282-3.16-.972-.86-2.127-1.528-3.4-1.978-1.273-.45-2.618-.68-4.028-.68zm0 0"/>
                    </svg>
                    <span>Beli via WhatsApp</span>
                </a>
                <a href="{{ env('TOKOPEDIA_LINK','https://www.tokopedia.com/search?q=') }}{{ urlencode($product->name) }}" target="_blank" class="btn-tokped">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                    </svg>
                    <span>Beli di Tokopedia</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <div class="reviews-container">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reviews Header -->
            <div class="reviews-header">
                <h2>Ulasan Produk</h2>
                <p class="reviews-subtitle">{{ $product->review_count }} ulasan dari pelanggan</p>
            </div>

            <!-- Reviews List -->
            @if($product->reviews->count() > 0)
                <div class="reviews-list">
                    @foreach($product->reviews->sortByDesc('created_at') as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">
                                    <h4>{{ $review->name }}</h4>
                                    <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="review-comment">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="no-reviews">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan!</p>
            @endif

            <!-- Review Form -->
            <div class="review-form-section">
                <h3>Tambahkan Ulasan Anda</h3>
                <form action="{{ route('review.store', $product) }}" method="POST" class="review-form">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Anda</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email Anda">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <div class="rating-input">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                <label for="rating{{ $i }}" class="star-label">★</label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment">Ulasan Anda</label>
                        <textarea id="comment" name="comment" rows="6" required placeholder="Tuliskan pengalaman Anda dengan produk ini...">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="related-products-section">
        <h2 class="related-title">Produk Lainnya yang Mungkin Anda Sukai</h2>
        <div class="related-grid">
            @php
                $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
                    ->take(4)
                    ->get();
            @endphp
            @foreach($relatedProducts as $relatedProduct)
                <a href="{{ route('product.show', $relatedProduct->id) }}" class="related-card">
                    <div class="product-card-image-wrap">
                        @php
                            $relatedImgUrl = $relatedProduct->image ? asset($relatedProduct->image) : 'https://placehold.co/300x300/CD853F/white?text='.urlencode($relatedProduct->name);
                        @endphp
                        <img src="{{ $relatedImgUrl }}" alt="{{ $relatedProduct->name }}">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">{{ $relatedProduct->name }}</h4>
                        <div class="product-price">
                            Rp{{ number_format($relatedProduct->price,0,',','.') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        </div>
    </div>
</div>
@endsection

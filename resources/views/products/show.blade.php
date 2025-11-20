<x-layout>
    <h1>{{ $product->name }}</h1>

    <p><strong>Apraksts:</strong> {{ $product->description }}</p>
    <p><strong>Cena:</strong> €{{ $product->price }}</p>
    <p><strong>Daudzums noliktavā:</strong> <span id="product-quantity">{{ $product->quantity }}</span></p>
    <p><strong>Statuss:</strong> {{ $product->status }}</p>
    <p><strong>Derīguma termiņš:</strong> {{ $product->expiration_date }}</p>

    <!-- Quantity buttons -->
    <div class="quantity-buttons">
        <button class="quantity-btn" data-action="increase" data-url="{{ route('products.increase', $product) }}">+ Palielināt</button>
        <button class="quantity-btn" data-action="decrease" data-url="{{ route('products.decrease', $product) }}">− Samazināt</button>
    </div>

    <hr>

    <!-- Tags Section -->
    <h3>Birkas:</h3>
    <ul id="product-tags">
        @foreach($product->tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
    </ul>

    <input type="text" id="new-tag-name" placeholder="Pievienot birku">
    <button id="add-tag-btn" data-url="{{ route('products.addTag', $product) }}">Pievienot</button>

    <hr>

    <p><a href="{{ route('products.index') }}">Atpakaļ uz produktu sarakstu</a></p>

    <!-- JS for AJAX functionality -->
    @vite(['resources/js/product-quantity.js', 'resources/js/product-tags.js'])
</x-layout>

<x-layout>
    <h1>Rediģēt produktu</h1>

    <x-success-alert />
    <x-errors-alert />

    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <p>
            <label>Nosaukums:</label><br>
            <input type="text" name="name" value="{{ old('name', $product->name) }}">
        </p>

        <!-- Description -->
        <p>
            <label>Apraksts:</label><br>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </p>

        <!-- Price -->
        <p>
            <label>Cena (€):</label><br>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}">
        </p>

        <!-- Quantity -->
        <p>
            <label>Daudzums:</label><br>
            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}">
        </p>

        <!-- Expiration Date -->
        <p>
            <label>Derīguma termiņš:</label><br>
            <input type="date" name="expiration_date" value="{{ old('expiration_date', $product->expiration_date) }}">
        </p>

        <!-- Status -->
        <p>
            <label>Statuss:</label><br>
            <select name="status">
                <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </p>

        <!-- Tags -->
        <p>
            <label>Izvēlies birkas:</label><br>
            <select name="tags[]" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ $product->tags->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </p>

        <!-- Add new tag AJAX -->
        <p>
            <label>Pievienot jaunu birku:</label><br>
            <input type="text" id="new-tag-name" placeholder="Jauna birka">
            <button type="button" id="add-tag-btn" data-url="{{ route('products.addTag', $product) }}">Pievienot</button>
        </p>

        <ul id="product-tags">
            @foreach($product->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>

        <button type="submit">Atjaunināt</button>
    </form>

    <!-- CSRF meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/product-tags.js'])
</x-layout>

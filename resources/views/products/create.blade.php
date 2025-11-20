<x-layout>
    <h1>Jauns produkts</h1>

    <x-success-alert />
    <x-errors-alert />

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <!-- Nosaukums -->
        <p>
            <label>Nosaukums:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </p>

        <!-- Apraksts -->
        <p>
            <label>Apraksts:</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
        </p>

        <!-- Cena -->
        <p>
            <label>Cena (€):</label><br>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
        </p>

        <!-- Daudzums -->
        <p>
            <label>Daudzums:</label><br>
            <input type="number" name="quantity" value="{{ old('quantity') }}" required>
        </p>

        <!-- Derīguma termiņš -->
        <p>
            <label>Derīguma termiņš:</label><br>
            <input type="date" name="expiration_date" value="{{ old('expiration_date') }}" required>
        </p>

        <!-- Statuss -->
        <p>
            <label>Statuss:</label><br>
            <select name="status">
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </p>

        <hr>

        <!-- Esošās birkas -->
        <p>
            <label>Esošās birkas:</label><br>
            <select name="tags[]" multiple id="existing-tags">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <br><small>(Turiet CTRL, lai izvēlētos vairākus)</small>
        </p>

        <hr>

        <!-- Pievienot jaunu birku -->
        <p>
            <label>Pievienot jaunu birku:</label><br>

            <input type="text" id="new-tag-name" placeholder="Ievadiet birkas nosaukumu">

            <button type="button" id="add-tag-btn" data-url="{{ route('tags.store') }}">
                + Pievienot jaunu birku
            </button>

        </p>

        <!-- Tikko pievienotās birkas -->
        <ul id="product-tags"></ul>

        <button type="submit">Saglabāt produktu</button>
    </form>

    <!-- CSRF Token priekš AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/product-tags.js'])
</x-layout>

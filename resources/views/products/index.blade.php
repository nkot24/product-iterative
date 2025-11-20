<x-layout>
    <h1>Produkti</h1>

    <x-success-alert />
    <x-errors-alert />

    <a href="{{ route('products.create') }}">+ Jauns produkts</a>

    <table cellpadding="5" cellspacing="0" style="margin-top: 10px;">
        <tr>
            <th>ID</th>
            <th>Nosaukums</th>
            <th>Cena (€)</th>
            <th>Daudzums</th>
            <th>Derīguma termiņš</th>
            <th>Statuss</th>
            <th>Birkas</th>
            <th>Darbības</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->expiration_date }}</td>
            <td>{{ ucfirst($product->status) }}</td>
            <td>
                @foreach($product->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                @endforeach
            </td>
            <td>
                <a href="{{ route('products.show', $product) }}">Skatīt</a> |
                <a href="{{ route('products.edit', $product) }}">Rediģēt</a> |
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Vai tiešām dzēst?')">Dzēst</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</x-layout>

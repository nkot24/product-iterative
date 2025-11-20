document.addEventListener('DOMContentLoaded', () => {
    const quantityDisplay = document.getElementById('product-quantity');

    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const url = this.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                quantityDisplay.textContent = data.quantity;
                alert(data.message); // Var arī izmantot toast vai alert, ja vēlaties
            })
            .catch(err => console.error('Error:', err));
        });
    });
});

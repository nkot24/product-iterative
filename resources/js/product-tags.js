document.addEventListener('DOMContentLoaded', () => {
    const tagInput = document.getElementById('new-tag-name');
    const addTagBtn = document.getElementById('add-tag-btn');
    const tagList = document.getElementById('product-tags');
    const token = document.querySelector('meta[name="csrf-token"]').content;

    addTagBtn.addEventListener('click', () => {
        const name = tagInput.value.trim();
        if (!name) return alert('Ievadiet birku');

        fetch(addTagBtn.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.tag) {
                alert("Kļūda: nav atgriezta birka no servera.");
                return;
            }

            // Add to visible list
            const li = document.createElement('li');
            li.textContent = data.tag.name;
            tagList.appendChild(li);

            // ADD hidden input so tags are saved with product
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tags[]';
            hiddenInput.value = data.tag.id;
            tagList.appendChild(hiddenInput);

            tagInput.value = '';
            alert(data.message);
        })
        .catch(err => console.error(err));
    });
});

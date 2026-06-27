@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productId = {{ $product->id }};
    
    // Handle size selection
    document.querySelectorAll('.option-button').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const configId = this.getAttribute('option-id');
            loadProductImages(productId, null, configId);
        });
    });

    // Handle color selection if available
    document.querySelectorAll('[data-color-select]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const colorId = this.getAttribute('data-color-id');
            const configId = document.getElementById('selected_option_id')?.value;
            loadProductImages(productId, colorId, configId);
        });
    });

    // Load initial images
    const initialConfigId = document.getElementById('selected_option_id')?.value;
    loadProductImages(productId, null, initialConfigId);
});

function loadProductImages(productId, colorId = null, configId = null) {
    const params = new URLSearchParams();
    if (colorId) params.append('color_id', colorId);
    if (configId) params.append('config_id', configId);

    fetch(`/api/product-images/${productId}?${params}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.images.length > 0) {
                updateProductImages(data.images);
            }
        })
        .catch(err => console.error('Error loading images:', err));
}

function updateProductImages(images) {
    const thumbMain = document.querySelector('.thumb_main img');
    const listThumb = document.querySelector('.list_thumb .owl-carousel');
    
    if (!thumbMain || !listThumb) return;

    // Update main image
    const mainImage = images.find(img => img.is_main) || images[0];
    if (mainImage) {
        thumbMain.src = mainImage.url;
        thumbMain.style.transition = 'opacity 0.3s';
    }

    // Update thumbnail carousel
    const thumbsHtml = images.map(img => `
        <div class="item">
            <img src="${img.url}" alt="Product image" />
        </div>
    `).join('');

    listThumb.innerHTML = thumbsHtml;

    // Reinitialize carousel if using owl-carousel
    if (typeof jQuery !== 'undefined' && jQuery.fn.owlCarousel) {
        jQuery('.list_thumb .owl-carousel').owlCarousel({
            items: 4,
            loop: true,
            nav: false,
            dots: false,
            autoplay: false
        });
    }
}
</script>
@endpush

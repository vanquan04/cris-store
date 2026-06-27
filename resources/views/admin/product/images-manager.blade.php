@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productId = document.getElementById('product-id')?.value;
    if (!productId) return;

    // Initialize product image manager
    initProductImageManager(productId);
});

function initProductImageManager(productId) {
    const container = document.getElementById('product-images-manager');
    if (!container) return;

    // Load combinations
    fetch(`/api/products/${productId}/combinations`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderCombinations(productId, data.combinations);
            }
        })
        .catch(err => console.error('Error loading combinations:', err));
}

function renderCombinations(productId, combinations) {
    const container = document.getElementById('product-images-manager');
    if (!container) return;

    let html = `<div class="card">
        <div class="card-header">
            <h5>Quản lý ảnh theo màu/size</h5>
        </div>
        <div class="card-body">
            <div class="tabs-section">`;

    // Create tabs for each combination
    const tabHeaders = combinations.map((combo, idx) => `
        <button class="btn btn-sm ${idx === 0 ? 'btn-primary' : 'btn-outline-primary'} combo-tab" 
                data-color-id="${combo.color_id || ''}" 
                data-config-id="${combo.config_id || ''}">
            ${combo.label}
        </button>
    `).join('');

    html += tabHeaders + `</div>
            <div class="combo-content mt-3">`;

    // Create content for each combination
    combinations.forEach((combo, idx) => {
        html += `
        <div class="combo-images ${idx === 0 ? '' : 'd-none'}" 
             data-color-id="${combo.color_id || ''}" 
             data-config-id="${combo.config_id || ''}">
            <div class="upload-area">
                <form class="image-upload-form">
                    <input type="file" multiple accept="image/*" class="form-control" />
                    <button type="submit" class="btn btn-primary mt-2">Tải lên ảnh</button>
                </form>
            </div>
            <div class="images-list mt-3">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Đang tải...</span>
                </div>
            </div>
        </div>`;
    });

    html += `</div></div></div>`;
    container.innerHTML = html;

    // Attach event listeners
    attachCombinationListeners(productId, combinations);
}

function attachCombinationListeners(productId, combinations) {
    // Tab switching
    document.querySelectorAll('.combo-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const colorId = this.dataset.colorId;
            const configId = this.dataset.configId;

            // Update active tab
            document.querySelectorAll('.combo-tab').forEach(t => t.classList.remove('btn-primary'));
            document.querySelectorAll('.combo-tab').forEach(t => t.classList.add('btn-outline-primary'));
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            // Show corresponding content
            document.querySelectorAll('.combo-images').forEach(c => c.classList.add('d-none'));
            document.querySelector(`[data-color-id="${colorId}"][data-config-id="${configId}"]`).classList.remove('d-none');

            // Load images for this combination
            loadImagesForCombination(productId, colorId, configId);
        });
    });

    // Upload forms
    document.querySelectorAll('.image-upload-form').forEach((form, idx) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput.files.length === 0) {
                alert('Vui lòng chọn ảnh');
                return;
            }

            const combo = combinations[idx];
            uploadImages(productId, fileInput.files, combo.color_id, combo.config_id);
        });
    });

    // Load initial images
    loadImagesForCombination(productId, null, null);
}

function uploadImages(productId, files, colorId, configId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('color_id', colorId || '');
    formData.append('config_id', configId || '');

    Array.from(files).forEach(file => {
        formData.append('images[]', file);
    });

    fetch('/api/product-images/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            loadImagesForCombination(productId, colorId, configId);
        } else {
            toastr.error(data.message || 'Lỗi khi tải ảnh');
        }
    })
    .catch(err => {
        console.error(err);
        toastr.error('Lỗi khi tải ảnh');
    });
}

function loadImagesForCombination(productId, colorId, configId) {
    const params = new URLSearchParams();
    if (colorId) params.append('color_id', colorId);
    if (configId) params.append('config_id', configId);

    fetch(`/api/product-images/${productId}?${params}`, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            renderImagesList(data.images, productId, colorId, configId);
        }
    })
    .catch(err => console.error('Error loading images:', err));
}

function renderImagesList(images, productId, colorId, configId) {
    const selector = `[data-color-id="${colorId || ''}"][data-config-id="${configId || ''}"] .images-list`;
    const container = document.querySelector(selector);
    if (!container) return;

    if (images.length === 0) {
        container.innerHTML = '<p class="text-muted">Không có ảnh nào</p>';
        return;
    }

    let html = '<div class="row">';
    images.forEach((img, idx) => {
        html += `
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="${img.url}" class="card-img-top" alt="Product image" />
                <div class="card-body">
                    <div class="btn-group btn-group-sm w-100" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="setMainImage(${img.id})">
                            ${img.is_main ? '✓ Chính' : 'Làm chính'}
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteImage(${img.id})">
                            Xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    });
    html += '</div>';

    container.innerHTML = html;
}

function deleteImage(imageId) {
    if (!confirm('Xóa ảnh này?')) return;

    fetch(`/api/product-images/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            // Reload current combination images
            const activeTab = document.querySelector('.combo-tab.btn-primary');
            if (activeTab) {
                loadImagesForCombination(
                    document.getElementById('product-id').value,
                    activeTab.dataset.colorId,
                    activeTab.dataset.configId
                );
            }
        }
    });
}

function setMainImage(imageId) {
    fetch(`/api/product-images/${imageId}/set-main`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            // Reload current combination images
            const activeTab = document.querySelector('.combo-tab.btn-primary');
            if (activeTab) {
                loadImagesForCombination(
                    document.getElementById('product-id').value,
                    activeTab.dataset.colorId,
                    activeTab.dataset.configId
                );
            }
        }
    });
}
</script>
@endpush

<style>
.tabs-section {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
}

.combo-tab {
    white-space: nowrap;
}

.combo-images {
    min-height: 200px;
}

.upload-area {
    padding: 20px;
    border: 2px dashed #dee2e6;
    border-radius: 5px;
    background-color: #f8f9fa;
}

.upload-area input[type="file"] {
    cursor: pointer;
}
</style>

<div id="product-images-manager"></div>

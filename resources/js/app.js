import './bootstrap';

function badgeText(n) {
    return n > 99 ? '99+' : String(n);
}

/**
 * Toast notification system (vanilla JS, reemplaza jQuery showToast)
 */
window.showToast = function (message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const bgColor = type === 'success' ? 'bg-purple-600' : 'bg-red-600';
    const icon = type === 'success' ? '✅' : '❌';

    const toast = document.createElement('div');
    toast.className = `${bgColor} text-white px-5 py-3 rounded-lg shadow-2xl transition duration-500 transform -translate-y-full opacity-0 pointer-events-auto max-w-sm`;
    toast.style.minWidth = '280px';
    toast.innerHTML = `<p class="font-semibold">${icon} ${message}</p>`;

    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('-translate-y-full', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    });

    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('-translate-y-full', 'opacity-0');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }, 3000);
};

/**
 * Toast flash messages del servidor
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toast-message]').forEach(el => {
        showToast(el.dataset.toastMessage, el.dataset.toastType || 'success');
    });
});

/**
 * Add-to-cart form handler (vanilla, reemplaza jQuery .submit)
 */
document.addEventListener('submit', (e) => {
    const form = e.target;
    if (!form.classList.contains('add-to-cart-form')) return;

    e.preventDefault();

    const productId = form.dataset.productId;
    const url = `/pedidos/agregar/${productId}`;
    const token = form.querySelector('input[name="_token"]')?.value;
    const button = form.querySelector('button[type="submit"]');

    if (button) {
        button.disabled = true;
        button.textContent = '...';
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ _token: token }),
    })
    .then(res => {
        if (res.status === 401) {
            showToast('Guardando producto... Redirigiendo al login', 'error');
            saveAndLogin(productId);
            return null;
        }
        return res.json();
    })
    .then(data => {
        if (data?.success) {
            showToast(data.message, 'success');
            const badge = document.getElementById('mini-cart-badge');
            if (badge && data.total_items) {
                badge.textContent = badgeText(data.total_items);
                badge.classList.remove('hidden');
            }
        }
    })
    .catch(() => showToast('Hubo un problema. Inténtalo de nuevo.', 'error'))
    .finally(() => {
        if (button) {
            button.disabled = false;
            button.innerHTML = 'Añadir 🛒';
        }
    });
});

/**
 * Auto-add pending cart item after login
 */
document.addEventListener('DOMContentLoaded', () => {
    const pendingId = document.querySelector('meta[name="auto_add_cart"]')?.content;
    if (pendingId) {
        const form = document.querySelector(`.add-to-cart-form[data-product-id="${pendingId}"]`);
        if (form) form.requestSubmit();
    }
});

/**
 * Live search (usado en main.blade.php)
 */
function initMainSearch() {
    const searchInput = document.getElementById('main-search-input');
    const searchResults = document.getElementById('main-search-results');
    if (!searchInput || !searchResults) return;

    let searchTimeout;

    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length < 2) {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(async () => {
            try {
                const res = await fetch(`/api/buscar?q=${encodeURIComponent(query)}`);
                const data = await res.json();

                if (data.length === 0) {
                    searchResults.innerHTML = '<div class="p-4 text-center text-gray-400">No se encontraron productos.</div>';
                } else {
                    const html = data.map(p => `
                        <a href="/productos/resenas/${p.id}" class="flex items-center justify-between p-3 hover:bg-gray-800/80 transition-colors border-b border-gray-700/50 last:border-0">
                            <div class="flex items-center gap-3">
                                <img src="/img/${p.imagen}" class="w-10 h-10 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-white font-semibold text-sm">${p.nombre}</h4>
                                    <p class="text-xs text-gray-400">${p.tipo} · ${p.compania}</p>
                                </div>
                            </div>
                            <span class="text-purple-400 font-bold">$${p.precio.toLocaleString('es-CL')}</span>
                        </a>
                    `).join('');
                    searchResults.innerHTML = `<div class="max-h-96 overflow-y-auto">${html}</div>`;
                }
                searchResults.classList.remove('hidden');
            } catch (err) {
                searchResults.classList.add('hidden');
            }
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
}

document.addEventListener('DOMContentLoaded', initMainSearch);

/**
 * Mini-Cart flyout (hover sobre el icono del carrito)
 */
document.addEventListener('DOMContentLoaded', function initMiniCart() {
    const wrapper = document.getElementById('mini-cart-wrapper');
    if (!wrapper) return;

    const trigger = document.getElementById('mini-cart-trigger');
    const dropdown = document.getElementById('mini-cart-dropdown');
    const itemsContainer = document.getElementById('mini-cart-items');
    const footer = document.getElementById('mini-cart-footer');
    const emptyMsg = document.getElementById('mini-cart-empty');
    const totalEl = document.getElementById('mini-cart-total');
    const countEl = document.getElementById('mini-cart-count');
    const badge = document.getElementById('mini-cart-badge');

    let showTimeout = null;
    let hideTimeout = null;
    let loaded = false;
    let currentItems = [];
    let currentTotal = 0;

    function show() {
        clearTimeout(hideTimeout);
        showTimeout = setTimeout(() => {
            fetchCart();
            dropdown.classList.remove('hidden');
        }, 150);
    }

    function hide() {
        clearTimeout(showTimeout);
        hideTimeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 200);
    }

    async function fetchCart() {
        try {
            const { data } = await window.axios.get('/pedidos/mini-cart');
            renderCart(data);
            loaded = true;
        } catch {
            itemsContainer.innerHTML = '';
            emptyMsg.classList.remove('hidden');
            footer.classList.add('hidden');
        }
    }

    function renderCart(data) {
        const { items, total, totalItems } = data;
        currentItems = items;
        currentTotal = total;

        if (items.length === 0) {
            itemsContainer.innerHTML = '';
            emptyMsg.classList.remove('hidden');
            footer.classList.add('hidden');
            countEl.textContent = '';
            badge.classList.add('hidden');
            return;
        }

        emptyMsg.classList.add('hidden');
        footer.classList.remove('hidden');
        countEl.textContent = `${totalItems} ${totalItems === 1 ? 'artículo' : 'artículos'}`;
        totalEl.textContent = `$${new Intl.NumberFormat('es-CL').format(Math.round(total))}`;

        badge.textContent = badgeText(totalItems);
        badge.classList.remove('hidden');

        itemsContainer.innerHTML = items.map(item => `
            <div class="flex items-center gap-3 px-4 py-3" id="mini-cart-item-${item.id}">
                <img src="/img/${item.imagen}" alt="${item.nombre}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">${item.nombre}</p>
                    <p class="text-xs text-gray-400">Cant: ${item.cantidad} × $${new Intl.NumberFormat('es-CL').format(Math.round(item.precio))}</p>
                </div>
                <button onclick="miniCartRemove(${item.id})" class="text-gray-500 hover:text-red-400 transition flex-shrink-0 p-1" title="Quitar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `).join('');
    }

    wrapper.addEventListener('mouseenter', show);
    wrapper.addEventListener('mouseleave', hide);

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            dropdown.classList.add('hidden');
            clearTimeout(showTimeout);
            clearTimeout(hideTimeout);
        }
    });

    window.miniCartRemove = async function (productId) {
        const row = document.getElementById(`mini-cart-item-${productId}`);
        if (!row) return;

        const itemData = currentItems.find(i => i.id === productId);
        const qty = itemData ? itemData.cantidad : 1;
        const price = itemData ? itemData.precio * qty : 0;
        const newTotalItems = Math.max(0, (parseInt(badge.textContent) || 0) - qty);
        const newTotal = Math.max(0, currentTotal - price);

        const height = row.offsetHeight;
        row.style.maxHeight = height + 'px';
        row.style.transition = 'opacity 0.2s ease, max-height 0.25s ease';
        requestAnimationFrame(() => {
            row.style.opacity = '0';
            row.style.maxHeight = '0';
        });
        row.style.overflow = 'hidden';

        setTimeout(() => {
            row.remove();
            if (newTotalItems <= 0) {
                itemsContainer.innerHTML = '';
                emptyMsg.classList.remove('hidden');
                footer.classList.add('hidden');
                countEl.textContent = '';
                badge.classList.add('hidden');
            }
        }, 280);

        if (newTotalItems > 0) {
            countEl.textContent = `${newTotalItems} artículos`;
            totalEl.textContent = `$${new Intl.NumberFormat('es-CL').format(Math.round(newTotal))}`;
            badge.textContent = badgeText(newTotalItems);
        }

        fetch(`/pedidos/mini-cart/${productId}`, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        }).catch(function () {});
    };

    fetchCart();

    window.updateMiniCartBadge = async function () {
        try {
            const { data } = await window.axios.get('/pedidos/mini-cart');
            if (data.totalItems === 0) {
                badge.classList.add('hidden');
            } else {
                badge.textContent = badgeText(data.totalItems);
                badge.classList.remove('hidden');
            }
        } catch (e) { /* silent */ }
    };
});

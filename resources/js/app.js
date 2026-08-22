import './bootstrap';

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
        if (data?.success) showToast(data.message, 'success');
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

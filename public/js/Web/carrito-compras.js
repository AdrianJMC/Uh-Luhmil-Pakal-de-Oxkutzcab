document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let debounceTimer = null;

    document.querySelectorAll('.btn-update-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');
            const action = button.getAttribute('data-action');
            const container = button.closest('.cart-item');
            const quantityDisplay = button.closest('.update-form').querySelector('.quantity-display');
            let itemTotal;
            const visibleTotal = [...container.querySelectorAll('.item-total')]
                .find(el => el.offsetParent !== null);
            itemTotal = visibleTotal;

            if (action === 'decrease') {
                const currentQuantity = parseFloat(quantityDisplay.dataset.quantity);
                if (currentQuantity <= 0.5) return;
            }

            if (debounceTimer) clearTimeout(debounceTimer);

            debounceTimer = setTimeout(async () => {
                document.querySelectorAll('.btn-update-cart').forEach(btn => btn.disabled = true);

                try {
                    const response = await fetch(`/cart/update/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({ action })
                    });

                    const data = await response.json();

                    if (data.success) {
                        const formattedQty = Number.isInteger(parseFloat(data.quantity))
                            ? parseInt(data.quantity)
                            : parseFloat(data.quantity).toFixed(1);

                        quantityDisplay.value = formattedQty;
                        quantityDisplay.dataset.quantity = data.quantity;
                        itemTotal.textContent = `$${data.itemTotal}`;

                        // Actualizar totales del resumen
                        document.querySelector('.cart-summary .total strong:last-child').textContent = `$${data.total}`;

                        // Total de toneladas
                        const totalTonElement = document.querySelector('.summary-item span:nth-child(2)');
                        if (totalTonElement) {
                            const totalQty = parseFloat(data.totalQuantity);
                            totalTonElement.textContent = `${Number.isInteger(totalQty) ? parseInt(totalQty) : totalQty.toFixed(1)} Ton`;
                        }

                        // Total productos
                        const productCountElement = document.querySelector('.summary-item span:first-child');
                        if (productCountElement) {
                            productCountElement.textContent = `${data.productCount} Producto(s)`;
                        }

                        // También actualiza el tap bar si existe
                        const stickyTotal = document.querySelector('#sticky-mobile-bar .sticky-total');
                        if (stickyTotal) {
                            stickyTotal.textContent = `Total: $${data.total}`;
                        }

                    } else if (data.removed) {
                        container.remove();
                    } else {
                        alert('Error: ' + (data.error || 'Algo salió mal'));
                    }
                } catch (err) {
                    console.error(err);
                    alert('Ocurrió un error al actualizar el carrito');
                }

                document.querySelectorAll('.btn-update-cart').forEach(btn => btn.disabled = false);
            }, 300);
        });
    });

    // === Tap bar: Ocultar cuando el resumen sea visible ===
    const stickyBar = document.getElementById('sticky-mobile-bar');
    const resumenCard = document.querySelector('.cart-summary');

    function toggleStickyBar() {
        if (!resumenCard || !stickyBar) return;

        const rect = resumenCard.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;
        stickyBar.style.display = isVisible ? 'none' : 'flex';
    }

    window.addEventListener('scroll', toggleStickyBar);
    window.addEventListener('resize', toggleStickyBar);
    toggleStickyBar(); // Inicial
});

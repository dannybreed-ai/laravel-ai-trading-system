// Trading bot activation modal logic
document.addEventListener('DOMContentLoaded', () => {
    // Bot activation polling
    const activationElements = document.querySelectorAll('[data-activation-id]');
    
    if (activationElements.length > 0) {
        // Poll every 15 seconds for activation status updates
        setInterval(async () => {
            for (const element of activationElements) {
                const activationId = element.dataset.activationId;
                
                try {
                    const response = await fetch(`/api/activations/${activationId}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        
                        // Update profit display
                        const profitElement = element.querySelector('[data-profit]');
                        if (profitElement && data.current_profit !== undefined) {
                            profitElement.textContent = `$${parseFloat(data.current_profit).toFixed(2)}`;
                        }
                        
                        // Update status if changed
                        const statusElement = element.querySelector('[data-status]');
                        if (statusElement && data.status) {
                            statusElement.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                            
                            // Update status badge color
                            statusElement.className = statusElement.className.replace(/bg-\w+-\d+/g, '');
                            statusElement.className = statusElement.className.replace(/text-\w+-\d+/g, '');
                            
                            if (data.status === 'active') {
                                statusElement.classList.add('bg-green-100', 'text-green-800');
                            } else {
                                statusElement.classList.add('bg-gray-100', 'text-gray-800');
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error polling activation status:', error);
                }
            }
        }, 15000); // 15 seconds
    }

    // Bot activation form validation
    const activationForms = document.querySelectorAll('form[action*="activate"]');
    activationForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const amountInput = form.querySelector('input[name="investment_amount"]');
            const amount = parseFloat(amountInput.value);
            const min = parseFloat(amountInput.min);
            const max = parseFloat(amountInput.max);

            if (amount < min || amount > max) {
                e.preventDefault();
                alert(`Investment amount must be between $${min} and $${max}`);
            }
        });
    });
});

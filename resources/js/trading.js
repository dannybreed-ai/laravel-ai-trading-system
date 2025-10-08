import './bootstrap';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    console.log('Trading module loaded');

    const activateForms = document.querySelectorAll('form[action*="activate"]');
    activateForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Confirm Activation',
                text: 'Are you sure you want to activate this bot?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1DA1F2',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    const closeForms = document.querySelectorAll('form[action*="close"]');
    closeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Close Bot',
                text: 'This will close the bot and return funds to your balance.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1DA1F2',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

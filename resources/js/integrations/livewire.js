import notificationService from '../services/notificationService';

// Integração com Livewire
window.addEventListener('livewire:init', () => {
    Livewire.on('showNotification', (data) => {
        
        if (Array.isArray(data)) {
            notificationService.showNotification(data[0], data[1], data[2] || {});
        } else if (typeof data === 'object') {
            notificationService.showNotification(data.type, data.message, data.options || {});
        }
    });

    Livewire.on('notify', (data) => {      
        
        if (Array.isArray(data)) {
            notificationService.showNotification(data[0], data[1], data[2] || {});
        } else if (typeof data === 'object') {
            notificationService.showNotification(data.type, data.message, data.options || {});
        }
    });

    Livewire.on('showConfirmation', (data) => {
        const options = typeof data === 'object' ? data : { message: data };
        const {method, params, ...optionsNotification} = options;
        notificationService.showConfirmation(optionsNotification).then((result) => {
            if (result.isConfirmed && options.method) {
                Livewire.dispatch(options.method, options.params || []);
            }
        });
    });

     Livewire.on('confirm', (data) => {        
        const options = typeof data === 'object' ? data : { message: data };
        const {method, params, ...optionsNotification} = options;
        notificationService.showConfirmation(optionsNotification).then((result) => {
            if (result.isConfirmed && options.method) {
                Livewire.dispatch(options.method, options.params || []);
            }
        });
    });
});
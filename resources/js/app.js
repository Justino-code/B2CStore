import './bootstrap';

// Importar bibliotecas primeiro
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Configurar Alpine ANTES de qualquer coisa que use Alpine
Alpine.plugin(persist);


// Importar configurações
import './config/theme';
import './config/notifications';
import './config/swiper';

// Importar outras bibliotecas
import './lib/chartjs';
import './lib/swiper'; 

// Importar serviços
import './services/themeService';
import './services/notificationService';
import './services/eventService';

// Importar integrações
import './integrations/livewire';
import './theme.js'
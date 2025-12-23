// resources/js/lib/swiper.js

// Importar Swiper e módulos
import Swiper from 'swiper';
import { 
    Navigation, 
    Pagination, 
    Autoplay, 
    EffectFade,
    Thumbs,
    FreeMode,
    Grid
} from 'swiper/modules';

// Importar estilos CSS
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import 'swiper/css/thumbs';
import 'swiper/css/free-mode';
import 'swiper/css/grid';

// Registrar módulos
Swiper.use([Navigation, Pagination, Autoplay, EffectFade, Thumbs, FreeMode, Grid]);

// Disponibilizar Swiper globalmente
window.Swiper = Swiper;

// Helper para inicializar swipers
window.initSwiper = function(selector, options = {}) {
    const elements = document.querySelectorAll(selector);
    
    elements.forEach(element => {
        const config = {
            ...window.swiperConfig?.defaults || {},
            ...options
        };
        
        return new Swiper(element, config);
    });
};

// Helper para detectar tipo de slider
window.initSwiperByType = function(selector, type = 'hero') {
    const elements = document.querySelectorAll(selector);
    
    elements.forEach(element => {
        const preset = window.swiperConfig?.presets?.[type] || {};
        const config = {
            ...window.swiperConfig?.defaults || {},
            ...preset
        };
        
        return new Swiper(element, config);
    });
};
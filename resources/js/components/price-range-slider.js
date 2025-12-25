// Componente Alpine para slider duplo de preço
export default function priceRangeSlider() {
    return {
        min: 0,
        max: 10000,
        maxAvailable: 10000,
        minThumb: null,
        maxThumb: null,
        track: null,
        activeTrack: null,
        isDraggingMin: false,
        isDraggingMax: false,
        
        init() {
            // Inicializar valores do Livewire
            if (this.$wire) {
                this.min = this.$wire.get('precoMin') || 0;
                this.max = this.$wire.get('precoMax') || 10000;
                this.maxAvailable = this.$wire.get('precoMaximoDisponivel') || 10000;
            }
            
            // Garantir valores válidos
            this.min = Math.max(0, Math.min(this.min, this.maxAvailable));
            this.max = Math.max(this.min, Math.min(this.max, this.maxAvailable));
            
            // Configurar elementos DOM
            this.$nextTick(() => {
                this.minThumb = this.$refs.minThumb;
                this.maxThumb = this.$refs.maxThumb;
                this.track = this.$refs.track;
                this.activeTrack = this.$refs.activeTrack;
                
                this.updateUI();
            });
            
            // Observar mudanças
            this.$watch('min', (value) => this.onMinChange(value));
            this.$watch('max', (value) => this.onMaxChange(value));
        },
        
        onMinChange(value) {
            value = parseInt(value) || 0;
            value = Math.max(0, Math.min(value, this.maxAvailable));
            
            if (value > this.max) {
                this.max = value;
            }
            
            this.updateUI();
            
            if (this.$wire) {
                this.$wire.set('precoMin', value);
            }
        },
        
        onMaxChange(value) {
            value = parseInt(value) || this.maxAvailable;
            value = Math.max(this.min, Math.min(value, this.maxAvailable));
            
            if (value < this.min) {
                this.min = value;
            }
            
            this.updateUI();
            
            if (this.$wire) {
                this.$wire.set('precoMax', value);
            }
        },
        
        updateUI() {
            if (!this.track || !this.activeTrack || !this.minThumb || !this.maxThumb) return;
            
            const trackWidth = this.track.offsetWidth;
            const minPercent = (this.min / this.maxAvailable) * 100;
            const maxPercent = (this.max / this.maxAvailable) * 100;
            
            // Posicionar thumbs
            this.minThumb.style.left = `calc(${minPercent}% - 8px)`;
            this.maxThumb.style.left = `calc(${maxPercent}% - 8px)`;
            
            // Atualizar track ativa
            this.activeTrack.style.left = `${minPercent}%`;
            this.activeTrack.style.width = `${maxPercent - minPercent}%`;
        },
        
        onTrackClick(event) {
            const trackRect = this.track.getBoundingClientRect();
            const clickX = event.clientX - trackRect.left;
            const percentage = (clickX / trackRect.width) * 100;
            const value = Math.round((percentage / 100) * this.maxAvailable);
            
            // Determinar qual thumb mover
            const minDistance = Math.abs(this.min - value);
            const maxDistance = Math.abs(this.max - value);
            
            if (minDistance <= maxDistance) {
                this.min = Math.max(0, Math.min(value, this.max));
            } else {
                this.max = Math.min(this.maxAvailable, Math.max(value, this.min));
            }
        },
        
        startDragMin(event) {
            this.isDraggingMin = true;
            document.addEventListener('mousemove', this.dragMin.bind(this));
            document.addEventListener('mouseup', this.stopDragMin.bind(this));
            event.preventDefault();
        },
        
        startDragMax(event) {
            this.isDraggingMax = true;
            document.addEventListener('mousemove', this.dragMax.bind(this));
            document.addEventListener('mouseup', this.stopDragMax.bind(this));
            event.preventDefault();
        },
        
        dragMin(event) {
            if (!this.isDraggingMin) return;
            
            const trackRect = this.track.getBoundingClientRect();
            let x = event.clientX - trackRect.left;
            x = Math.max(0, Math.min(x, trackRect.width));
            
            const percentage = (x / trackRect.width) * 100;
            this.min = Math.round((percentage / 100) * this.maxAvailable);
            this.min = Math.min(this.min, this.max);
        },
        
        dragMax(event) {
            if (!this.isDraggingMax) return;
            
            const trackRect = this.track.getBoundingClientRect();
            let x = event.clientX - trackRect.left;
            x = Math.max(0, Math.min(x, trackRect.width));
            
            const percentage = (x / trackRect.width) * 100;
            this.max = Math.round((percentage / 100) * this.maxAvailable);
            this.max = Math.max(this.max, this.min);
        },
        
        stopDragMin() {
            this.isDraggingMin = false;
            document.removeEventListener('mousemove', this.dragMin);
            document.removeEventListener('mouseup', this.stopDragMin);
        },
        
        stopDragMax() {
            this.isDraggingMax = false;
            document.removeEventListener('mousemove', this.dragMax);
            document.removeEventListener('mouseup', this.stopDragMax);
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('pt-AO', {
                style: 'currency',
                currency: 'AOA',
                minimumFractionDigits: 0
            }).format(value);
        }
    };
}
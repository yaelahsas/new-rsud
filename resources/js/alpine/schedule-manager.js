document.addEventListener('alpine:init', () => {
    Alpine.data('scheduleManager', () => ({
        schedules: [],
        loading: false,
        
        init() {
            this.loadSchedules();
        },
        
        // Load schedules from API
        async loadSchedules() {
            this.loading = true;
            
            try {
                const response = await fetch('/api/doctor-schedules');
                const data = await response.json();
                
                if (data.success) {
                    this.schedules = data.schedules;
                }
            } catch (error) {
                console.error('Error loading schedules:', error);
                this.schedules = [];
            } finally {
                this.loading = false;
            }
        }
    }));
});
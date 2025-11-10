document.addEventListener('alpine:init', () => {
    Alpine.data('heroSearch', () => ({
        searchQuery: '',
        
        // Perform search from hero section
        performSearch() {
            if (!this.searchQuery.trim()) return;
            
            // Check if search is for doctors specifically
            const doctorKeywords = ['dokter', 'doctor', 'spesialis', 'poli', 'klinik', 'dr.', 'dr'];
            const isDoctorSearch = doctorKeywords.some(keyword =>
                this.searchQuery.toLowerCase().includes(keyword)
            );
            
            if (isDoctorSearch) {
                // Redirect to doctor page with search query
                window.location.href = `/medis?search=${encodeURIComponent(this.searchQuery)}`;
            } else {
                // For general search, redirect to medis page as well since it has search functionality
                window.location.href = `/medis?search=${encodeURIComponent(this.searchQuery)}`;
            }
        }
    }));
});
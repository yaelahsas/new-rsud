document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('dashboardManager', () => ({
        stats: {},
        recentBerita: [],
        recentUsers: [],
        monthlyData: [],
        loading: false,
        
        init() {
            this.loadStats();
            this.loadRecentBerita();
            this.loadRecentUsers();
            this.loadMonthlyData();
        },
        
        async loadStats() {
            this.loading = true;
            try {
                const response = await fetch('/admin/api/dashboard/stats');
                const data = await response.json();
                
                if (data.success) {
                    this.stats = data.data;
                }
            } catch (error) {
                console.error('Error loading stats:', error);
                this.showToast('Error loading statistics', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        async loadRecentBerita() {
            try {
                const response = await fetch('/admin/api/dashboard/recent-berita');
                const data = await response.json();
                
                if (data.success) {
                    this.recentBerita = data.data;
                }
            } catch (error) {
                console.error('Error loading recent berita:', error);
                this.showToast('Error loading recent news', 'error');
            }
        },
        
        async loadRecentUsers() {
            try {
                const response = await fetch('/admin/api/dashboard/recent-users');
                const data = await response.json();
                
                if (data.success) {
                    this.recentUsers = data.data;
                }
            } catch (error) {
                console.error('Error loading recent users:', error);
                this.showToast('Error loading recent users', 'error');
            }
        },
        
        async loadMonthlyData() {
            try {
                const response = await fetch('/admin/api/dashboard/monthly-data');
                const data = await response.json();
                
                if (data.success) {
                    this.monthlyData = data.data;
                    // Initialize chart after data is loaded
                    this.$nextTick(() => {
                        this.initCharts();
                    });
                }
            } catch (error) {
                console.error('Error loading monthly data:', error);
                this.showToast('Error loading chart data', 'error');
            }
        },
        
        initCharts() {
            // Main Chart
            const ctx = document.getElementById('beritaChart');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Jumlah Berita',
                            data: this.monthlyData,
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        family: 'Inter',
                                        size: 12,
                                        weight: '500'
                                    },
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    family: 'Inter',
                                    size: 14,
                                    weight: '600'
                                },
                                bodyFont: {
                                    family: 'Inter',
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        family: 'Inter',
                                        size: 11
                                    },
                                    color: '#64748b'
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter',
                                        size: 11
                                    },
                                    color: '#64748b'
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }

            // Mini Chart
            const miniCtx = document.getElementById('beritaMiniChart');
            if (miniCtx && typeof Chart !== 'undefined') {
                new Chart(miniCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Berita',
                            data: this.monthlyData.slice(0, 6),
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(107, 114, 128, 0.8)'
                            ],
                            borderColor: [
                                '#6366f1',
                                '#10b981',
                                '#f59e0b',
                                '#3b82f6',
                                '#ef4444',
                                '#6b7280'
                            ],
                            borderWidth: 0,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    family: 'Inter',
                                    size: 12,
                                    weight: '600'
                                },
                                bodyFont: {
                                    family: 'Inter',
                                    size: 11
                                },
                                padding: 8,
                                cornerRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                display: false,
                                grid: {
                                    display: false
                                }
                            },
                            x: {
                                display: false,
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        },
        
        refreshAll() {
            this.loadStats();
            this.loadRecentBerita();
            this.loadRecentUsers();
            this.loadMonthlyData();
        },
        
        // Show toast notification
        showToast(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                
                const iconMap = {
                    'success': 'success',
                    'error': 'error',
                    'warning': 'warning',
                    'info': 'info'
                };
                
                toast.fire({
                    icon: iconMap[type] || 'info',
                    title: message
                });
            } else {
                alert(message);
            }
        },
        
        // Export dashboard data
        exportData() {
            const data = {
                stats: this.stats,
                monthly_data: this.monthlyData,
                export_date: new Date().toISOString()
            };
            
            const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `dashboard-export-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            this.showToast('Dashboard data exported successfully', 'success');
        }
    }));
});
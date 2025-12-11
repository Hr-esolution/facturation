// dashboard.js - JavaScript pour le dashboard utilisateur

document.addEventListener('DOMContentLoaded', function() {
    // Gestion du toggle du sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Animation pour les cartes statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Initialisation des tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Gestion des notifications
    const notificationBell = document.querySelector('.notification-bell');
    if (notificationBell) {
        notificationBell.addEventListener('click', function() {
            const notificationDropdown = this.nextElementSibling;
            if (notificationDropdown) {
                notificationDropdown.classList.toggle('show');
            }
        });
    }
    
    // Fermer les dropdowns quand on clique ailleurs
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown-menu.show');
        dropdowns.forEach(dropdown => {
            if (!dropdown.parentElement.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    });
    
    // Gestion des filtres sur le dashboard
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            // Ici vous pouvez ajouter la logique pour filtrer les données
            console.log('Filtre sélectionné:', filter);
        });
    });
    
    // Animation pour les graphiques (si utilisés)
    const chartContainers = document.querySelectorAll('.chart-container');
    chartContainers.forEach(container => {
        // Animation d'entrée pour les graphiques
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100);
    });
});

// Fonction utilitaire pour le formatage des nombres
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

// Fonction pour le formatage des devises
function formatCurrency(amount, currency = '€') {
    return currency + ' ' + formatNumber(parseFloat(amount).toFixed(2));
}

// Fonction pour la gestion des dates
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// Fonction pour la gestion des états de paiement
function getPaymentStatusClass(status) {
    switch(status) {
        case 'payee':
            return 'bg-success';
        case 'en_attente':
            return 'bg-warning';
        case 'impayee':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

// Fonction pour la mise à jour des statistiques en temps réel
function updateStats() {
    // Ici vous pouvez ajouter la logique pour récupérer les données en temps réel
    // via des appels AJAX ou WebSocket
    console.log('Mise à jour des statistiques...');
}

// Si vous utilisez des graphiques, voici un exemple avec Chart.js
function initCharts() {
    // Cet exemple suppose que Chart.js est chargé
    if (typeof Chart !== 'undefined') {
        const ctx = document.getElementById('dashboardChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Revenus',
                        data: [12000, 19000, 15000, 18000, 22000, 17000],
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Évolution des revenus'
                        }
                    }
                }
            });
        }
    }
}

// Appeler les fonctions d'initialisation
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});
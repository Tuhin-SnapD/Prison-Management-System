/**
 * Prison Management System - Main JavaScript
 * 
 * Common functionality and utilities for the application
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Form validation
    initializeFormValidation();
    
    // Data tables
    initializeDataTables();
    
    // Search functionality
    initializeSearch();
    
    // Print functionality
    initializePrint();
});

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

/**
 * Initialize data tables with search and pagination
 */
function initializeDataTables() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        // Add search input
        const searchDiv = document.createElement('div');
        searchDiv.className = 'mb-3';
        searchDiv.innerHTML = `
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search..." id="search-${table.id}">
            </div>
        `;
        table.parentNode.insertBefore(searchDiv, table);
        
        // Add search functionality
        const searchInput = document.getElementById(`search-${table.id}`);
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    const searchInputs = document.querySelectorAll('.search-input');
    
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const targetClass = this.dataset.target;
            const elements = document.querySelectorAll(`.${targetClass}`);
            
            elements.forEach(element => {
                const text = element.textContent.toLowerCase();
                element.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
}

/**
 * Initialize print functionality
 */
function initializePrint() {
    const printButtons = document.querySelectorAll('.print-btn');
    
    printButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetElement = document.querySelector(this.dataset.target);
            if (targetElement) {
                printElement(targetElement);
            }
        });
    });
}

/**
 * Print a specific element
 */
function printElement(element) {
    const printWindow = window.open('', '_blank');
    const printContent = element.cloneNode(true);
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @media print {
                    .no-print { display: none !important; }
                }
            </style>
        </head>
        <body>
            ${printContent.outerHTML}
            <script>window.print();</script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

/**
 * Show loading spinner
 */
function showLoading() {
    const spinner = document.createElement('div');
    spinner.className = 'loading-overlay';
    spinner.innerHTML = `
        <div class="spinner-container">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    `;
    document.body.appendChild(spinner);
}

/**
 * Hide loading spinner
 */
function hideLoading() {
    const spinner = document.querySelector('.loading-overlay');
    if (spinner) {
        spinner.remove();
    }
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Confirm action
 */
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * Format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(amount);
}

/**
 * Validate email
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Validate phone number
 */
function validatePhone(phone) {
    const re = /^[6-9]\d{9}$/;
    return re.test(phone);
}

/**
 * Validate Aadhaar number
 */
function validateAadhaar(aadhaar) {
    const re = /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/;
    return re.test(aadhaar);
}

/**
 * AJAX request helper
 */
function ajaxRequest(url, method = 'GET', data = null) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    resolve(response);
                } catch (e) {
                    resolve(xhr.responseText);
                }
            } else {
                reject(xhr.statusText);
            }
        };
        
        xhr.onerror = function() {
            reject(xhr.statusText);
        };
        
        if (data) {
            xhr.send(JSON.stringify(data));
        } else {
            xhr.send();
        }
    });
}

/**
 * Export table to CSV
 */
function exportToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];
        cols.forEach(col => {
            rowData.push('"' + col.textContent.replace(/"/g, '""') + '"');
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Add CSS for loading overlay
const style = document.createElement('style');
style.textContent = `
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .spinner-container {
        text-align: center;
        color: white;
    }
    
    .spinner-container p {
        margin-top: 1rem;
        font-size: 1.1rem;
    }
`;
document.head.appendChild(style); 
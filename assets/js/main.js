// PolyShop - Main JavaScript File

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initAnimations();
    initProductCards();
    initSearchForm();
    initContactForm();
    initScrollEffects();
});

// Animation effects
function initAnimations() {
    // Add fade-in animation to elements when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observe all cards and sections
    document.querySelectorAll('.product-card, .category-card, .about-section, .contact-section').forEach(el => {
        observer.observe(el);
    });
}

// Product card interactions
function initProductCards() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        
        // Add click effect
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
}

// Search form functionality
function initSearchForm() {
    const searchForm = document.querySelector('form[action*="search"]');
    const searchInput = document.querySelector('input[name="keyword"]');
    
    if (searchForm && searchInput) {
        // Add search suggestions
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                showSearchSuggestions(query);
            } else {
                hideSearchSuggestions();
            }
        });
        
        // Handle form submission
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                e.preventDefault();
                showAlert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm', 'warning');
            }
        });
    }
}

// Show search suggestions
function showSearchSuggestions(query) {
    // This would typically make an AJAX call to get suggestions
    // For now, we'll just show a placeholder
    console.log('Searching for:', query);
}

// Hide search suggestions
function hideSearchSuggestions() {
    // Hide suggestions dropdown
}

// Contact form functionality
function initContactForm() {
    const contactForm = document.querySelector('#contact form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const name = formData.get('name') || document.getElementById('name').value;
            const email = formData.get('email') || document.getElementById('email').value;
            const subject = formData.get('subject') || document.getElementById('subject').value;
            const message = formData.get('message') || document.getElementById('message').value;
            
            // Validate form
            if (!name || !email || !subject || !message) {
                showAlert('Vui lòng điền đầy đủ thông tin', 'warning');
                return;
            }
            
            if (!isValidEmail(email)) {
                showAlert('Email không hợp lệ', 'warning');
                return;
            }
            
            // Simulate form submission
            showAlert('Đang gửi tin nhắn...', 'info');
            
            setTimeout(() => {
                showAlert('Tin nhắn đã được gửi thành công! Chúng tôi sẽ liên hệ lại sớm nhất.', 'success');
                this.reset();
            }, 2000);
        });
    }
}

// Email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Scroll effects
function initScrollEffects() {
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add shadow to navbar on scroll
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (scrollTop > 50) {
                navbar.classList.add('shadow');
            } else {
                navbar.classList.remove('shadow');
            }
        }
        
        // Parallax effect for hero section
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            heroSection.style.transform = `translateY(${rate}px)`;
        }
        
        lastScrollTop = scrollTop;
    });
}

// Alert system
function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Loading states
function showLoading(element) {
    if (element) {
        element.innerHTML = '<div class="spinner mx-auto"></div>';
        element.disabled = true;
    }
}

function hideLoading(element, originalText) {
    if (element) {
        element.innerHTML = originalText;
        element.disabled = false;
    }
}

// Utility functions
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(price);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize tooltips and popovers if Bootstrap is available
if (typeof bootstrap !== 'undefined') {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

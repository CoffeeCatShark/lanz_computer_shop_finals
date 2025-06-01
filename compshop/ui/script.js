// ====================
// IFRAME NAVIGATION
// ====================
function setupIframeNavigation() {
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a:not(.logout-btn)');
    const iframe = document.querySelector('.iframe-container');
    
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.href.includes('logout.php')) return;
            
            e.preventDefault();
            
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Change to loading class instead of removing loaded
            iframe.classList.add('loading');
            
            // Load new content immediately (no need for timeout)
            iframe.src = this.href;
        });
    });
    
    iframe.addEventListener('load', function() {
        this.classList.remove('loading');
        
        try {
            const iframeDoc = this.contentDocument || this.contentWindow.document;
            const styleLink = iframeDoc.createElement('link');
            styleLink.rel = 'stylesheet';
            styleLink.href = '../ui/styles.css';
            iframeDoc.head.appendChild(styleLink);
            
            const fontAwesome = iframeDoc.createElement('link');
            fontAwesome.rel = 'stylesheet';
            fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css';
            iframeDoc.head.appendChild(fontAwesome);
        } catch (e) {
            console.log('Could not inject styles into iframe');
        }
    });
    
    // Initialize iframe as visible by removing any loading class
    iframe.classList.remove('loading');
    
    if (sidebarLinks.length > 0) {
        sidebarLinks[0].classList.add('active');
    }
}

// ====================
// FILE HANDLING
// ====================
function setupFileViewer() {
    // Force download for direct file links
    document.querySelectorAll('a.file-link[href*="/docs/"]').forEach(link => {
        if(!link.href.includes('file-viewer.php')) {
            link.setAttribute('download', '');
            link.innerHTML = '<i class="fas fa-download"></i> Download';
        }
    });
    
    // Handle back button in file viewer
    const backBtn = document.querySelector('.back-btn');
    if(backBtn) {
        backBtn.addEventListener('click', function() {
            window.history.back();
        });
    }
}

// ====================
// FORM VALIDATION
// ====================
function setupFormValidation() {
    // Registration form validation
    const registrationForm = document.querySelector('form[action="register.php"]');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const retypePassword = document.getElementById('retypePassword').value;
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                e.preventDefault();
                return;
            }
            
            if (password !== retypePassword) {
                alert('Passwords do not match');
                e.preventDefault();
            }
        });
    }
    
    // Promote user confirmation
    const promoteForm = document.querySelector('.promote-form');
    if (promoteForm) {
        promoteForm.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to promote this user to admin?')) {
                e.preventDefault();
            }
        });
    }
}

// ====================
// UI ENHANCEMENTS
// ====================
function setupUIEnhancements() {
    // Button hover effects
    const buttons = document.querySelectorAll('button, .btn, .action-btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Card hover effects
    const cards = document.querySelectorAll('.card, .feature-card, .service-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 6px 12px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        });
    });
}

// ====================
// RESIZE HANDLING
// ====================
function handleResize() {
    const iframe = document.querySelector('.iframe-container');
    if (iframe) {
        iframe.style.height = '100vh'; // Simple full viewport height
    }
}

// Call this on load and resize
window.addEventListener('load', handleResize);
window.addEventListener('resize', handleResize);

// ====================
// INITIALIZATION
// ====================
document.addEventListener('DOMContentLoaded', function() {
    setupIframeNavigation();
    setupFileViewer();
    setupFormValidation();
    setupUIEnhancements();
    
    // Set up initial resize
    handleResize();
    
    // Add resize listener
    window.addEventListener('resize', handleResize);
    
    // Add active class to current navigation link
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
            link.classList.add('active');
        }
    });
});

// Handle back to dashboard links from iframe content
window.addEventListener('message', function(e) {
    if (e.data === 'backToDashboard') {
        const iframe = document.querySelector('.iframe-container');
        iframe.src = 'welcome.html';
        
        // Reset active states
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        sidebarLinks.forEach(link => link.classList.remove('active'));
        document.querySelector('.sidebar-nav a[href="welcome.html"]').classList.add('active');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    setupIframeNavigation();
    setupFileViewer();
    setupFormValidation();
    setupUIEnhancements();
    
    // Set up initial resize
    handleResize();
    
    // Add resize listener
    window.addEventListener('resize', handleResize);
    
    // Add active class to current navigation link
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
            link.classList.add('active');
        }
    });
    
    // Trigger the fade-in animations after a small delay to ensure DOM is ready
    setTimeout(() => {
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach(el => {
            el.style.opacity = '0'; // Reset to ensure animation plays
            el.style.visibility = 'visible';
        });
    }, 100);
});
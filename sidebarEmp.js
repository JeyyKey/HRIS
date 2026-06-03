// ================sidebarEmp.js====================
// SHARED SIDEBAR FUNCTIONALITY
// ====================================
// This file handles sidebar toggle and navigation across all modules

// Initialize mobile toggle on page load
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        console.log('Mobile toggle button found:', mobileToggle);
        // Remove any existing event listeners and add new one
        mobileToggle.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Mobile toggle clicked via event listener');
            toggleSidebar();
        };
    } else {
        console.warn('Mobile toggle button not found!');
    }
});

// Sidebar Toggle Functions
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    console.log('Toggle clicked!');
    console.log('Sidebar element:', sidebar);
    console.log('Overlay element:', overlay);
    console.log('Sidebar classes:', sidebar ? sidebar.className : 'Not found');
    console.log('Has visible class:', sidebar ? sidebar.classList.contains('visible') : false);
    
    if (sidebar && sidebar.classList.contains('visible')) {
        console.log('Closing sidebar...');
        closeSidebar();
    } else {
        console.log('Opening sidebar...');
        openSidebar();
    }
}

function openSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    console.log('Opening sidebar...');
    console.log('Sidebar found:', !!sidebar);
    console.log('Overlay found:', !!overlay);
    
    if (sidebar && overlay) {
        sidebar.classList.add('visible');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        console.log('Sidebar opened successfully');
        console.log('Sidebar classes after:', sidebar.className);
        console.log('Sidebar computed style width:', window.getComputedStyle(sidebar).width);
        console.log('Sidebar offset width:', sidebar.offsetWidth);
        console.log('Sidebar client width:', sidebar.clientWidth);
    } else {
        console.error('Sidebar or overlay not found!');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    console.log('Closing sidebar...');
    console.log('Sidebar found:', !!sidebar);
    console.log('Overlay found:', !!overlay);
    
    if (sidebar && overlay) {
        sidebar.classList.remove('visible');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
        console.log('Sidebar closed successfully');
        console.log('Sidebar classes after:', sidebar.className);
    } else {
        console.error('Sidebar or overlay not found!');
    }
}

// Navigation Functions
function showPage(pageId) {
    // Determine the base path based on current location
    const currentPath = window.location.pathname;
    const isInDashboard = currentPath.includes('/Dashboard/');
    const isInEmployeeDashboard = currentPath.includes('/Employee_dashboard/');
    
    // Add loading feedback
    const activeLink = document.querySelector(`[onclick*="showPage('${pageId}')"]`);
    if (activeLink) {
        activeLink.style.opacity = '0.7';
        setTimeout(() => {
            activeLink.style.opacity = '1';
        }, 200);
    }
    
    // Navigate to the appropriate module
    setTimeout(() => {
        switch(pageId) {
            case 'home':
                window.location.href = '../Employee_dashboard/employee_homepage.php';
                break;
            case 'attendance':
                window.location.href = '../Attendance/Attendance.php';
                break;
            case 'leave':
                window.location.href = '../SLVL/leavefiling.php';
                break;
            case 'profile':
                window.location.href = '../profile/profile.php';
                break;
            case 'payroll':
                window.location.href = '../payrollEmp/payrollEmpSide.php';
                break;
            case 'incentive':
                window.location.href = '../Incentivization/employee_incen.php';
                break;
            default:
                console.log('Unknown page:', pageId);
                return;
        }
    }, 150);
    
    // Close sidebar on mobile after navigation
    if (window.innerWidth <= 768) {
        closeSidebar();
    }
}



// Replace the performLogout function in your sidebarEmp.js with this:

function performLogout() {
    const logoutBtn = document.querySelector('.logout-link');
    
    try {
        // Show loading state
        if (logoutBtn) {
            logoutBtn.innerHTML = '<span class="nav-icon"><i class="fas fa-spinner fa-spin"></i></span><span class="nav-text">Logging out...</span>';
            logoutBtn.style.pointerEvents = 'none';
        }

        // OPTION 1: Set logout flag for login required message
        localStorage.setItem('user_logged_out', 'true');
        localStorage.removeItem('user_logged_in');
        
        // Clear all client-side data
        sessionStorage.clear();
        
        // Redirect to logout.php (this will destroy server-side session)
        window.location.href = '../../Admin/Log_in/logout.php';
        
    } catch (error) {
        console.error('Logout error:', error);
        
        // Force logout even if there's an error
        localStorage.setItem('user_logged_out', 'true');
        localStorage.removeItem('user_logged_in');
        sessionStorage.clear();
        window.location.href = '../../Admin/Log_in/logout.php';
    }
}

// Keep your existing confirmLogout function
function confirmLogout() {
    if (confirm('Are you sure you want to log out?')) {
        performLogout();
    }
}


// Set Active Navigation Link
function setActiveNav(pageId) {
    // Remove active class from all nav links
    const allNavLinks = document.querySelectorAll('.nav-link');
    allNavLinks.forEach(link => {
        link.classList.remove('active');
    });

    // Add active class to current page link
    const activeLink = document.querySelector(`[onclick*="showPage('${pageId}')"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}



// Initialize sidebar based on current page
function initializeSidebar() {
    const currentPath = window.location.pathname;
    let currentPage = 'home';
    
    console.log('Current path:', currentPath);
    
    // Determine current page based on URL
    if (currentPath.includes('/Attendance/')) {
        currentPage = 'attendance';
    } else if (currentPath.includes('/Employee_dashboard/')) {
        currentPage = 'home';
    } else if (currentPath.includes('/SLVL/')) {
        currentPage = 'leave';
    } else if (currentPath.includes('/profile/')) {
        currentPage = 'profile';
    } else if (currentPath.includes('/payroll')) {
        currentPage = 'payroll';
    } else if (currentPath.includes('/Incentivization/')) {
        currentPage = 'incentive';
    }
    
    console.log('Detected page:', currentPage);
    
    // Set active navigation
    setActiveNav(currentPage);
}

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    if (window.innerWidth > 768) {
        // Desktop: Show sidebar by default, close overlay
        if (sidebar) {
            sidebar.classList.remove('visible');
            sidebar.style.transform = 'translateX(0)'; // Force show on desktop
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
    } else {
        // Mobile: Hide sidebar by default
        if (sidebar) {
            sidebar.classList.remove('visible');
            sidebar.style.transform = 'translateX(-100%)'; // Force hide on mobile
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
    }
});

// Handle browser back/forward buttons
window.addEventListener('popstate', function(event) {
    if (event.state && event.state.page) {
        showPage(event.state.page);
    }
});

// Initialize sidebar state based on screen size
function initializeSidebarState() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    if (window.innerWidth > 768) {
        // Desktop: Show sidebar by default
        if (sidebar) {
            sidebar.classList.remove('visible');
            sidebar.style.transform = 'translateX(0)';
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
    } else {
        // Mobile: Hide sidebar by default
        if (sidebar) {
            sidebar.classList.remove('visible');
            sidebar.style.transform = 'translateX(-100%)';
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = 'auto';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeSidebarState();
    
    // Add click event to overlay to close sidebar
    const overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
});

// Utility Functions
function showNotification(message, type = 'info') {
    // Remove existing notifications first
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${getNotificationIcon(type)}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Append to body
    document.body.appendChild(notification);
    
    // Force reflow to ensure styles are applied before animation
    notification.offsetHeight;
    
    // Show notification with animation
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Auto hide after 4 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        
        // Remove element after transition completes
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 350);
    }, 4000);
}

function getNotificationIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

// Export functions for external use (if needed)
if (typeof window !== 'undefined') {
    window.Sidebar = {
        toggle: toggleSidebar,
        open: openSidebar,
        close: closeSidebar,
        showPage: showPage,
        setActiveNav: setActiveNav,
        showNotification: showNotification,
        logout: confirmLogout
    };
}
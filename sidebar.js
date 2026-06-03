// ================sidebar.js====================
// SHARED SIDEBAR FUNCTIONALITY
// ====================================
// This file handles sidebar toggle and navigation across all modules

// Sidebar Toggle Functions
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    console.log('Toggle clicked!');
    console.log('Sidebar element:', sidebar);
    console.log('Sidebar classes before:', sidebar ? sidebar.className : 'Not found');
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
        
        console.log('Sidebar classes after:', sidebar.className);
        console.log('Overlay classes after:', overlay.className);
        console.log('Sidebar computed style:', window.getComputedStyle(sidebar).transform);
    } else {
        console.error('Sidebar or overlay not found!');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    if (sidebar && overlay) {
        sidebar.classList.remove('visible');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Navigation Functions
function showPage(pageId) {
    // Determine the base path based on current location
    const currentPath = window.location.pathname;
    const isInDashboard = currentPath.includes('/Dashboard/');
    
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
                if (isInDashboard) {
                    window.location.href = 'Dashboard.php';
                } else {
                    window.location.href = '../Dashboard/Dashboard.php';
                }
                break;
            case 'attendance':
                if (isInDashboard) {
                    window.location.href = '../Attendance_system/attendance_index.php';
                } else {
                    window.location.href = '../Attendance_system/attendance_index.php';
                }
                break;
            case 'Employee':
                if (isInDashboard) {
                    window.location.href = '../Employee/employee.php';
                } else {
                    window.location.href = '../Employee/employee.php';
                }
                break;
            case 'leave':
                if (isInDashboard) {
                    window.location.href = '../SLVL/HR_SLVL.php';
                } else {
                    window.location.href = '../SLVL/HR_SLVL.php';
                }
                break;
            case 'profile':
                if (isInDashboard) {
                    window.location.href = '../Profile/profile.php';
                } else {
                    window.location.href = '../Profile/profile.php';
                }
                break;
            case 'payroll':
                if (isInDashboard) {
                    window.location.href = '../Payroll/payroll.php';
                } else {
                    window.location.href = '../Payroll/payroll.php';
                }
                break;
            case 'incentive':
                if (isInDashboard) {
                    window.location.href = '../incentivization/incentives.php';
                } else {
                    window.location.href = '../incentivization/incentives.php';
                }
                break;
            case 'backup':
                if (isInDashboard) {
                    window.location.href = '../Backup_Restore/backup_restore.php';
                } else {
                    window.location.href = '../Backup_Restore/backup_restore.php';
                }
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

// Replace the performLogout function with the one from sidebarEmp.js

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
        window.location.href = '/HRIS/Admin/Log_in/logout.php';
        
    } catch (error) {
        console.error('Logout error:', error);
        
        // Force logout even if there's an error
        localStorage.setItem('user_logged_out', 'true');
        localStorage.removeItem('user_logged_in');
        sessionStorage.clear();
        window.location.href = '/HRIS/Admin/Log_in/logout.php';
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
    
    // Determine current page based on URL
    if (currentPath.includes('/attendance')) {
        currentPage = 'attendance';
    } else if (currentPath.includes('/employee')) {
        currentPage = 'Employee';
    } else if (currentPath.includes('/SLVL')) {
        currentPage = 'leave';
    } else if (currentPath.includes('/profile')) {
        currentPage = 'profile';
    } else if (currentPath.includes('/payroll')) {
        currentPage = 'payroll';
    } else if (currentPath.includes('/incentive')) {
        currentPage = 'incentive';
    } else if (currentPath.includes('/Backup_Restore') || currentPath.includes('/backup')) {
        currentPage = 'backup';
    }
    
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
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function getNotificationIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
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
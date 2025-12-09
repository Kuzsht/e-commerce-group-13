<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="logo">KICKSup</a>
        
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('products.index') }}">Products</a></li>
            
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                @elseif(auth()->user()->store)
                    <li><a href="{{ route('seller.dashboard') }}">Seller Dashboard</a></li>
                @else
                    <li><a href="{{ route('transactions.index') }}">My Orders</a></li>
                    <li><a href="{{ route('seller.register') }}">Become a Seller</a></li>
                @endif
                
                <li class="user-menu-dropdown">
                    <button class="user-menu-button" onclick="toggleUserMenu()">
                        @if(auth()->user()->buyer && auth()->user()->buyer->profile_picture)
                            <img src="{{ asset('images/profiles/' . auth()->user()->buyer->profile_picture) }}" alt="Profile" class="user-avatar">
                        @else
                            <div class="user-avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        @endif
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <svg class="dropdown-icon" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-header">
                            <div class="dropdown-user-info">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 8C10.21 8 12 6.21 12 4C12 1.79 10.21 0 8 0C5.79 0 4 1.79 4 4C4 6.21 5.79 8 8 8ZM8 10C5.33 10 0 11.34 0 14V16H16V14C16 11.34 10.67 10 8 10Z" fill="currentColor"/>
                            </svg>
                            My Profile
                        </a>
                        <a href="{{ route('transactions.index') }}" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M14 2H2C0.9 2 0 2.9 0 4V12C0 13.1 0.9 14 2 14H14C15.1 14 16 13.1 16 12V4C16 2.9 15.1 2 14 2ZM14 12H2V8H14V12ZM14 6H2V4H14V6Z" fill="currentColor"/>
                            </svg>
                            My Orders
                        </a>
                        @if(auth()->user()->store)
                        <a href="{{ route('seller.dashboard') }}" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M13.5 2H2.5L2 4.5V5H14V4.5L13.5 2ZM14 6H2V13C2 13.55 2.45 14 3 14H13C13.55 14 14 13.55 14 13V6Z" fill="currentColor"/>
                            </svg>
                            Seller Dashboard
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 14H3C2.45 14 2 13.55 2 13V3C2 2.45 2.45 2 3 2H6V0H3C1.35 0 0 1.35 0 3V13C0 14.65 1.35 16 3 16H6V14ZM12.09 7L9.59 4.5L11 3.09L16 8.09L11 13.09L9.59 11.67L12.09 9.18H4V7H12.09Z" fill="currentColor"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="btn btn-outline">Login</a></li>
                <li><a href="{{ route('register') }}" class="btn btn-primary">Register</a></li>
            @endauth
        </ul>

        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<style>
/* User Dropdown Styles */
.user-menu-dropdown {
    position: relative;
}

.user-menu-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: background 0.2s;
}

.user-menu-button:hover {
    background: var(--gray);
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border);
}

.user-avatar-placeholder {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--red), var(--yellow));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
}

.user-name {
    color: var(--dark-blue);
    font-weight: 600;
    font-size: 0.9rem;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropdown-icon {
    transition: transform 0.2s;
}

.user-menu-button.active .dropdown-icon {
    transform: rotate(180deg);
}

.user-dropdown-menu {
    position: absolute;
    top: calc(100% + 0.5rem);
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    min-width: 240px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s;
    z-index: 1000;
}

.user-dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 1rem;
    background: var(--gray);
    border-radius: 12px 12px 0 0;
}

.dropdown-user-info strong {
    display: block;
    color: var(--dark-blue);
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.dropdown-user-info small {
    display: block;
    color: #666;
    font-size: 0.8rem;
}

.dropdown-divider {
    height: 1px;
    background: var(--border);
    margin: 0.5rem 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: var(--black);
    text-decoration: none;
    transition: background 0.2s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    font-size: 0.9rem;
    cursor: pointer;
}

.dropdown-item:hover {
    background: var(--gray);
}

.dropdown-item svg {
    color: #666;
}

.dropdown-item-danger {
    color: var(--red);
}

.dropdown-item-danger svg {
    color: var(--red);
}

.dropdown-item-danger:hover {
    background: #fee;
}

@media (max-width: 768px) {
    .user-name {
        display: none;
    }
    
    .user-dropdown-menu {
        right: -1rem;
    }
}
</style>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userDropdownMenu');
    const button = document.querySelector('.user-menu-button');
    menu.classList.toggle('show');
    button.classList.toggle('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.user-menu-dropdown');
    if (dropdown && !dropdown.contains(event.target)) {
        document.getElementById('userDropdownMenu')?.classList.remove('show');
        document.querySelector('.user-menu-button')?.classList.remove('active');
    }
});
</script>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About KICKSup</h3>
                <p>Your trusted destination for authentic sneakers from verified sellers worldwide.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('products.index') }}">Shop Products</a></li>
                    <li><a href="{{ route('seller.register') }}">Sell on KICKSup</a></li>
                    @auth
                        <li><a href="{{ route('transactions.index') }}">Track Order</a></li>
                    @endauth
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Return Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Connect</h3>
                <ul>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 KICKSup. All rights reserved.</p>
        </div>
    </div>
</footer>
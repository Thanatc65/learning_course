<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>LearnHub</h3>
                <p>Expand your skills with professional courses taught by industry experts.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i data-feather="facebook"></i></a>
                    <a href="#" class="social-link"><i data-feather="twitter"></i></a>
                    <a href="#" class="social-link"><i data-feather="instagram"></i></a>
                    <a href="#" class="social-link"><i data-feather="linkedin"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Categories</h3>
                <ul class="footer-links">
                    <li><a href="#">Design</a></li>
                    <li><a href="#">Development</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Business</a></li>
                    <li><a href="#">Photography</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Subscribe</h3>
                <p>Get the latest updates and offers.</p>
                <form class="subscribe-form">
                    <input type="email" placeholder="Your email address">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> LearnHub. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Feather icons
        feather.replace();
        
        // Mobile menu toggle
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mainNav = document.querySelector('.main-nav');
        
        if (mobileMenuToggle && mainNav) {
            mobileMenuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('show');
                
                // Update icon
                const icon = this.querySelector('i');
                if (mainNav.classList.contains('show')) {
                    icon.setAttribute('data-feather', 'x');
                } else {
                    icon.setAttribute('data-feather', 'menu');
                }
                feather.replace();
            });
        }
    });
</script>
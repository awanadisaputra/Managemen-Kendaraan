<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FleetPro - Manajemen Kendaraan Perusahaan</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header class="hero">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <i class="fas fa-car-alt"></i>
                    <span>FleetPro</span>
                </div>
                <div class="nav-links">
                    <a href="#features">Fitur</a>
                    <a href="#about">Tentang</a>
                    <a href="#contact">Kontak</a>
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                </div>
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>

            <div class="hero-content">
                <div class="hero-text">
                    <h1>Manajemen Kendaraan Perusahaan yang Lebih Efisien</h1>
                    <p>Solusi terintegrasi untuk mengelola pemesanan, servis, dan konsumsi BBM kendaraan perusahaan Anda
                    </p>
                </div>
            </div>
        </div>
    </header>

    <section id="features" class="features">
        <div class="container">
            <h2>Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Pemesanan Kendaraan</h3>
                    <p>Sistem pemesanan online dengan persetujuan multi-level untuk efisiensi waktu</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-gas-pump"></i>
                    </div>
                    <h3>Pelacakan BBM</h3>
                    <p>Monitor konsumsi bahan bakar dan biaya operasional kendaraan</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Manajemen Servis</h3>
                    <p>Jadwal perawatan rutin dan riwayat servis kendaraan</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Laporan Lengkap</h3>
                    <p>Analisis dan ekspor data untuk pengambilan keputusan</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang Sistem Kami</h2>
                    <p>FleetPro dikembangkan untuk membantu perusahaan mengoptimalkan penggunaan kendaraan operasional
                        dengan sistem terintegrasi yang mencakup semua aspek manajemen kendaraan.</p>
                    <ul class="about-list">
                        <li><i class="fas fa-check-circle"></i> Antarmuka pengguna yang intuitif</li>
                        <li><i class="fas fa-check-circle"></i> Akses multi-level sesuai jabatan</li>
                        <li><i class="fas fa-check-circle"></i> Notifikasi real-time</li>
                        <li><i class="fas fa-check-circle"></i> Keamanan data terjamin</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Hubungi Kami</h2>
                    <p>Pertanyaan lebih lanjut tentang solusi kami?</p>

                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>awanadisaputra101@gmail.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>+62 815 5482 4594</span>
                    </div>
                </div>

                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Email Anda" required>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Pesan Anda" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="logo">
                        <i class="fas fa-car-alt"></i>
                        <span>FleetPro</span>
                    </div>
                    <p>Solusi manajemen kendaraan perusahaan yang efisien dan terintegrasi.</p>
                </div>

                <div class="footer-links">
                    <h3>Tautan Cepat</h3>
                    <ul>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#demo">Demo</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </div>

                <div class="footer-social">
                    <h3>Ikuti Kami</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2023 FleetPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
            document.querySelector('.nav-links').classList.toggle('active');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
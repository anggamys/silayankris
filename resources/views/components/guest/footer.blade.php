<style>
    .footer-section {
    background: #f4f5f7;
    color: #4a4a4a;
    font-family: "Inter", sans-serif;
}

.footer-text {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    max-width: 330px;
}

/* ICON BULAT */
.circle-icon {
    width: 45px;
    height: 45px;
    background: #a9c4ed;
    border-radius: 50%;
    display: inline-block;
}

/* JUDUL */
.footer-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 18px;
    color: #3a3a3a;
}

/* LIST */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    text-decoration: none;
    color: #555;
    transition: 0.2s ease;
}

.footer-links a:hover {
    color: #008080;
}

/* GARIS PEMBATAS */
.footer-divider {
    border-color: #ddd;
}

/* COPYRIGHT */
.footer-bottom {
    color: #888;
    font-size: 14px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .footer-title {
        margin-top: 20px;
    }
}

</style>

   {{-- Footer --}}
    <footer class="footer-section pt-5 pb-2">
    <div class="container">

        <div class="row justify-content-between align-items-start">

            <!-- About -->
            <div class="col-lg-4 col-md-12 mb-4">
                  <a href="" class="text-decoration-none fs-4 text-primary fw-bold">
                <img src="{{ asset('assets/img/logo.png') }}" height="64" alt="kemenag" class="mb-2">
              SILAYANKRIS</a>
                <div class="d-flex gap-3 mt-4">
                    <span class="circle-icon"></span>
                    <span class="circle-icon"></span>
                    <span class="circle-icon"></span>
                    <span class="circle-icon"></span>
                </div>
            </div>

            <!-- Quick Link -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Quick Link</h5>
                <ul class="footer-links">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/">Berita</a></li>
                    <li><a href="/">Layanan</a></li>
                </ul>
            </div>
            <!-- Services -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Service</h5>
                <ul class="footer-links">
                    <li><a href="/login">Berkas TPG Guru</a></li>
                    <li><a href="/login">Pendataan Gereja</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div class="col-lg-3 col-md-4 mb-4">
                <h5 class="footer-title">Help & Support</h5>
                <ul class="footer-links">
                    <li><a href="#">Hubungi Whatsapp</a></li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider my-4">

        <p class="footer-bottom text-center">
          &copy; 2025 <strong>SILAYANKRIS</strong> — Kementerian Agama Kota Surabaya.  
                <br>Seluruh hak cipta dilindungi.
        </p>
      
    </div>
</footer>
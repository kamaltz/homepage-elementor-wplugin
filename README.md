# Homepage Elementor Plugin

Plugin homepage editor untuk Elementor dengan widget-widget khusus untuk membuat homepage yang menarik dan responsif.

## Fitur

### Widget yang Tersedia:
1. **Category Banner** - Slider banner kategori dengan gambar desktop dan mobile
2. **Steps Section** - Section langkah-langkah dengan nomor dan deskripsi
3. **Follow Us** - Section follow us dengan gambar dan tombol
4. **Footer Section** - Footer dengan menu dan social media

### Fitur Kustomisasi:
- ✅ Kustomisasi konten (gambar, caption, deskripsi)
- ✅ Kustomisasi jumlah gambar/item
- ✅ Link caption dapat diarahkan ke page yang sudah ada
- ✅ Kustomisasi style (warna, typography, spacing)
- ✅ Kustomisasi advance setting Elementor
- ✅ Responsive design
- ✅ Slider dengan navigasi custom

## Instalasi

1. Upload folder `homepage-elementor` ke direktori `/wp-content/plugins/`
2. Aktifkan plugin melalui menu 'Plugins' di WordPress admin
3. Pastikan plugin Elementor sudah terinstall dan aktif
4. Widget akan muncul di kategori "Homepage Elements" di Elementor editor

## Penggunaan

### 1. Category Banner Widget
- Tambahkan widget "Category Banner" ke halaman
- Upload gambar untuk desktop dan mobile
- Atur title dan subtitle
- Tambahkan link untuk setiap banner
- Kustomisasi style sesuai kebutuhan

### 2. Steps Section Widget
- Tambahkan widget "Steps Section"
- Atur main title
- Tambahkan langkah-langkah dengan nomor dan deskripsi
- Kustomisasi warna dan typography

### 3. Follow Us Widget
- Tambahkan widget "Follow Us"
- Atur title dan button text
- Upload banner image
- Tambahkan link social media
- Kustomisasi style

### 4. Footer Section Widget
- Tambahkan widget "Footer Section"
- Atur footer title dengan HTML support
- Tambahkan menu footer
- Atur social media link
- Kustomisasi style

## Kustomisasi Style

Setiap widget memiliki tab "Style" dengan opsi:
- Warna teks dan background
- Typography (font family, size, weight)
- Spacing dan padding
- Hover effects
- Responsive settings

## Kustomisasi Advanced

Setiap widget mendukung:
- Custom CSS classes
- Motion effects
- Background options
- Border dan shadow
- Responsive visibility
- Custom attributes

## File Structure

```
homepage-elementor/
├── homepage-elementor.php (Main plugin file)
├── widgets/
│   ├── category-banner.php
│   ├── steps-section.php
│   ├── follow-us.php
│   └── footer-section.php
├── assets/
│   ├── css/
│   │   └── homepage.css
│   └── js/
│       └── homepage.js
└── README.md
```

## Dependencies

- WordPress 5.0+
- Elementor 3.0+
- jQuery
- Slick Carousel (loaded via CDN)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Changelog

### Version 1.0.0
- Initial release
- 4 custom widgets
- Responsive design
- Slider functionality
- Style customization
- Advanced Elementor settings

## Support

Untuk dukungan dan pertanyaan, silakan hubungi developer atau buat issue di repository.

## License

GPL v2 or later
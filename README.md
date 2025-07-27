# Homepage Elementor Plugin

**Dibuat oleh: kamaltz**

Plugin Elementor khusus untuk membuat homepage yang profesional dan responsif dengan 4 widget custom yang siap pakai, dilengkapi sistem auto-update dari GitHub.

## Widget yang Tersedia

### 1. Category Banner
Slider banner kategori dengan fitur lengkap:
- **Gambar Responsif**: Upload terpisah untuk desktop dan mobile
- **Arrow Navigation**: 4 posisi (bottom-right, bottom-left, bottom-center, center-sides)
- **Dots Navigation**: Dapat dikombinasikan dengan arrows
- **Caption Positioning**: 6 posisi dengan style custom
- **Image Sizing**: Height control, object-fit, object-position
- **Border Radius**: Rounded corners untuk gambar
- **Arrow Styling**: Size, color, background, hover effects

### 2. Steps Section  
Section langkah-langkah proses dengan style orpcatalog.id:
- **Grid Layout**: 4 kolom dengan connecting lines
- **Number Circles**: Gradient design dengan shadow
- **Responsive**: Mobile horizontal layout
- **Custom Colors**: Typography dan spacing control

### 3. Follow Us
Section call-to-action untuk social media dengan banner image dan tombol yang dapat disesuaikan.

### 4. Footer Section
Footer lengkap dengan menu navigasi dan link social media, mendukung HTML untuk konten yang lebih fleksibel.

## Instalasi

### Manual Installation
1. Download plugin dari GitHub Releases
2. Upload folder plugin ke `/wp-content/plugins/`
3. Aktifkan melalui menu Plugins di WordPress admin
4. Pastikan Elementor sudah aktif
5. Widget tersedia di kategori "Homepage Elements"

### Auto-Update Setup
1. Pergi ke **Settings > Homepage Elementor**
2. Atur **GitHub Repository**: `username/homepage-elementor-wplugin`
3. Atur **GitHub Token** (optional untuk private repo)
4. Aktifkan **Auto Update**
5. Plugin akan otomatis update dari GitHub releases

## Cara Penggunaan

### Category Banner

#### Content Tab
1. **Slides**: Tambah/edit slide dengan tombol "Add Item"
2. **Desktop Image**: Upload gambar untuk desktop (recommended: 1920x1080)
3. **Mobile Image**: Upload gambar untuk mobile (recommended: 768x1024)
4. **Title & Subtitle**: Atur teks caption
5. **Link**: URL tujuan saat banner diklik
6. **Slider Settings**: Slides to show, slides to scroll
7. **Navigation**: Toggle arrows dan dots

#### Style Tab
**Caption Style:**
- Background color dengan opacity
- Padding responsive
- Text alignment (left/center/right)

**Arrow Style:**
- Size: 30px-100px
- Colors: arrow, background, border
- Hover effects

#### Advanced Settings
- **Arrow Position**: bottom-right, bottom-left, bottom-center, center-sides
- **Caption Position**: 6 pilihan posisi
- **Image Height**: px, vh, % units
- **Image Fit**: cover, contain, fill, none
- **Image Position**: 9 focal points
- **Border Radius**: rounded corners

### Steps Section

#### Content Tab
1. **Main Title**: Judul utama section
2. **Steps**: Tambah langkah dengan "Add Item"
   - **Number**: Nomor urut (otomatis)
   - **Description**: Deskripsi langkah

#### Style Tab
- **Title Typography**: Font, size, color
- **Number Style**: Background, border, colors
- **Description Style**: Typography dan spacing
- **Connecting Line**: Color dan thickness

### Follow Us
1. **Banner Image**: Upload background image
2. **Title & Button Text**: Atur teks CTA
3. **Social Links**: Tambah link media sosial
4. **Style**: Colors, typography, spacing

### Footer Section
1. **Title**: Judul footer (support HTML)
2. **Footer Menu**: Buat menu navigasi
3. **Social Media**: Link dan icon social media
4. **Layout**: Column layout dan spacing

## Fitur Kustomisasi

### Category Banner
**Navigation Options:**
- Show/hide arrows dan dots
- 4 arrow positions
- Custom arrow styling
- Dots + arrows combination

**Image Controls:**
- Responsive height (px, vh, %)
- Object-fit: cover, contain, fill
- Object-position: 9 focal points
- Border radius dengan overflow

**Caption Controls:**
- 6 positioning options
- Background color dengan opacity
- Responsive padding
- Text alignment

### Steps Section
**Layout Options:**
- Grid 4 kolom dengan connecting lines
- Mobile: horizontal layout
- Number circles dengan gradient
- Responsive typography

**Style Controls:**
- Title typography lengkap
- Number circle: size, colors, shadow
- Description styling
- Connecting line customization

### Universal Features
**Elementor Integration:**
- Motion effects support
- Custom CSS classes
- Responsive visibility
- Background options
- Border dan shadow controls

**Performance:**
- Lazy loading images
- Optimized CSS/JS
- Mobile-first responsive
- Cross-browser compatibility

## Auto-Update System

### GitHub Integration
Plugin dilengkapi sistem auto-update dari GitHub repository:

**Settings Page:**
- **GitHub Repository**: Format `username/repository-name`
- **GitHub Token**: Personal Access Token untuk private repo
- **Auto Update**: Toggle otomatis update
- **Manual Update**: Check dan update manual
- **Debug Tools**: Clear cache, force check

**CI/CD Pipeline:**
- Auto-increment version setiap push
- GitHub Actions untuk build dan release
- WordPress integration untuk update notification
- Backup system untuk rollback

### Update Methods
1. **Auto Update**: Background update dari WordPress
2. **Manual Update**: Via settings page
3. **WordPress Dashboard**: Standard plugin update

## Requirements

- WordPress 5.0+
- Elementor 3.0+
- PHP 7.4+
- jQuery (included)
- Slick Carousel (auto-loaded)

## Browser Support

Semua browser modern termasuk mobile browsers dengan support untuk:
- CSS Grid dan Flexbox
- Object-fit dan object-position
- CSS Custom Properties
- ES6 JavaScript features

## Changelog

### Version 1.0.3
- ✅ Auto-update system dari GitHub
- ✅ Category banner: arrow + dots navigation
- ✅ Image sizing controls (height, fit, position)
- ✅ Border radius untuk images
- ✅ Enhanced arrow positioning (4 options)
- ✅ Caption positioning (6 options)
- ✅ Steps section: orpcatalog.id style
- ✅ CI/CD pipeline dengan auto-versioning
- ✅ Manual update functionality
- ✅ Debug tools dan cache management

### Version 1.0.0
- 4 widget custom siap pakai
- Responsive design otomatis
- Slider dengan navigasi
- Kustomisasi style lengkap
- Integrasi penuh dengan Elementor

---

**Developed by kamaltz**  
**GitHub**: [homepage-elementor-wplugin](https://github.com/kamaltz/homepage-elementor-wplugin)  
**Auto-Update**: Enabled via GitHub Releases
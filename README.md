# meme-lucu
Merupakan website berkumpulnya meme lucu.

# Cara menambahkan file sebagai developer
1. `git clone https://github.com/alfa-th/meme-lucu/`
2. Tambahkan file di folder khusus kalian masing"
3. `git add .`
4. `git commit -m "judul commit"`
5. `git push origin master`

# Fitur
## Front-end
- [x] Login Page 
	- [x] Flash rendering
- [x] Registration Page 
	- [x] Flash rendering
**_Baru_**
- [x] Dashboard
	- [x] Client-side list(categories) rendering
	- [x] Conditional dashboard item rendering (untuk yang login dan untuk yang tidak login melihat hal berbeda)
- [x] Beranda Page
	- [x] Flash rendering
	- [x] Client-side API vote operation
	- [x] Client-side list(meme) rendering
- [x] Kategori Page
	- [x] Flash rendering
	- [x] Client-side API vote operation
	- [x] Client-side list(meme) rendering
- [x] Upload Page
	- [x] Image(meme) Preview with Javascript
	
	
## Back-end
- [x] Operasi Login dengan : 
	- [x] Server-side form validation
	- [x] Session setting
	- [x] Message flashing
- [x] Operasi Registrasi dengan :
	- [x] Server-side form validation
	- [x] Registration data insertion to database
	- [x] Message flashing
- [x] Operasi logout dengan :
	- [x] Session destroying
**_Baru_**
- [x] API untuk operasi resource sharing pada website dengan:
	- [x] Endpoint :
		- [x] Mendapatkan vote state pada suatu meme dari user
		- [x] Mendapatkan total vote yang dimiliki oleh sebuah post
		- [x] Mendapatkan kategori yang dimiliki oleh sebuah post
		- [x] Mendapatkan semua kategori meme yang ada di website
	- [x] Fitur :
		- [x] Cross-origin resource sharing (API dapat diakses di domain lain)
		- [x] Bad request setter (Apabila pengaksesan API tidak meliputi data yang cukup)
- [x] Operasi Rendering Meme dengan :
	- [x] Implementasi pada  :
		- [x] Bagian Beranda
		- [x] Bagian Kategori
	- [x] Fitur : 
		- [x] Akomodasi terhadap client side list rendering
		- [x] Redireksi jika endpoint kategori diakses tanpa data yang cukup
- [x] Operasi Voting Post dengan :
	- [x] Endpoint :
		- [x] /action, apabila terjadi akses endpoint post untuk voting
	- [x] Fitur :
		- [x] Insert atau Update keadaan vote pada suatu meme berdasarkan user
- [x] Operasi Upload dengan :
	- [x] Endpoint :
		- [x] /, Untuk memperlihatkan halaman upload
		- [x] /upload_action, Untuk menerima aksi upload dari sisi client
	- [x] Fitur :
		- [x] Menggunakan library image_upload yang disediakan oleh codeigniter
		- [x] Enkripsi nama
		- [x] Server-side Image Validation
		- [x] Server-side Form Validation
		- [x] Message flashing

# Tugas
## Front-end
- [x] Membuat Login Page yang mempunyai fitur :
	- [x] Email input box
	- [x] Password input box
	- [x] Ingat email dan password checkbox
- [x] Membuat Registrasi Page yang mempunyai fitur :
	- [x] Email input box
	- [x] Username input box
	- [x] Password input box
	- [x] Confirm Password input box
- [ ] Membuat Home Page yang mempunyai fitur :
	- [ ] List Meme
		- [ ] Tombol Upvote
		- [ ] Tombol Downvote
		- [ ] Tombol Lapor
- [ ] Membuat Dashboard dengan fitur : 
	- [ ] Bagian Kiri
		- [ ] Logo
		- [ ] Hyperlink Home
		- [ ] Dropdown Kategori
	- [ ] Bagian Kanan
		- [ ] Hyperlink Logout
		- [ ] Hyperlink User
- [ ] Membuat Halaman Upload dengan fitur :
	- [ ] Input Box Gambar
	- [ ] Input Box Judul
	- [ ] Input Box Kategori
	- [ ] Tombol Submit
	
		
## Back-end
- [x] Dokumen Analisa dan Desain Sistem  berupa :
	- [ ] System Flow Diagram 
		- [x] Registration Flow
		- [x] Login Flow
		- [ ] Yang Lainnya
	- [ ] Data Flow Diagram
		- [x] DFD 0 
		- [ ] DFD 1 
		- [ ] DFD 2
- [x] Skema Database berupa :
	- [x] Dokumen dbdiagram.io
- [ ] Operasi Backend
	- [x] Login 
		- [x] Server-side form validation
		- [x] Session setting
	- [x] Registrasi
		- [x] Server-side form validation
		- [x] Registration data insertion to database
	- [x] Logout
		- [x] Session destroying
	- [ ] Upload Meme
	- [ ] Menampilkan Meme
	
# Link
## Laporan Final Project
[Google Docs](https://docs.google.com/document/d/1T4N62dsxHGXPVadHxJ1uvz3_ohbTQIPYrLTKyy_6IxA/edit)
## Diagram Analisa dan Desain Sistem
[diagrams.net](https://app.diagrams.net/#G1is6fezWZZrsBbdVYQgIa9fKeMo6NOr7V)
## Dokumen Skema Database
[dbdiagram.io](https://dbdiagram.io/d/5ea03c8739d18f5553fe06d9)

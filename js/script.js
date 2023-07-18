// Mendapatkan referensi ke elemen <body> pada halaman. 
// untuk digunakan dalam perubahan kelas atau atribut yang berkaitan dengan elemen <body>.
let body = document.body;

// Mendapatkan referensi ke elemen dengan class "profile" 
// yang berada di dalam elemen dengan class "flex" yang berada di dalam elemen dengan class "header". 
// untuk memanipulasi kelas atau atribut pada elemen profil.
let profile = document.querySelector('.header .flex .profile');

// Mendapatkan referensi ke elemen dengan class "profile" 
// yang berada di dalam elemen dengan class "flex" yang berada di dalam elemen dengan class "header". 
// untuk memanipulasi kelas atau atribut pada elemen profil.
document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   searchForm.classList.remove('active');
}

// Mendapatkan referensi ke elemen dengan class "search-form" 
// yang berada di dalam elemen dengan class "flex" yang berada di dalam elemen dengan class "header". 
// untuk memanipulasi kelas atau atribut pada elemen formulir pencarian.
let searchForm = document.querySelector('.header .flex .search-form');

// Menetapkan event handler ketika elemen dengan id "search-btn" 
// diklik. Ketika diklik, toggle class "active" pada elemen searchForm dan menghapus class "active" 
// dari elemen profil. untuk memberikan respons saat tombol pencarian diklik.
document.querySelector('#search-btn').onclick = () =>{
   searchForm.classList.toggle('active');
   profile.classList.remove('active');
}

// Mendapatkan referensi ke elemen dengan class "side-bar". 
// untuk memanipulasi kelas atau atribut pada elemen sidebar.
let sideBar = document.querySelector('.side-bar');

// Menetapkan event handler ketika elemen dengan id "menu-btn" 
// diklik. Ketika diklik, toggle class "active" pada elemen sidebar dan elemen body. 
// untuk memberikan respons saat tombol menu diklik.
document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

// Menetapkan event handler ketika elemen dengan class "close-side-bar" 
// yang berada di dalam elemen dengan class "side-bar" diklik. Ketika diklik, 
// menghapus class "active" dari elemen sidebar dan elemen body. 
// untuk memberikan respons saat tombol tutup sidebar diklik.
document.querySelector('.side-bar .close-side-bar').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(InputNumber => {
   InputNumber.oninput = () =>{
      if(InputNumber.value.length > InputNumber.maxLength) InputNumber.value = InputNumber.value.slice(0, InputNumber.maxLength);
   }
});


// Menetapkan event handler ketika terjadi scroll pada jendela (window). 
// Ketika terjadi scroll, menghapus class "active" dari elemen profil dan elemen searchForm. 
// Jika lebar kurang dari 1200 piksel, menghapus class "active" dari elemen sidebar dan elemen body. 
//  memberikan respons saat terjadi scroll pada halaman dan menyesuaikan tampilan sesuai dengan lebar.
window.onscroll = () =>{
   profile.classList.remove('active');
   searchForm.classList.remove('active');

   if(window.innerWidth < 1200){
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }

}

let toggleBtn = document.querySelector('#toggle-btn');
let darkMode = localStorage.getItem('dark-mode');

const enabelDarkMode = () =>{
   toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}

toggleBtn.onclick = (e) =>{
   let darkMode = localStorage.getItem('dark-mode');
   if(darkMode === 'disabled'){
      enabelDarkMode();
   }else{
      disableDarkMode();
   }
}
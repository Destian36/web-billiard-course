let body = document.body;

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   searchForm.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   searchForm.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

document.querySelector('.side-bar .close-side-bar').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

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


toggleBtn.onclick = (e) =>{
   let darkMode = localStorage.getItem('dark-mode');
   if(darkMode === 'disabled'){
      enabelDarkMode();
   }else{
      disableDarkMode();
   }
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}

function sendReply(contactName) {
   var replyTextarea = document.getElementById('reply-textarea-' + contactName);
   var replyMessage = replyTextarea.value.trim();

   if (replyMessage !== '') {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'data_message.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
         if (xhr.readyState === 4) {
            if (xhr.status === 200) {
               var messageContainer = document.getElementById('message-container-' + contactName);
               var sentMessage = document.createElement('div');
               sentMessage.classList.add('sent-message');
               sentMessage.textContent = replyMessage;
               messageContainer.appendChild(sentMessage);
               replyTextarea.value = '';
            } else {
               console.error('Error:', xhr.status);
            }
         }
      };
      xhr.send('reply_contact=1&contact_name=' + encodeURIComponent(contactName) + '&reply_message=' + encodeURIComponent(replyMessage));
   }
}

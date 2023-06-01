<div id="MainCookie" class="position-fixed bottom-0 end-0 p-3 d-none" style="z-index: 11">
  <div id="CookieToast" class="toast p-3 toastdark" data-bs-autohide="false" role="alert" aria-live="assertive">
    <div class="toast-header toastdarkhead text-white">
      <i class="icon-info-circle fs-5 me-3"></i>
      <strong class="me-auto">{{ $setting->cookie_title }}</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close" onclick="hideCookieBanner()"></button>
    </div>
    <div class="toast-body text-white p-3">
      {!! $setting->cookie_body !!}
    </div>
  </div>
</div>
<script>
  window.onload = (event)=> {
   initializeCookieBanner();
  }
  var MainCookie = document.getElementById('MainCookie');

  function hideCookieBanner(){
   localStorage.setItem("CookieAccepted", "yes");
   MainCookie.classList.add("d-none");
  }

  function initializeCookieBanner(){
   let isCookieAccepted = localStorage.getItem("CookieAccepted");
   if(isCookieAccepted === null) {
      MainCookie.classList.remove("d-none");
      let myAlert = document.getElementById('CookieToast');
      let bsAlert = new  bootstrap.Toast(myAlert);
      bsAlert.show();
    }
  }  
</script>
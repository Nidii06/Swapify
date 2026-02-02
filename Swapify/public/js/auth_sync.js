(function () {
  function redirectToLogin() {
    var page = (window.location.pathname.split('/').pop() || '').toLowerCase();
    if (page === 'login.php' || page === 'register.php') return;
    window.location.replace('login.php');
  }

  // Ensure back/forward cache does not show authenticated pages after logout
  window.addEventListener('pageshow', function (e) {
    if (e && e.persisted) {
      window.location.reload();
    }
  });

  window.addEventListener('storage', function (e) {
    if (e && e.key === 'swapify:logout') {
      redirectToLogin();
    }
  });

  try {
    if ('BroadcastChannel' in window) {
      var bc = new BroadcastChannel('swapify:auth');
      bc.onmessage = function (ev) {
        if (ev && ev.data && ev.data.type === 'logout') {
          redirectToLogin();
        }
      };
    }
  } catch (_) {

  }
})();

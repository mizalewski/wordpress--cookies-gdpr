(function () {
  'use strict';

  var GdprCookieName = 'gdpr_cookies_accepted';

  function ready(fn) {
    if (document.readyState !== 'loading'){
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  function getCookie(cookieName) {
    var name = cookieName + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  function setCookie(cookieName, value, expiresInDays) {
    var d = new Date();
    d.setTime(d.getTime() + (expiresInDays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cookieName + "=" + value + ";" + expires + ";path=/";
  }

  function accept (el) {
    hideBar(el)

    setCookie(GdprCookieName, '1', 3650);
  }

  function hideBar (el) {
    el.style.display = 'none';
  }

  function showBar (el) {
    el.style.display = 'block';
  }

  function accepted () {
    return getCookie(GdprCookieName) === '1';
  }

  ready(function () {
    if (accepted()) {
      return;
    }

    var element = document.querySelector('#cookies_gdpr_bar');
    if (element) {
      element.querySelector('[data-user-action="accept"]').addEventListener('click', function () {
        accept(element);
      });

      showBar(element);
    }
  })
})();

function msieversion() {
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");

  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv:11\./)) {
    // If Internet Explorer, return version number
    alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
  } // If another browser, return 0
  else {
    alert("otherbrowser");
  }

  return false;
}

[1, 2, 3].map(n => n ** 2);

msieversion();

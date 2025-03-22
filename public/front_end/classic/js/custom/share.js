function queryStringToObject() {
  const params = new URLSearchParams(window.location.search);
  const result = {};
  for (const [key, value] of params.entries()) {
    if (result[key]) {
      if (Array.isArray(result[key])) {
        result[key].push(value);
      } else {
        result[key] = [result[key], value];
      }
    } else {
      result[key] = value;
    }
  }
  return result;
}

function openInApp(pathName) {
  const androidLink = document.getElementById("android-link").innerText.trim();
  const iosLink = document.getElementById("ios-link").innerText.trim();

  var androidAppStoreLink = androidLink ?? "https://play.google.com/store/apps/details?id=eShop.multivendor.customer";
  var iosAppStoreLink = iosLink ?? "https://apps.apple.com/fr/app/microsoft-word/id462054704?l=en-GB&mt=12";
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;
  var isAndroid = /android/i.test(userAgent);
  var isIOS = /iPad|iPhone|iPod/.test(userAgent) && !window.MSStream;
  var appStoreLink = isAndroid
    ? androidAppStoreLink
    : isIOS
    ? iosAppStoreLink
    : androidAppStoreLink;

  if (isAndroid) {
    const scheme = document.getElementById("android-scheme").innerText.trim();
    if(confirm("Do you want to open in app")){
      window.location.href = `${scheme}://app${pathName}`;
    }
  } else if (isIOS) {
    const scheme = document.getElementById("ios-scheme").innerText.trim();
    if(confirm("Do you want to open in app")){
      window.location.href = `${scheme}://app${pathName}`;
    }
  }

  setTimeout(function () {
    if (document.hidden || document.webkitHidden) {
      // App was opened successfully
    } else {
      if (
        confirm(
          "News app is not installed. Would you like to download it from the app store?"
        )
      ) {
        window.location.href = appStoreLink;
      }
    }
  }, 1000);
}

$(document).ready(function () {
  function isMobileOrTablet() {
    return window.matchMedia("(max-width: 1024px)").matches;
  }

  if (isMobileOrTablet() && !sessionStorage.getItem("bottomSheetShown")) {

    const pathName = window.location.pathname;

    if(document.getElementsByClassName("share-div").length == 0){
        return;
    }

    document.getElementsByClassName("share-div")[0].innerHTML =
                  `<div class="bottom-sheet p-4" id="bottomSheet">
                        <h5>Open in App</h5>
                        <p>Get a better experience by using our mobile app!</p>
                        <button class="btn btn-outline-secondary w-100" onclick="hideBottomSheet()">Close</button>
                    </div>` +
      document.getElementsByClassName("share-div")[0].innerHTML;


    // Define helper functions
    window.toggleBottomSheet = function (show = true) {
      const bottomSheet = document.getElementById("bottomSheet");
      if (show) {
        bottomSheet.classList.add("show");
      } else {
        bottomSheet.classList.remove("show");
      }
    };

    window.hideBottomSheet = function () {
      toggleBottomSheet(false);
      sessionStorage.setItem("bottomSheetShown", "true");
    };

    openInApp(pathName);

    toggleBottomSheet(true);
  }
});

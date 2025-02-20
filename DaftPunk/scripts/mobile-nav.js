document.addEventListener("DOMContentLoaded", function () {
  const NAV_BUTTON = document.querySelector("#nav-btn");
  const NAV_LIST = document.querySelector("#nav-list");

  if (NAV_BUTTON && NAV_LIST) {
    
    NAV_BUTTON.addEventListener("click", function () {
      NAV_LIST.classList.toggle("show-navigation");
    });

    
    NAV_LIST.addEventListener("click", function (event) {
      if (event.target.tagName === "A") {
        NAV_LIST.classList.remove("show-navigation");
      }
    });
  } 
});
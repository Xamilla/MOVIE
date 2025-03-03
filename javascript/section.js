let nextDom = document.getElementById("next");
let prevDom = document.getElementById("prev");
let carouselDom = document.querySelector(".carousel");
let ListItemDom = document.querySelector(".carousel .list");
let thumbnailDom = document.querySelector(".thumbnail");

nextDom.onclick = function () {
  showSlider("next");
};
prevDom.onclick = function () {
  showSlider("prev");
};

let timeRunning = 3000;
let timeAutoNext = 7000;
let runTimeOut;
let runAutoRun = setTimeout(() => {
  showSlider("next");
}, timeAutoNext);

function showSlider(type) {
  let itemSlider = document.querySelectorAll(".carousel .list .item");
  let itemThumbnail = document.querySelectorAll(".thumbnail .item");

  if (type === "next") {
    ListItemDom.appendChild(itemSlider[0]);
    thumbnailDom.appendChild(itemThumbnail[0]);
    carouselDom.classList.add("next");
  } else {
    let positionLastItem = itemSlider.length - 1;
    ListItemDom.insertBefore(itemSlider[positionLastItem], itemSlider[0]);
    thumbnailDom.insertBefore(
      itemThumbnail[positionLastItem],
      itemThumbnail[0]
    );
    carouselDom.classList.add("prev");
  }

  clearTimeout(runTimeOut);
  runTimeOut = setTimeout(function () {
    carouselDom.classList.remove("next");
    carouselDom.classList.remove("prev");
  }, timeRunning);

  clearTimeout(runAutoRun);
  runAutoRun = setTimeout(() => {
    showSlider("next");
  }, timeAutoNext);
}

// Add event listeners to thumbnail items
document.querySelectorAll(".thumbnail .item").forEach((thumbnail, index) => {
  thumbnail.addEventListener("click", () => {
    showSliderByIndex(index);
  });
});

function showSliderByIndex(index) {
  let itemSlider = document.querySelectorAll(".carousel .list .item");
  let itemThumbnail = document.querySelectorAll(".thumbnail .item");

  // Move the selected item to the first position
  while (index > 0) {
    ListItemDom.appendChild(itemSlider[0]);
    thumbnailDom.appendChild(itemThumbnail[0]);
    index--;
  }

  // Reset the carousel classes
  carouselDom.classList.remove("next");
  carouselDom.classList.remove("prev");

  // Restart the auto-run timer
  clearTimeout(runAutoRun);
  runAutoRun = setTimeout(() => {
    showSlider("next");
  }, timeAutoNext);
}

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const inputs = document.querySelectorAll(
    "input[type='text'], input[type='password'], input[type='captcha']"
  );

  let lastInputs = {};

  form.addEventListener("submit", function (event) {
    let hasError = false;

    inputs.forEach((input) => {
      let value = input.value.trim();
      let name = input.getAttribute("name");

      // Check if the field is empty
      if (value === "") {
        triggerVibration(input);
        hasError = true;
      }

      // Check if the user keeps repeating the same input
      if (lastInputs[name] === value && value !== "") {
        triggerVibration(input);
        hasError = true;
      }

      // Store the last input value
      lastInputs[name] = value;
    });

    if (hasError) {
      event.preventDefault(); // Stop form submission if there are errors
    }
  });

  function triggerVibration(input) {
    input.classList.add("shake");
    setTimeout(() => {
      input.classList.remove("shake");
    }, 300);
  }
});

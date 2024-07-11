  // Hamburger menu functionality
  const mobileNav = document.querySelector(".hamburger");
  const navbar = document.querySelector(".menubar");

  const toggleNav = () => {
    navbar.classList.toggle("active");
    mobileNav.classList.toggle("hamburger-active");
  };
  mobileNav.addEventListener("click", () => toggleNav());

  // Image upload functionality
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
        $('.image-title').html(input.files[0].name);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      removeUpload();
    }
  }

  function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
  }

  // Form step functionality
  const steps = Array.from(document.querySelectorAll("form .step"));
  const nextBtn = document.querySelectorAll("form .next-btn");
  const prevBtn = document.querySelectorAll("form .previous-btn");
  const form = document.querySelector("form");

  nextBtn.forEach((button) => {
    button.addEventListener("click", () => {
      changeStep("next");
    });
  });
  prevBtn.forEach((button) => {
    button.addEventListener("click", () => {
      changeStep("prev");
    });
  });

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const inputs = [];
    form.querySelectorAll("input").forEach((input) => {
      const { name, value } = input;
      inputs.push({ name, value });
    });
    console.log(inputs);
    form.submit();
    form.reset();
  });

  function changeStep(btn) {
    let index = 0;
    const active = document.querySelector(".active");
    index = steps.indexOf(active);
    steps[index].classList.remove("active");
    if (btn === "next") {
      index++;
    } else if (btn === "prev") {
      index--;
    }
    steps[index].classList.add("active");
  }

  const button = document.getElementById("submit-listing");

  
  function Submit(){
    const form = document.getElementById("form2");
    form.submit();
  }

  // button.addEventListener("click", function(event) {
  //   // Prevent default form submission behavior (if using client-side validation)
  //   event.preventDefault();

  //   const form = document.getElementById("form2");

  //   // Submit the form programmatically
  //   form.submit();
  // });


  var model = document.querySelector(".model");

  function fadeIn () {
    console.log('fadein')
    model.className += " fadeIn";
  }



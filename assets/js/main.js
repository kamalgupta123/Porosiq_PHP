$(document).ready(function () {
  //   const status = document.querySelectorAll("#tableStatus");

  // status.forEach((e) => {
  //   if (e.innerText == "Completed") {
  //     e.style.textDecoration = "underline";
  //     e.style.textDecorationColor = "green";
  //     e.style.textDecorationThickness = "2px";
  //   } else {
  //     e.style.textDecoration = "underline";
  //     e.style.textDecorationColor = "red";
  //     e.style.textDecorationThickness = "2px";
  //   }
  // });

  //logout functionality
  $(".navbar__logout").on("click", function (e) {
    $(".header-profile").toggle("fast");
    e.stopPropagation();
  });

  $(".header-profile").click(function (e) {
    e.stopPropagation();
  });

  $(document).click(function () {
    $(".header-profile").hide();
  });

  //display upload file functionality

  // getting input elements
  const applicationForm = document.getElementById("application_form");
  const ssa_form = document.getElementById("ssa_form");
  const non_disclosure_aggrement = document.getElementById(
    "non_disclosure_aggrement"
  );
  const drug_test_form = document.getElementById("drug_test_form");
  const cori_form = document.getElementById("cori_form");

  //getting upload button
  const application_file = document.getElementById("application_file");
  const disclosureFile = document.getElementById("nonDisclosure_file");
  const ssa_file = document.getElementById("ssa_file");
  const drug_test_file = document.getElementById("drug_test_file");
  const cori_file = document.getElementById("cori_file");

  //adding validation
  applicationForm.addEventListener("change", function () {
    application_file.textContent = this.files[0].name;
  });
  non_disclosure_aggrement.addEventListener("change", function () {
    disclosureFile.textContent = this.files[0].name;
  });
  ssa_form.addEventListener("change", function () {
    ssa_file.textContent = this.files[0].name;
  });
  drug_test_form.addEventListener("change", function () {
    drug_test_file.textContent = this.files[0].name;
  });
  cori_form.addEventListener("change", function () {
    cori_file.textContent = this.files[0].name;
  });
});
var showing1 = false;

function show1() {
  if (showing1) {
    document.getElementById("password1").setAttribute("type", "password");
    showing1 = false;
  } else {
    document.getElementById("password1").setAttribute("type", "text");
    showing1 = true;
  }
}
var showing2 = false;
function show2() {
  if (showing2) {
    document.getElementById("password2").setAttribute("type", "password");
    showing2 = false;
  } else {
    document.getElementById("password2").setAttribute("type", "text");
    showing2 = true;
  }
}
var showing3 = false;
function show3() {
  if (showing3) {
    document.getElementById("password").setAttribute("type", "password");
    showing3 = false;
  } else {
    document.getElementById("password").setAttribute("type", "text");
    showing3 = true;
  }
}

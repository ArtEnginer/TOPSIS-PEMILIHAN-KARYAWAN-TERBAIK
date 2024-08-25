const url = `${baseURL}`;

$("body").on("submit", "form#login", function (e) {
  e.preventDefault();
  const data = {};

  $(this)
    .serializeArray()
    .map(function (x) {
      data[x.name] = x.value;
    });
  const credType = data.cred.includes("@") ? "email" : "username";
  $(this).find("#cred_type").attr("name", credType).val(data.cred);
  delete data.username;
  delete data.email;
  data[credType] = data.cred;
  const urlParams = Array.from(new URLSearchParams(window.location.search)).map(
    (uri) => {
      const a = {};
      a[uri[0]] = uri[1];
      return a;
    }
  );
  urlParams.forEach((uri) => {
    data[Object.keys(uri)[0]] = Object.values(uri)[0];
  });

  console.log(data);
  // $(".preloader").slideDown();
  $.ajax({
    type: "POST",
    url: origin + "/login",
    data: data,
    cache: false,
    success: async function (response) {
      $(".preloader").slideUp();
      await Toast.fire({
        icon: "success",
        title: "Anda berhasil masuk",
      });
      if (response.redirect) {
        window.location.href = url + response.redirect;
      }
    },
    complete: function () {
      // $(".preloader").slideUp();
    },
  });
});
$("body").on("submit", "form#register", function (e) {
  e.preventDefault();
  const data = {};
  $(this)
    .serializeArray()
    .map(function (x) {
      data[x.name] = x.value;
    });

  const form = $(this)[0];
  const elements = form.elements;
  for (let i = 0, len = elements.length; i < len; ++i) {
    elements[i].readOnly = true;
  }

  $.ajax({
    type: "POST",
    url: url + "/api/user",
    data: data,
    cache: false,
    success: async (data) => {
      $(this)[0].reset();
      await Toast.fire({
        icon: "success",
        title: "Anda berhasil mendaftar, silahkan login",
      });
      $(this).closest(".page.slider").removeClass("active");
    },
    complete: () => {
      for (let i = 0, len = elements.length; i < len; ++i) {
        elements[i].readOnly = false;
      }
    },
  });
});

$(document).ready(function () {
  $(".preloader").slideUp();
});

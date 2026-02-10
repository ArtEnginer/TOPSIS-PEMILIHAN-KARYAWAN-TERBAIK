$(".parent-wrapper").scroll(function () {
  if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
  } else {
  }
  console.log(
    $(this).scrollTop(),
    $(this).innerHeight(),
    $(this)[0].scrollHeight,
  );
});

$(".next-page").on("click", function (e) {
  const page = $(this).closest(".page").next();
  page.addClass("active");
});
$(".back-page").on("click", function (e) {
  const page = $(this).closest(".page");
  page.removeClass("active");
});

$("form#form-diagnosa").on("submit", function (e) {
  e.preventDefault();
  const data = {};
  $(this)
    .serializeArray()
    .map(function (x) {
      data[x.name] = parseFloat(x.value);
    });
  console.log(data);
  if (Object.keys(data).length === 0) {
    return;
  }
  $(this).find("input, select").attr("readonly", true);
  $(this).find("button[type=submit]").attr("disabled", true);
  $.ajax({
    type: "POST",
    url: url + "/api/implementasi",
    data: data,
    success: (res) => {
      console.log(res);
      $(this).find("button[type=submit]").attr("disabled", false);
      $(this).find("input, select").attr("readonly", false);
      $(this)[0].reset();

      if (res.result.length == 0) {
        Swal.fire({
          title: "Mohon maaf",
          text: "Tidak ditemukan penyakit yang sesuai",
          icon: "warning",
        });
        return;
      }
      Swal.fire({
        title: "Hasil Diagnosa",
        html: `
          <table class="striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Penyakit</th>
                <th>Nilai Keyakinan</th>
                <th>Nilai Kebenaran</th>
              </tr>
            </thead>
            <tbody>
              ${res.result
                .map(
                  (item, index) => `
                <tr>
                  <td>${index + 1}</td>
                  <td>${item.penyakit.name}</td>
                  <td>${item.belief.toFixed(2)}</td>
                  <td>${item.plausibility.toFixed(2)}</td>
                </tr>
              `,
                )
                .join("")}
            </tbody>
          </table>
        `,
        icon: "success",
      });
    },
  });
});

$(document).ready(function () {
  $(".preloader").slideUp();
});

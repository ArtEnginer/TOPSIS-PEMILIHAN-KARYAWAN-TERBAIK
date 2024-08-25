const table = {
  alternatif: $("#table-alternatif").DataTable({
    responsive: true,
    ajax: {
      url: origin + "/api/alternatif",
      dataSrc: "",
    },
    columns: [
      {
        title: "#",
        data: "id",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      { title: "Kode", data: "kode" },
      { title: "Nama", data: "nama" },
      { title: "NIP", data: "nip" },
      { title: "Tempat Lahir", data: "tempat_lahir" },
      { title: "Tanggal Lahir", data: "tanggal_lahir" },
      { title: "Bidang Tugas", data: "bidang_tugas" },
      {
        title: "Aksi",
        data: "id",
        render: (data, type, row) => {
          return `<div class="table-control">
          <a role="button" class="btn waves-effect waves-light btn-action btn-popup blue" data-target="edit" data-action="edit" data-id="${data}"><i class="material-icons">edit</i></a>
 <a role="button" class="btn waves-effect waves-light btn-action red" data-action="delete" data-id="${data}"><i class="material-icons">delete</i></a>
          </div>`;
        },
      },
    ],
  }),
};

$("form#form-add").on("submit", function (e) {
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
    url: origin + "/api/alternatif",
    data: data,
    cache: false,
    success: (data) => {
      $(this)[0].reset();
      cloud.pull("alternatif");
      if (data.messages) {
        $.each(data.messages, function (icon, text) {
          Toast.fire({
            icon: icon,
            title: text,
          });
        });
      }
    },
    complete: () => {
      for (let i = 0, len = elements.length; i < len; ++i) {
        elements[i].readOnly = false;
      }
    },
  });
});

$("form#form-edit").on("submit", function (e) {
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

  const button = $(this).find("button[type=submit]");
  button.attr("disabled", true);
  $.ajax({
    type: "POST",
    url: origin + "/api/alternatif/" + data.id,
    data: data,
    cache: false,
    success: (data) => {
      $(this)[0].reset();
      cloud.pull("alternatif");
      if (data.messages) {
        $.each(data.messages, function (icon, text) {
          Toast.fire({
            icon: icon,
            title: text,
          });
        });
      }
      $(this).closest(".popup").find(".btn-popup-close").trigger("click");
      button.attr("disabled", false);
    },
    complete: () => {
      for (let i = 0, len = elements.length; i < len; ++i) {
        elements[i].readOnly = false;
      }
    },
  });
});

$("body").on("click", ".btn-action", function (e) {
  e.preventDefault();
  const action = $(this).data("action");
  const id = $(this).data("id");
  switch (action) {
    case "add":
      $(".page.slider[data-page=form]").find("h1").text("Tambah Data Barang");
      break;
    case "delete":
      Swal.fire({
        title: "Apakah anda yakin ingin menghapus data ini ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "DELETE",
            url: origin + "/api/alternatif/" + id,
            cache: false,
            success: (data) => {
              table.alternatif.ajax.reload();
              if (data.messages) {
                $.each(data.messages, function (icon, text) {
                  Toast.fire({
                    icon: icon,
                    title: text,
                  });
                });
              }
            },
          });
        }
      });
      break;
    case "edit":
      let dataEdit = cloud.get("alternatif").find((x) => x.id == id);
      $("form#form-edit")[0].reset();
      $("form#form-edit").find("input[name=id]").val(dataEdit.id);
      $.each(dataEdit, function (field, val) {
        $("form#form-edit").find(`[name=${field}]`).val(val);
      });
      M.updateTextFields();
      break;
    default:
      break;
  }
});

$("body").on("click", ".btn-slider-close", function () {
  $(".upload-image img").addClass("hide");
  $("form#form-alternatif")[0].reset();
  $("form#form-alternatif").find("input[name=id]").val("");
});

$(document).ready(function () {
  cloud
    .add(origin + "/api/alternatif", {
      name: "alternatif",
      callback: (data) => {
        table.alternatif.ajax.reload();
      },
    })
    .then((alternatif) => {});
  $(".preloader").slideUp();
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
});

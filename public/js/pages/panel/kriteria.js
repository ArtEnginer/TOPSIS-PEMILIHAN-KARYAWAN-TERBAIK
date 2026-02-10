const url = `${baseURL}`;
const table = {
  kriteria: $("#table-kriteria").DataTable({
    responsive: true,
    ajax: {
      url: url + "/api/kriteria",
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
      { title: "Bobot", data: "bobot" },
      {
        title: "Subkriteria",
        data: "id",
        render: (data, type, row) => {
          return `
          <div class="table-control">
          <a role="button" class="btn waves-effect waves-light btn-action btn-popup" data-target="subkriteria" data-action="subkriteria" data-id="${data}" ><i class="material-icons">add</i></a>
          </div>
          `;
        },
      },
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
    url: url + "/api/kriteria",
    data: data,
    cache: false,
    success: (data) => {
      $(this)[0].reset();
      cloud.pull("kriteria");
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
    url: url + "/api/kriteria/" + data.id,
    data: data,
    cache: false,
    success: (data) => {
      $(this)[0].reset();
      cloud.pull("kriteria");
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

let selectedKriteriaId = null;
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
            url: url + "/api/kriteria/" + id,
            cache: false,
            success: (data) => {
              table.kriteria.ajax.reload();
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
      let dataEdit = cloud.get("kriteria").find((x) => x.id == id);
      $("form#form-edit")[0].reset();
      $("form#form-edit").find("input[name=id]").val(dataEdit.id);
      $.each(dataEdit, function (field, val) {
        $("form#form-edit").find(`[name=${field}]`).val(val);
      });
      M.updateTextFields();
      break;
    case "subkriteria":
      selectedKriteriaId = id;
      if ($.fn.DataTable.isDataTable("#table-subkriteria")) {
        $("#table-subkriteria").DataTable().destroy();
      }

      let dataSubkriteria = cloud
        .get("kriteria")
        .find((x) => x.id == id).subkriteria;

      let tableSubkriteria = $("#table-subkriteria").DataTable({
        responsive: true,
        data: dataSubkriteria,
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
          { title: "Bobot", data: "value" },
          {
            title: "Aksi",
            data: "id",
            render: (data, type, row) => {
              return `<div class="table-control">
          <a role="button" class="btn waves-effect waves-light btn-action btn-popup blue" data-target="edit-subkriteria" data-action="edit-subkriteria" data-id="${data}"><i class="material-icons">edit</i></a>
          <a role="button" class="btn waves-effect waves-light btn-action red" data-action="delete-subkriteria" data-id="${data}"><i class="material-icons">delete</i></a>
          </div>`;
            },
          },
        ],
      });

      $(".page.slider[data-page=subkriteria]").find("h1").text("Subkriteria");
      $(".page.slider[data-page=subkriteria]")
        .find("input[name=kriteria_id]")
        .val(selectedKriteriaId);

      break;
    case "edit-subkriteria":
      let dataEditSubkriteria = cloud
        .get("subkriteria")
        .find((x) => x.id == id);
      $("form#form-edit-subkriteria")[0].reset();
      $("form#form-edit-subkriteria")
        .find("input[name=id]")
        .val(dataEditSubkriteria.id);
      $.each(dataEditSubkriteria, function (field, val) {
        $("form#form-edit-subkriteria").find(`[name=${field}]`).val(val);
      });
      M.updateTextFields();
      break;
    case "delete-subkriteria":
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
            url: url + "/api/subkriteria/" + id,
            cache: false,
            success: (data) => {
              cloud.pull("kriteria");
              cloud.pull("subkriteria");
              table.kriteria.ajax.reload();

              setTimeout(() => {
                $(
                  ".btn-popup[data-action=subkriteria][data-id=" +
                    selectedKriteriaId +
                    "]",
                ).trigger("click");
              }, 1000);

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
    default:
      break;
  }
});

$("body").on("submit", "form#form-add-subkriteria", function (e) {
  e.preventDefault();
  const data = $(this)
    .serializeArray()
    .reduce((obj, item) => {
      obj[item.name] = item.value;
      return obj;
    }, {});
  if (!data.kriteria_id) {
    data.kriteria_id = selectedKriteriaId;
  }

  const dataPost = {
    kriteria_id: data.kriteria_id,
    kode: data.kode,
    nama: data.nama,
    value: data.value,
  };

  $.ajax({
    type: "POST",
    url: url + "/api/subkriteria",
    data: dataPost,
    cache: false,
    success: (data) => {
      table.kriteria.ajax.reload();
      cloud.pull("kriteria");
      cloud.pull("subkriteria");

      $(this)[0].reset();
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
});

$("body").on("submit", "form#form-edit-subkriteria", function (e) {
  e.preventDefault();
  const data = $(this)
    .serializeArray()
    .reduce((obj, item) => {
      obj[item.name] = item.value;
      return obj;
    }, {});

  const dataPost = {
    kode: data.kode,
    nama: data.nama,
    value: data.value,
  };

  $.ajax({
    type: "POST",
    url: url + "/api/subkriteria/" + data.id,
    data: dataPost,
    cache: false,
    success: (data) => {
      table.kriteria.ajax.reload();
      cloud.pull("kriteria");
      cloud.pull("subkriteria");
      $(this)[0].reset();
      if (data.messages) {
        $.each(data.messages, function (icon, text) {
          Toast.fire({
            icon: icon,
            title: text,
          });
        });
      }
      $(this).closest(".popup").find(".btn-popup-close").trigger("click");
      $(
        ".btn-popup[data-action=subkriteria][data-id=" +
          selectedKriteriaId +
          "]",
      ).trigger("click");
    },
  });
});

$("body").on("click", ".btn-slider-close", function () {
  $(".upload-image img").addClass("hide");
  $("form#form-kriteria")[0].reset();
  $("form#form-kriteria").find("input[name=id]").val("");
});

$(document).ready(function () {
  cloud
    .add(url + "/api/kriteria", {
      name: "kriteria",
      callback: (data) => {
        table.kriteria.ajax.reload();
      },
    })
    .then((kriteria) => {});

  cloud
    .add(url + "/api/subkriteria", {
      name: "subkriteria",
      callback: (data) => {},
    })
    .then((subkriteria) => {});

  $(".preloader").slideUp();
  Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
});

const table = {
  alternatif: [],
  kriteria: [],
};

function buildTable() {
  const $headerRow = $("#headerRow");
  const $dataBody = $("#dataBody");

  // Clear previous table content
  $headerRow.empty();
  $dataBody.empty();

  // Create table header
  $headerRow.append("<th>Alternatif</th>");
  table.kriteria.forEach((k) => {
    $headerRow.append("<th>" + k.kode + "</th>");
  });
  $headerRow.append("<th>Aksi</th>"); // Add header for action column

  // Create table rows
  table.alternatif.forEach((alternatif) => {
    const $row = $("<tr>");
    $row.append("<td>" + alternatif.nama + "</td>");

    table.kriteria.forEach((kriteria) => {
      const subKriteria = kriteria.subkriteria;
      const $select = $("<select>");
      $select.addClass("browser-default");
      $select.append("<option value='' disabled selected>Pilih</option>");
      subKriteria.forEach((sub) => {
        $select.append(
          "<option value='" + sub.id + "'>" + sub.nama + "</option>"
        );
      });
      $row.append($("<td>").append($select));
    });

    // Add action buttons
    const $actionCell = $("<td>");
    const $buttonNilai = $("<button>")
      .addClass("btn waves-effect waves-light buttonNilai")
      .data("alternatifId", alternatif.id)
      .append($("<i>").addClass("material-icons").text("save"));
    $actionCell.append($buttonNilai);
    $row.append($actionCell);

    $dataBody.append($row);
  });
}

$(document).ready(function () {
  $.when($.getJSON("/api/alternatif"), $.getJSON("/api/kriteria")).done(
    function (alternatifData, kriteriaData) {
      table.alternatif = alternatifData[0];
      table.kriteria = kriteriaData[0];
      buildTable();
      $(".preloader").slideUp();
      M.AutoInit();
      M.updateTextFields();
    }
  );

  $(".preloader").slideUp();

  // Handle button click to save data
  $(document).on("click", ".buttonNilai", function () {
    const alternatifId = $(this).data("alternatifId");
    const $row = $(this).closest("tr");
    const kriteriaData = table.kriteria;
    const prd = $("#periode").val();

    // Collect selected subkriteria ids
    const penilaianData = kriteriaData.map((kriteria, index) => {
      const selectedValue = $row.find(`td:eq(${index + 1}) select`).val();
      return {
        alternatif_id: alternatifId,
        kriteria_id: kriteria.id,
        subkriteria_id: selectedValue,
        periode: prd,
      };
    });

    // Validate data
    const isValid = penilaianData.every((data) => data.subkriteria_id);
    if (!isValid) {
      M.toast({ html: "Harap lengkapi data penilaian" });
      return;
    }

    // Send data to server
    $.ajax({
      url: "/api/penilaian/save",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(penilaianData),
      success: function (data) {
        console.log(data);
        M.toast({ html: "Data berhasil disimpan" });
      },
      error: function (xhr, status, error) {
        M.toast({ html: "Terjadi kesalahan saat menyimpan data" });
      },
    });
  });
});

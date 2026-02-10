const url = `${baseURL}`;
let table;

$(document).ready(function () {
  cloud
    .add(url + "/api/hasil", {
      name: "hasil",
      callback: (data) => {
        table.hasil.ajax.reload();
      },
    })
    .then((hasil) => {
      console.log(hasil);

      // Initialize DataTable
      table = $("#table-hasil").DataTable({
        data: [],
        columns: [
          { data: "alternatif.nama" },
          { data: "nilai" },
          {
            data: null,
            render: function (data, type, row, meta) {
              // Ranking will be handled separately
              return "";
            },
          },
        ],
        order: [[1, "desc"]], // Sort by 'nilai' column in descending order
        rowCallback: function (row, data, index) {
          // Update the ranking column based on the sorted order
          const rank = index + 1;
          $("td:eq(2)", row).html(rank); // Assuming the ranking column is the 3rd column
        },
      });

      $(".preloader").slideUp();
    });
});

$("#periode").on("change", function () {
  const periode = $(this).val();
  const data = cloud.get("hasil");
  const filteredData = data.filter((x) => x.periode === periode);

  // Clear and update the table with new data
  table.clear().rows.add(filteredData).draw();
});

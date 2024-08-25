$("#periode").on("change", function () {
  const periode = $(this).val();
  const dataPenilaian = cloud.get("penilaian");
  const kriteria = cloud.get("kriteria");
  const alternatif = cloud.get("alternatif");

  const filteredData = dataPenilaian.filter((x) => x.periode === periode);

  const kriteriaMap = {};
  kriteria.forEach((x) => {
    kriteriaMap[x.id] = x.kode;
  });

  const alternatifMap = {};
  alternatif.forEach((x) => {
    alternatifMap[x.id] = x.nama;
  });

  const groupedData = {};
  filteredData.forEach((item) => {
    if (!groupedData[item.alternatif_id]) {
      groupedData[item.alternatif_id] = {};
    }
    groupedData[item.alternatif_id][item.kriteria_id] = item.subkriteria.value;
  });

  let table = `
   <div class="row">
  <div class="col s12 text-center mt-3">
  <h5>Data Penilaian</h5>
  <table class="striped">
    <thead>
      <tr>
        <th>Alternatif</th>
        ${Object.values(kriteriaMap)
          .map((kode) => `<th>${kode}</th>`)
          .join("")}
      </tr>
    </thead>
    <tbody>
      ${Object.keys(groupedData)
        .map((alternatif_id) => {
          const values = kriteria.map((k) => {
            return groupedData[alternatif_id][k.id] || "";
          });

          return `
            <tr>
              <td>${alternatifMap[alternatif_id] || alternatif_id}</td>
              ${values.map((value) => `<td>${value}</td>`).join("")}
            </tr>`;
        })
        .join("")}
    </tbody>
  </table>
  </div>
  </div>

  `;

  $("#result").html(table);

  // Calculate average per criterion
  const averages = {};
  kriteria.forEach((k) => {
    // Sum of squares for each subcriteria value
    const sumOfSquares = filteredData
      .filter((item) => item.kriteria_id === k.id)
      .reduce((acc, curr) => acc + Math.pow(curr.subkriteria.value, 2), 0);

    // Calculate the square root of the sum of squares
    averages[k.id] = Math.sqrt(sumOfSquares);
  });

  // Create normalization table
  let normalizationTable = ` <div class="row">
  <div class="col s12 text-center">
  <h5>Normalisasi</h5>
  <table class="striped">
    <thead>
      <tr>
        <th>Alternatif</th>
        ${Object.values(kriteriaMap)
          .map((kode) => `<th>${kode}</th>`)
          .join("")}
      </tr>
    </thead>
    <tbody>
      ${Object.keys(groupedData)
        .map((alternatif_id) => {
          const values = kriteria.map((k) => {
            const value = groupedData[alternatif_id][k.id] || 0;
            const average = averages[k.id] || 1;
            return (value / average).toFixed(2);
          });

          return `
            <tr>
              <td>${alternatifMap[alternatif_id] || alternatif_id}</td>
              ${values.map((value) => `<td>${value}</td>`).join("")}
            </tr>`;
        })
        .join("")}
    </tbody>
  </table>
  </div>
  </div>
  `;

  $("#normalisasi").html(normalizationTable);

  // calculate matrix Y dimana masing masng nilai di kali dengan bobot kriria
  const bobot = kriteria.map((k) => k.bobot);
  const matrixY = Object.keys(groupedData).map((alternatif_id) => {
    const values = kriteria.map((k) => {
      const value = groupedData[alternatif_id][k.id] || 0;
      const average = averages[k.id] || 1;
      return (value / average).toFixed(2);
    });

    return values.map((value, index) => value * bobot[index]);
  });

  // Create matrix Y table
  let matrixYTable = `
   <div class="row">
  <div class="col s12 text-center">
  <h5>Matrix Y</h5>
  <table class="striped">
    <thead>
      <tr>
        <th>Alternatif</th>
        ${Object.values(kriteriaMap)
          .map((kode) => `<th>${kode}</th>`)
          .join("")}
      </tr>
    </thead>
    <tbody>
      ${Object.keys(groupedData)
        .map((alternatif_id, index) => {
          const values = matrixY[index];

          return `
            <tr>
              <td>${alternatifMap[alternatif_id] || alternatif_id}</td>
              ${values.map((value) => `<td>${value.toFixed(2)}</td>`).join("")}
            </tr>`;
        })
        .join("")}
    </tbody>
  </table>
  </div>
  </div>
  
  `;

  $("#matrixY").html(matrixYTable);

  // Calculate Solusi Ideal Positif (A+) and Negatif (A-)
  const solusiIdealPositif = [];
  const solusiIdealNegatif = [];

  kriteria.forEach((k, index) => {
    const values = matrixY.map((row) => row[index]);

    solusiIdealPositif[index] = Math.max(...values);
    solusiIdealNegatif[index] = Math.min(...values);
  });

  // Create table for Solusi Ideal Positif (A+) and Negatif (A-)
  let solusiTable = ` <div class="row">
  <div class="col s12 text-center">
  <h5>Solusi Ideal</h5>
  <table class="striped">
  <thead>
    <tr>
      <th>Solusi</th>
      ${Object.values(kriteriaMap)
        .map((kode) => `<th>${kode}</th>`)
        .join("")}
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Ideal Positif (A+)</td>
      ${solusiIdealPositif
        .map((value) => `<td>${value.toFixed(2)}</td>`)
        .join("")}
    </tr>
    <tr>
      <td>Ideal Negatif (A-)</td>
      ${solusiIdealNegatif
        .map((value) => `<td>${value.toFixed(2)}</td>`)
        .join("")}
    </tr>
  </tbody>
</table>
</div>
</div>
`;

  $("#solusiIdeal").html(solusiTable);

  // Calculate Jarak Solusi Ideal Positif (D+) and Negatif (D-)
  const jarakPositif = [];
  const jarakNegatif = [];

  matrixY.forEach((row, index) => {
    let sumPositif = 0;
    let sumNegatif = 0;

    row.forEach((value, kIndex) => {
      sumPositif += Math.pow(value - solusiIdealPositif[kIndex], 2);
      sumNegatif += Math.pow(value - solusiIdealNegatif[kIndex], 2);
    });

    jarakPositif[index] = Math.sqrt(sumPositif);
    jarakNegatif[index] = Math.sqrt(sumNegatif);
  });

  // Create table for Jarak Solusi Ideal Positif (D+) and Negatif (D-)
  let jarakTable = ` <div class="row">
  <div class="col s12 text-center">
<h5>Jarak Solusi Ideal</h5>
  <table class="striped">
  <thead>
    <tr>
      <th>Alternatif</th>
      <th>Jarak D+ (Positif)</th>
      <th>Jarak D- (Negatif)</th>
    </tr>
  </thead>
  <tbody>
    ${Object.keys(groupedData)
      .map((alternatif_id, index) => {
        return `
          <tr>
            <td>${alternatifMap[alternatif_id] || alternatif_id}</td>
            <td>${jarakPositif[index].toFixed(2)}</td>
            <td>${jarakNegatif[index].toFixed(2)}</td>
          </tr>`;
      })
      .join("")}
  </tbody>
</table>
</div>
</div>

`;

  $("#jarakSolusi").html(jarakTable);

  // Calculate Kedekatan Terhadap Solusi Ideal (V)
  const kedekatanRelatif = jarakNegatif.map((dNegatif, index) => {
    const dPositif = jarakPositif[index];
    return dPositif / (dNegatif + dPositif);
  });

  // Create table for Kedekatan Relatif (V)
  let kedekatanTable = ` <div class="row">
  <div class="col s12 text-center">
<h5>Kedekatan Relatif</h5>
  <table class="striped">
  <thead>
    <tr>
      <th>Alternatif</th>
      <th>Kedekatan Relatif (V)</th>
    </tr>
  </thead>
  <tbody>
    ${Object.keys(groupedData)
      .map((alternatif_id, index) => {
        return `
          <tr>
            <td>${alternatifMap[alternatif_id] || alternatif_id}</td>
            <td>${kedekatanRelatif[index].toFixed(4)}</td>
          </tr>`;
      })
      .join("")}
  </tbody>
</table>
</div>
</div>
`;

  $("#kedekatanSolusi").html(kedekatanTable);

  // save data to database
  // alternatif_id, periode, kedekatan_relatif
  const dataToSave = Object.keys(groupedData).map((alternatif_id, index) => ({
    alternatif_id,
    nilai: kedekatanRelatif[index],
    periode,
  }));

  const data = {
    periode: $("#periode").val(),
    nilai: kedekatanRelatif,
    alternatif_id: Object.keys(groupedData),
  };

  $.ajax({
    url: `${origin}/api/hasil/save`,
    method: "POST",
    cache: false,
    contentType: "application/json",
    data: JSON.stringify(dataToSave),
    success: (response) => {
      M.toast({
        html: "Data berhasil disimpan",
        classes: "green",
      });
    },
    error: (xhr, status, error) => {
      M.Toast({
        html: "Data gagal disimpan",
        classes: "red",
      });
    },
  });

  // Calculate Rank
  const rank = kedekatanRelatif
    .map((v, index) => {
      return {
        alternatif:
          alternatifMap[Object.keys(groupedData)[index]] ||
          Object.keys(groupedData)[index],
        v,
      };
    })
    .sort((a, b) => b.v - a.v);

  // Create table for Rank
  let rankTable = `
  <div class="row">
  <div class="col s12 text-center">

<h5>Ranking</h5>
  <table class="striped">
  <thead>
    <tr>
      <th>Rank</th>
      <th>Alternatif</th>
      <th>Kedekatan Relatif (V)</th>
    </tr>
  </thead>
  <tbody>
    ${rank
      .map((data, index) => {
        return `
          <tr>
            <td>${index + 1}</td>
            <td>${data.alternatif}</td>
            <td>${data.v.toFixed(4)}</td>
          </tr>`;
      })
      .join("")}
  </tbody>
</table>
  </div>
  </div>
`;
  $("#rank").html(rankTable);
});

$(document).ready(function () {
  cloud.add(origin + "/api/penilaian", {
    name: "penilaian",
    callback: (data) => {
      table.penilaian.ajax.reload();
    },
  });

  cloud.add(origin + "/api/kriteria", {
    name: "kriteria",
    callback: (data) => {
      table.kriteria.ajax.reload();
    },
  });

  cloud.add(origin + "/api/alternatif", {
    name: "alternatif",
    callback: (data) => {
      table.alternatif.ajax.reload();
    },
  });

  $(".preloader").slideUp();
});

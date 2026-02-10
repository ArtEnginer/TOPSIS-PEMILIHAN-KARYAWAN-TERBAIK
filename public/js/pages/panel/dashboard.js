const url = `${baseURL}`;
const elalternatif = $("[data-entity=alternatif]");
const elkriteria = $("[data-entity=kriteria]");

$(document).ready(function () {
  cloud
    .add(url + "/api/alternatif", {
      name: "alternatif",
      callback: (data) => {
        elalternatif.text(service.length).counterUp();
      },
    })
    .then((service) => {
      elalternatif.text(service.length).counterUp();
    });
  cloud
    .add(url + "/api/kriteria", {
      name: "kriteria",
      callback: (data) => {
        elkriteria.text(customer.length).counterUp();
      },
    })
    .then((customer) => {
      elkriteria.text(customer.length).counterUp();
    });
});

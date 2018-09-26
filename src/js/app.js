class Api {
  constructor(url) {
    this.url = url;
    this.init();
  }

  init() {
    if (document.querySelector("#form")) {
      this.form = document.querySelector("#form");
      this.token = document.querySelector("input[name=token]").value;
    }
  }

  // get unmarshalled response
  get(path) {
    return fetch(this.url + path).then(response => response.json());
  }

  // post to path, assumes #form
  post(path) {
    let data = this.serializeForm();

    return fetch(this.url + path, {
      method: "POST", // *GET, POST, PUT, DELETE, etc.
      mode: "cors", // no-cors, cors, *same-origin
      cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, same-origin, *omit
      headers: {
        "Content-Type": "application/json; charset=utf-8"
        // "Content-Type": "application/x-www-form-urlencoded",
      },
      redirect: "follow", // manual, *follow, error
      referrer: "no-referrer", // no-referrer, *client
      body: JSON.stringify(data) // body data type must match "Content-Type" header
    }).then(response => response.json());
  }

  // convert formdata to object
  serializeForm() {
    let inputs = this.form.elements;
    let values = {};

    for (let i = 0; i < inputs.length; i++) {
      if (inputs[i].name) {
        // handle checkboxes
        if (inputs[i].type === "checkbox") {
          values[inputs[i].name] = inputs[i].checked ? true : false;
        } else {
          values[inputs[i].name] = inputs[i].value;
        }
      }
    }

    return values;
  }

  clearForm() {
    let inputs = this.form.elements;

    for (let i = 0; i < inputs.length; i++) {
      if (inputs[i].name) {
        inputs[i].value = "";
      }
    }
  }
}

let api = new Api("http://localhost:8080");

if (api.form) {
  api.form.addEventListener("submit", e => {
    e.preventDefault();
    api
      .post("/api/create")
      .then(response => {
        api.clearForm();
        if (response.code === 200) {
          window.location = "/thank-you";
        } else {
          console.log("something went wrong");
        }
      })
      .catch(error => console.error("Error:", error));
  });
}

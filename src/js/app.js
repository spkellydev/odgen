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

  get(path) {
    return fetch(this.url + path).then(response => response.json());
  }

  post(path) {
    let data = {
      fname: "Sean",
      lname: "Kellr",
      age: "26",
      smoker: true,
      email: "spkelld@gmail.com",
      token: this.token
    };

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
}

let api = new Api("http://localhost:8080");
api.form.addEventListener("submit", e => {
  e.preventDefault();
  api
    .post("/api/create")
    .then(response => console.log("Success:", JSON.stringify(response)))
    .catch(error => console.error("Error:", error));
});

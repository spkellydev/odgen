import React, { Fragment } from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route } from "react-router-dom";
import App from "./App";
import NavbarPrimary from "./components/Navbar";
import Welcome from "./pages/Welcome/";
import registerServiceWorker from "./registerServiceWorker";

ReactDOM.render(
  <BrowserRouter>
    <Fragment>
      <NavbarPrimary />
      <App>
        <Route path="/" exact={true} component={Welcome} />
        <Route path="/about" component={Welcome} />
        <Route path="/insurance/individual" component={Welcome} />
        <Route path="/insurance/group" component={Welcome} />
        <Route path="/insurance/travel" component={Welcome} />
        <Route path="/contact" component={Welcome} />
      </App>
    </Fragment>
  </BrowserRouter>,
  document.getElementById("root")
);
registerServiceWorker();

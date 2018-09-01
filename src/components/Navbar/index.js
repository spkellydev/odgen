import React, { Component, Fragment } from "react";
import { Nav, Navbar, NavItem, Glyphicon } from "react-bootstrap/lib";
import "./NavbarPrimary.css";

export default class NavbarPrimary extends Component {
  renderLinks = (
    <Fragment>
      <NavItem eventKey={"home"} href="/">
        Home
      </NavItem>
      <NavItem eventKey={"about"} href="/about">
        About Us
      </NavItem>
      <NavItem eventKey={"individual"} href="/insurance/individual">
        Individual Services
      </NavItem>
      <NavItem eventKey={"group"} href="/insurance/group">
        Group Services
      </NavItem>
      <NavItem eventKey={"travel"} href="/insurance/travel">
        Travel Insurance
      </NavItem>
      <NavItem eventKey={"contact"} href="/contact">
        Contact
      </NavItem>
    </Fragment>
  );

  render() {
    return (
      <Fragment>
        <Navbar fluid style={{ marginBottom: 0 }}>
          <Navbar.Header>
            <Navbar.Brand>
              <a href="/">Ogden Co.</a>
            </Navbar.Brand>
          </Navbar.Header>
          <Nav pullRight>
            <NavItem eventKey={1} href="#">
              <Glyphicon glyph="earphone" /> Call Us
              <br />
              732-842-7903
            </NavItem>
            <NavItem eventKey={2} href="#">
              <Glyphicon glyph="time" />
              Hours of Operation <br />
              Mon - Fri 6am - 7pm
            </NavItem>
          </Nav>
        </Navbar>
        <Navbar className="navbar-secondary" fluid collapseOnSelect={true}>
          <Navbar.Header>
            <Navbar.Toggle />
          </Navbar.Header>
          <Navbar.Collapse>
            <Nav>{this.renderLinks}</Nav>
          </Navbar.Collapse>
        </Navbar>
      </Fragment>
    );
  }
}

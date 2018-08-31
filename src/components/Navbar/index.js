import React, { Component, Fragment } from "react";
import { Nav, Navbar, NavItem } from "react-bootstrap/lib";

export default class NavbarPrimary extends Component {
  renderLinks() {
    return (
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
  }

  render() {
    return (
      <Navbar collapseOnSelect={true}>
        <Navbar.Header>
          <Navbar.Brand>
            <a href="/">Ogden Insurance & Co.</a>
          </Navbar.Brand>
          <Navbar.Toggle />
        </Navbar.Header>
        <Navbar.Collapse>
          <Nav>{this.renderLinks()}</Nav>
        </Navbar.Collapse>
      </Navbar>
    );
  }
}

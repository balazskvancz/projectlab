import { Fragment } from "react";

export const ClientNavbar = () => {
  return(
    <Fragment>
      <li className="nav-item active">
        <a className="nav-link" href="/">Főoldal</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/newproduct">Új termék </a>
      </li>

      <li className="nav-item ">
        <a className="nav-link" href="/products">Termékek</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/logout">Kijelentkezés</a>
      </li>
    </Fragment>
  )
}
import { Fragment } from "react"

export const AdminNavbar = () => {
  return (
    <Fragment>
      <li className="nav-item active">
        <a className="nav-link" href="/">Főoldal</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/users">Felhasználók</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/categories">Kategóriák</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/products">Termékek</a>
      </li>
      <li className="nav-item ">
        <a className="nav-link" href="/logs">Napló</a>
      </li>
    </Fragment>
  )
}
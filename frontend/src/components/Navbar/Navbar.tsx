import * as React from 'react'

import './Navbar.css'

export default class Navbar extends React.Component<{}> {
  render() {
    return (
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark sticky-top p-3 shadow">
        <div className="container-fluid">
          <a className="navbar-brand" href="javascript:void(0)">Önállólabor</a>
                
          <div className="collapse navbar-collapse">
            <ul className="navbar-nav ms-auto">
              <li className="nav-item active">
                  <a className="nav-link" href="/">Főoldal <span className="sr-only">(current)</span></a>
              </li>
              <li className="nav-item ">
                  <a className="nav-link" href="/users">Felhasználók</a>
              </li>
              <li className="nav-item ">
                  <a className="nav-link" href="/products">Termékek</a>
              </li>
              <li className="nav-item ">
                  <a className="nav-link" href="/logs">Napló</a>
              </li>

              <li className="nav-item ">
                  <a className="nav-link" href="/logout">Kijelentkezés</a>
              </li>
            </ul>
          </div> 
        </div>
      </nav>
    )
  }
}
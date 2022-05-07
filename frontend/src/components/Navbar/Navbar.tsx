import * as React from 'react'

import { AdminNavbar } from './AdminNavbar'
import { ClientNavbar } from './ClientNavbar'

import './Navbar.css'

import type { UserObject } from '../../definitions'
import { getUser, logout } from '../../common/authentication'

interface IProps {}
interface IState {
  user: UserObject
}

export default class Navbar extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { user: getUser()!} 
  }

  render() {
    return (
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark sticky-top p-3 shadow">
        <div className="container-fluid">
          <a className="navbar-brand" href="javascript:void(0)">Önállólabor</a>
                
          <div className="collapse navbar-collapse">
            <ul className="navbar-nav ms-auto">
              {
                this.state.user.role === 2 ?
                  <AdminNavbar />
                :
                  <ClientNavbar /> 
              } 
              <li className="nav-item ">
                <a className="nav-link" onClick={ this.onClickLogout }>Kijelentkezés</a>
              </li>
            </ul>
          </div> 
        </div>
      </nav>
    )
  }

  /**
   * Kijelentkezés gomb eseménykezélője.
   */
  private onClickLogout = () => {
    logout()

    window.location.href = '/'
  } 
}

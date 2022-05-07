import * as React from 'react'

import { AdminNavbar } from './AdminNavbar'
import { ClientNavbar } from './ClientNavbar'

import './Navbar.css'

import type { UserObject } from '../../definitions'
import { getUser } from '../../common/authentication'
interface IState {
  user: UserObject
}

export default class Navbar extends React.Component<{}, IState> {
  constructor() {
    super({})

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
            </ul>
          </div> 
        </div>
      </nav>
    )
  }
}

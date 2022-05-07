import * as React from 'react'
import { BrowserRouter, Routes, Route } from "react-router-dom"

import { getUser } from '../../common/authentication'

import Navbar    from '../Navbar/Navbar'
import Dashboard from '../Dashboard/Dashboard'
import Logs      from '../Logs/Logs'
import Products  from '../Products/Products'
import User      from '../User/User'

import type { UserObject } from '../../definitions'

interface IState {
  user: UserObject | null
}

export default class Page extends React.Component<{}, IState> {

  constructor() {
    super({})

    this.state = { user: getUser() }
  }

  /**
   * 
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <React.Fragment>
        <Navbar />
        <div className='container-fluid'>
          <BrowserRouter>
            <Routes>
              <Route path='/' element={<Dashboard/>} />
              <Route path='/users' element={<User apikey={this.state.user!.apikey} />} />
              <Route path='/products' element={<Products />} />
              <Route path='/logs' element={<Logs user={this.state.user!} />} />
            </Routes>
          </BrowserRouter>
        </div>
      </React.Fragment>
      )
  }
}
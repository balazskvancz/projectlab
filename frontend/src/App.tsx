import * as React from 'react'
import './App.css'

import { getUser } from './common/authentication'

import Login from './components/Login/Login'
import Page from './components/Page/Page'

interface IState {
  isLoggedIn: boolean
}

export default class App extends React.Component<{}, IState> {
  constructor() {
    super({})
    const user = getUser()

    this.state = {isLoggedIn: user ? true : false}
  }

  render() {
    return (
      <React.Fragment>
        {
          this.state.isLoggedIn ? 
            <Page />
          :
            <Login />
        }
      </React.Fragment>
    )
  }
  

  
}



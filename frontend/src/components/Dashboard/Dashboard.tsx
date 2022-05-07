import * as React from 'react'

import { getUser } from '../../common/authentication'

import type { UserObject } from '../../definitions'

import AdminDashboard from './AdminDashboard'

interface IState {
  user: UserObject
}

export default class Dashboard extends React.Component<{}, IState> {

  constructor() {
    super({})

    const user = getUser()

    if (!user) {
      return
    }



    this.state = { user }
  }

  render() {
    return (
      <div className='container-fluid' id='dashboard'>
        <div className='container mx-auto mt-5'>
          <AdminDashboard apikey={this.state.user.apikey} />
        </div>
      </div>
    )
  }
}
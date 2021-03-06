import * as React from 'react'

import { getUser } from '../../common/authentication'

import type { UserObject } from '../../definitions'

import AdminDashboard  from './AdminDashboard'
import ClientDashboard from './ClientDashboard'

interface IState {
  user: UserObject
}

export default class Dashboard extends React.Component<{}, IState> {

  constructor(props: any) {
    super(props)

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
          {
            this.state.user.role === 2 ?
              <AdminDashboard user={this.state.user} />
            :
              <ClientDashboard user={this.state.user} />
          }
        </div>
      </div>
    )
  }
}

import * as React from 'react'

import { getUser } from '../../common/authentication'

import type { UserObject } from '../../definitions'

import AdminProducts from './AdminProducts'
import ClientProducts from './ClientProducts'

interface IProps {}
interface IState {
  user: UserObject
}

export default class Products extends React.Component<IProps, IState> {

  constructor(props: IProps) {
    super(props)

    this.state = { user: getUser()! }
  }

  /**
   * @returns {React.ReactNode}
   */
  render(): React.ReactNode {
    return (
      <div className='container-fluid'>
        <div className='container mx-auto mt-5'>
        {
          this.state.user.role === 2 ? 
            <AdminProducts user={ this.state.user } />
          :
            <ClientProducts user={ this.state.user }  />
        }
        </div>
      </div>
    )

  }

}
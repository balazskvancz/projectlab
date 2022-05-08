import * as React from 'react'

import { EAdminRoute } from '../../definitions'
import type { IUser  } from '../../definitions'

import { request } from '../../common/request'



interface IProps {
  readonly apikey: string
}

interface IState {
  users: IUser[]
}

export default class User extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = {users: []}
  }

  /**
   * 
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return(
      <div className='container mx-auto mt-5'>
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">Felhasználók</h2>
          </div>

          <div className="card-body">
            <div className="table-responsive">
              <table className='table table-striped table-hover table-bordered'>
                <thead>
                  <tr>
                    <th className="text-center w-50">Név</th>
                    <th className="text-center w-50">Szint</th>
                  </tr>
                </thead>
                <tbody>
                  {
                    this.state.users.map((user) => {
                      return (
                        <tr>
                          <td className="text-center">{ user.username }</td>
                          <td className="text-center">{ user.role }</td>
                        </tr>
                      )
                    })
                  }
                </tbody>
              </table>
            </div> 
          </div>
        </div>
      </div>
    )
  }

  /**
   * Amikor már bekerült a DOM-ba az elem, akkor intézzük a requestet.
   */
  async componentDidMount(): Promise<void> {
    const url = `${ EAdminRoute.Users }?apikey=${ this.props.apikey}`

    const users = await request(url) as IUser[]

    this.setState({ users }) 
  } 
}

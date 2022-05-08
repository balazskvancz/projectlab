import * as React from 'react'

import type { IAdminDashboardData, ILogins, UserObject } from '../../definitions'

import { EAdminRoute } from '../../definitions'

import { request } from '../../common/request'

interface IProps {
  readonly user: UserObject
}

interface IState {
  productsCount: number
  usersCount: number
  logins: ILogins[] 
}

/**
 * Az admin számára megjeleníti a dashboard-ot.
 */
export default class AdminDashboard extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = {productsCount:0, usersCount:0, logins:[]}
  }

  /**
   * 
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return ( 
      <div className='card'>
        <div className='card-header'>
          <h2 className='p-2 text-center'>Áttekintés</h2>
        </div>

        <div className="card-body">
          <div className="row">
            <div className="col-sm-12 col-md-4 mx-auto">
              <div className="card">
                <div className="card-header">
                  <h3 className="p-2 text-center">Userek száma</h3>
                </div>
                <div className="card-body text-center">
                  <h5 className='fw-bold'>{this.state.usersCount } db</h5>
                </div>
              </div>
            </div>

            <div className="col-sm-12 col-md-4 mx-auto">
              <div className="card">
                <div className="card-header">
                  <h3 className="p-2 text-center">Felvett termékek száma</h3>
                </div>
                <div className="card-body text-center">
                  <h5 className='fw-bold'>{this.state.productsCount} db</h5>
                </div>
              </div>
            </div>
          </div>

          <div className="table-responsive mt-4">
            <table className="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th className="text-center w-50">User</th>
                  <th className="text-center w-50">Dátum</th>
                </tr>
              </thead>

              <tbody>
                {
                  this.state.logins.map((log) => {
                    return (
                      <tr>
                        <td className="text-center">{ log.username }</td>
                        <td className="text-center">{ log.created_at }</td>
                      </tr>
                    )
                  })
                }
              </tbody>
            </table>
          </div>
        </div>
      </div>
    )
  }

  /**
   * Amikor bekerül az element a DOM-ba, elküldjük a requestet.
   */
  async componentDidMount() {
    const path = `${EAdminRoute.Dashboard}?apikey=${ this.props.user.apikey }` 
    const response = await request(path) as IAdminDashboardData

    this.setState({productsCount: response.productsCount})
    this.setState({usersCount: response.usersCount})
    this.setState({logins: response.logins})
  }
}
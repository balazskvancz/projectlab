import * as React from 'react'

import { request} from '../../common/request'

import type { IClientDashboardData, UserObject } from '../../definitions'

import { EClientRoute } from '../../definitions'

interface IProps {
  user: UserObject
}

interface IState {
  productsCount: number
  lastLogin: string
}

export default class ClientDasboard extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { productsCount: 0, lastLogin: ''}
  }

  /**
   * 
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className='card'>
        <div className="card-header">
          <h2 className="p-2 text-center">Áttekintés</h2>
        </div>

        <div className="card-body">
          <div className="row">
            <div className="col-sm-12 col-md-6 mx-auto mt-3 ">
              <div className="card">
                <div className="card-header">
                  <h3 className='text-center'>Felvett termékek száma:</h3>
                </div> 
                <div className="card-body">
                  <h3 className="fw-bold text-center">{this.state.productsCount} db</h3>
                </div>
              </div>
            </div> 

            <div className="col-sm-12 col-md-6 mx-auto mt-3 ">
              <div className="card">
                <div className="card-header">
                  <h3 className='text-center'>Utolsó bejelentkezés:</h3>
                </div> 
                <div className="card-body">
                  <h3 className="fw-bold text-center">{ this.state.lastLogin } </h3>
                </div>
              </div>
            </div> 
          </div>

          <div className="col-sm-12">
            <hr className="my-3" />
          </div>

          <div className="row mt-3">
            <div className="row">
              <div className="col-sm-12 col-md-6 col-lg-4 mx-auto text-center">
                <a href='/newproduct'><button className='btn btn-success'>
                  Új termék felvétele
                </button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  }

  /**
   * Amikor bekerül a DOM-ba az elem, lekérjük az adatokat.
   */
  async componentDidMount(): Promise<void> {
    const url = `${ EClientRoute.Dashboard }`

    const data = await request(url) as IClientDashboardData

    this.setState({ productsCount: data.productsCount })
    this.setState({ lastLogin: data.lastLogin})
  }
}

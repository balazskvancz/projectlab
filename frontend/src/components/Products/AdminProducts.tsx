import * as React from 'react'

import type { IAdminProductsResponse, IProduct, UserObject } from '../../definitions'

import { EAdminRoute } from '../../definitions'

import { request } from '../../common/request'

interface IProps {
  user: UserObject
}

interface IState {
  products: IProduct[]
}

export default class AdminProducts extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { products: [] }
  }

  /**
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className='card'>
        <div className="card-header">
          <h2 className="p-2 text-center">Termékek</h2> 
        </div>

        <div className="card-body">
          <div className="table-responsive">
            <table className="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th className="text-center">Név</th>
                  <th className="text-center">Kategória</th>
                  <th className="text-center">Felhasználó</th>
                  <th className="text-center"></th>
                </tr>
              </thead>

              <tbody>
                {
                  this.state.products.map((product) => {
                    return (
                      <tr>
                        <td className="text-center">{ product.name }</td>
                        <td className="text-center">{ product.categoryName }</td>
                        <td className="text-center">{ product.username } </td>
                        <td className="text-center">
                          <button className='btn btn-primary'>
                            Részletek
                          </button>
                        </td>
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

  async componentDidMount(): Promise<void> {
    const url = `${ EAdminRoute.Products }?apikey=${ this.props.user.apikey}`

    const response = await request(url) as IAdminProductsResponse

    this.setState({ products: response.products})
  }
}

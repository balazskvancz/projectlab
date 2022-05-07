import * as React from 'react'

import type { IProduct, UserObject } from '../../definitions'

import { EClientRoute } from '../../definitions'

import { get } from '../../common/request'

interface IProps {
  user: UserObject
}

interface IState {
  products: IProduct[]
}

export default class ClientProducts extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { products: [] }
  }

  /**
   * @returns {React.ReactNode}
   */
  render(): React.ReactNode{
    return (
      <div className='card'>
        <div className="card-header">
          <h2 className="p-2 text-center">Termékek áttekintése</h2>
        </div>

        <div className="card-body">
          <div className="table-responsive">
            <table className="table table-striped table-hover">
              <thead>
                <tr>
                  <th className="text-center">Kategória</th>
                  <th className="text-center">Név</th>
                  <th className="text-center"></th>
                  <th className="text-center"></th>
                </tr>
              </thead>

              <tbody>
                {
                  this.state.products.map((product) => {
                    return (
                      <tr>
                        <td className="text-center">{ product.categoryName } </td>
                        <td className="text-center">{ product.name }</td>
                        <td className="text-center">
                          <button className='btn btn-primary'>Megnyitás</button>
                        </td>
                        <td className="text-center">
                          <button className='btn btn-danger'>Törlés</button>
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

  /**
   * Amikor a komponens a DOM-ba kerül, akkor lekérjük az adatokat.
   */
  async componentDidMount(): Promise<void> {
    const url = `${ EClientRoute.Products }?userid=${ this.props.user.userid }&apikey=${ this.props.user.apikey }`

    const products = await get(url) as IProduct[]

    this.setState({ products })    
  }
}
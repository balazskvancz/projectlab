import * as React from 'react'

import type { ICategory, UserObject } from '../../definitions'
import { ECommonRoute } from '../../definitions'

import { request} from '../../common/request'

interface IProps {
  user: UserObject
}

interface IState {
  categories: ICategory[]
}
export default class Category extends React.Component<IProps, IState>{

  constructor(props: IProps) {
    super(props)

    this.state = { categories: [] }
  }


  /**
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className="container mx-auto mt-5">
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">Kategóriák kezelése</h2>
          </div>

          <div className="card-body">
            <div className="table-responsive">
              <table className="table table striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th className="text-center">Név</th>
                    <th className="text-center"></th>
                    <th className="text-center"></th>
                  </tr>
                </thead>

                <tbody>
                  { 
                    this.state.categories.map((category) => {
                      return (
                        <tr>
                          <td className="text-center">
                            { category.name }
                          </td>
                          <td className="text-center">
                            <button className="btn btn-primary">Módosítás</button>
                          </td>
                          <td className="text-center">
                            <button className="btn btn-danger">Törlés</button>
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
      </div>
    )
  }

  /**
   *  DOM-ba kerülés után adatok fetchelése.
   */
  async componentDidMount(): Promise<void> {
    const url = `${ ECommonRoute.Categories}?apikey=${ this.props.user.apikey }`

    const categories = await request(url) as ICategory[]

    this.setState({ categories })
  }

}
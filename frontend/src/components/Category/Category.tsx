import * as React from 'react'

import { EAdminRoute, ICategory, UserObject } from '../../definitions'
import { ECommonRoute } from '../../definitions'

import { request} from '../../common/request'

import NewCategory from './NewCategory'

interface IProps {
  user: UserObject
}

interface IState {
  categories: ICategory[]
  newCategory: boolean 
}
export default class Category extends React.Component<IProps, IState>{
  constructor(props: IProps) {
    super(props)

    this.state = { categories: [], newCategory: false }
  }

  /**
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className="container mx-auto mt-5">
        {
          this.state.newCategory ? 
            <NewCategory />
          :
            ''
        }

        <div className="card">
          <div className="card-header text-center">
            <h2 className="p-2 text-center">Kategóriák kezelése</h2>

            <button className='btn btn-secondary mx-auto' onClick={() => { this.setState({newCategory: true}) }}>Új hozzáadás</button>
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
                            <button className="btn btn-danger" onClick={() => this.onClickDelete(category.id)}>Törlés</button>
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
    this.fetchData()
  }

  /**
   * Kategóriák lekérdezése API végpontról & state-be mentés.
   */
  private fetchData = async (): Promise<void> => {
    const categories = await request(ECommonRoute.Categories) as ICategory[]

    this.setState({ categories })
  }

  /**
   * Egy adott kategória törlés gombjának eseménykezelője.
   * @param {number} categoryId A törölni kívánt kategória azonosítója.
   */
  private onClickDelete = async (categoryId: number): Promise<void> => {
    const url = `${ EAdminRoute.Categories}/${ categoryId }/delete`
    const response = await request(url, 'POST') 

    console.log(response)
    this.fetchData()
  }
}

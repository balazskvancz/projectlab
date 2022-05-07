import * as React from 'react'

import type { ICategory, UserObject } from '../../definitions'

import { get } from '../../common/request'

import { EClientRoute, ECommonRoute} from '../../definitions'


interface IProps {
  user: UserObject
}

interface IState {
  categories: ICategory[]
}

export default class NewProduct extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { categories: [] }
  }

  /**
   * @returns {React.ReactNode}
   */
  render(): React.ReactNode {
    return (
      <div className="container mx-auto mt-5">
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">Új termék felvétele</h2>
          </div>

          <div className="card-body">
            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Termék megnevezése</label>
              <input type='text' className='form-control' name='product_name' />
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Kategória</label>
              <select className='form-select' name='product_category'>
                {
                  this.state.categories.map((category) => {
                    return (
                      <option value={category.id} key={category.id}>{ category.name }</option> 
                    )
                  })
                }
              </select>
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Ár</label>
              <input type='text' className='form-control' name='product_price' />
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Leírás</label>
              <textarea className='form-control' rows={ 6 } name='product_description'></textarea>
            </div> 
            
          </div>

          <div className="card-footer">
            <div className="col-sm-12 text-center p-3">
              <button className='btn btn-primary btn-lg'>Mentés</button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  /**
   * 
   */
  async componentDidMount(): Promise<void> {
    const url = ECommonRoute.Categories 

    const categories = await get(url)  as ICategory[]

    this.setState({ categories })
  }
}
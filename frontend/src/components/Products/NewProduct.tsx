import * as React from 'react'

import type { ICategory, UserObject } from '../../definitions'

import { request } from '../../common/request'

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
              <input type='text' className='form-control' name='name' />
              <span className='text-danger' id='err_name' />
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Kategória</label>
              <select className='form-select' name='categoryId'>
                {
                  this.state.categories.map((category) => {
                    return (
                      <option value={category.id} key={category.id}>{ category.name }</option> 
                    )
                  })
                }
              </select>
              <span className='text-danger' id='err_categoryId' />
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Ár</label>
              <input type='text' className='form-control' name='product_price' />
            </div> 

            <div className="col-sm-12 col-md-6 col-lg-4 mx-auto form-group mt-4">
              <label className='fw-bold'>Leírás</label>
              <textarea className='form-control' rows={ 6 } name='description'></textarea>
            </div> 
            
          </div>

          <div className="card-footer">
            <div className="col-sm-12 text-center p-3">
              <button className='btn btn-primary btn-lg' onClick={this.onClickSave}>Mentés</button>
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

    const categories = await request(url)  as ICategory[]

    this.setState({ categories })
  }

  /**
   * Mentés gomb eseménykezelője.
   */
  private onClickSave = async (): Promise<void> => {
    const nameInput           = document.querySelector('[name="name"]') as HTMLInputElement
    const categoryInput       = document.querySelector('[name="categoryId"]') as HTMLSelectElement 
    const priceInput          = document.querySelector('[name="product_price]') as HTMLInputElement
    const descriptionInput    = document.querySelector('[name="description"]') as HTMLTextAreaElement

    const name        = nameInput.value
    const categoryId  = parseInt(categoryInput.value)
    // const price       = priceInput.value
    const description = descriptionInput.value

   
    const data = { name, categoryId }

    const response = await request(EClientRoute.Products, 'POST', data )

    // Ekkora tudjuk, hogy minden jól ment.
    if (response === '') {
      window.location.href = '/products'
    }

    if (typeof response.errors === 'undefined') {
      return
    }

    const badFields = Object.keys(response.errors)

    badFields.forEach((field) => {
      const query = `[name="${ field }"]`

      const el = document.querySelector(query) as HTMLElement
      if (!el) {
        return  
      }

      el.classList.add('border', 'border-danger')

      const span = document.querySelector(`#err_${ field }`) as HTMLSpanElement
      if (!span) {
        return
      }

      span.innerHTML = response.errors[field]
    })
  }
}

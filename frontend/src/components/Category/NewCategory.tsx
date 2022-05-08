import * as React from 'react'

import { request } from '../../common/request'

import { EAdminRoute } from '../../definitions'

interface IProps {}
interface IState {}

export default class NewCategory extends React.Component<IProps, IState> {
  /**
   * 
   */
  render(): React.ReactNode {
    return (
      <div className='card mb-5'>
        <div className='card-header text-center'>
          <h2 className="p-2">Új kategória felvétele</h2>
        </div>

        <div className="card-body">
          <div className="col-sm-12 col-md-6 mx-auto form group">
            <label className="fw-bold">Kategória megnevezése</label>
            <input type="text" className="form-control" name='name'/>
            <span className='text-danger' id='err_name'></span>
          </div>
        </div>

        <div className="card-footer">
          <div className="col-sm-12 text-center">
            <button className="btn btn-success" onClick={this.onClickSave}>Hozzáadás</button>
          </div>
        </div>
      </div>
    ) 
  }

  /**
   * 
   */
  private onClickSave = async (): Promise<void> => {
    const nameInput = document.querySelector('[name="name"]') as HTMLInputElement

    if (!nameInput) {
      return
    }

    const name = nameInput.value


    const data = { name }
    const response = await request(EAdminRoute.Categories, 'POST', data)

    if (response === '') {
      window.location.href = '/categories'

      return
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

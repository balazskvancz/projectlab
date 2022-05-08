import * as React from 'react'

import type { IProduct } from '../../definitions'
import { EClientRoute } from '../../definitions'

import { request, postForm } from '../../common/request'
interface IProps {
  readonly productId: number
}

interface IState {
  readonly productId: number 
  readonly product: IProduct | null
}

export default class DisplayProduct extends React.Component<IProps, IState> {

  constructor(props: IProps) {
    super(props)
        
    this.state = { productId: props.productId, product: null }
  }

  /**
   * @returns { React.ReactNode }
   */
  render(): React.ReactNode {
    return (
      <div className="container mx-auto mt-5 mb-5">
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">
              Termék megjelenítése
            </h2>
          </div>

          <div className="card-body">
            {
              !this.state.product ? 
                <h1 className='p-3 text-center mt-3'>A keresett termék nem található.</h1>
                :
                <React.Fragment>
                  <div className="row col-sm-12 col-md-6 mx-auto">
                    <div className="table-responsive">
                      <table className="table table-bordered">
                        <tbody>

                          <tr>
                            <td className="w-50 text-center fw-bold">Név</td>
                            <td className="w-50 text-center ">{ this.state.product.name }</td>
                          </tr> 

                          <tr>
                            <td className="w-50 text-center fw-bold">Kategória</td>
                            <td className="w-50 text-center ">{ this.state.product.categoryName}</td>
                          </tr> 

                          <tr>
                            <td className="w-50 text-center fw-bold">Ár</td>
                            <td className="w-50 text-center ">{ this.state.product.price}</td>
                          </tr> 

                          <tr>
                            <td className="w-50 text-center fw-bold">Leírás</td>
                            <td className="w-50 text-center ">{ this.state.product.description}</td>
                          </tr> 
                        </tbody> 
                      </table>
                    </div>
                  </div> 

                  <div className="row col-sm-12 col-md-6 mx-auto">
                    <div className="table-responsive">
                      <table className="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th className="text-center w-50">Kép</th>
                            <th className="text-center w-50">Törlés</th>
                          </tr>
                        </thead>
                        <tbody>
                          {
                            this.state.product.images.map((image) => {
                              return(
                                <tr>
                                  <td className='text-center'>
                                    <img className='img-fluid' src={`/images/uploads/${image.path}`} />
                                    </td>
                                  <td className='text-center align-middle'>
                                    <button className='btn btn-danger' onClick={() => {this.onClickDeletePicture(image.id)}}>Törlés</button>
                                  </td>
                                </tr>
                              )
                            })
                          }
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div className="col-sm-12 p -2">
                    <hr className="my-3" />
                  </div>

                  <div className="col-sm-12 col-md-6 mx-auto mt-5 ">
                    <h3 className="text-center p-3">Új kép hozzáadás</h3>

                    <div className="mb-3">
                      <input className="form-control" type="file" id="formFile" onChange={(e) => this.handleFileUpload(e)}/>
                    </div>
                  </div>
                </React.Fragment>
            }
          </div>
        </div>
      </div> 
      
    )
  }

  /**
   * API lekérdezés.
   */
  async componentDidMount(): Promise<void> {
    this.fetchData()
  }

  /**
   * 
   * @returns 
   */
  private fetchData = async (): Promise<void> => {
    const url = `${ EClientRoute.Product }/${ this.state.productId }`

    const response = await request(url) 

    if (response === '') {
      return
    }
    
    const product = response as IProduct
    this.setState({ product }) 

  }

  private handleFileUpload = async (e: React.ChangeEvent): Promise<void> => {
    const upload = e.target as HTMLInputElement
    const file = upload.files![0]

    const formData = new FormData()

    formData.append("product", this.state.productId.toString())
    formData.append("image", file)

    const response = await postForm(EClientRoute.ImageUpload, formData)

    if (response === "") {
      upload.value = ''
      this.fetchData()
    }
    
    // Hibakezelés.
  }

  /**
   * Kép törlés gomb eseménykezelője. 
   * @param {number} pictureId 
   */
  private onClickDeletePicture = async (pictureId: number): Promise<void> => {
    const url = `${ EClientRoute.ImageDelete}/${ pictureId }`

    const response = await request(url, 'POST')

    if (response === '') {
      this.fetchData()
    }
  }
}

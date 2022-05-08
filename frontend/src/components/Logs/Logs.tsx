import * as React from 'react'

import type { ILog, IUser, UserObject } from '../../definitions'

import { EAdminRoute } from '../../definitions'

import { request} from '../../common/request'

interface IProps {
  user: UserObject
}

interface IState {
  users: IUser[]
  logs: ILog[]
  query: boolean
}

export default class Logs extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    this.state = { users: [], logs: [], query: false }
  }

  /**
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className='container mx-auto mt-5'>
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">Napló</h2>
          </div>

          <div className="card-body">
            <div className="row">
              <div className="col-sm-12 col-md-4">
                <label className='fw-bold'>Felhasználó</label>
                <select className='form-select' name='userselect'>
                  {
                    this.state.users.map((user) => {
                      return (
                        <option value={user.id} key={user.id}>{user.username}</option>
                      )
                    })
                  }
                </select>
              </div>
              <div className="col-sm-12 col-md-3">
                <label className='fw-bold'>Kezdő dátum</label>
                <input type='date' className='form-control' name='starting_date' />
              </div>
              <div className="col-sm-12 col-md-3">
                <label className='fw-bold'>Vége dátum</label>
                <input type='date' className='form-control' name='ending_date' />
              </div>

              <div className='col-sm-12 col-md-2 '>
                <button className='btn btn-primary mt-4' onClick={this.onClickFetchData}>Keresés</button>
              </div>
            </div>

            <div className='col-sm-12'>
              <hr className='my-3' />
            </div>

            {
              this.state.logs.length > 0 ?
                <div className='table-responsive mt-3'>
                  <table className="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th className="text-center">Dátum</th>
                        <th className="text-center">Termék</th>
                        <th className="text-center">Típus</th>
                        <th className="text-center">Különbség</th>
                      </tr>
                    </thead>

                    <tbody>
                      {
                        this.state.logs.map((log) => {
                          return (
                            <tr>
                              <td className="text-center">{ log.created_at }</td>
                              <td className="text-center">{ log.productName }</td>
                              <td className="text-center">{ log.logName }</td>
                              <td className="text-center">{ log.diff }</td>
                            </tr>
                          )
                        })
                      }
                    </tbody>
                  </table>
                </div>
              :
                this.state.query ? 
                  <div className='col-sm-12 mt-3'>
                    <h2 className='p-2 text-center'>Nincs találat.</h2>
                  </div>
                :
                  ''
            }

          </div>

        </div> 
      </div>
    )
  }

  async componentDidMount(): Promise<void> {
    const usersRoute = `${ EAdminRoute.Users }?apikey=${ this.props.user.apikey }` 
    const users = await request(usersRoute) as IUser[]
    this.setState({users})
  }

  private onClickFetchData = async () => {
    const userSelectInput   = document.querySelector('[name="userselect"') as HTMLSelectElement
    const startingDateInput = document.querySelector('[name="starting_date"') as HTMLInputElement
    const endingDateInput   = document.querySelector('[name="ending_date"') as HTMLInputElement

    const userSelect    = userSelectInput.value
    const startingDate  = startingDateInput.value
    const endingDate    = endingDateInput.value
   
    const url = `${ EAdminRoute.Logs }?userid=${userSelect}&startdate=${startingDate}&enddate=${endingDate}` 

    const logs = await request(url) as ILog[]

    this.setState({ logs })
    this.setState({ query: true })
  }
}

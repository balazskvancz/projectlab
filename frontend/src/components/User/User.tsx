import * as React from 'react'

interface IProps {
  readonly apikey: string
}

interface IState {

}

export default class User extends React.Component<IProps, IState> {
  constructor(props: IProps) {
    super(props)

    
  }

  render() {
    return(
      <div className='container mx-auto mt-5'>
        <div className="card">
          <div className="card-header">
            <h2 className="p-2 text-center">Felhasználók</h2>
          </div>

          <div className="card-body">
            <div className="table-responsive">
              </div> 
          </div>
        </div>
      </div>
    )
  }


}
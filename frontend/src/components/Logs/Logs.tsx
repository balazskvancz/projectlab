import * as React from 'react'

import type { UserObject } from '../../definitions'

interface IProps {
  user: UserObject
}

export default class Logs extends React.Component<IProps, {}> {
  constructor(props: IProps) {
    super(props)
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
        </div> 
      </div>
    )
  }
}
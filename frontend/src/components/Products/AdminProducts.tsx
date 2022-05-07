import * as React from 'react'

import type { UserObject } from '../../definitions'

interface IProps {
  user: UserObject
}

export default class AdminProducts extends React.Component<IProps, {}> {
  constructor(props: IProps) {
    super(props)
  }

  /**
   * @returns {React.ReactNode} A lerenderelt elem.
   */
  render(): React.ReactNode {
    return (
      <div className='card'>
        <div className="card-header">
          <h2 className="p-2 text-center">Termékek</h2> 
        </div> 
      </div>
    )
  }
}
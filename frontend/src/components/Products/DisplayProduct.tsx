import * as React from 'react'

import { useLocation } from 'react-router-dom'

interface IProps {}

interface IState {
  readonly productId: number 
}

export default class DisplayProduct extends React.Component<IProps, IState> {

  constructor(props: IProps) {
    super(props)

        
    this.state = { productId: 1 }
  }

  /**
   * @returns { React.ReactNode }
   */
  render(): React.ReactNode {
    return (
      <h1>{ this.state.productId }</h1>
    )
  }
}
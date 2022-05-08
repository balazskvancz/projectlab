import * as React from 'react'
import axios from 'axios'
import './Login.css'

import { handleLogin } from '../../common/authentication'

export default class Login extends React.Component<{}> {
  render() {
    return(
      <div className="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div className="login">
          <div className="row">
            <div className="col-sm-12  text-center">
              <h2 className="p-2">Bejelentkezés</h2>
              <hr className="my-3" />
            </div>
          </div>
          <div className="row">
            <div className="col-sm-12">
              <div className="form-group p-2">
                <input type="text" className="form-control shadow-none" placeholder="Felhasználónév" name="username"/>
              </div>
            </div>
          </div>
          <div className="row mb-5">
            <div className="col-sm-12">
              <div className="form-group p-2">
                <input type="password" className="form-control shadow-none" placeholder="Jelszó" name="password"/>
              </div>
            </div>
          </div>
          <div className="row">
            <div className="col-sm-12">
              <button className="login_button" type="submit" onClick={this.onClickLogin}><i className="bi bi-box-arrow-in-right"></i></button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  private onClickLogin = async () => {
    const nameInput = document.querySelector('[name="username"]') as HTMLInputElement
    const passInput = document.querySelector('[name="password"]') as HTMLInputElement

    const name     = nameInput.value 
    const password = passInput.value
    
    if (name.length === 0 || password.length === 0) {
      this.handleBadLogin()

      return
    }

    // const data = JSON.stringify({name, password})

    // Mehet a request.
    await axios.post('http://localhost:8000/api/login', {
      name, 
      password 
    }).then((response) => {

      if (response.data === "") {
        this.handleBadLogin()
        return
      }

      handleLogin(response.data) 
      
      window.location.href = '/' 
    }).catch((err) => {
      console.log(err)
    })
  }

  private handleBadLogin = () => {
    const nameInput = document.querySelector('[name="username"]') as HTMLInputElement
    const passInput = document.querySelector('[name="password"]') as HTMLInputElement

    if (!nameInput || !passInput) {
      return
    }

    nameInput.classList.add('border', 'border-danger') 
    passInput.classList.add('border', 'border-danger') 
  }

}
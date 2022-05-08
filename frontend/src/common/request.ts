import axios from 'axios'

import { logout } from './authentication'

const host = 'http://localhost:8000'
/**
 * POST request.
 * @param {string} path Hoston belüli path
 * @param {any} data PostDatában küldendő adat.
 * @returns {Promise<any>} Response.
 */
export async function post(path: string, data: any): Promise<any> {
  return new Promise((resolve) => {
    const targetUrl = host + path 

    axios.post(targetUrl, {
      data, 
      headers: {
        Cookie: "cookie1=value; cookie2=value; cookie3=value;"
      }
    })
    .then((res: any) => {

      resolve(res.data)
    })
    // Ne foglalkozzunk az error-ral.
    .catch((err: any) => {
      console.log(err) 
    })
  })
}



/**
 * 
 * @param {sring} path Milyen path-re menjen ki a request.
 * @param {string} method Milyen típusú legyen a request.
 * @param {any} data Milyen adat menjen a törzsben.
 * @returns {Promise<any>} A válasz.
 */
export async function request(path: string, method='GET', data?:any): Promise<any> {
  return new Promise((resolve) => {
    const targetUrl = host + path
    axios(targetUrl, {
      method,
      withCredentials: true,
      data
    }).then((res: any) => {
      resolve(res.data)
    }).catch((err: any) => {
      const statusCode = err.response.status

      if (statusCode === 403) {
        logout()
        window.location.href = '/'
      }

      if (statusCode === 422) {
        resolve(err.response.data)
      }
    }) 
  })
}
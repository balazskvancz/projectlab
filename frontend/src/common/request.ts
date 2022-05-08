import axios from 'axios'

import { logout } from './authentication'

const host = 'http://localhost:8000'


export async function postForm(path: string, data: FormData): Promise<any> {
return new Promise((resolve) =>  {
    const targetUrl = host + path
    axios(targetUrl, {
      method: 'POST',
      withCredentials: true,
      data,
      headers: { "Content-Type": "multipart/form-data" },
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
/**
 * 
 * @param {sring} path Milyen path-re menjen ki a request.
 * @param {string} method Milyen típusú legyen a request.
 * @param {any[]?} postData Milyen adat menjen a törzsben.
 * @returns {Promise<any>} A válasz.
 */
export async function request(path: string, method='GET', postData?:any): Promise<any> {
  return new Promise((resolve) =>  {
    const targetUrl = host + path
    axios(targetUrl, {
      method,
      withCredentials: true,
      data: postData
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
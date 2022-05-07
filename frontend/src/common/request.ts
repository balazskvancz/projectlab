import axios from 'axios'

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
      data
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
 * GET.
 * @param {string} path Hoston belüli path.
 * @return {Promise<any>} Response.
 */
export async function get(path: string): Promise<any> {
  return new Promise((resolve) => {
    const targetUrl = host + path

    axios.get(targetUrl)
    .then((res: any) => {
      resolve(res.data)
    })
    .catch((err: any) => {
      console.log(err) 
    })
  })
}
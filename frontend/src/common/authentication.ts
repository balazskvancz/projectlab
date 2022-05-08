import type { UserObject } from "../definitions"

/**
 * Elmenti localStorage-be. 
 * @param values 
 * @returns 
 */
export function handleLogin(values: UserObject): boolean {
  if (typeof values.userid !== 'number' && typeof values.apikey !== 'string'&&  typeof values.role !== 'number') {
    return false
  }

  const stringified = JSON.stringify(values)
  const coded = btoa(stringified)

  document.cookie = `loggedUser= ${ coded };path=/`
  
  return true
}

/**
 * Visszaadje egy bejelentkezett user adatait, ha van ilyen. 
 * @returns {UserObject | null} A bejelentkezett user adatai, ha nincs ilyen akkor null.
 */
export function getUser(): UserObject | null {
  const cookie = getCookie("loggedUser")

  if (!cookie) {
    return null
  }
  
  const user:UserObject = JSON.parse(atob(cookie))
  
  return user
}



/**
 * Törli a bejelentkeztetett user-t.
 */
export function logout(): void {
  document.cookie = 'loggedUser=; Max-Age=0'
}

function getCookie(cname: string):string {
  let name = cname + "=";
  let ca = document.cookie.split(';');

  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";  
}

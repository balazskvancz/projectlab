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

  localStorage.setItem("user", stringified)
  
  return true
}

/**
 * Visszaadje egy bejelentkezett user adatait, ha van ilyen. 
 * @returns {UserObject | null} A bejelentkezett user adatai, ha nincs ilyen akkor null.
 */
export function getUser(): UserObject | null {
  const storedUser = localStorage.getItem("user")

  if (!storedUser) {
    return null
  }

  const parsed: UserObject = JSON.parse(storedUser)

  return parsed
}

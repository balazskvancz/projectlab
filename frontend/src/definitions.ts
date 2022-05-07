export enum EAdminRoute {
  Dashboard = '/api/admin/dashboard',
  Users = '/api/admin/users',
  Products = '/api/admin/products',
  Logs = '/api/admin/logs'
}

export enum EClientRoute {
  Dashboard = '/api/client/dashboard',
  Products = '/api/client/products',
}

export enum EUserRole {
  Admin = 2,
  User = 1
}

export interface UserObject {
  readonly userid: number
  readonly apikey: string
  readonly role: number
}

export interface ILogins {
  readonly username: string
  readonly created_at: string 
}
export interface IAdminDashboardData {
  readonly logins: ILogins[] 
  readonly productsCount: number
  readonly usersCount: number
}

export interface IUser {
  readonly id: number
  readonly username: string
  readonly role: string
}

export interface ISortingOption {
  readonly key: string
  readonly value: string
}


export interface ILog {
  readonly productName: string
  readonly logName: string 
  readonly diff: string
  readonly created_at: string
}

export interface IProduct {
  readonly id: number
  readonly name: string
  readonly price: number
  readonly description: string
  readonly username: string
  readonly categoryName: string
}

export interface IAdminProductsResponse {
  readonly products: IProduct[]
}

/** KLIENS. */
export interface IClientDashboardData {
  readonly productsCount: number
  readonly lastLogin: string
}